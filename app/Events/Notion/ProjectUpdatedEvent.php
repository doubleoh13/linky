<?php

namespace App\Events\Notion;

use Illuminate\Foundation\Events\Dispatchable;
use Notion\Pages\Page;

class ProjectUpdatedEvent
{
    use Dispatchable;

    public function __construct(public Page $page)
    {
    }
}
