<?php

namespace App\Models;

use App\Support\Enums\ConnectionProvider;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    protected function casts(): array
    {
        return [
            'provider' => ConnectionProvider::class,
            'access_token' => 'encrypted',
            'refresh_token' => 'encrypted',
            'expires_at' => 'datetime',
            'scopes' => 'array',
        ];
    }
}
