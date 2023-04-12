<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Mail;
use App\Mail\TestSMTP;

class SmtpController extends Controller
{

    public function index()
    {
        $settings = Settings::whereIn('key', ['MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_TO_ADDRESS'])->get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.smtp')->with("setting", $setting);
    }

    public function update(Request $request)
    {

        $rules = [
            'MAIL_MAILER' => 'required',
            'MAIL_HOST' => 'required',
            'MAIL_PORT' => 'required',
            'MAIL_USERNAME' => 'required',
            'MAIL_FROM_ADDRESS' => 'required',
            'MAIL_TO_ADDRESS' => 'required',
        ];


        $customMessages = [
            'MAIL_MAILER.required' => 'The Mailer field is required.',
            'MAIL_HOST.required' => 'The Host field is required.',
            'MAIL_PORT.required' => 'The Port field is required.',
            'MAIL_USERNAME.required' => 'The Username field is required.',
            'MAIL_PASSWORD.required' => 'The Password field is required.',
            'MAIL_ENCRYPTION.required' => 'The Encryption field is required.',
            'MAIL_FROM_ADDRESS.required' => 'The From Address field is required.',
            'MAIL_TO_ADDRESS.required' => 'The To Address field is required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $settings = Settings::whereIn('key', ['MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_TO_ADDRESS'])->get();
        foreach ($settings as $setting) {
            $key = $setting->key;
            setEnv($key, trim($request->$key));
            $setting->value = $request->$key;
            $setting->save();
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.smtp'));
    }


    public function check(Request $request)
    {


        $request->validate([
            'test_email' => 'required|email',
        ]);


        if (
            empty(Settings::selectSettings('MAIL_MAILER')) ||  empty(Settings::selectSettings('MAIL_HOST')) ||
            empty(Settings::selectSettings('MAIL_PORT')) ||  empty(Settings::selectSettings('MAIL_USERNAME')) ||
            empty(Settings::selectSettings('MAIL_PASSWORD')) ||  empty(Settings::selectSettings('MAIL_ENCRYPTION')) ||
            empty(Settings::selectSettings('MAIL_TO_ADDRESS')) ||  empty(Settings::selectSettings('MAIL_FROM_ADDRESS'))
        ) {

            return back()->with('error', 'Fill in all SMTP fields first !');
        } else {

            try {

                Mail::to($request->test_email)->send(new TestSMTP($request));
            } catch (\Exception $e) {

                return back()->with('error', 'Incorrect authentication data');
            }

            return back()->with('success', 'Message has been sent successfully');
        }
    }
}
