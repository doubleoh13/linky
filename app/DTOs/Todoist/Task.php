<?php

namespace App\DTOs\Todoist;

use Spatie\LaravelData\Data;

class Task extends Data
{
    public function __construct(
        public string $id,
        public string $project_id,
        public string $content,
        public ?string $description,
        public ?Date $due,
        public int $priority,
        public ?string $parent_id,
        public array $labels,
        public bool $checked,
        public bool $is_deleted,
    ) {}
}
