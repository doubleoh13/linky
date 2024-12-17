<?php

namespace App\Events\Todoist;

use App\DTOs\Todoist\Task;
use Illuminate\Foundation\Events\Dispatchable;

class TaskCompleted
{
    use Dispatchable;

    public function __construct(public Task $task) {}
}
