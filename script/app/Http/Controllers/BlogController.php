<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Settings;
use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BlogController extends Controller
{
    public function index()
    {
        $locale = LaravelLocalization::getCurrentLocale();


        $title = translate('Blog Title', 'seo');
        $description = translate('Blog Description', 'seo');
        $keyword = translate('Blog keywords', 'seo');
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

        $limit = Settings::selectSettings('max_posts');
        $posts = Post::where("status", "=", 1)->where("lang", $locale)->orderBy('created_at', 'DESC')->paginate($limit);
        return view('frontend.blog', compact('posts'));
    }
}
