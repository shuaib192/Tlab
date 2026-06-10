<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('class_sessions')->cascadeOnDelete();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('present');
            $table->text('notes')->nullable();
            $table->timestamp('marked_at')->useCurrent();
            $table->foreignId('marked_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['session_id', 'child_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
