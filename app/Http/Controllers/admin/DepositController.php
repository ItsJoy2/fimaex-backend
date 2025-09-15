<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Deposit::where('status', 1)->with('user');
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                });
            });
        }

        $deposits = $query->paginate(10);

        return view('admin.pages.deposit.index', compact('deposits'));
    }

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
    public function update(Request $request, string $id)
    {
        $status = $request->input('status');
        $depositData = Transactions::where('id', $id)->first();
        if($status == 'completed'){
            $user = User::where('id', $depositData->user_id)->first();
            $user->wallet = $user->wallet + $depositData->amount;
            $user->save();
            $depositData->status = 'Completed';
            $depositData->save();
            cache()->flush();
            return back()->with('success', 'Updated Successfully');
        }

        $depositData->status = $status;
        $depositData->save();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
