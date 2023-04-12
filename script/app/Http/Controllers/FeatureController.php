<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Language;
use Illuminate\Http\Request;
use voku\helper\AntiXSS;


class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.features.index')->with('features', Feature::all())->with("languages", Language::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the Feature fields
        $request->validate([
            'icon' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:300',
            'lang' => 'required',
        ]);

        $antiXss = new AntiXSS();

        $request_icon = strip_tags($request->icon, '<i>');

        $icon = $antiXss->xss_clean($request_icon);

        $feature = new Feature();
        $feature->icon =  $icon;
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->lang = $request->lang;
        $feature->save();

        session()->flash('success', 'Feature Created Successfuly');
        return redirect(route('features.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Feature
     */
    public function edit(Feature $feature)
    {

        return view('backend.features.edit')->with('feature', $feature)->with("languages", Language::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature  $Feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {

        $request->validate([
            'icon' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|max:300',
            'lang' => 'required',
        ]);


        $antiXss = new AntiXSS();

        $request_icon = strip_tags($request->icon, '<i>');

        $icon = $antiXss->xss_clean($request_icon);

        $feature->update([
            'icon' => $icon,
            'title' => $request->title,
            'description' => $request->description,
            'lang' => $request->lang,
        ]);

        session()->flash('success', 'Feature Updated Successfuly');
        return redirect(route('features.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        session()->flash('success', 'Feature Deleted Successfuly');

        return redirect(route('features.index'));
    }

    
}
