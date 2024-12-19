<?php

namespace App\Services\Notion;

use Notion\Notion;
use Notion\Pages\Page;
use Notion\Pages\PageParent;

class NotionService
{
    public function __construct(protected Notion $notion) {}

    private function tasksDatabaseId(): string
    {
        return config('services.notion.databases.tasks');
    }

    public function addPage(Page $page): void
    {
        $this->notion->pages()->create($page);
    }

    public function newTask(): PendingTask
    {
        $parent = PageParent::database($this->tasksDatabaseId());

        return new PendingTask($parent, $this);
    }
}
