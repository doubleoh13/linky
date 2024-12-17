<?php

namespace App\Listeners;

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

class LogEvent
{
    public function __construct() {}

    public function handle(TaskAdded|TaskUpdated|TaskDeleted|TaskCompleted|TaskUncompleted|ProjectAdded|ProjectUpdated|ProjectDeleted|ProjectArchived|ProjectUnarchived $event): void
    {
        match (true) {
            property_exists($event, 'task') => Log::info($event->task),
            property_exists($event, 'project') => Log::info($event->project),
        };
    }
}
