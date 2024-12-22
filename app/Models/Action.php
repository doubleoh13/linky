<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    protected $attributes = [
        'enabled' => true,
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
        ];
    }

    public function trigger(): BelongsTo
    {
        return $this->belongsTo(Trigger::class, 'event', 'event');
    }
}
