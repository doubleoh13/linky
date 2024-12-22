<?php

namespace App\Exceptions;

use Exception;

class TodoistClientException extends Exception
{
    public function __construct(protected int $statusCode, protected string $responseMessage)
    {
        parent::__construct("Todoist sync failed with status code {$this->statusCode}: {$this->responseMessage}");
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }
}
