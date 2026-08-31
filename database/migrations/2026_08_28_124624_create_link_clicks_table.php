<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('social_link_id')
                ->constrained('social_links')
                ->cascadeOnDelete();

            $table->timestamp('clicked_at')->useCurrent();

            $table->timestamps();

            $table->index('clicked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_clicks');
    }
};