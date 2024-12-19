<?php

namespace App\Jobs;

use App\DTOs\Todoist\Project;
use App\DTOs\Todoist\Task;
use App\Events\Todoist\ProjectAdded;
use App\Events\Todoist\ProjectArchived;
use App\Events\Todoist\ProjectDeleted;
use App\Events\Todoist\ProjectUnarchived;
use App\Events\Todoist\ProjectUpdated;
use App\Events\Todoist\TaskAdded;
use App\Events\Todoist\TaskCompleted;
use App\Events\Todoist\TaskDeleted;
use App\Events\Todoist\TaskUncompleted;
use App\Events\Todoist\TaskUpdated;
use Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessTodoistWebhook extends ProcessWebhookJob
{
    public function handle(): void
    {
        $eventName = $this->webhookCall->payload['event_name'];
        $eventData = $this->webhookCall->payload['event_data'];

        Log::info("Todoist {$eventName} received");
        Log::debug('Todoist event data', $eventData);

        match ($eventName) {
            'item:added' => TaskAdded::dispatch(Task::from($eventData)),
            'item:updated' => TaskUpdated::dispatch(Task::from($eventData)),
            'item:completed' => TaskCompleted::dispatch(Task::from($eventData)),
            'item:uncompleted' => TaskUncompleted::dispatch(Task::from($eventData)),
            'item:deleted' => TaskDeleted::dispatch(Task::from($eventData)),
            'project:added' => ProjectAdded::dispatch(Project::from($eventData)),
            'project:updated' => ProjectUpdated::dispatch(Project::from($eventData)),
            'project:deleted' => ProjectDeleted::dispatch(Project::from($eventData)),
            'project:archived' => ProjectArchived::dispatch(Project::from($eventData)),
            'project:unarchived' => ProjectUnarchived::dispatch(Project::from($eventData)),
        };
    }
}
