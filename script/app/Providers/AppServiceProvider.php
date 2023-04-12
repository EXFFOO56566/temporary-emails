<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Settings;
use App\Models\Post;
use App\Models\Category;
use App\Models\Language;
use App\Models\Page;
use App\Models\Feature;
use App\Models\Menu;
use Illuminate\Support\Facades\Cookie;
use Config;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;



use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
        if (env('HTTPS_FORCE')) {
            $this->app['request']->server->set('HTTPS', true);
        }

        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (env('SYSTEM_INSTALLED') != 0) {
        Config::set('laravellocalization.supportedLocales', getSupportedLocales());
        }

        
        /*
        // ONLY FOR TEST 
        if(\App::environment()=='local' && isset($_SERVER['HTTP_X_ORIGINAL_HOST'])){
            $this->app['url']->forceRootUrl($_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_X_ORIGINAL_HOST']);
        }
        
        */

        try {

            if (env('SYSTEM_INSTALLED') != 0) {

                view()->composer('*', function ($view) {
                    $setting = Settings::pluck('value', 'key')->all();
                    $view->with('setdata', $setting);
                });

                view()->composer('layouts.user', function ($view) {
                    $locale = LaravelLocalization::getCurrentLocale();

                    $links = Menu::all();
                    $lang_name = Language::where('code', $locale)->first()->name;
                    $pages = Page::where("status", "=", 1)->where("lang", $locale)->get();
                    $view->with('pages', $pages)->with('lang_locale', $locale)->with('lang_name', $lang_name)
                    ->with('links', $links);

                });


                view()->composer('frontend.*', function ($view) {
                    $locale = LaravelLocalization::getCurrentLocale();
                    $lang_name = Language::where('code', $locale)->first()->name;
                    $view->with('lang_locale', $locale)->with('lang_name', $lang_name);
                });



                view()->composer('frontend.features', function ($view) {
                    $locale = LaravelLocalization::getCurrentLocale();

                    $limit = Settings::selectSettings('popular_posts');
                    $posts = Post::where("status", "=", 1)->where("lang", $locale)->orderBy('views', 'DESC')->limit($limit)->get();
                    $features = Feature::where("lang", $locale)->get();
                    $view->with('popular_posts', $posts)->with("features", $features);
                });

                view()->composer('frontend.sidebar', function ($view) {
                    $locale = LaravelLocalization::getCurrentLocale();

                    $posts = Post::where("status", "=", 1)->where("lang", $locale)->orderBy('views', 'DESC')->limit(4)->get();
                    $categories = Category::where("lang", $locale)->get();
                    $view->with('popular_posts', $posts)->with("categories", $categories);
                });
            }
        } catch (\Exception $e) {
            return [];
        }
    }
}
