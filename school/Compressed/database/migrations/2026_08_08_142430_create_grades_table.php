<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('educational_stage_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique(['educational_stage_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
