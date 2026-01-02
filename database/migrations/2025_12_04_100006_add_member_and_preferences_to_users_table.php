<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'member_id')) {
                $table->foreignId('member_id')->nullable()->after('phone')->constrained('members')->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'receive_quote_email')) {
                $table->boolean('receive_quote_email')->default(true)->after('member_id');
            }
            if (!Schema::hasColumn('users', 'receive_event_reminder_email')) {
                $table->boolean('receive_event_reminder_email')->default(true)->after('receive_quote_email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'member_id')) {
                $table->dropForeign(['member_id']);
                $table->dropColumn('member_id');
            }
            if (Schema::hasColumn('users', 'receive_quote_email')) {
                $table->dropColumn('receive_quote_email');
            }
            if (Schema::hasColumn('users', 'receive_event_reminder_email')) {
                $table->dropColumn('receive_event_reminder_email');
            }
        });
    }
};