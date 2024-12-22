<?php

namespace App\Events\Todoist;

use App\DTOs\Todoist\Task;
use Illuminate\Foundation\Events\Dispatchable;

class TaskUncompleted
{
    use Dispatchable;

    public function __construct(public Task $task) {}
}
