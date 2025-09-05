<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use App\Service\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AutoDepositController extends Controller
{
    protected TransactionService $transactionService;
    public function __construct(TransactionService $transactionService){
        $this->transactionService = $transactionService;
    }
    public function Deposit(Request $request){
        try {
            $user = $request->user();
            $validate = $request->validate([
                'amount' => 'required|numeric|min:0.1',
            ]);
            $amount = $validate['amount'];
            $response = Http::withHeaders([
                'x-license' => 'nlgced7a239fa6c5f8410758d498bdf64f50aa4c858ffd697d7252dc8f5a5e1eca2',
                'x-user-key' => 'nf3dUW',
            ])->post('https://payment.web3twenty.com/v2/api/invoices', [
                "merchantId" => "Petroxcin",
                "amount" => $validate['amount'],
                "currency" => "USDT",
                "blockchain"=> "bsc",
                "expirationMinutes"=> 25,
                "success_url" => "https://petroxcin.com/dashboard",
                "failed_url" => "https://petroxcin.com/dashboard",
                "ipn_url" => "https://api.petroxcin.com/api/paymentHooks"
            ]);

            if ($response->successful()) {
                $incomingData = $response->json();

                $storeTransaction = $this->transactionService->addNewTransaction(
                    "$user->id",
                    "$amount",
                    "deposit",
                    "+",
                    "$incomingData[invoiceId]",
                    "Pending"
                );

                if($storeTransaction){
                    return response()->json([
                        'status'=> true,
                        'payment_url'=> $incomingData['pay_url'],
                    ]);
                }else{
                    return response()->json([
                        'status'=> false,
                        'message'=> 'Something went wrong try again later'
                    ]);
                }
            }else{
                return response()->json([
                    'status'=> false,
                    'message'=> 'payment invoice create failed'
                ]);
            }



        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }
    }


    public function PaymentHooks(Request $request){
        $invoiceId = $request->input('invoiceId');
        $amount = $request->input('amount');
        $status = $request->input('status');
        $findData = Transactions::where('details',$invoiceId)->where('status','pending')->first();
        if(!$findData){
            return 'this route not found';
        }
        if($amount <= $findData->amount && $status == 'paid'){
            User::where('id',$findData->user_id)->increment('wallet',$amount);
            User::where('id',$findData->user_id)->update(['is_active'=>1]);
            $findData->status = 'paid';
            $findData->save();
            Cache::forget('admin_dashboard_data');
        }
    }
}
