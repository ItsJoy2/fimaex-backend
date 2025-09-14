<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\TransferSetting;
use App\Models\withdraw_settings;
use Illuminate\Support\Facades\DB;
use App\Service\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransactionsController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function transactions(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($keyword) {
            $transactions = Transactions::where('user_id', $request->user()->id)->where('remark', '=', $keyword)->orderBy('id', 'desc')->paginate(10);
            return response()->json([
                'status' => true,
                'data' => $transactions->items(),
                'total' => $transactions->total(),
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
            ]);
        }
        $transactions = Transactions::where('user_id', $request->user()->id)->orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $transactions->items(),
            'total' => $transactions->total(),
            'last_page' => $transactions->lastPage(),
            'current_page' => $transactions->currentPage(),
            'per_page' => $transactions->perPage(),
            'from' => $transactions->firstItem(),
        ]);
    }



    // public function withdraw(Request $request)
    // {
    //     $withdrawSettings = withdraw_settings::first();

    //     if($withdrawSettings->status == 0){
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Withdrawals are temporarily disabled. Please contact support'
    //         ]);
    //     }

    //     if (!$withdrawSettings) {
    //         return back()->with('error', 'Withdraw settings not found.');
    //     }

    //     $min = $withdrawSettings->min_withdraw;
    //     $max = $withdrawSettings->max_withdraw;
    //     $charge = $withdrawSettings->charge;

    //     $validatedData = $request->validate([
    //         'amount' => ['required', 'numeric', "min:$min", "max:$max"],
    //         'wallet' => ['required', 'string', 'min:10', 'max:70'],
    //     ]);

    //     $user = $request->user();
    //     $amount = $validatedData['amount'];
    //     $chargeAmount = ($amount * $charge) / 100;
    //     $totalAmount = $amount + $chargeAmount;
    //     $wallet = $validatedData['wallet'];



    //     if ($user->profit_wallet < $totalAmount) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Insufficient balance',
    //         ], 400);
    //     } else {
    //         $this->transactionService->addNewTransaction(
    //             "$user->id",
    //             "$amount",
    //             "withdrawal",
    //             "-",
    //             "$wallet",
    //             'Pending',
    //             "$chargeAmount"
    //     );
    //         $user->profit_wallet -= $totalAmount;
    //         $user->save();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Your withdrawal request has been received and is currently pending.',
    //             'wallet_balance' => $user->profit_wallet,
    //         ]);
    //     }
    // }

    public function withdraw(Request $request)
    {
        $withdrawSettings = withdraw_settings::first();

        if (!$withdrawSettings) {
            return back()->with('error', 'Withdraw settings not found.');
        }

        if ($withdrawSettings->status == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Withdrawals are temporarily disabled. Please contact support'
            ]);
        }

        $user = $request->user();
        if ($user->is_block == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, your account is blocked. Please contact admin.',
            ]);
        }

        $min = $withdrawSettings->min_withdraw;
        $max = $withdrawSettings->max_withdraw;
        $charge = $withdrawSettings->charge;

        $validatedData = $request->validate([
            'amount' => ['required', 'numeric', "min:$min", "max:$max"],
            'wallet' => ['required', 'string', 'min:10', 'max:70'],
        ]);

        $amount = $validatedData['amount'];
        $chargeAmount = $amount * $charge / 100;
        $finalAmount = $amount - $chargeAmount;
        $wallet = $validatedData['wallet'];

        if ($user->profit_wallet < $amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient balance',
            ], 400);
        }

        $response = Http::post('https://evm.blockmaster.info/api/payout', [
            'amount' => $finalAmount,
            'type' => 'token',
            'to' => $wallet,
            'token_address' => env('TOKEN'),
            'chain_id' => env('CHAIN_ID'),
            'rpc_url' => env('RPC'),
            'user_id' => 29,
        ]);

        $response = json_decode($response->body());

        if ($response && $response->status && $response->txHash != null) {

            $this->transactionService->addNewTransaction(
                $user->id,
                $finalAmount,
                'withdrawal',
                '-',
                "Withdraw success Tx Hash: {$response->txHash}",
                'Paid',
                $chargeAmount
            );

            $user->profit_wallet -= $amount;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Your withdrawal successfully',
                'wallet_balance' => $user->profit_wallet,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Withdrawal failed, please contact support',
        ]);
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'email'  => 'required|exists:users,email',
        ]);

        $sender = $request->user();
        $receiver = User::where('email', $validated['email'])->first();

        if ($sender->id === $receiver->id) {
            return response()->json([
                'status'  => false,
                'message' => "You cannot transfer to yourself",
            ], 400);
        }

        if ($sender->is_block == 1) {
            return response()->json([
                'status'  => false,
                'message' => "Your account is blocked by admin.",
            ], 400);
        }

        $setting = TransferSetting::first();
        if (!$setting || $setting->status == 0) {
            return response()->json([
                'status'  => false,
                'message' => "Transfer is currently disabled by Admin",
            ], 403);
        }

        if ($validated['amount'] < $setting->min_transfer) {
            return response()->json([
                'status'  => false,
                'message' => "Minimum transfer amount is {$setting->min_transfer}",
            ], 400);
        }

        if ($validated['amount'] > $setting->max_transfer) {
            return response()->json([
                'status'  => false,
                'message' => "Maximum transfer amount is {$setting->max_transfer}",
            ], 400);
        }

        if ($sender->main_wallet < $validated['amount']) {
            return response()->json([
                'status'  => false,
                'message' => "You don't have enough balance in main_wallet",
            ], 400);
        }

        DB::beginTransaction();

        try {
            $sender->decrement('main_wallet', $validated['amount']);

            $receiver->increment('main_wallet', $validated['amount']);

            Transactions::create([
                'transaction_id'=> Transactions::generateTransactionId(),
                'user_id'       => $sender->id,
                'amount'        => $validated['amount'],
                'wallet_type'   => 'main_wallet',
                'type'          => '-',
                'status'        => 'Completed',
                'details'       => "Transfer to {$receiver->email}",
                'remark'        => 'transfer',
            ]);

            Transactions::create([
                'transaction_id'=> Transactions::generateTransactionId(),
                'user_id'       => $receiver->id,
                'amount'        => $validated['amount'],
                'wallet_type'   => 'main_wallet',
                'type'          => '+',
                'status'        => 'Completed',
                'details'       => "Received from {$sender->email}",
                'remark'        => 'transfer',
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => "Transaction successful from main_wallet",
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => "Transaction failed",
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


}
