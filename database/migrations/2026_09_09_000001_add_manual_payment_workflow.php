<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('gateway')->default('paystack')->after('status');
            $table->string('proof_path')->nullable()->after('gateway');
            $table->timestamp('proof_submitted_at')->nullable()->after('proof_path');
            $table->timestamp('verified_at')->nullable()->after('paid_at');
            $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable()->after('verified_by');
            $table->foreignId('invoice_id')->nullable()->after('rejection_reason')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verified_by');
            $table->dropConstrainedForeignId('invoice_id');
            $table->dropColumn(['gateway', 'proof_path', 'proof_submitted_at', 'verified_at', 'rejection_reason']);
        });
    }
};
