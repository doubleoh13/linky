<?php

namespace App\Actions;

use App\DTOs\Todoist\Task as TodoistTask;
use App\Events\Todoist;
use App\Services\Notion\NotionService;
use Log;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsListener;
use Lorisleiva\Actions\Concerns\AsObject;

class AddTodoistTaskToNotion
{
    use AsJob, AsListener, AsObject;

    public function __construct(private readonly NotionService $notion) {}

    public function handle(TodoistTask $task): void
    {
        Log::info('Adding task to Notion from Todoist');

        $this->notion->newTask()
            ->withName($task->content)
            ->withDescription($task->description)
            ->add();
    }

    public function asListener(Todoist\TaskAdded $event): void
    {
        $this->handle($event->task);
    }
}
