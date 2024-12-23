<?php

namespace App\DTOs\Todoist;

use Spatie\LaravelData\Data;

class Date extends Data
{
    public function __construct(
        public string $date,
        public bool $is_recurring,
        public string $lang,
        public string $string,
        public ?string $timezone,
    ) {}
}
