<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ChangeLangObserver;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'rtl'];


    protected static function boot()
    {
        parent::boot();
        Language::observe(ChangeLangObserver::class);
    }

}
