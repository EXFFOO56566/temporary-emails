<?php

namespace App\Http\Controllers\settings;

use App\Models\Settings;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ddeboer\Imap\Server;
use Carbon\Carbon;
use Config;
use File;


class GeneralController extends Controller
{

    public function index()
    {

        $settings = Settings::get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.general')->with("setting", $setting)->with("languages", Language::all());
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'site_url' => 'required|url',
            'site_logo' => 'mimes:png,jpg,jpeg,svg,gif|max:2048',
            'favicon' => 'mimes:ico,png,jpg,jpeg,gif|max:2048',
        ]);

        $request->site_url = rtrim($request->site_url, '/');


        if ($request->has('site_logo')) {
            $site_logo = FileUpload($request->site_logo, "uploads/", Settings::selectSettings('site_logo'), 'logo');
            Settings::updateSettings('site_logo', $site_logo);
        }

        if ($request->has('favicon')) {
            $favicon = FileUpload($request->favicon, "uploads/", Settings::selectSettings('favicon'), 'favicon');
            Settings::updateSettings('favicon', $favicon);
        }

        if ($request->has('lang')) {
            Settings::updateSettings('lang', $request->lang);
            setEnv("DEFAULT_LANGUAGE", trim($request->lang));
        }


        $settings = Settings::whereIn('key', ['name', 'site_url', 'main_color', 'secondary_color'])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            $setting->value = $request->$key;
            $setting->save();
        }


        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.general'));
    }

    public function update2(Request $request)
    {

        $request->validate([
            'imap_host' => 'required',
            'imap_user' => 'required',
            'imap_port' => 'required|numeric',
            'imap_certificate' => 'boolean',
            'domains' => 'required',
            'fetch_time' => 'numeric|required|min:5',
            'email_lifetime' => 'numeric|required|min:1',
            'messages_received' => 'numeric|required|min:0',
            'emails_created' => 'numeric|required|min:0',
            'COOKIE_CONSENT_ENABLED' => 'boolean',
            'https_force' => 'boolean',
            'enable_preloader' => 'boolean',
            'hideDefaultLocaleInURL' => 'boolean',
            'email_lifetime_type' => 'required|in:1,60,1440',
        ]);

        if ($request->imap_certificate == null) {
            $request->imap_certificate = 0;
        }

        if ($request->has('RECAPTCHA_SITE_KEY')) {
            setEnv("RECAPTCHA_SITE_KEY", trim($request->RECAPTCHA_SITE_KEY));
        }

        if ($request->has('RECAPTCHA_SECRET_KEY')) {
            setEnv("RECAPTCHA_SECRET_KEY", trim($request->RECAPTCHA_SECRET_KEY));
        }



        if ($request->COOKIE_CONSENT_ENABLED == null) {
            $request->COOKIE_CONSENT_ENABLED = "0";
        }

        if ($request->https_force == null) {
            $request->https_force = "0";
        }

        if ($request->enable_preloader == null) {
            $request->enable_preloader = "0";
        }

        if ($request->hideDefaultLocaleInURL == null) {
            $request->hideDefaultLocaleInURL = "0";
            setEnv("HIDE_DEFAULT_LANG_IN_URL", 0);
        }


        if ($request->hideDefaultLocaleInURL == 1) {
            setEnv("HIDE_DEFAULT_LANG_IN_URL", 1);
        }

        setEnv("COOKIE_CONSENT_ENABLED", trim($request->COOKIE_CONSENT_ENABLED));
        setEnv("HTTPS_FORCE", trim($request->https_force));



        $settings = Settings::whereIn('key', [
            'INVISIBLE_SECRET_KEY', 'INVISIBLE_SITE_KEY', 'email_lifetime_type', 'imap_host', 'imap_user', 'imap_pass', 'domains', 'forbidden_id', 'allowed_files', 'RECAPTCHA_SITE_KEY', 'RECAPTCHA_SECRET_KEY',
            'fetch_time', 'email_lifetime', 'emails_created', 'messages_received', 'imap_encryption', 'imap_port', 'imap_certificate', 'COOKIE_CONSENT_ENABLED', 'https_force',
            'hideDefaultLocaleInURL', 'enable_preloader'
        ])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            $setting->value = $request->$key;
            $setting->save();
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.general'));
    }


    public function check_imap(Request $request)
    {


        if (env('DEMO_MODE')) {

            return '<div class="error">ERROR [0s]:  Demo version some features are disabled </div>';
        }



        $time1 = Carbon::now()->timestamp;

        if ($request->certificate == null) {
            $request->certificate = 0;
        }



        $host = $request->host;
        $user = $request->user;
        $pass = $request->pass;
        $port = $request->port;
        $encryption = $request->encryption;
        $certificate = $request->certificate;


        try {

            if (empty($host) || empty($user) || empty($pass) || empty($port) || empty($encryption)) {

                return '<div class="error">ERROR:  The server data is incomplete :/ </div>';
            }

            $flag = '/imap/' . $encryption;

            if ($certificate == 0) {
                $flag .= '/novalidate-cert';
            } else {
                $flag .= '/validate-cert';
            }

            $server = new Server($host, $port,  $flag);
            $connection = $server->authenticate($user, $pass);
            $mailboxes = $connection->getMailboxes();

            $i = 0;
            foreach ($mailboxes as $mailbox) {
                $i++;
            }

            if ($i > 0) {

                $time2 = Carbon::now()->timestamp;
                $t = $time2 - $time1;
                return '<div class="success">SUCCESS [' . $t . 's]:  Your IMAP Server Is Working :)</div>';
            }
        } catch (\Exception $e) {
            $time2 = Carbon::now()->timestamp;
            $t = $time2 - $time1;
            return '<div class="error">ERROR [' . $t . 's]: Please Check You Info Or Try With Another Port And Encryption <br>' . $e->getMessage() . '</div>';
        }
    }



    public function css_js()
    {
        //dd('ddd');
        $settings = Settings::get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.css_js')->with("setting", $setting);
    }


    public function css_js_update(Request $request)
    {
        $settings = Settings::whereIn('key', ['custom_css', 'custom_js'])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            $setting->value = $request->$key;
            $setting->save();
        }


        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.css.js'));
    }


    public function license()
    {
		$settingslc = array('license' => '************');
		$settings = (object) array('code' => '******************', 'license' => 'nullcave', 'type' => 'Regular');
		Settings::updateSettings('license', $settingslc);
        return view('backend.settings.license')->with("settings", $settings);
    }


    public function license_update(Request $request)
    {
        $request->validate([
            'license' => 'required|file',
        ]);

        if ($request->has('license')) {
            $license = Upload_license($request->license, "script/", Settings::selectSettings('license'));
            Settings::updateSettings('license', $license);
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.license'));
    }
}
