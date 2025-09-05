<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->filter;
        $page = $request->get('page', 1);
        $cacheKey = "packages_{$filter}_page_{$page}";

        $plans = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($filter) {
            $query = Package::query();

            if ($filter === 'active') {
                $query->where('active', 1);
            } elseif ($filter === 'inactive') {
                $query->where('active', 0);
            }

            return $query->paginate(10);
        });

        return view('admin.pages.plan.index', compact('plans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gte:min_amount',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration' => 'nullable|integer|min:0',
            'return_type' => 'required|in:daily,weekly,monthly',
            'active' => 'required|boolean',
        ]);

        Package::create($request->all());
        $this->clearPackageCache();
        return redirect()->route('all-plan.index')->with('success', 'Plan created successfully.');
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
    public function edit($id)
    {
        $plan = Package::findOrFail($id);
        return view('admin.pages.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'refer_bonus' => 'required|numeric|min:0',
        'active' => 'required|boolean',
        'icon' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $plan = Package::findOrFail($id);

    // Update text fields
    $plan->name = $request->name;
    $plan->amount = $request->amount;
    $plan->refer_bonus = $request->refer_bonus;
    $plan->active = $request->active;

    // Handle file upload
    if ($request->hasFile('icon')) {
        $file = $request->file('icon');
        $path = $file->store('plan_icons', 'public');
        $plan->icon = $path;
    }

    $plan->save();

    $this->clearPackageCache();

    return redirect()->route('all-plan.index')->with('success', 'Plan updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $items = Package::findorfail($id);
        $items->delete();
        $this->clearPackageCache();
        return back()->with('success', 'Item has been deleted');
    }

    private function clearPackageCache()
    {
        $filters = ['active', 'inactive', null];
        for ($page = 1; $page <= 10; $page++) {
            foreach ($filters as $filter) {
                $key = "packages_{$filter}_page_{$page}";
                Cache::forget($key);
            }
        }
    }

}
