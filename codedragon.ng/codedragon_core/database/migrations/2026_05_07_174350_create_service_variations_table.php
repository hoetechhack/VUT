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
        Schema::create('service_variations', function (Blueprint $table) {
            $table->id();
            $table->string('service_id')->index(); // e.g. mtn-data
            $table->string('variation_code'); // e.g. mtn-10mb-100
            $table->string('name');
            $table->decimal('wholesale_price', 10, 2);
            $table->decimal('retail_price', 10, 2)->nullable();
            
            // Hot Deals Engine
            $table->boolean('is_hot_deal')->default(false);
            $table->timestamp('hot_deal_start')->nullable();
            $table->timestamp('hot_deal_end')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Unique constraint to prevent duplicates during sync
            $table->unique(['service_id', 'variation_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_variations');
    }
};
