<?php

namespace App\Console\Commands\Todoist;

use Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Uri;
use Str;

class EnableWebhooks extends Command
{
    protected $signature = 'todoist:enable-webhooks';

    protected $description = 'Runs the authorization flow to enable webhooks for Todoist.';

    public function handle(): void
    {
        $state = Str::random(40);
        Cache::put('todoist-oauth-state', $state, now()->addMinutes(10));

        $authUrl = Uri::of('https://todoist.com/oauth/authorize')
            ->withQuery([
                'client_id' => config('services.todoist.client_id'),
                'scope' => 'data:read_write',
                'state' => $state,
            ]);

        $this->info('Please visit this URL to authorize the app:');
        $this->info($authUrl);
    }
}
