<?php

namespace App\Jobs;

use App\Events\Google\NewTodoEmail;
use App\Services\Google\GoogleService;
use App\Support\Enums\CacheKey;
use Google\Service\Gmail\History;
use Google\Service\Gmail\HistoryLabelAdded;
use Google\Service\Gmail\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchEmailHistoryUpdate implements ShouldBeUniqueUntilProcessing, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?GoogleService $google;

    public function __construct() {}

    public function handle(GoogleService $google): void
    {
        $this->google = $google;
        $previousHistory = CacheKey::GoogleWatchEmailHistoryId->getValue();

        $history = $google->gmail()
            ->users_history
            ->listUsersHistory('me', ['startHistoryId' => $previousHistory]);
        CacheKey::GoogleWatchEmailHistoryId->setValue($history->historyId);

        $this->dispatchNewTodoEmailEvents($history->getHistory());
    }

    /**
     * @param  History[]  $history
     */
    private function dispatchNewTodoEmailEvents(array $history): void
    {
        $todoLabel = $this->google->getGmailLabelByName('todo');

        collect($history)
            ->flatMap(fn (History $history) => $history->getLabelsAdded())
            ->filter(fn (HistoryLabelAdded $event) => in_array($todoLabel->getId(), $event->getLabelIds()))
            ->pluck('message')
            ->map(fn (Message $message) => $this->google->gmail()->users_messages->get('me', $message->getId()))
            ->mapInto(\App\Services\Google\Message::class)
            ->each(fn (\App\Services\Google\Message $message) => NewTodoEmail::dispatch($message));
    }
}
