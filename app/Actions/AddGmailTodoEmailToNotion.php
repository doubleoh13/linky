<?php

namespace App\Actions;

use App\Events\Google;
use App\Services\Google\Message;
use App\Services\Notion\NotionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Lorisleiva\Actions\Concerns\AsJob;
use Lorisleiva\Actions\Concerns\AsListener;
use Lorisleiva\Actions\Concerns\AsObject;

class AddGmailTodoEmailToNotion implements ShouldQueue
{
    use AsJob, AsListener, AsObject;

    public function __construct(private readonly NotionService $notion) {}

    public function handle(Message $message): void
    {
        Log::info('Adding task to Notion from Todoist');

        $this->notion->newTask()
            ->withName($message->getSubject())
            ->withDescription($message->getUrl())
            ->add();
    }

    public function asListener(Google\NewTodoEmail $event): void
    {
        $this->handle($event->message);
    }
}
