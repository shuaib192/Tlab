<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('safe_links', function (Blueprint $t) {
            $t->id();
            $t->string('domain')->unique();
            $t->boolean('is_allowed')->default(true);
            $t->string('category')->nullable();
            $t->text('description')->nullable();
            $t->timestamps();
        });

        Schema::create('communication_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('parent_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->string('subject');
            $t->text('message');
            $t->string('type')->default('general');
            $t->boolean('is_read')->default(false);
            $t->timestamps();
        });

        Schema::create('moderated_uploads', function (Blueprint $t) {
            $t->id();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $t->string('file_url');
            $t->string('file_name');
            $t->string('file_type')->nullable();
            $t->unsignedBigInteger('file_size')->nullable();
            $t->string('status')->default('pending');
            $t->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('moderated_at')->nullable();
            $t->text('reason')->nullable();
            $t->timestamps();
        });

        Schema::create('invoices', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('invoice_number')->unique();
            $t->unsignedInteger('amount');
            $t->string('currency')->default('NGN');
            $t->string('status')->default('pending');
            $t->date('due_date')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->json('items')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });

        Schema::create('schools', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->text('address')->nullable();
            $t->string('city')->nullable();
            $t->string('state')->nullable();
            $t->string('country')->default('Nigeria');
            $t->string('status')->default('active');
            $t->unsignedInteger('max_students')->default(100);
            $t->string('subscription_tier')->default('basic');
            $t->timestamps();
        });

        Schema::create('licenses', function (Blueprint $t) {
            $t->id();
            $t->foreignId('school_id')->constrained()->cascadeOnDelete();
            $t->string('type')->default('annual');
            $t->unsignedInteger('seats')->default(30);
            $t->unsignedInteger('used_seats')->default(0);
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });

        Schema::create('streaks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('child_profile_id')->constrained()->cascadeOnDelete()->unique();
            $t->unsignedInteger('current_streak')->default(0);
            $t->unsignedInteger('longest_streak')->default(0);
            $t->date('last_activity_date')->nullable();
            $t->timestamps();
        });

        Schema::table('subscriptions', function (Blueprint $t) {
            $t->timestamp('trial_ends_at')->nullable()->after('ends_at');
        });
    }

    public function down()
    {
        Schema::table('subscriptions', fn (Blueprint $t) => $t->dropColumn('trial_ends_at'));
        Schema::dropIfExists('streaks');
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('schools');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('moderated_uploads');
        Schema::dropIfExists('communication_logs');
        Schema::dropIfExists('safe_links');
    }
};
