<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;
use App\Models\Statistic;
use Artisan;


class DashboardController extends Controller
{

    public function index()
    {
        $total_email = Statistic::where("key", "total_email_pay_day")
            ->orderBy('created_at', 'DESC')->limit(7)->get();

            
        $total_email = $total_email->reverse();

        $total_messges = Statistic::where("key", "total_messges_pay_day")
            ->orderBy('created_at', 'DESC')->limit(7)->get();

        $total_messges = $total_messges->reverse();

        $posts = Post::all()->count();
        $pages = Page::all()->count();

        return view('backend.dashboard', compact('posts', 'pages', 'total_email', 'total_messges'));
    }





    public function settings()
    {
        return view('backend.settings.index');
    }


    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        session()->flash('success', 'Cache Cleared Successfuly');
        return back();
    }


    public function update()
    {
        translate('Default Title', 'seo');
        translate('Default Description', 'seo');
        translate('Default keywords', 'seo');
        translate('Home Page Title', 'seo');
        translate('Home Page Description', 'seo');
        translate('Home Page keywords', 'seo');
        translate('Change Page Title', 'seo');
        translate('Change Page Description', 'seo');
        translate('Change Page keywords', 'seo');
        translate('Blog Title', 'seo');
        translate('Blog Description', 'seo');
        translate('Blog keywords', 'seo');
        translate('Contact Page Title', 'seo');
        translate('Contact Page Description', 'seo');
        translate('Contact Page keywords', 'seo');

        setEnv('VERSION_UPDATE', '1.2');

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        session()->flash('success', 'Updated To Version 1.2 Successfully');
        return redirect('admin/dashboard');
    }

    
}
