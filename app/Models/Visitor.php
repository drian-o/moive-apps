<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [

        'ip',

        'url',

        'user_agent',

        'referer',

        'country',

        'city',

    ];
}