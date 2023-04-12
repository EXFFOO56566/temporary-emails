<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use voku\helper\AntiXSS;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.menu.index')->with('links', Menu::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the Menu fields

        
        
            $request->validate([
                'icon' => 'required_without:title|max:255',
                'title' => 'required_without:icon|max:255',
                'url' => 'required|max:255|url',
                'postion' => 'boolean',
                'target' => 'boolean',
            ]);



        if ($request->target == null) {
            $request->target = 0;
        }

        $antiXss = new AntiXSS();

        $request_icon = strip_tags($request->icon, '<i>');

        $icon = $antiXss->xss_clean($request_icon);

        $menu = new Menu();
        $menu->icon =  $icon;
        $menu->title = $request->title;
        $menu->url = $request->url;
        $menu->postion = $request->postion;
        $menu->target = $request->target;
        $menu->save();

        session()->flash('success', 'Link Created Successfuly');
        return redirect(route('menu.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Menu
     */
    public function edit(Menu $menu)
    {

        return view('backend.menu.edit')->with('menu', $menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $Menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {

        $request->validate([
            'icon' => 'required_without:title|max:255',
            'title' => 'required_without:icon|max:255',
            'url' => 'required|max:255|url',
            'postion' => 'boolean',
            'target' => 'boolean',
        ]);


        if ($request->target == null) {
            $request->target = 0;
        }


        $antiXss = new AntiXSS();

        $request_icon = strip_tags($request->icon, '<i>');

        $icon = $antiXss->xss_clean($request_icon);

        $menu->update([
            'icon' => $icon,
            'title' => $request->title,
            'url' => $request->url,
            'postion' => $request->postion,
            'target' => $request->target,
        ]);

        session()->flash('success', 'Link Updated Successfuly');
        return redirect(route('menu.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        session()->flash('success', 'Link Deleted Successfuly');

        return redirect(route('menu.index'));
    }
}
