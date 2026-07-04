<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('transaction_pin')->nullable()->after('password');
            $table->string('referral_code')->unique()->nullable()->after('transaction_pin');
            $table->foreignId('referred_by')->nullable()->constrained('users')->nullOnDelete()->after('referral_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['transaction_pin', 'referral_code', 'referred_by']);
        });
    }
};
