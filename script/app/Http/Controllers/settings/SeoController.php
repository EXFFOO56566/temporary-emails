<?php

namespace App\Http\Controllers\settings;

use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class SeoController extends Controller
{
    public function index()
    {
        $settings = Settings::get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.seo')->with("setting", $setting)->with("languages", Language::all());
    }

    public function update(Request $request)
    {

        //dd($request);
        $request->validate([
            'og_image' =>  'mimes:jpeg,png,jpg|max:5120',
            'separator' => 'required|max:10',
            'custom_tags' => 'max:2000',
            'google_analytics_code' => 'max:100',
            'google_analytics_4' => 'max:100',
            'sitemap' =>  'nullable|mimes:xml',
            'robots' =>  'nullable',
        ]);

        if ($request->has('og_image')) {
            $og_image = FileUpload($request->og_image, "uploads/", Settings::selectSettings('og_image'), 'cover');
            Settings::updateSettings('og_image', $og_image);
        }


        $myfile = fopen("robots.txt", "w") or die("Unable to open file!");
        $txt = $request->robots;
        fwrite($myfile, $txt);
        fclose($myfile);


        if ($request->has('sitemap')) {
            @$og_image = $request->sitemap->move(base_path('../'), 'sitemap.xml');
            //$og_image = FileUpload($request->sitemap, "", Settings::selectSettings('sitemap'), 'sitemap');
            Settings::updateSettings('sitemap', $og_image);
        }



        $settings = Settings::whereIn('key', ['separator', 'custom_tags', 'google_analytics_code', 'google_tag_manager', 'google_analytics_4', 'sitemap', 'robots'])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            $setting->value = $request->$key;
            $setting->save();
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.seo'));
    }
}
