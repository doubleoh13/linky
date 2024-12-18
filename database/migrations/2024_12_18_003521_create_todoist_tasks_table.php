<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todoist_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('todoist_id')->nullable();
            $table->string('notion_id')->nullable();
            $table->string('content');
            $table->text('description')->nullable();
            $table->json('due')->nullable();
            $table->json('deadline')->nullable();
            $table->integer('priority');
            $table->json('labels');
            $table->boolean('checked');
            $table->boolean('is_deleted');
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todoist_tasks');
    }
};
