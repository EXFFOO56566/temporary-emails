<?php

namespace App\Observers;

use App\Models\Language;
use App\Models\Post;
use App\Models\Feature;
use App\Models\Category;
use App\Models\Page;

class ChangeLangObserver
{
    /**
     * Handle the Language "created" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function created(Language $language)
    {
        //
    }

    /**
     * Handle the Language "updated" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function updated(Language $language)
    {

        if($language->wasChanged('code')){

            $old_lang = $language->getOriginal('code');
            $new_lang = $language->code;

            $features = Feature::where('lang', $old_lang)->get();
            foreach($features as $feature){
                $feature->update([
                    'lang' => $new_lang,
                ]);
            }

            $posts = Post::where('lang', $old_lang)->get();
            foreach($posts as $post){
                $post->update([
                    'lang' => $new_lang,
                ]);
            }

            $pages = Page::where('lang', $old_lang)->get();
            foreach($pages as $page){
                $page->update([
                    'lang' => $new_lang,
                ]);
            }

            $categories = Category::where('lang', $old_lang)->get();
            foreach($categories as $category){
                $category->update([
                    'lang' => $new_lang,
                ]);
            }
        }
    }

    /**
     * Handle the Language "deleted" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function deleted(Language $language)
    {
            $old_lang = $language->code;

            $features = Feature::where('lang', $old_lang)->get();
            foreach($features as $feature){
                $feature->delete();
            }

            $posts = Post::where('lang', $old_lang)->get();
            foreach($posts as $post){
                $post->delete();
            }

            $pages = Page::where('lang', $old_lang)->get();
            foreach($pages as $page){
                $page->delete();
            }

            $categories = Category::where('lang', $old_lang)->get();
            foreach($categories as $category){
                $category->delete();
            }

    }

    /**
     * Handle the Language "restored" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function restored(Language $language)
    {
        //
    }

    /**
     * Handle the Language "force deleted" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function forceDeleted(Language $language)
    {

    }
}
