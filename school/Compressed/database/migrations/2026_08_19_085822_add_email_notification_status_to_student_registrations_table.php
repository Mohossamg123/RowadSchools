<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->boolean('email_notification_sent')
                ->default(false)
                ->after('status');

            $table->timestamp('email_notification_sent_at')
                ->nullable()
                ->after('email_notification_sent');
        });
    }

    public function down(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'email_notification_sent',
                'email_notification_sent_at',
            ]);
        });
    }
};