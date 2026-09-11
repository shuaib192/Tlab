<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->string('canvas_path')->nullable()->after('link_note');
            $table->string('canvas_bg', 16)->nullable()->default('white')->after('canvas_path');
        });
    }

    public function down(): void
    {
        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->dropColumn(['canvas_path', 'canvas_bg']);
        });
    }
};
