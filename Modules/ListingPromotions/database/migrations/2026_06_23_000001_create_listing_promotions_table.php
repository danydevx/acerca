<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('business_location_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longText('image')->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('promotion_price', 10, 2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['listing_id', 'slug']);
            $table->index('listing_id');
            $table->index('is_active');
        });

        Schema::create('listing_promotion_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('promotion_id');
            $table->string('path');
            $table->string('filename');
            $table->string('original_name');
            $table->string('extension', 20)->nullable();
            $table->string('mime_type', 150)->nullable();
            $table->bigInteger('size')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('promotion_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_promotion_images');
        Schema::dropIfExists('listing_promotions');
    }
};
