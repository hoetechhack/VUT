<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('is_admin');
            $table->string('bvn')->nullable()->after('transaction_pin');
            $table->timestamp('bvn_verified_at')->nullable()->after('bvn');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'bvn', 'bvn_verified_at']);
        });
    }
};
