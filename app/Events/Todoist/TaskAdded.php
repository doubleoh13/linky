<?php

namespace App\Events\Todoist;

use App\DTOs\Todoist\Task;
use Illuminate\Foundation\Events\Dispatchable;

class TaskAdded
{
    use Dispatchable;

    public function __construct(public Task $task) {}
}
