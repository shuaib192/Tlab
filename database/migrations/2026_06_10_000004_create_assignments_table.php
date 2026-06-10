<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('instructions')->nullable();
            $table->string('type')->default('file');
            $table->date('due_date')->nullable();
            $table->integer('max_score')->default(100);
            $table->timestamps();
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->text('submission_text')->nullable();
            $table->string('file_url')->nullable();
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->default('submitted');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['assignment_id', 'child_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }
};
