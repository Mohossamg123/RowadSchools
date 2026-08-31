<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('special_offer_page_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('special_offer_page_id')
                ->constrained('special_offer_pages')
                ->cascadeOnDelete();

            $table->string('image');
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('special_offer_page_images');
    }
};
