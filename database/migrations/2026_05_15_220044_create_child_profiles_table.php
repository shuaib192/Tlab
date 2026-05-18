<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('child_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Parent
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->text('interests')->nullable();
            $table->string('skill_level')->default('beginner');
            $table->integer('xp')->default(0);
            $table->string('rank')->default('Explorer');
            $table->string('pin', 4)->nullable(); // Child-safe login PIN
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_profiles');
    }
};
