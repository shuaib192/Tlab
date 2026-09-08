<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_session_id')
                ->nullable()
                ->constrained('class_sessions')
                ->nullOnDelete();
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();
            $table->string('title');
            $table->string('room_name')->unique();
            $table->string('jitsi_domain')->default('meet.jit.si');
            $table->string('status')->default('scheduled')
                ->comment('scheduled | live | ended');
            $table->timestamp('scheduled_at')->nullable();
            $table->unsignedInteger('duration_minutes')->default(60);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->foreignId('host_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_sessions');
    }
};
