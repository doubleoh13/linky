<?php

namespace App\Jobs;

use Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessNotionWebhook extends ProcessWebhookJob
{
    public function handle(): void
    {
        Log::info('Notion Webhook Received:', $this->webhookCall->toArray());
    }
}
