<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service\TransactionService;
use App\Http\Controllers\Controller;

class FounderBonusController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        return view('admin.pages.settings.founder_bonus_send');
    }

    public function sendFounderBonus(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $amount = $request->amount;

        $founders = User::where('is_founder', 1)->get();

        if ($founders->isEmpty()) {
            return redirect()->back()->with('error', 'No Founder found.');
        }

        DB::beginTransaction();
        try {
            foreach ($founders as $user) {

                $user->increment('profit_wallet', $amount);

                $this->transactionService->addNewTransaction(
                    $user->id,
                    $amount,
                    "founder_bonus",
                    "+",
                    "Founder Bonus from Admin"
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Founder bonus sent successfully to all founders!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }
}
