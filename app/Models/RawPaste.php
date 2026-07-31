<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RawPaste extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'slug',
        'filename',
        'language',
        'visibility',
        'content',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'views' => 'integer',
        ];
    }

    /**
     * Route admin akan menggunakan slug,
     * bukan ID database.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Generate slug otomatis ketika paste dibuat.
     */
    protected static function booted(): void
    {
        static::creating(function (RawPaste $paste) {
            if (empty($paste->slug)) {
                $paste->slug = static::generateUniqueSlug();
            }
        });
    }

    private static function generateUniqueSlug(): string
    {
        do {
            $slug = Str::lower(Str::random(12));
        } while (
            static::withTrashed()
                ->where('slug', $slug)
                ->exists()
        );

        return $slug;
    }

    public function isExpired(): bool
    {
        return $this->expires_at?->isPast() ?? false;
    }

    public function isPubliclyAccessible(): bool
    {
        return !$this->isExpired()
            && $this->visibility !== 'private';
    }
}