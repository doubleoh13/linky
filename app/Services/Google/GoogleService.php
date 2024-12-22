<?php

namespace App\Services\Google;

use App\Models\Connection;
use Google\Client;
use Google\Service\Gmail;
use Log;

class GoogleService
{
    public function __construct(private readonly Client $client) {}

    public function setConnection(Connection $connection): void
    {
        try {
            if ($connection->expires_at->subMinutes(5)->isPast()) {
                $newToken = $this->client->fetchAccessTokenWithRefreshToken($connection->refresh_token);

                $connection->update([
                    'access_token' => $newToken['access_token'],
                    'expires_at' => now()->addSeconds($newToken['expires_in']),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to refresh Google API token.', [
                'error' => $e->getMessage(),
                'connection_id' => $connection->id,
            ]);

            throw $e;
        }

        $this->setAccessToken($connection->access_token);
    }

    public function getConfig(): Config
    {
        return resolve(Config::class);
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->client->setAccessToken($accessToken);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function gmail(): Gmail
    {
        return new Gmail($this->client);
    }

    public function getGmailLabelByName(string $name): ?Gmail\Label
    {
        $labelsResponse = $this->gmail()->users_labels->listUsersLabels('me');

        return collect($labelsResponse->getLabels())
            ->first(fn (Gmail\Label $label) => $label->getName() === $name);
    }

    public function newWatchRequest(): Gmail\WatchRequest
    {
        return new Gmail\WatchRequest;
    }
}
