<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NotionProjectTodoistProject extends Pivot
{
    protected $table = 'notion_project_todoist_project';
}
