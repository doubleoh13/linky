<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notion_task_todoist_task', function (Blueprint $table) {
            $table->string('notion_task_id')->index();
            $table->string('todoist_task_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notion_task_todoist_task');
    }
};
