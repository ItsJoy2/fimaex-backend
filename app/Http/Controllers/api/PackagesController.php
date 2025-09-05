<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Founder;
use App\Models\Package;
use App\Models\referrals_settings;
use App\Service\TransactionService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function getPackages():JsonResponse
    {
        $packages = Package::where('active', 1)->get();
        return response()->json([
            'status' => true,
            'data' => $packages,
        ]);
    }


    public function BuyPackage($id, Request $request): JsonResponse
    {

         $package = Package::findOrFail($id);
        $amount = $package->amount;
        $user = $request->user();
        $packageName = $package->name;

        if ($user->is_block == 1) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, you cannot make a transaction because it is blocked'
            ], 401);
        }

        if ($user->main_wallet < $amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient funds',
            ]);
        }

        DB::beginTransaction();

        try {
            $user->main_wallet -= $amount;
            $user->is_founder = 1;
            $user->save();

            $this->transactionService->addNewTransaction(
                $user->id,
                $amount,
                "package_purchased",
                "-",
                "Purchased $packageName package for $$amount"
            );

            Founder::create([
                'user_id' => $user->id,
                'package_name' => $packageName,
                'package_id' => $package->id,
                'investment' => $amount,
            ]);

            $referrer = $user->referredBy()->first();
            if ($referrer) {
                // $bonus = $amount * $package->refer_bonus / 100;
                $bonus =$package->refer_bonus;
                $referrer->increment('profit_wallet', $bonus);

                $this->transactionService->addNewTransaction(
                    $referrer->id,
                    $bonus,
                    "referral_commission",
                    "+",
                    "Referral Bonus from $user->name"
                );
            }

            DB::commit();

            Cache::forget('admin_dashboard_data');
            Cache::forget('packages_active_page_1');
            Cache::forget('packages_inactive_page_1');

            return response()->json([
                'status' => true,
                'message' => 'Package purchased successfully',
                'wallet_balance' => $user->main_wallet,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! ' . $e->getMessage(),
            ], 500);
        }
    }


    public function InvestHistory(Request $request): JsonResponse{
        $user = $request->user();
        $investorData = Founder::where('user_id', $user->id)
            ->join('package', 'investors.package_id', '=', 'package.id')
            ->select('investors.*', 'package.interest_rate')
            ->paginate(10);
        $investorData->getCollection()->transform(function ($item) {
            $item->daily_roi = ($item->interest_rate * $item->investment) / 100;
            return $item;
        });
        return response()->json([
            'status' => true,
            'data' => $investorData->items(),
            'total' => $investorData->total(),
            'current_page' => $investorData->currentPage(),
            'last_page' => $investorData->lastPage(),

        ]);
    }

}
