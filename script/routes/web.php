<?php

use Illuminate\Support\Facades\Route;
use App\Models\Settings;

Route::group(['middleware' => 'IsInstalled'], function () {
    Route::get('/install', function () {
        return redirect()->route('install/install');
    })->name('install');
    Route::get('/install/install', "Install\InstallController@index")->name('install/install');
    Route::get('/install/step1', "Install\InstallController@step1")->name('install/step1');
    Route::post('/install/step1/set_database', "Install\InstallController@set_database")->name('install/step1/set_database');
    Route::get('/install/step2', "Install\InstallController@step2")->name('install/step2');
    Route::post('/install/step2/import_database', "Install\InstallController@import_database")->name('install/step2/import_database');
    Route::get('/install/step3', "Install\InstallController@step3")->name('install/step3');
    Route::post('/install/step3/set_siteinfo', "Install\InstallController@set_siteinfo")->name('install/step3/set_siteinfo');
    Route::get('/install/step4', "Install\InstallController@step4")->name('install/step4');
    Route::post('/install/step4/set_admininfo', "Install\InstallController@set_admininfo")->name('install/step4/set_admininfo');
});




Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin', 'check.installation']], function () {

    Route::get('/update', 'DashboardController@update')->name("update");

    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('admin');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/settings', 'DashboardController@settings')->name('settings');

    // General Settings
    Route::get('/settings/general', 'settings\GeneralController@index')->name('settings.general');
    Route::post('/settings/general/update', 'settings\GeneralController@update')->name('settings.general.update');
    Route::post('/settings/general/update2', 'settings\GeneralController@update2')->name('settings.general.update2');
    Route::post('/settings/check/imap', 'settings\GeneralController@check_imap')->name('check.imap');

    // Seo Settings
    Route::get('/settings/seo', 'settings\SeoController@index')->name('settings.seo');
    Route::post('/settings/seo/update', 'settings\SeoController@update')->name('settings.seo.update');


    Route::get('/settings/license', 'settings\GeneralController@license')->name('settings.license');
    Route::post('/settings/license/update', 'settings\GeneralController@license_update')->name('settings.license.update');


    // Ads Settings
    Route::get('/settings/ads', 'settings\AdsController@index')->name('settings.ads');
    Route::post('/settings/ads/update', 'settings\AdsController@update')->name('settings.ads.update');

    // Blog Setting
    Route::get('/settings/blog', 'settings\BlogSettingController@index')->name('settings.blog');
    Route::post('/settings/blog/update', 'settings\BlogSettingController@update')->name('settings.blog.update');

    // languages
    Route::resource('/settings/languages', 'LanguageController');
    Route::post('/settings/languages/update_translation', 'LanguageController@update_translation')->name('languages.update_translation');
    Route::get('/settings/languages/{language}/seo', 'LanguageController@show_seo')->name('languages.show.seo');
    Route::get('/settings/languages/{language}/text', 'LanguageController@text')->name('languages.show.text');

    // SMTP Setting
    Route::get('/settings/smtp', 'settings\SmtpController@index')->name('settings.smtp');
    Route::post('/settings/smtp/update', 'settings\SmtpController@update')->name('settings.smtp.update');
    Route::post('/settings/check/smtp', 'settings\SmtpController@check')->name('check.smtp');
    // Profile Settings
    Route::get('/profile', 'settings\ProfileController@index')->name('profile');
    Route::post('/profile/info/update', 'settings\ProfileController@changeInfo')->name('settings.info.update');
    Route::post('/profile/password/update', 'settings\ProfileController@changePassword')->name('settings.password.update');


    // API  Settings
    Route::get('/settings/api', 'APIController@admin_api')->name('settings.api');

    Route::get('/settings/css_js', 'settings\GeneralController@css_js')->name('settings.css.js');
    Route::post('/settings/css_js/update', 'settings\GeneralController@css_js_update')->name('settings.css.js.update');


    Route::get('/posts/checkslug', 'PostController@checkSlug')->name('posts.checkslug');
    Route::get('/categories/checkslug', 'CategoryController@checkSlug')->name('categories.checkslug');
    Route::get('/pages/checkslug', 'PageController@checkSlug')->name('pages.checkslug');
    Route::get('/posts/getcategory/{lang}', 'PostController@getCategory')->name('posts.getCategory');
    Route::post('ckeditor/image_upload', 'PageController@upload')->name('ckeditor.upload');


    Route::resource('/posts', "PostController");
    Route::resource('/categories', 'CategoryController');
    Route::resource('/pages', 'PageController');
    Route::resource('/features', 'FeatureController');
    Route::resource('/menu', 'MenuController');

    Route::get('/clear-cache', 'DashboardController@clear')->name('clear.cache');
});


Route::group(['middleware' => ['check.installation']], function () {

    Auth::routes(['register' => false]);

    Route::get('/delete', 'TrashMailController@delete')->name("delete");

    Route::get('/delete/{id}', 'TrashMailController@deletemessage')->name("delete.message");

    Route::post('/contact', 'ContactController@store')->name('contact.store');

    Route::post('/check_bot', 'TrashMailController@check_bot')->name('check_bot');

    Route::post('/create', 'TrashMailController@create')->name("create");

    Route::get('/download/{id}/{file?}', 'TrashMailController@download');


    Route::post('/messages', 'TrashMailController@messages')->name("messages");
});

if (env('VERSION_UPDATE') == 1.2) {
    Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeCookieRedirect', 'localizationRedirect', 'localeViewPath', 'check.installation']
    ], function () {

        if (env('SYSTEM_INSTALLED') != 0) {
            if (Settings::selectSettings('enable_blog')) {

                Route::get('/blog', 'BlogController@index')->name("blog");

                Route::get('/post/{slug}', 'PostController@show')->name("post");

                Route::get('/category/{slug}', 'CategoryController@show')->name("category");
            }
        }

        Route::get('/', 'TrashMailController@index')->name("home");

        Route::get('/index', 'TrashMailController@index')->name("index");

        Route::get('/change', 'TrashMailController@change')->name("change");

        Route::get('/view/{id}', 'TrashMailController@show')->name("view");

        Route::get('/message/{id}', 'TrashMailController@message')->name("message");

        Route::get('/page/{slug}', 'PageController@show')->name("page");

        Route::get('/contact', 'ContactController@index')->name('contact');

        Route::get('/token/{token}', 'TrashMailController@tokenToEmail'); // Only API
    });
}
