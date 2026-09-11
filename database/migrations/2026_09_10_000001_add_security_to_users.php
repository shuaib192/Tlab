<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('role');
            $table->timestamp('suspended_at')->nullable()->after('is_active');
            $table->text('suspended_reason')->nullable()->after('suspended_at');
            $table->boolean('two_factor_enabled')->default(false)->after('suspended_reason');
            $table->timestamp('two_factor_enrolled_at')->nullable()->after('two_factor_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'suspended_at',
                'suspended_reason',
                'two_factor_enabled',
                'two_factor_enrolled_at',
            ]);
        });
    }
};
