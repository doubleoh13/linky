<?php

namespace App\DTOs\Todoist;

use Spatie\LaravelData\Data;

class Project extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $parent_id,
        public bool $is_deleted,
        public bool $is_archived,
    ) {}
}
