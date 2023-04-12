<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Translate;
use Illuminate\Http\Request;
use voku\helper\AntiXSS;

class TranslateController extends Controller
{

    public function index()
    {
        return view('backend.settings.frontend')->with("translation", Translate::all());
    }


    public function update(Request $request, Translate $translate)
    {
        foreach ($request->values as $id => $value) {

            $translation = Translate::where('id', '=', $id)->first();
            if ($translation != null) {
                
                $antiXss = new AntiXSS();

                $value_check = strip_tags($value, '<b><u><i><a><span><h1><h2><h3><h4><h5><h6><br>');

                $value__after_check = $antiXss->xss_clean($value_check);

                $translation->value = $value__after_check;
                $translation->save();
            }
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect(route('settings.frontend'));
    }
}
