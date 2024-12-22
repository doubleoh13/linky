<?php

use App\Jobs\ProcessTodoistWebhook;
use App\Services\WebhookClient\TodoistSignatureValidator;

return [
    'configs' => [
        [
            'name' => 'todoist',
            'signing_secret' => env('TODOIST_CLIENT_SECRET'),
            'signature_header_name' => 'X-Todoist-Hmac-SHA256',
            'signature_validator' => TodoistSignatureValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'store_headers' => [
                'X-Todoist-Delivery-Id',
            ],
            'process_webhook_job' => ProcessTodoistWebhook::class,
        ],
        [
            'name' => 'notion',
            'signing_secret' => env('NOTION_WEBHOOK_TOKEN'),
            'signature_header_name' => 'X-Notion-Token',
            'signature_validator' => \App\Services\WebhookClient\TokenSignatureValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'store_headers' => [
                'X-Notion-Event-Type',
            ],
            'process_webhook_job' => \App\Jobs\ProcessNotionWebhook::class,
        ],
        [
            'name' => 'google-pubsub',
            'signature_validator' => \App\Services\WebhookClient\GooglePubSubJwtValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => \App\Jobs\ProcessGooglePubSubWebhook::class,
        ],
    ],

    /*
     * The integer amount of days after which models should be deleted.
     *
     * It deletes all records after 30 days. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,

    /*
     * Should a unique token be added to the route name
     */
    'add_unique_token_to_route_name' => false,
];
