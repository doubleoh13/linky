<?php

namespace App\Events\Google;

use App\Services\Google\Message;
use Illuminate\Foundation\Events\Dispatchable;

class NewTodoEmail
{
    use Dispatchable;

    public function __construct(readonly public Message $message) {}
}
