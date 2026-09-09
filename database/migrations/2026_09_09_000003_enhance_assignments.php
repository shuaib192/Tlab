<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('max_score');
            $table->timestamp('published_at')->nullable()->after('is_published');
        });

        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->unsignedInteger('version')->default(1)->after('child_profile_id');
            $table->json('files_json')->nullable()->after('version');
            $table->string('link_url')->nullable()->after('files_json');
            $table->text('link_note')->nullable()->after('link_url');
            $table->boolean('submitted_late')->default(false)->after('link_note');
        });

        Schema::create('submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('assignment_submissions')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size');
            $table->string('file_mime')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_files');

        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->dropColumn(['version', 'files_json', 'link_url', 'link_note', 'submitted_late']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn(['is_published', 'published_at']);
        });
    }
};
