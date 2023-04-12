<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Settings;
use App\Models\TrashMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Crypt;
use Exception;




class TrashMailController extends Controller
{

    // show home page
    public function index()
    {
        $title = translate('Home Page Title', 'seo');
        $description = translate('Home Page Description', 'seo');
        $keyword = translate('Home Page keywords', 'seo');
        $canonical = url()->current();
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setKeywords($keyword);
        SEOMeta::setCanonical($canonical);
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setSiteName(Settings::selectSettings('name'));
        OpenGraph::addImage(asset(Settings::selectSettings('og_image')));
        OpenGraph::setUrl($canonical);
        OpenGraph::addProperty('type', 'article');
        return view('frontend.index');
    }


    // generat email and check if unique
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


    // get all messages from
    public function messages(Request $request)
    {


        if (!empty(Settings::selectSettings("INVISIBLE_SITE_KEY")) && !empty(Settings::selectSettings("INVISIBLE_SECRET_KEY"))) {


            $secretKey = Settings::selectSettings("INVISIBLE_SECRET_KEY");

            if (isset($request->captcha) && !empty($request->captcha)) {
                // Get verify response data

                $rq = $request->captcha;

                $responseData = Cache::remember($rq, 30 * 60, function () use ($rq, $secretKey) {

                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $rq);
                    $responseData = json_decode($verifyResponse);

                    return $responseData;
                });

                if ($responseData->success) {


                    if (Cookie::has('email')) {
                        $email =  Cookie::get('email');
                    } else {

                        $date = Carbon::now();
                        if (Settings::selectSettings("email_lifetime_type") == 1) {
                            $newDateTime = Carbon::now()->addMinutes(Settings::selectSettings("email_lifetime"));
                        } elseif (Settings::selectSettings("email_lifetime_type") == 60) {
                            $newDateTime = Carbon::now()->addHours(Settings::selectSettings("email_lifetime"));
                        } else {
                            $newDateTime = Carbon::now()->addDays(Settings::selectSettings("email_lifetime"));
                        }


                        $email = $this->generateRandomEmail();
                        Cookie::queue('email', $email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));
                        Settings::updateSettings(
                            'total_emails_created',
                            Settings::selectSettings('total_emails_created') + 1
                        );

                        $trashmail = new TrashMail();
                        $trashmail->email = $email;
                        $trashmail->delete_in = $newDateTime;
                        $trashmail->save();
                    }

                    $response  = TrashMail::allMessages($email);

                    return $response;
                } else {
                    return response()->json(['error' => false, 'message' => "Robot verification failed, please try again"], 404);
                }
            } else {
                return response()->json(['error' => false, 'message' => "Robot verification failed, please try again"], 404);
            }
        } else {

            if (Cookie::has('email')) {
                $email =  Cookie::get('email');
            } else {

                $date = Carbon::now();
                if (Settings::selectSettings("email_lifetime_type") == 1) {
                    $newDateTime = Carbon::now()->addMinutes(Settings::selectSettings("email_lifetime"));
                } elseif (Settings::selectSettings("email_lifetime_type") == 60) {
                    $newDateTime = Carbon::now()->addHours(Settings::selectSettings("email_lifetime"));
                } else {
                    $newDateTime = Carbon::now()->addDays(Settings::selectSettings("email_lifetime"));
                }


                $email = $this->generateRandomEmail();
                Cookie::queue('email', $email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));
                Settings::updateSettings(
                    'total_emails_created',
                    Settings::selectSettings('total_emails_created') + 1
                );

                $trashmail = new TrashMail();
                $trashmail->email = $email;
                $trashmail->delete_in = $newDateTime;
                $trashmail->save();
            }

            $response  = TrashMail::allMessages($email);

            return $response;
        }
    }

    //delete email
    public function delete()
    {
        if (Cookie::has('count') && Cookie::get('count') >= 5) {
            return back();
        }

        $now = Carbon::now();

        if (Cookie::has('email')) {
            $email =  Cookie::get('email');
            $trash = TrashMail::where('email', $email)->first();
            if ($trash) {
                $trash->update([
                    'delete_in' => $now,
                ]);
            }

            Cookie::queue(Cookie::forget('email'));
        }

        if (Cookie::has('count')) {
            $count =  Cookie::get('count');
            Cookie::queue('count', $count + 1, 3);
        } else {
            Cookie::queue('count', 1, 3);
        }
        return redirect(route('home'));
    }

    //check_bot
    public function check_bot(Request $request)
    {

        if (!empty(env('RECAPTCHA_SECRET_KEY'))) {
            $request->validate([
                'g-recaptcha-response' => 'required|captcha'
            ]);
        }

        if (Cookie::has('count') && Cookie::get('count') >= 5) {

            Cookie::queue(Cookie::forget('count'));

            return back();
        }
    }

    // delete messgae
    public function deletemessage($id)
    {

        if (Cache::has($id)) {
            Cache::forget($id);
        }
        $id = Hashids::decode($id);

        TrashMail::DeleteMessage($id[0]);

        return redirect(route('home'));
    }


    //show message
    public function show($id)
    {
        $message[] = Cache::remember($id, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type") * 60, function () use ($id) {
            return TrashMail::messages($id);
        });


        $title = translate('Default Title', 'seo');
        $description = translate('Default Description', 'seo');
        $keyword = translate('Default keywords', 'seo');
        $canonical = url()->current();
        SEOMeta::setTitle($title . ' ' . Settings::selectSettings('separator') . ' ' . $message[0]['subject']);
        SEOMeta::setDescription($description);
        SEOMeta::setKeywords($keyword);
        SEOMeta::setCanonical($canonical);
        OpenGraph::setTitle($title . ' ' . Settings::selectSettings('separator') . ' ' . $message[0]['subject']);
        OpenGraph::setDescription($description);
        OpenGraph::setSiteName(Settings::selectSettings('name'));
        OpenGraph::addImage(asset(Settings::selectSettings('og_image')));
        OpenGraph::setUrl($canonical);
        OpenGraph::addProperty('type', 'article');


        return view('frontend.view')->with('message', $message[0]);
    }



    //show message content
    public function message($id)
    {
        $message[] = Cache::remember($id, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type") * 60, function () use ($id) {
            return TrashMail::messages($id);
        });

        return $message[0]['content'];
    }


    // download files
    public function download($id, $file)
    {
        $id = Hashids::decode($id);

        if (file_exists('temp/attachments/' . $id[0] . '/' . $file)) {
            return response()->download('temp/attachments/' . $id[0] . '/' . $file);
        } else {
            abort(404);
        }
    }


    public function change()
    {

        $title = translate('Change Page Title', 'seo');
        $description = translate('Change Page Description', 'seo');
        $keyword = translate('Change Page keywords', 'seo');
        $canonical = url()->current();
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setKeywords($keyword);
        SEOMeta::setCanonical($canonical);
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setSiteName(Settings::selectSettings('name'));
        OpenGraph::addImage(asset(Settings::selectSettings('og_image')));
        OpenGraph::setUrl($canonical);
        OpenGraph::addProperty('type', 'article');

        return view('frontend.change');
    }

    // create new Custom Email
    public function create(Request $request)
    {

        if (Cookie::has('count') && Cookie::get('count') >= 5) {
            return back();
        }

        if (Cookie::has('count')) {
            $count =  Cookie::get('count');
            Cookie::queue('count', $count + 1, 3);
        } else {
            Cookie::queue('count', 1, 3);
        }

        $request->validate([
            'name' => 'required|max:100|min:1|alpha_num|notIn:' . implode(',', explode(',', Settings::selectSettings('forbidden_id'))),
            'domain' => 'required|in:' . implode(',', explode(',', Settings::selectSettings('domains'))),
        ]);

        $new_email =  $request->name . "@" .  $request->domain;

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


            if (Cookie::has('email')) {
                $email =  Cookie::get('email');
                $trash = TrashMail::where('email', $email)->first();
                if ($trash) {
                    $trash->update([
                        'delete_in' => $date,
                    ]);
                }
                Cookie::queue(Cookie::forget('email'));
                $email = $this->generateRandomEmail();
                Cookie::queue('email', $new_email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));

                Settings::updateSettings(
                    'total_emails_created',
                    Settings::selectSettings('total_emails_created') + 1
                );

                $trashmail = new TrashMail();
                $trashmail->email = $new_email;
                $trashmail->delete_in = $newDateTime;
                $trashmail->save();

                return redirect(route('home'));
            }
        } else {

            session()->flash('error', translate('The address you have chosen is already in use. Please choose a different one.'));
            return redirect(route('change'));
        }
    }



    // create new Custom Email by token
    public function tokenToEmail($email)
    {


        try {
            $new_email = Crypt::decryptString($email);
        } catch (Exception $e) {
            return redirect(route('home'));
        }


        $check = TrashMail::where('email', '=', $new_email)->count();

        $date = Carbon::now();

        if ($check == 0) {


            if (Settings::selectSettings("email_lifetime_type") == 1) {
                $newDateTime = Carbon::now()->addMinutes(Settings::selectSettings("email_lifetime"));
            } elseif (Settings::selectSettings("email_lifetime_type") == 60) {
                $newDateTime = Carbon::now()->addHours(Settings::selectSettings("email_lifetime"));
            } else {
                $newDateTime = Carbon::now()->addDays(Settings::selectSettings("email_lifetime"));
            }

            if (Cookie::has('email')) {
                $email =  Cookie::get('email');
                $trash = TrashMail::where('email', $email)->first();
                if ($trash) {
                    $trash->update([
                        'delete_in' => $date,
                    ]);
                }
                Cookie::queue(Cookie::forget('email'));

                Cookie::queue('email', $new_email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));

                Settings::updateSettings(
                    'total_emails_created',
                    Settings::selectSettings('total_emails_created') + 1
                );

                $trashmail = new TrashMail();
                $trashmail->email = $new_email;
                $trashmail->delete_in = $newDateTime;
                $trashmail->save();
            } else {

                Cookie::queue('email', $new_email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));

                Settings::updateSettings(
                    'total_emails_created',
                    Settings::selectSettings('total_emails_created') + 1
                );

                $trashmail = new TrashMail();
                $trashmail->email = $new_email;
                $trashmail->delete_in = $newDateTime;
                $trashmail->save();
            }
        } else {

            if (Cookie::has('email')) {
                $email =  Cookie::get('email');
                $trash = TrashMail::where('email', $email)->first();
                if ($trash) {
                    $trash->update([
                        'delete_in' => $date,
                    ]);
                }
                Cookie::queue(Cookie::forget('email'));

                Cookie::queue('email', $new_email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));
            } else {

                Cookie::queue('email', $new_email, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type"));
            }
        }


        return view('frontend.index');
    }
}
