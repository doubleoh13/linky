<?php

namespace App\Jobs;

use Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessGooglePubSubWebhook extends ProcessWebhookJob
{
    public function handle(): void
    {
        $event = str($this->webhookCall->url)->afterLast('/');
        $payload = $this->webhookCall->payload;
        if ($event != 'email-event') {
            // Ignore other events for now...

            return;
        }

        if (! data_get($payload, 'message.data', false)) {
            throw new \Exception('No data found in payload');
        }

        $data = json_decode(base64_decode($payload['message']['data']), true);

        if (! in_array($data['emailAddress'], config('auth.authorized_users'))) {
            Log::info('Received email from unauthorized user: '.$data['emailAddress']);

            return;
        }

        FetchEmailHistoryUpdate::dispatch();
    }
}
