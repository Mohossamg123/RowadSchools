<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('social_media_account_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('external_id');

            $table->text('content')->nullable();

            $table->text('post_url');

            $table->text('media_url')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique([
                'social_media_account_id',
                'external_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_posts');
    }
};
