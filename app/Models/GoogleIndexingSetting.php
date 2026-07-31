<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleIndexingSetting extends Model
{
    protected $fillable = [
        'credential',
        'is_connected',
        'last_test_at'
    ];

    protected $casts = [
        'credential' => 'array',
        'is_connected' => 'boolean',
        'last_test_at' => 'datetime'
    ];
}