<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('educational_stages', function (Blueprint $table) {
            $table->unsignedTinyInteger('age_from')->nullable()->after('icon');
            $table->unsignedTinyInteger('age_to')->nullable()->after('age_from');
            $table->json('features')->nullable()->after('age_to');
        });
    }

    public function down(): void
    {
        Schema::table('educational_stages', function (Blueprint $table) {
            $table->dropColumn(['age_from', 'age_to', 'features']);
        });
    }
};
