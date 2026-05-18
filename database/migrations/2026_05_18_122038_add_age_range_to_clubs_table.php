<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->unsignedTinyInteger('min_age')->default(3)->after('icon');
            $table->unsignedTinyInteger('max_age')->default(15)->after('min_age');
            $table->boolean('is_active')->default(true)->after('max_age');
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn(['min_age', 'max_age', 'is_active']);
        });
    }
};
