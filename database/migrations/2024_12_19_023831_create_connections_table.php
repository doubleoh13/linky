<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->unique();
            $table->string('provider_id')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('provider_email')->nullable();
            $table->string('provider_avatar')->nullable();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->text('scopes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
