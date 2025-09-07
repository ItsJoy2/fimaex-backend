<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;

class AdminClubController extends Controller
{
    public function index()
    {
        $clubs = Club::orderBy('required_refers')->get();
        return view('admin.pages.club.index', compact('clubs'));
    }

    public function create()
    {
        return view('admin.pages.club.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'required_refers' => 'required|integer|min:1',
            'bonus_percent'   => 'required|numeric|min:0|max:100',
            'incentive'       => 'nullable|string|max:255',
            'status'          => 'required|boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('clubs', 'public');
        }

        Club::create($data);

        return redirect()->route('clubs.index')->with('success', 'Club created successfully.');
    }

    public function edit(Club $club)
    {
        return view('admin.pages.club.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'required_refers' => 'required|integer|min:1',
            'bonus_percent'   => 'required|numeric|min:0|max:100',
            'incentive'       => 'nullable|string|max:255',
            'status'          => 'required|boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('clubs', 'public');
        }

        $club->update($data);

        return redirect()->route('clubs.index')->with('success', 'Club updated successfully.');
    }

    public function destroy(Club $club)
    {
        if ($club->image && file_exists(storage_path('app/public/' . $club->image))) {
            unlink(storage_path('app/public/' . $club->image));
        }
        $club->delete();

        return redirect()->route('clubs.index')->with('success', 'Club deleted successfully.');
    }

    public function toggleStatus(Club $club)
    {
        $club->status = !$club->status;
        $club->save();

        return redirect()->back()->with('success', 'Club status updated successfully.');
    }
}
