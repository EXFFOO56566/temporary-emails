<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Page extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'slug', 'content', 'status', 'lang', 'mete_title', 'meta_description'];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
