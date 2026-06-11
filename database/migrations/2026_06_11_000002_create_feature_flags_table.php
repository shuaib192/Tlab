<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feature_flags', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->string('name');
            $t->text('description')->nullable();
            $t->json('enabled_for_roles')->nullable();
            $t->json('enabled_for_users')->nullable();
            $t->boolean('is_active')->default(false);
            $t->boolean('staging_only')->default(false);
            $t->timestamps();
        });
        DB::table('feature_flags')->insert([
            ['key' => 'new_dashboard', 'name' => 'New Dashboard Design', 'is_active' => true, 'staging_only' => false],
            ['key' => 'ai_recommendations', 'name' => 'AI Learning Recommendations', 'is_active' => false, 'staging_only' => true],
            ['key' => 'bulk_invoicing', 'name' => 'Bulk School Invoicing', 'is_active' => false, 'staging_only' => true],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('feature_flags');
    }
};
