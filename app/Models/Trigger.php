<?php

namespace App\Models;

use App\Events\Google;
use App\Events\Notion;
use App\Events\Todoist;
use App\Support\Enums\ConnectionProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sushi\Sushi;

class Trigger extends Model
{
    use Sushi;

    private const array EVENTS = [
        ConnectionProvider::Google->value => [
            Google\NewTodoEmail::class,
        ],
        ConnectionProvider::Todoist->value => [
            Todoist\ProjectAdded::class,
            Todoist\ProjectArchived::class,
            Todoist\ProjectDeleted::class,
            Todoist\ProjectUnarchived::class,
            Todoist\ProjectUpdated::class,
            Todoist\TaskAdded::class,
            Todoist\TaskCompleted::class,
            Todoist\TaskDeleted::class,
            Todoist\TaskUncompleted::class,
            Todoist\TaskUpdated::class,
        ],
        ConnectionProvider::Notion->value => [
            Notion\ProjectAddedEvent::class,
            Notion\ProjectUpdatedEvent::class,
        ],
    ];

    public function getRows(): array
    {
        return collect(self::EVENTS)
            ->flatMap(fn (array $events, $provider) => collect($events)
                ->map(fn ($event) => $rows[] = [
                    'provider' => $provider,
                    'event' => $event,
                ]))->values()->toArray();
    }

    protected function casts(): array
    {
        return [
            'provider' => ConnectionProvider::class,
        ];
    }

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class, 'event', 'event');
    }
}
