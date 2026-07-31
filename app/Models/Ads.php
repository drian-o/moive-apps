<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
  protected $fillable = [
    'name',
    'position',
    'image',
    'url',
    'is_active',
    'sort_order',
];
}
