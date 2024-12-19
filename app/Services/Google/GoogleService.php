<?php

namespace App\Services\Google;

use Google\Client;

class GoogleService
{
    public function __construct(private readonly Client $client) {}

    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function authenticate(string $authCode): array
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
        $this->client->setAccessToken($accessToken);

        return $accessToken;
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->client->setAccessToken($accessToken);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
