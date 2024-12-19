<?php

namespace App\Services\Google;

readonly class Config
{
    public function __construct(
        private string $client_id,
        private string $client_secret,
        private string $redirect_uri,
    ) {}

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
        return $this->redirect_uri;
    }
}
