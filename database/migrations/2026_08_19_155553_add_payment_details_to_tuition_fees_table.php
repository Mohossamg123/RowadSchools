<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tuition_fees', function (Blueprint $table) {
            $table->decimal('cash_amount', 12, 2)
                ->default(0)
                ->after('annual_fee');

            $table->decimal('first_term_amount', 12, 2)
                ->default(0)
                ->after('installment_count');

            $table->decimal('second_term_amount', 12, 2)
                ->default(0)
                ->after('first_term_amount');
        });
    }

    public function down(): void
    {
        Schema::table('tuition_fees', function (Blueprint $table) {
            $table->dropColumn([
                'cash_amount',
                'first_term_amount',
                'second_term_amount',
            ]);
        });
    }
};
