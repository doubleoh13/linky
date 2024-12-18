<?php

namespace App\Services;

use Notion\Notion;

class NotionService
{
    public function __construct(protected Notion $notion)
    {
    }

    public function listProjects() {
        $database = $this->notion->databases()->find(config('services.notion.databases.projects'));

        return $this->notion->databases()->queryAllPages($database);
    }

    public function createTask($task) {

    }
}
