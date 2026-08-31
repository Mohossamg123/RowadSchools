<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuition_fees', function (Blueprint $table) {
    $table->id();

    $table->foreignId('grade_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('academic_year');

    $table->decimal('annual_fee', 12, 2)->default(0);

    $table->decimal('registration_fee', 12, 2)->default(0);

    $table->decimal('installment_amount', 12, 2)->default(0);

    $table->unsignedInteger('installment_count')->default(1);

    $table->decimal('sibling_discount', 12, 2)->default(0);

    $table->text('notes')->nullable();

    $table->boolean('status')->default(true);

    $table->timestamps();

    $table->unique(['grade_id', 'academic_year']);
});
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_fees');
    }
};
