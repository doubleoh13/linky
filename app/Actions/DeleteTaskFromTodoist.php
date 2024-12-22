<?php

namespace App\Actions;

use App\DTOs\Todoist\Task;
use App\Events\Todoist\TaskAdded;
use App\Services\Todoist\TodoistService;
use Log;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsListener;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteTaskFromTodoist
{
    use AsJob, AsListener, AsObject;

    public function __construct(private readonly TodoistService $todoist) {}

    public function handle(Task $task): void
    {
        Log::info("Deleting task from Todoist with id: $task->id");

        $this->todoist->deleteTask($task->id);
    }

    public function asListener(TaskAdded $event): void
    {
        $this->handle($event->task);
    }
}
