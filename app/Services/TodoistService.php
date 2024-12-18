<?php

namespace App\Services;

use App\Exceptions\TodoistSyncException;
use Cache;
use Http;
use Illuminate\Http\Client\ConnectionException;

class TodoistService
{
    private const CACHE_KEY = 'todoist.sync_token';

    public function __construct() {}

    public function getSyncToken(): ?string
    {
        return Cache::get(self::CACHE_KEY, '*');
    }

    private function setSyncToken(string $syncToken): void
    {
        Cache::put(self::CACHE_KEY, $syncToken);
    }

    /**
     * @throws TodoistSyncException
     * @throws ConnectionException
     */
    public function fetchSyncData(?array $resourceTypes = null, bool $fullSync = false): array
    {
        $syncToken = $fullSync ? '*' : $this->getSyncToken();
        $resourceTypes ??= ['items', 'labels', 'projects'];

        $response = Http::todoistSync()->get('sync', [
            'sync_token' => $syncToken,
            'resource_types' => json_encode($resourceTypes),
        ]);

        if ($response->failed()) {
            throw new TodoistSyncException($response->status(), $response->body());
        }

        return tap($response->json(), function ($data) {
            $this->setSyncToken($data['sync_token']);
        });
    }
}
