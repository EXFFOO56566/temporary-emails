<?php

namespace App\Http\Controllers\settings;

use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogSettingController extends Controller
{
    public function index()
    {
        $settings = Settings::whereIn('key', ['enable_blog', 'popular_posts', 'max_posts', 'disqus'])->get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.blog')->with("setting", $setting);
    }


    public function update(Request $request)
    {

        $request->validate([
            'enable_blog' => 'boolean',
            'popular_posts_in_page' => 'numeric|min:3',
            'max_posts' => 'numeric|min:2',

        ]);

        if ($request->enable_blog == null) {
            $request->enable_blog = 0;
        }

        $settings = Settings::whereIn('key', ['enable_blog', 'popular_posts', 'max_posts', 'disqus'])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            $setting->value = $request->$key;
            $setting->save();
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.blog'));
    }
}
