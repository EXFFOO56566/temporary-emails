<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Settings;
use App\Models\TrashMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Exception;
use Vinkla\Hashids\Facades\Hashids;




class APIController extends Controller
{
    // only for admin
    public function admin_api()
    {

        $check = Settings::where('key', '=', 'key_api')->count();

        //dd($check);
        if ($check == 0) {
            $setting = new Settings();
            $setting->key = "key_api";
            $setting->value = Str::random(40);
            $setting->save();
        } else {

            if (empty(Settings::selectSettings("key_api"))) {

                Settings::updateSettings("key_api", Str::random(40));
            }
        }

        $settings = Settings::get();
        $setting = $settings->pluck('value', 'key')->all();
        return view('backend.settings.api.index')->with("setting", $setting);
    }


    public function domains($key)
    {

        if ($key == Settings::selectSettings("key_api")) {
            if (Str::length(Settings::selectSettings("domains")) > 0) {

                $domains = explode(',', Settings::selectSettings("domains"));

                $arrNewSku = array();
                $incI = 1;
                foreach ($domains as $arrKey => $arrData) {
                    $arrNewSku[$incI] = $arrData;
                    $incI++;
                }

                $response = [
                    'status' => "success",
                    'data'   => ["domains" => $arrNewSku]
                ];
            } else {

                $response = [
                    'status' => "error",
                    'message'   => "You must add a domain"
                ];

                //abort(401, 'You must add a domain');
            }
        } else {

            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }

    private function generateRandomEmail($length = 7, $num = 3)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '013456789';
        $charactersLength = strlen($characters);
        $numbersLength = strlen($numbers);
        $randomEmail = '';
        for ($i = 0; $i < $length; $i++) {
            $randomEmail .= $characters[rand(0, $charactersLength - 1)];
        }
        for ($i = 0; $i < $num; $i++) {
            $randomEmail .= $numbers[rand(0, $numbersLength - 1)];
        }

        $randomEmail .= "@";

        if (Str::length(Settings::selectSettings("domains")) > 0) {
            $domain = explode(',', Settings::selectSettings("domains"));
            $randomEmail .= $domain[array_rand($domain)];
        } else {
            abort(401, 'You must add a domain');
        }

        if (TrashMail::where('email',  $randomEmail)->exists()) {
            return generateRandomEmail();
        } else {
            return $randomEmail;
        }
    }


    private function generateEmailToken($email)
    {

        $date = Carbon::now();
        if (Settings::selectSettings("email_lifetime_type") == 1) {
            $newDateTime = Carbon::now()->addMinutes(Settings::selectSettings("email_lifetime"));
        } elseif (Settings::selectSettings("email_lifetime_type") == 60) {
            $newDateTime = Carbon::now()->addHours(Settings::selectSettings("email_lifetime"));
        } else {
            $newDateTime = Carbon::now()->addDays(Settings::selectSettings("email_lifetime"));
        }

        $response = [
            'status' => "success",
            'data'   => [
                "email" => $email,
                "email_token" => Crypt::encryptString($email),
                "deleted_in" => $newDateTime->format("Y-m-d H:i:s")
            ]
        ];

        return $response;
    }


    public function email_create($key)
    {

        if ($key == Settings::selectSettings("key_api")) {

            $response = $this->generateEmailToken($this->generateRandomEmail());
        } else {

            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }



    public function messages($email, $key)
    {



        if ($key == Settings::selectSettings("key_api") && isset($email)) {


            try {
                $new_email = Crypt::decryptString($email);
            } catch (Exception $e) {

                $response = [
                    'status' => "error",
                    'message'   => "The token is invalid or has expired"
                ];

                return response()->json($response);
            }

            $check = TrashMail::where('email', '=', $new_email)->count();


            if ($check == 0) {

                $date = Carbon::now();
                if (Settings::selectSettings("email_lifetime_type") == 1) {
                    $newDateTime = Carbon::now()->addMinutes(Settings::selectSettings("email_lifetime"));
                } elseif (Settings::selectSettings("email_lifetime_type") == 60) {
                    $newDateTime = Carbon::now()->addHours(Settings::selectSettings("email_lifetime"));
                } else {
                    $newDateTime = Carbon::now()->addDays(Settings::selectSettings("email_lifetime"));
                }

                $email = $new_email;
                Settings::updateSettings(
                    'total_emails_created',
                    Settings::selectSettings('total_emails_created') + 1
                );

                $trashmail = new TrashMail();
                $trashmail->email = $email;
                $trashmail->delete_in = $newDateTime;
                $trashmail->save();
            }

            $messages  = TrashMail::allMessagesApi($new_email);

            $response = [
                'status' => "success",
                'data'   => $messages
            ];
        } else {
            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }


    public function message($id, $key)
    {


        if ($key == Settings::selectSettings("key_api") && isset($id)) {

            try {

                $message = TrashMail::messages($id);

                $response = [
                    'status' => "success",
                    'data'   => $message
                ];
            } catch (Exception $e) {

                $response = [
                    'status' => "error",
                    'message'   => "The ID is invalid or has expired"
                ];

                return response()->json($response);
            }
        } else {
            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }


    public function message_delete($id, $key)
    {

        if ($key == Settings::selectSettings("key_api") && isset($id)) {

            try {

                $id = Hashids::decode($id);
                TrashMail::DeleteMessage($id[0]);

                $response = [
                    'status' => "success",
                    'message'   => "the message has been deleted"
                ];
            } catch (Exception $e) {

                $response = [
                    'status' => "error",
                    'message'   => "The messge ID is invalid or has expired"
                ];

                return response()->json($response);
            }
        } else {

            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }


    public function email_delete($email, $key)
    {

        if ($key == Settings::selectSettings("key_api") && isset($email)) {

            try {

                $now = Carbon::now();

                $new_email = Crypt::decryptString($email);

                $check = TrashMail::where('email', '=', $new_email)->count();

                if ($check > 0) {
                    $trash = TrashMail::where('email', $email)->first();
                    if ($trash) {
                        $trash->update([
                            'delete_in' => $now,
                        ]);
                    }
                }

                $response = $this->generateEmailToken($this->generateRandomEmail());
            } catch (Exception $e) {

                $response = [
                    'status' => "error",
                    'message'   => "The token is invalid or has expired"
                ];

                return response()->json($response);
            }
        } else {
            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }



    public function email_change($email, $username, $domain, $key)
    {

        if ($key == Settings::selectSettings("key_api") && isset($domain) && isset($username) && isset($email)) {

            try {
                $oldEmail = Crypt::decryptString($email);
            } catch (Exception $e) {

                $response = [
                    'status' => "error",
                    'message'   => "The token is invalid or has expired"
                ];

                return response()->json($response);
            }



            $forbidden_id = explode(',', Settings::selectSettings('forbidden_id'));

            if (in_array($username, $forbidden_id)) {

                $response = [
                    'status' => "error",
                    'message'   => "Username forbidden"
                ];
            } else {

                $domains = explode(',', Settings::selectSettings("domains"));

                if (in_array($domain, $domains)) {

                    $new_email =  $username . "@" .  $domain;

                    $check = TrashMail::where('email', '=', $new_email)->count();

                    if ($check == 0) {

                        $now = Carbon::now();

                        $check_old = TrashMail::where('email', '=', $oldEmail)->count();

                        if ($check_old > 0) {
                            $trash = TrashMail::where('email', $email)->first();
                            if ($trash) {
                                $trash->update([
                                    'delete_in' => $now,
                                ]);
                            }
                        }

                        $response = $this->generateEmailToken($new_email);
                    } else {

                        $response = [
                            'status' => "error",
                            'message'   => "The address you have chosen is already in use. Please choose a different one."
                        ];
                    }
                } else {

                    $response = [
                        'status' => "error",
                        'message'   => "The domain does not exist or has been deleted"
                    ];
                }
            }
        } else {
            $response = [
                'status' => "error",
                'message'   => "You are not authorized"
            ];
        }

        return response()->json($response);
    }
}
