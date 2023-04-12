<?php

namespace App\Http\Controllers\settings;

use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index()
    {
        $settings = Settings::whereIn('key', ['top_ad', 'bottom_ad', 'right_ad', 'left_ad', 'head_ad', 'sidebar_ad'])->get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.ads')->with("setting", $setting);
    }


    public function update(Request $request)
    {

        $settings = Settings::whereIn('key', ['top_ad', 'bottom_ad', 'right_ad', 'left_ad', 'head_ad', 'sidebar_ad'])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            $setting->value = $request->$key;
            $setting->save();
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.ads'));
    }
}
