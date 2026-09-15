<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programme_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('phone');
            $table->string('email');
            $table->string('child_name');
            $table->unsignedTinyInteger('child_age');
            $table->string('programme');
            $table->string('device');
            $table->string('payment_option');
            $table->integer('amount');
            $table->string('status')->default('pending');
            $table->string('reference')->unique();
            $table->string('gateway_transaction')->nullable();
            $table->string('gateway_channel')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programme_registrations');
    }
};
