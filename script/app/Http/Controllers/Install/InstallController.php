<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Statistic;
use Carbon\Carbon;


class InstallController extends Controller
{


    public function index()
    {
        // view start page
        return view('install.start');
    }

    // View step 1 page
    public function step1()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 1) {
            return redirect()->route('install/step2');
        }

        return view('install.step1');
    }

    // Step 1 Set database information
    public function set_database(Request $request)
    {

        $validate = $request->validate([
            'database_name' => ['required'],
            'database_user_name' => ['required'],
            'database_host_name' => ['required'],
        ]);

        if (function_exists('curl_version')) {
            if (is_writable(base_path('.env'))) {

                if (@mysqli_connect(
                    $request['database_host_name'],
                    $request['database_user_name'],
                    $request['database_password'],
                    $request['database_name']
                )) {

                    setEnv('DB_DATABASE', '"'.trim($request['database_name']).'"');
                    setEnv('DB_USERNAME', '"'.trim($request['database_user_name']).'"');
                    setEnv('DB_PASSWORD', '"'.trim($request['database_password']).'"');
                    setEnv('DB_HOST', '"'.trim($request['database_host_name']).'"');
                    setEnv('DB_INSTALLED', 1);
                    return redirect('/install/step2');
                } else {

                    $request->session()->flash('error', 'Incorrect database information');
                    return redirect()->back();
                }
            } else {

                $request->session()->flash('error', 'Some of your file does not have writable permission');
                return redirect()->back();
            }
        } else {

            $request->session()->flash('error', 'CURL does not exist in server');
            return redirect()->back();
        }
    }

    // View step 2 page
    public function step2()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 0) {
            return redirect()->route('install/step1');
        }
        if (env('DB_IMPORTED') == 1) {
            return redirect()->route('install/step3');
        }

        return view('install.step2');
    }

    // Step 2 Import database file
    public function import_database()
    {

        $sql_path = base_path('database/data.sql');
        $do = DB::unprepared(file_get_contents($sql_path));

        if ($do) {
            setEnv('DB_IMPORTED', 1);
            return redirect('/install/step3');
        }
    }

    // View step 3 page
    public function step3()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 0) {
            return redirect()->route('install/step1');
        }
        if (env('DB_IMPORTED') == 0) {
            return redirect()->route('install/step2');
        }
        if (env('INFO_INSTALLED') == 1) {
            return redirect()->route('install/step4');
        }

        return view('install.step3');
    }

    // Step 3 Update site name & set asset URL
    public function set_siteinfo(Request $request)
    {

        $validate = $request->validate([
            'site_name' => ['required', 'string'],
            'site_url' => ['required'],
        ]);

        $update = Settings::updateSettings('name', $request['site_name']);
        $update = Settings::updateSettings('site_url', $request['site_url']);

        if ($update) {
            setEnv('INFO_INSTALLED', 1);
            setEnv('APP_URL', trim($request['site_url']));
            setEnv('APP_NAME', str_replace(' ', '', $request['site_name']));
            return redirect('/install/step4');
        } else {

            $request->session()->flash('error', 'Cannot find settings id');
            return redirect()->back();
        }
    }

    // View step 4 page
    public function step4()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 0) {
            return redirect()->route('install/step1');
        }
        if (env('DB_IMPORTED') == 0) {
            return redirect()->route('install/step2');
        }
        if (env('INFO_INSTALLED') == 0) {
            return redirect()->route('install/step3');
        }

        return view('install.step4');
    }

    // Step 4 Set admin information
    public function set_admininfo(Request $request)
    {

        $currentDateTime = Carbon::now();

        for ($x = 1; $x <= 6; $x++) {

            $email_statistic = new Statistic();
            $email_statistic->key = "total_email_pay_day";
            $email_statistic->value = 0;
            $email_statistic->created_at = Carbon::now()->addDays(-$x);
            $email_statistic->save();
    
            $message_statistic = new Statistic();
            $message_statistic->key = "total_messges_pay_day";
            $message_statistic->value = 0;
            $message_statistic->created_at = Carbon::now()->addDays(-$x);
            $message_statistic->save();
        }


        $validate = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $register = User::create([
            'name' => 'Admin Admin',
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 1,
            'avater' => "uploads/avatar-place.png",
        ]);

        if ($register) {

            setEnv('SYSTEM_INSTALLED', 1);
            setEnv('ADMIN_INSTALLED', 1);
            Auth::login($register);
            return redirect('admin/dashboard');
        }
    }

}
