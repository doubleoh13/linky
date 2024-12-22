<?php

namespace App\DTOs\Todoist;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class Date extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $date,
        public bool $is_recurring,
        public string $lang,
        public string $string,
        public ?string $timezone,
    ) {}
}
