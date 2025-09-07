<?php

namespace App\Http\Controllers\admin;

use App\Models\Club;
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
                    "Founder Bonus Added from Admin"
                );
            }

            $sponsors = User::whereIn('id', $founders->pluck('refer_by')->filter()->unique())->get();

            foreach ($sponsors as $sponsor) {
                $directFounders = $founders->where('refer_by', $sponsor->id);

                if ($directFounders->count() == 0) {
                    continue;
                }

                $club = Club::where('status', 1)
                    ->where('required_refers', '<=', $directFounders->count())
                    ->orderByDesc('required_refers')
                    ->first();

                if (!$club) {
                    continue;
                }

                $alreadyAssigned = DB::table('user_club')
                    ->where('user_id', $sponsor->id)
                    ->where('club_id', $club->id)
                    ->exists();

                if (!$alreadyAssigned) {
                    DB::table('user_club')->where('user_id', $sponsor->id)->delete();
                    DB::table('user_club')->insert([
                        'user_id'    => $sponsor->id,
                        'club_id'    => $club->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $totalFounderBonus = $directFounders->count() * $amount;

                $clubBonus = ($totalFounderBonus * $club->bonus_percent) / 100;

                if ($clubBonus > 0) {
                    $sponsor->increment('profit_wallet', $clubBonus);

                    $this->transactionService->addNewTransaction(
                        $sponsor->id,
                        $clubBonus,
                        "club_bonus",
                        "+",
                        "{$club->name} Club Bonus from Founders"
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Founder bonus sent successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }


}
