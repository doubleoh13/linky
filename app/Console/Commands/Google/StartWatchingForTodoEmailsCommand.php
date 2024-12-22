<?php

namespace App\Console\Commands\Google;

use App\Services\Google\GoogleService;
use App\Support\Enums\CacheKey;
use Cache;
use Illuminate\Console\Command;

class StartWatchingForTodoEmailsCommand extends Command
{
    protected $signature = 'google:start-watching-for-todo-emails';

    public $description = 'Calls the users.watch endpoint to start watching for emails labeled \'todo\'.';

    public function handle(GoogleService $google): void
    {
        $taskLabel = $google->getGmailLabelByName('todo');
        $this->info("Found label: {$taskLabel->getName()} with ID: {$taskLabel->getId()}");

        $watchRequest = $google->newWatchRequest();
        $watchRequest->setTopicName(config('services.google.topics.email-event'));
        $watchRequest->setLabelIds([$taskLabel->getId()]);
        $watchRequest->setLabelFilterAction('include');

        $watchResponse = $google->gmail()->users->watch('me', $watchRequest);
        $historyId = $watchResponse->getHistoryId();

        $this->info("Watch history ID: {$historyId}");
        Cache::put(CacheKey::GoogleWatchEmailHistoryId->value, $historyId);

    }
}
