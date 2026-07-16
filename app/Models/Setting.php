<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'site_name',
        'site_title',
        'site_description',
        'site_keywords',

        'logo',
        'favicon',

        'email',

        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'discord',
        'telegram',

        'theme_color',

        'maintenance',

    ];
}