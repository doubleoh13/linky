<?php

namespace App\Console\Commands\Google;

use App\Services\Google\GoogleService;
use App\Support\Enums\CacheKey;
use Cache;
use Illuminate\Console\Command;

class StopWatchingForTodoEmailsCommand extends Command
{
    protected $signature = 'google:stop-watching-for-todo-emails';

    public $description = 'Calls the users.stop endpoint to stop watching for emails labeled \'todo\'.';

    public function handle(GoogleService $google): void
    {
        $stopResponse = $google->gmail()->users->stop('me');

        Cache::delete(CacheKey::GoogleWatchEmailHistoryId->value);
    }
}
