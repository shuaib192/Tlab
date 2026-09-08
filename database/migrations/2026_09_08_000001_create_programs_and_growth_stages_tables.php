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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->string('discipline')->default('technology'); // science, technology, engineering, arts, mathematics
            $table->string('ages')->default('3–18');
            $table->string('color', 30)->default('#4E9966');
            $table->string('accent_color', 30)->default('#6EE7B7');
            $table->text('gradient')->nullable();
            $table->text('icon_svg')->nullable();
            $table->text('description')->nullable();
            $table->json('what_learn')->nullable();
            $table->json('outcomes')->nullable();
            $table->json('career_paths')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('program_growth_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('stage_name'); // e.g. Explorers, Creators, Builders, Innovators, Specialists
            $table->string('age_band'); // e.g. "Ages 3–5", "Ages 6–8", "Ages 9–11", "Ages 12–14", "Ages 15–18"
            $table->unsignedTinyInteger('min_age')->default(3);
            $table->unsignedTinyInteger('max_age')->default(18);
            $table->string('focus_title')->nullable(); // e.g. "Sensory Robotics & Pattern Logic"
            $table->text('description')->nullable();
            $table->json('skills')->nullable(); // list of key skills acquired
            $table->json('milestones')->nullable(); // list of tangible milestones
            $table->json('tools_used')->nullable(); // list of tools/software/hardware
            $table->string('featured_project')->nullable(); // flagship project completed at this stage
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_growth_stages');
        Schema::dropIfExists('programs');
    }
};
