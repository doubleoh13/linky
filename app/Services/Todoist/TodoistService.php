<?php

namespace App\Services\Todoist;

use App\Exceptions\TodoistClientException;
use Http;
use Illuminate\Http\Client\ConnectionException;

class TodoistService
{
    /**
     * @throws TodoistClientException
     * @throws ConnectionException
     */
    public function deleteTask(string $taskId): void
    {
        $response = Http::todoistRest()->delete("tasks/$taskId");

        if (! $response->successful()) {
            throw new TodoistClientException($response->getStatusCode(), $response->getBody());
        }
    }
}
