<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            // مفتاح أيقونة Lucide (زي "eye") أو مسار صورة/SVG مرفوعة
            // (زي "icons/2026/08/xxxx.webp") — بيتعرض جنب رؤيتنا/رسالتنا/قيمنا.
            $table->string('icon', 255)->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
