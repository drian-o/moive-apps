<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
        'google_indexed',
        'google_indexed_at',
        'published_at',
    ];

    protected $casts = [
        'google_indexed'    => 'boolean',
        'google_indexed_at' => 'datetime',
        'published_at'      => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }
}