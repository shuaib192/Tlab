<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('child_profiles', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->boolean('pin_enabled')->default(false)->after('pin');
        });
    }

    public function down(): void
    {
        Schema::table('child_profiles', function (Blueprint $table) {
            $table->dropColumn(['username', 'pin_enabled']);
        });
    }
};
