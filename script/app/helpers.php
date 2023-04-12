<?php

use App\Models\Translate;
use App\Models\Language;
use Illuminate\Support\Str;
use File as fle;






//We use this to convert date to new format

function ToDate($date)
{
    return $date->format('Y-m-d');
};


//We use this to translate text

function translate($key, $coll = 'general',  $lang = null)
{
    if ($lang == null) {
        $lang = App::getLocale();
    }

    // if Translate = 0 create new one
    $translation = Translate::where('lang', env('DEFAULT_LANGUAGE', 'en'))->where('key', $key)->where('collection', $coll)->first();
    if ($translation == null) {

        foreach (Language::all() as $lang) {
            $translation = new Translate;
            $translation->lang = $lang['code'];
            $translation->key = $key;
            $translation->value = null;
            $translation->collection = $coll;
            $translation->save();
        }
    }

    $translation_locale = Translate::where('key', $key)->where('lang', $lang)->where('collection', $coll)->first();
    if ($translation_locale != null && $translation_locale->value != null) {
        return $translation_locale->value;
    } elseif ($translation->value != null) {
        return $translation->value;
    } else {
        return $key;
    }
};



//We use this to remove files

function removeFile($path)
{
    if (!file_exists($path)) {
        return true;
    }
    return fle::delete($path);
};

// We use this to make files directory

function makeDirectory($path)
{
    if (fle::exists($path)) {
        return true;
    }
    return fle::makeDirectory($path, 0775, true);
};


// We use this to upload images

function FileUpload($file, $location, $old = null, $specificName = null)
{
    //$path = makeDirectory($location);
    if (!empty($old)) {
        removeFile($old);
    }
    if (!empty($specificName)) {
        $filename = $specificName . '.' . $file->getClientOriginalExtension();
    } else {
        $filename = Str::random(15) . '_' . time() . '.' . $file->getClientOriginalExtension();
    }
    $file->move($location, $filename);
    return $location . $filename;
};


function Upload_license($file, $location, $old = null)
{
    //$path = makeDirectory($location);
    if (!empty($old)) {
        removeFile($old);
    }

    $filename = $file->getClientOriginalName();

    $file->move($location, $filename);
    return $location . $filename;
};



function getSupportedLocales()
{
    $locales = [];

    foreach (Language::all() as $lang) {
        $locales[$lang->code] = [
            'name' => $lang->name
        ];
    }

    return $locales;
}



function setEnv($key, $value)
{
    $path = base_path('.env');

    if (is_bool(env($key))) {
        $old = env($key) ? 'true' : 'false';
    } elseif (env($key) === null) {
        $old = 'null';
    } else {
        $old = env($key);
    }

    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            "$key=" . $old,
            "$key=" . $value,
            file_get_contents($path)
        ));
    }
}
