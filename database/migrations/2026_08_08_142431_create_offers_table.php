<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
    $table->id();

    $table->string('title');
    $table->text('description')->nullable();

    $table->string('badge_text')->nullable();
    $table->string('discount')->nullable();

    $table->string('image')->nullable();

    $table->string('button_text')->nullable();
    $table->string('button_url')->nullable();

    $table->dateTime('start_date')->nullable();
    $table->dateTime('end_date')->nullable();

    $table->unsignedInteger('sort_order')->default(0);
    $table->boolean('status')->default(true);

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
