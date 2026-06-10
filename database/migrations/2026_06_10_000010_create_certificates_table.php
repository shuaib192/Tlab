<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_id')->unique();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('completion');
            $table->string('title');
            $table->string('grade')->nullable();
            $table->text('metadata')->nullable();
            $table->string('file_url')->nullable();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamps();

            $table->unique(['child_profile_id', 'course_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
