<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Server extends Model
{
    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password_encrypted',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function setPasswordAttribute(?string $password): void
    {
        $this->attributes['password_encrypted'] = $password
            ? Crypt::encryptString($password)
            : null;
    }

    public function getDecryptedPasswordAttribute(): ?string
    {
        if (!$this->password_encrypted) {
            return null;
        }

        return Crypt::decryptString($this->password_encrypted);
    }
}