<?php

namespace App\Providers;

use App\Actions\AddTodoistTaskToNotion;
use App\Actions\DeleteTaskFromTodoist;
use App\Events\Todoist;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Todoist\TaskAdded::class => [
            AddTodoistTaskToNotion::class,
            DeleteTaskFromTodoist::class,
        ],
    ];
}
