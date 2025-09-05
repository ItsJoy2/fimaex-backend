<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Founder;
use App\Models\Investor;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function Pest\Laravel\json;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService){$this->userService = $userService;}

    public function UserProfile(Request $request):JsonResponse
    {
        return $this->userService->UserProfile($request);
    }

    public function team(Request $request): JsonResponse
    {
        $user = $request->user();
        $team = $this->getTeamRecursive($user);
        return response()->json([
            'status' => true,
            'user' => $user->only(['email','name','is_founder','created_at']),
            'team' => $team
        ]);
    }



public function getDirectReferrals(Request $request): JsonResponse
{
    $user = $request->user();
    $directReferrals = $user->referrals()
        ->select('users.id', 'users.name', 'users.refer_by', 'users.email','users.is_founder','users.created_at')
        ->selectRaw('COALESCE(SUM(founders.investment), 0) as investment')
        ->leftJoin('founders', 'founders.user_id', '=', 'users.id')
        ->groupBy('users.id', 'users.name', 'users.refer_by', 'users.email','users.is_founder','users.created_at')
        ->paginate(10);

    return response()->json([
        'status' => true,
        'data' => $directReferrals->items(),
        'total' => $directReferrals->total(),
        'per_page' => $directReferrals->perPage(),
        'page' => $directReferrals->currentPage(),
        'current_page' => $directReferrals->currentPage(),
        'last_page' => $directReferrals->lastPage(),
        'from' => $directReferrals->firstItem(),
    ]);
}

    private function getTeamRecursive(User $user, int $level = 1, int $maxLevel = 3): array
    {
        if ($level > $maxLevel) {
            return [];
        }
        $user->load('referrals');
        $team = [];
        foreach ($user->referrals as $referral) {
            $team[] = [
                'level' => $level,
                'email' => $referral->email,
                'name' => $referral->name,
                'is_active' => $referral->is_active,
                'created_at' => $referral->created_at,
                'investment' => Founder::where('user_id', $referral->id)->sum('investment'),
                'team' => $this->getTeamRecursive($referral, $level + 1, $maxLevel)
            ];
        }
        return $team;
    }


    public function kyc(Request $request): JsonResponse
    {
        return $this->userService->UserKyc($request);
    }

}
