<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('passing_score')->default(50);
            $table->integer('time_limit')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->string('type')->default('multiple_choice');
            $table->json('options')->nullable();
            $table->text('correct_answer');
            $table->integer('points')->default(10);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->json('answers')->nullable();
            $table->integer('score')->nullable();
            $table->integer('total')->nullable();
            $table->string('status')->default('in_progress');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_attempts');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessments');
    }
};
