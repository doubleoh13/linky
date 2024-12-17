<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notion_project_todoist_project', function (Blueprint $table) {
            $table->string('notion_project_id')->index();
            $table->string('todoist_project_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notion_project_todoist_project');
    }
};
