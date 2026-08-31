<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('platform', 50);
            $table->string('username')->nullable();
            $table->text('url');

            $table->text('access_token')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamp('last_synced_at')->nullable();

            $table->timestamps();

            $table->unique('platform');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_accounts');
    }
};
