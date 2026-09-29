<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programme_registrations', function (Blueprint $table) {
            $table->string('class_format')->default('physical')->after('device');
        });
    }

    public function down(): void
    {
        Schema::table('programme_registrations', function (Blueprint $table) {
            $table->dropColumn('class_format');
        });
    }
};
