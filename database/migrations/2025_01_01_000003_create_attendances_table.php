<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['present','absent','online'])->default('present');
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->unique(['service_id','member_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
