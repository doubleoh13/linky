<?php

namespace App\Support\Enums;

use Cache;
use DateInterval;
use DateTimeInterface;

enum CacheKey: string
{
    case GoogleWatchEmailHistoryId = 'google.watch.new-todo-email.history-id';

    /**
     * Retrieve the value stored in the cache for the given key.
     */
    public function getValue(): mixed
    {
        return Cache::get($this->value);
    }

    public function setValue(mixed $value, DateInterval|DateTimeInterface|int|null $ttl = null): void
    {
        Cache::put($this->value, $value, $ttl);
    }
}
