<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transactions::where('remark', 'withdrawal');

        // if ($request->filled('filter')) {
        //     $query->where('status', $request->filter);
        // }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                ->orWhere('details', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                });
            });
        }

        $withdrawals = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pages.withdraw.index', compact('withdrawals'));
    }

    // public function update(Request $request,$id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:pending,completed,rejected',
    //     ]);

    //     $withdraw = Transactions::findOrFail($id);
    //     if ($request->status == 'rejected') {
    //         User::where('id', $withdraw->user_id)->increment('wallet', $withdraw->amount);
    //         $withdraw->status = $request->status;
    //         $withdraw->save();
    //         return redirect()->route('withdraw.index')->with('success', 'Withdrawal status updated.');
    //     }
    //     $withdraw->status = $request->status;
    //     $withdraw->save();

    //     return redirect()->route('withdraw.index')->with('success', 'Withdrawal status updated.');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
