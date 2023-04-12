<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Translate;
use Illuminate\Http\Request;
use voku\helper\AntiXSS;
use App\Models\Settings;
use Illuminate\Support\Facades\Cookie;
use App\Models\Feature;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = Language::pluck('code')->toarray();
        return view('backend.settings.languages.index')->with('languages', Language::all())->with('lang', $lang);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate the Language fields
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:10|unique:languages',
            'rtl' => 'boolean',
        ]);

        if ($request->rtl == null) {
            $request->rtl = 0;
        }

        $language = new Language();
        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = $request->rtl;

        $language->save();

        $translates = Translate::where('lang', Settings::selectSettings('lang'))->get();

        foreach ($translates as $translate) {

            $new_translate = new Translate();
            $new_translate->lang = $request->code;
            $new_translate->key = $translate->key;
            $new_translate->collection = $translate->collection;
            $new_translate->value = "";
            $new_translate->save();
        }


        session()->flash('success', 'Language Created Successfuly');
        return redirect(route('languages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        $translates = Translate::where('lang', $language->code)->where('collection', 'general')->get();
        return view('backend.settings.languages.show', compact('language', 'translates'));
    }


    public function show_seo(Language $language)
    {
        $translates = Translate::where('lang', $language->code)->where('collection', 'seo')->get();
        return view('backend.settings.languages.show', compact('language', 'translates'));
    }


    public function text(Language $language)
    {
        $translates = Translate::where('lang', $language->code)->where('collection', 'text')->get();
        return view('backend.settings.languages.show', compact('language', 'translates'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        $lang = Language::pluck('code')->toarray();

        if (($key = array_search($language->code, $lang)) !== false) {
            unset($lang[$key]);
        }

        return view('backend.settings.languages.edit')->with('language', $language)->with('lang', $lang);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */

    public function update_translation(Request $request)
    {
        foreach ($request->values as $id => $value) {

            $translation = Translate::where('id', '=', $id)->first();
            if ($translation != null) {

                //dd($value);

                //$antiXss = new AntiXSS();

                //$value_check = strip_tags($value, '<b><u><i><a><span><h1><h2><h3><h4><h5><h6><br>');

                //$value__after_check = $antiXss->xss_clean($value_check);

                $translation->value = $value;
                $translation->save();
            }
        }

        session()->flash('success', 'Updated Successfuly');
        return redirect()->back();
    }


    public function update(Request $request, Language $language)
    {

        if (Settings::selectSettings('lang') == $language->code) {
            session()->flash('error', 'Default language can not be edited');
            return redirect(route('languages.index'));
        }

        //validate the Language fields
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:10',
            'rtl' => 'boolean',
        ]);

        if ($request->rtl == null) {
            $request->rtl = 0;
        }

        $old_lang = $language->code;

        $language->update([
            'name' => $request->name,
            'code' => $request->code,
            'rtl' => $request->rtl,
        ]);


        $translates = Translate::where('lang', $old_lang)->get();

        foreach ($translates as $translate) {
            $translate->update([
                'lang' => $request->code,
            ]);
        }


        session()->flash('success', 'Language Created Successfuly');
        return redirect(route('languages.index'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {

        if (Settings::selectSettings('lang') == $language->code) {
            session()->flash('error', 'Default language can not be deleted');
            return redirect(route('languages.index'));
        }

        $old_lang =  $language->code;

        $language->delete();

        $translates = Translate::where('lang', $old_lang)->get();

        foreach ($translates as $translate) {
            $translate->delete();
        }

        session()->flash('success', 'Language Deleted Successfuly');

        return redirect(route('languages.index'));
    }


    public function switchLang($lang)
    {

        $language = Language::pluck('code')->toarray();

        if (in_array($lang, $language)) {
            Cookie::queue('locale', $lang, 365 * 1440);
        }

        return redirect()->back();
    }
}
