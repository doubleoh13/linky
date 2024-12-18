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
use Notion\Pages\Page;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessNotionWebhook extends ProcessWebhookJob
{
    public function handle(): void
    {
        $event = $this->webhookCall->headers()->get('X-Notion-Event-Type');
        /** @noinspection PhpInternalEntityUsedInspection */
        $page = Page::fromArray($this->webhookCall->payload['data']);

        match(true) {
            str($event)->before(':')->is('project') => $this->handleProjectEvent($event),
            default => null,
        };
    }
}
