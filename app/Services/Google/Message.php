<?php

namespace App\Services\Google;

use BadMethodCallException;
use Google\Service\Gmail\Message as M;
use LogicException;

/**
 * @mixin M
 */
class Message
{
    private M $message;

    public function __construct(M $message)
    {
        $this->message = $message;
    }

    public function getSubject(): string
    {
        foreach ($this->getPayload()->getHeaders() as $header) {
            if ($header->getName() === 'Subject') {
                return $header->getValue();
            }
        }

        throw new LogicException('Subject header not found on message');
    }

    public function getUrl(): string
    {
        return "https://mail.google.com/mail/u/0/#inbox/$this->id";
    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->message, $name)) {
            return $this->message->$name(...$arguments);
        }

        throw new BadMethodCallException('Method '.$name.' does not exist on '.get_class($this->message));
    }

    public function __get(string $name)
    {
        if (property_exists($this->message, $name)) {
            return $this->message->$name;
        }

        throw new BadMethodCallException('Property '.$name.' does not exist on '.get_class($this->message));
    }
}
