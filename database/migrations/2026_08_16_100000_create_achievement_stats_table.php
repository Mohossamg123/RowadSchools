<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievement_stats', function (Blueprint $table) {
            $table->id();

            // Icon key resolved on the frontend (e.g. "calendar", "award", "users", "graduation-cap")
            $table->string('icon')->nullable();

            // Display value, kept as free text so it supports "+15" / "98%" / "+2500" etc.
            $table->string('value');

            $table->string('label');
            $table->string('note')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_stats');
    }
};
