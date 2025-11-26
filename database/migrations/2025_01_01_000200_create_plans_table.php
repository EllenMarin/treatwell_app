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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('duration')->comment('Duration in minutes');
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('GBP');
            $table->boolean('is_active')->default(true);
            $table->integer('max_bookings_per_day')->nullable();
            $table->boolean('requires_deposit')->default(false);
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->index(['business_id', 'is_active']);
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

