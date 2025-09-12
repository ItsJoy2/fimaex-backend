<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Deposit;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\UserWalletData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Service\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class DepositController extends Controller
{
    protected TransactionService $transactionService;
    public function __construct(TransactionService $transactionService){
        $this->transactionService = $transactionService;
    }


    public function Store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'wallet' => 'required',
            'amount' => 'required|min:1',
        ]);

        $client = new Client();

        $headers = [
            'x-api-key'      => '9S3WW3P-JRB43DN-PBCJ23E-P9W96H3',
            'Content-Type'   => 'application/json',
        ];

        $payload = [
            "amount"      => $request->amount,
            "chain_id"    => 56,
            "type"        => "token",
            "token_name"  => "MIND",
            "user_id"     => 29,
            "contract_address" => "0x55d398326f99059fF775485246999027B3197955",
            // "webhook_url" => "https://api.fimaex.com/api/deposit-check",
            "webhook_url" => "https://webhook.site/7975c5c7-28a7-4799-bfc5-97e974b657ac",

        ];


        $payment = $client->request('POST', 'https://evm.blockmaster.info/api/create_invoice', [
            'headers' => $headers,
            'json'    => $payload
        ]);


        $response = json_decode($payment->getBody()->getContents(), true);


        // save to db
        $deposit = new Deposit();
        $deposit->user_id    = $user->id;
        $deposit->amount     = $request->amount;
        $deposit->wallet      = $request->wallet;
        $deposit->transaction_id = $response['data']['invoice_id'];
        $deposit->save();

        // instead of return string, redirect to show page
        return response()->json([
            'status' => true,
            'message' => 'success',
            'invoice_id' => $response['data']['invoice_id']
        ]);

    }

    public function webHook(Request $request){
        $data = $request->input();

        if (isset($data['status']) && ($data['status'] === true || $data['status'] === "completed")) {

            $invoice = new Deposit();

            $customerData = $invoice->where('transaction_id', $data['invoice_id'])->where('status', 0)->first();

            if(!$customerData){
                return "no data";
            }

            $customerData->amount = $data['amount'];
            $customerData->status = 1;
            $customerData->save();

            $user = User::where('id', $customerData->user_id)->first();
            if ($customerData->wallet == "deposit"){
                $user->main_wallet += $data['amount'];
                $user->save();


            return response()->json([
                'success' => true,
                'message' => 'Deposit added successfully.',
                'deposit_id' => $customerData->id
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Deposit not added, status is false.'
        ]);
    }
    }



    public function history(Request $request)
    {
        $user = $request->user();
        $history = Deposit::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $history->items(),
            'total' => $history->total(),
            'current' => $history->currentPage(),
            'next' => $history->nextPageUrl(),
            'previous' => $history->previousPageUrl(),
        ]);
    }
}
