<?php

namespace App\Services\Google;

readonly class Config
{
    private string $client_id;

    private string $client_secret;

    private string $redirect;

    private array $scopes;

    private string $webhook_endpoint_host;

    private string $service_account_email;

    private array $topics;

    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            if (! property_exists($this, $key)) {
                continue;
            }
            $this->$key = $value;
        }
    }

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function getClientSecret(): string
    {
        return $this->client_secret;
    }

    public function getRedirectUri(): string
    {
        return $this->redirect;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getWebhookEndpointHost(): string
    {
        return $this->webhook_endpoint_host;
    }

    public function getServiceAccountEmail(): string
    {
        return $this->service_account_email;
    }
}
