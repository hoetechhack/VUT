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
        Schema::table('service_variations', function (Blueprint $table) {
            $table->string('category')->nullable()->after('retail_price')->index(); // hot, daily, weekly, monthly
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_variations', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
