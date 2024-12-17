<?php

namespace App\Events\Todoist;

use App\DTOs\Todoist\Project;
use Illuminate\Foundation\Events\Dispatchable;

class ProjectUpdated
{
    use Dispatchable;

    public function __construct(public Project $project) {}
}
