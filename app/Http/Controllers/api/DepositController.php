<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Service\TransactionService;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    protected $transactionService;
    public function __construct(TransactionService $transactionService){
        $this->transactionService = $transactionService;
    }

    public function addDeposit(Request $request){
        $validatedData = $request->validate([
            'transaction_id' => 'required',
            'amount' => 'required',
        ]);
        $user = $request->user();
        $amount = $request->input('amount');
        $transactionID = $request->input('transaction_id');

        $alreadySubmited =   Transactions::where('details',$transactionID)->first();
        if($alreadySubmited){
            return response()->json([
                'success' => false,
                'message' => 'Transaction already submitted'
            ]);
        }

        $deposit =  $this->transactionService->addNewTransaction(
            (string)$user->id,
            "$amount",
            'deposit',
            '+',
            "$transactionID",
            'Pending'
        );
        return response()->json([
            'success' => true,
            'message' => 'Transaction submitted',
            'deposit' => $deposit
        ]);
    }
}
