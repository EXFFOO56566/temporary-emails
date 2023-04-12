<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    // get setting by key
    public static function selectSettings($key)
    {
        $setting = Settings::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return false;
    }

    // update setting to tabel
    public static function updateSettings($key, $value)
    {
        $setting = Settings::where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            return $setting->save();
        }
        return false;
    }
}
