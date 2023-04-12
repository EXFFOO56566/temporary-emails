<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use voku\helper\AntiXSS;
use App\Models\Settings;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\Models\Language;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pages.index')->with('pages', Page::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.create')->with("languages", Language::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|max:255|min:2',
            'slug' => 'required|unique:pages|alpha_dash',
            'content' => 'required|min:2',
            'status' => 'boolean|required',
            'lang' => 'required',
            'meta_description' => 'nullable|max:160',
            'mete_title' => 'nullable|max:100',
        ]);

        $antiXss = new AntiXSS();

        $antiXss->removeEvilAttributes(array('style'));

        $antiXss->removeEvilHtmlTags(array('iframe'));

        $description = $antiXss->xss_clean($request->content);

        $page = new Page();
        $page->title = $request->title;
        $page->status = $request->status;
        $page->content = $description;
        $page->lang = $request->lang;
        $page->meta_description = $request->meta_description;
        $page->mete_title = $request->mete_title;
        $page->slug = SlugService::createSlug(Page::class, 'slug', $request->title);
        $page->save();

        session()->flash('success', 'Page Created Successfuly');
        return redirect(route('pages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {

        $page = Page::where("slug", "=", $page)->first();

        if ($page['status'] == 1) {

            if ($page['lang'] ==  LaravelLocalization::getCurrentLocale()) {

                $title = translate('Default Title', 'seo');
                $description = translate('Default Description', 'seo');
                $keyword = translate('Default keywords', 'seo');
                $canonical = url()->current();

                if ($page->mete_title == null) {
                    SEOMeta::setTitle($page->title . ' ' . Settings::selectSettings('separator') . ' ' . $title);
                    OpenGraph::setTitle($page->title . ' ' . Settings::selectSettings('separator') . ' ' . $title);
                } else {
                    SEOMeta::setTitle($page->mete_title);
                    OpenGraph::setTitle($page->mete_title);
                }

                if ($page->meta_description == null) {
                    SEOMeta::setDescription($description);
                    OpenGraph::setDescription($description);
                } else {
                    SEOMeta::setDescription($page->meta_description);
                    OpenGraph::setDescription($page->meta_description);
                }

                SEOMeta::setKeywords($keyword);
                SEOMeta::setCanonical($canonical);
                OpenGraph::setSiteName(Settings::selectSettings('name'));
                OpenGraph::addImage(asset(Settings::selectSettings('og_image')));
                OpenGraph::setUrl($canonical);
                OpenGraph::addProperty('type', 'article');

                return view('frontend.page', compact('page'));
            } else {

                return redirect(route('home'));
            }
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('backend.pages.edit')->with('page', $page)->with("languages", Language::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {

        //dd($request);
        $request->validate([
            'title' => 'required|max:255|min:2',
            'slug' => 'required|alpha_dash|unique:pages,slug,' . $page->id,
            'content' => 'required|min:2',
            'status' => 'boolean|required',
            'lang' => 'required',
            'meta_description' => 'nullable|max:160',
            'mete_title' => 'nullable|max:100',
        ]);

        $antiXss = new AntiXSS();

        $antiXss->removeEvilAttributes(array('style'));

        $antiXss->removeEvilHtmlTags(array('iframe'));

        $description = $antiXss->xss_clean($request->content);

        $page->update([
            $page->title = $request->title,
            $page->status = $request->status,
            $page->content = $description,
            $page->slug = $request->slug,
            $page->mete_title = $request->mete_title,
            $page->meta_description = $request->meta_description,
            $page->lang = $request->lang
        ]);


        session()->flash('success', 'Page Updated Successfuly');
        return redirect(route('pages.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();

        session()->flash('success', 'Page Deleted Successfuly');

        return redirect(route('pages.index'));
    }


    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Page::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }


    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('upload')->move('./uploads/', $filenametostore);

            // $file->move('./uploads/', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset("/uploads/" . $filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
