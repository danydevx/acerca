<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('business_location_id')->nullable();
            $table->string('client_name');
            $table->string('company')->nullable();
            $table->text('comment');
            $table->tinyInteger('rating');
            $table->string('google_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('listing_id');
            $table->index('rating');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_reviews');
    }
};
