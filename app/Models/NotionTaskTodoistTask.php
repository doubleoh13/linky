<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NotionTaskTodoistTask extends Pivot
{
    protected $table = 'notion_task_todoist_task';
}
