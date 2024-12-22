<?php

namespace App\Providers;

use App\Actions\AddGmailTodoEmailToNotion;
use App\Actions\AddTodoistTaskToNotion;
use App\Actions\DeleteTaskFromTodoist;
use App\Events\Google;
use App\Events\Todoist;
use App\Models\Action;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected static $shouldDiscoverEvents = false;

    protected $listen = [
        Todoist\TaskAdded::class => [
            AddTodoistTaskToNotion::class,
            DeleteTaskFromTodoist::class,
        ],
        Google\NewTodoEmail::class => [
            AddGmailTodoEmailToNotion::class,
        ],
    ];

    public function getEvents(): array
    {
        try {
            $actions = Action::whereIn('event', array_keys($this->listen))->get();
        } catch (\Exception $e) {
            return [];
        }

        $events = [];
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $action = $actions->first(fn (Action $action) => $action->event === $event && $action->listener === $listener);
                $action ??= Action::create(['event' => $event, 'listener' => $listener]);

                if ($action->enabled) {
                    $events[$event][] = $listener;
                }
            }
        }

        return $events;
    }
}
