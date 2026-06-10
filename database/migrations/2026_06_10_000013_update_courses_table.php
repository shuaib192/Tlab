<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('grade_level')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_published')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['teacher_id', 'grade_level', 'thumbnail', 'is_published']);
        });
    }
};
