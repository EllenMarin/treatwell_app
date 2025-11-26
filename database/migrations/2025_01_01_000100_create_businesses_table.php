<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('UK');
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('images')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

            // Pivot table for business-category relationship
        Schema::create('business_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['business_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('business_category');
    }
};
