<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();

            $table->string('student_name');
            $table->string('parent_name');

            $table->string('phone');
            $table->string('email')->nullable();

            $table->enum('gender', [
                'male',
                'female',
            ])->nullable();

            $table->foreignId('educational_stage_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('grade_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'contacted',
                'approved',
                'rejected',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
