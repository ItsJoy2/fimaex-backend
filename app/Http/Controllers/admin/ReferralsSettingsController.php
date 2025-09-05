<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\referrals_settings;
use Illuminate\Http\Request;

class ReferralsSettingsController extends Controller
{
    public function index(){
        $settings = referrals_settings::first();
        return view('admin.pages.settings.referral_settings', compact('settings'));
    }

    public function update(Request $request){
        $request->validate([
            'invest_level_1' => 'required|numeric|min:0',
            'roi_level_1' => 'required|numeric|min:0|max:100',
            'roi_level_2' => 'required|numeric|min:0|max:100',
            'roi_level_3' => 'required|numeric|min:0|max:100',
        ]);

        $settings = referrals_settings::first();

        if ($settings) {
            $settings->update([
                'invest_level_1' => $request->invest_level_1,
                'roi_level_1' => $request->roi_level_1,
                'roi_level_2' => $request->roi_level_2,
                'roi_level_3' => $request->roi_level_3,
            ]);

            return redirect()->back()->with('success', 'Referral settings updated successfully.');
        }

        return redirect()->back()->with('error', 'Referral settings not found.');
    }
}
