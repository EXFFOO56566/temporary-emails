<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Settings;
use App\Models\Post;
use App\Models\Language;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.categories.index')->with('categories', Category::all())->with("languages", Language::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the category fields
        $request->validate([
            'name' => 'required|max:255|min:2',
            'slug' => 'required|unique:categories|alpha_dash',
            'lang' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->lang = $request->lang;
        $category->slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        $category->save();

        session()->flash('success', 'Category Created Successfuly');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = Category::where('slug', $category)->first();

        if($category['lang'] ==  LaravelLocalization::getCurrentLocale()){

            $title = translate('Default Title', 'seo');
            $description = translate('Default Description', 'seo');
            $keyword = translate('Default keywords', 'seo');
            $canonical = url()->current();
            SEOMeta::setTitle($title . ' ' .Settings::selectSettings('separator'). ' ' . $category->name);
            SEOMeta::setDescription($description);
            SEOMeta::setKeywords($keyword);
            SEOMeta::setCanonical($canonical);
            OpenGraph::setTitle($title . ' ' .Settings::selectSettings('separator'). ' ' . $category->name);
            OpenGraph::setDescription($description);
            OpenGraph::setSiteName(Settings::selectSettings('name'));
            OpenGraph::addImage(asset(Settings::selectSettings('og_image')));
            OpenGraph::setUrl($canonical);
            OpenGraph::addProperty('type', 'article');


            $limit = Settings::selectSettings('max_posts');
            $posts = Post::where("status", "=", 1)->where("category_id", "=", $category->id)->orderBy('created_at', 'DESC')->paginate($limit);

            return view('frontend.category', compact('posts', 'category'));

        }else{
            return redirect(route('home'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('backend.categories.edit')->with('category', $category)->with("languages", Language::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'required|max:255|min:2',
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'lang' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
            'lang' => $request->lang,
            'slug' => SlugService::createSlug(Category::class, 'slug', $request->slug, ['unique' => false])
        ]);

        session()->flash('success', 'Category Updated Successfuly');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        session()->flash('success', 'Category Deleted Successfuly');

        return redirect(route('categories.index'));
    }


    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
