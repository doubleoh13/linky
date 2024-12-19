<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('service_id')->nullable();
            $table->string('access_token');
            $table->text('refresh_token')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_access_tokens');
    }
};
