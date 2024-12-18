<?php

namespace App\Actions;

use App\Exceptions\TodoistSyncException;
use App\Models\TodoistTask;
use App\Services\TodoistService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Lorisleiva\Actions\Concerns\AsCommand;
use Lorisleiva\Actions\Concerns\AsObject;
use Symfony\Component\Console\Command\Command as CMD;

use function Laravel\Prompts\progress;

class SyncFromTodoist
{
    use AsCommand;
    use AsObject;

    public $commandSignature = 'sync:from-todoist {--full : Perform a full sync}';

    public $commandDescription = 'Sync data from Todoist';

    private ?Command $command = null;

    public function __construct(private readonly TodoistService $todoist) {}

    /**
     * @throws TodoistSyncException
     * @throws ConnectionException
     */
    public function handle(bool $doFullSync = false): void
    {
        $data = $this->todoist->fetchSyncData(fullSync: $doFullSync);

        $this->doSync($data['items'], 'task', $this->createTask(...));
        $this->doSync($data['projects'], 'project', $this->createProject(...));
        $this->doSync($data['labels'], 'label', $this->createLabel(...));
    }

    public function asCommand(Command $command): int
    {
        $this->command = $command;

        try {
            $this->handle($command->option('full'));
        } catch (TodoistSyncException|ConnectionException $e) {
            $command->error("Failed to sync data from Todoist: {$e->getMessage()}");

            return CMD::FAILURE;
        }

        return CMD::SUCCESS;
    }

    private function doSync(array $data, string $resource, callable $callback): void
    {
        $resource = str($resource);
        if (empty($data)) {
            $this->command?->info("No {$resource->plural()} to sync...");

            return;
        }

        if ($this->command) {
            progress(
                label: "Syncing {$resource->plural()}...",
                steps: $data,
                callback: $callback
            );

            return;
        }

        foreach ($data as $item) {
            $callback($item);
        }
    }

    private function createTask(array $item): void
    {
        TodoistTask::updateOrCreate(
            [
                'todoist_id' => $item['id'],
            ], [
                'content' => $item['content'],
                'description' => $item['description'],
                'due_date' => $item['due'],
                'deadline' => $item['deadline'],
                'priority' => $item['priority'],
                'labels' => $item['labels'],
                'checked' => $item['checked'],
                'is_deleted' => $item['is_deleted'],
                'deleted_at' => $item['is_deleted'] ? Carbon::parse($item['updated_at']) : null,
                'metadata' => $item,
            ]
        );
    }

    private function createLabel(array $label): void
    {
        // todo Create label
    }

    private function createProject(array $label): void
    {
        // todo Create Project
    }
}
