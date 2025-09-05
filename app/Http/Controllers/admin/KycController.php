<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\kyc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KycController extends Controller
{
    /**
     * Display a listing of the KYC applications with caching.
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $page = $request->page ?? 1;

        $cacheKey = "kycs_{$status}_page_{$page}";

        $kycs = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($status) {
            $query = Kyc::query();

            if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }

            return $query->latest()->paginate(10);
        });

        return view('admin.pages.kyc.index', compact('kycs'));
    }

    /**
     * Show the form for editing the specified KYC application.
     */
    public function edit(string $id)
    {
        $kyc = Kyc::findOrFail($id);
        return view('admin.pages.kyc.edit', compact('kyc'));
    }

    /**
     * Update the specified KYC application in storage and clear related cache.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'details' => 'nullable|string|max:1000',
        ]);

        $kyc = Kyc::findOrFail($id);
        $kyc->status = $request->status;
        $kyc->details = $request->details;
        $user = User::findOrFail($kyc->user_id);
        $user->kyc_status = "1";
        $user->save();
        $kyc->save();

        Cache::flush();

        return redirect()->route('kyc.index')->with('success', 'KYC status updated successfully.');
    }

    /**
     * Not used but required for resource controller.
     */
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function destroy(string $id) {}
}
