<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('followups', function (Blueprint $table) {
            if (!Schema::hasColumn('followups', 'category')) {
                $table->string('category')->nullable()->after('member_id');
            }
            if (!Schema::hasColumn('followups', 'assigned_user_id')) {
                $table->foreignId('assigned_user_id')->nullable()->after('category')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('followups', 'status')) {
                $table->string('status')->default('pending')->after('note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('followups', function (Blueprint $table) {
            if (Schema::hasColumn('followups', 'assigned_user_id')) {
                $table->dropForeign(['assigned_user_id']);
                $table->dropColumn('assigned_user_id');
            }
            if (Schema::hasColumn('followups', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('followups', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};