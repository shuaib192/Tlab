<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            if (! Schema::hasColumn('clubs', 'min_age')) {
                $table->unsignedTinyInteger('min_age')->default(3)->after('icon');
            }
            if (! Schema::hasColumn('clubs', 'max_age')) {
                $table->unsignedTinyInteger('max_age')->default(15)->after('min_age');
            }
            if (! Schema::hasColumn('clubs', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('max_age');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn(['min_age', 'max_age', 'is_active']);
        });
    }
};
