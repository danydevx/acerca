<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_service_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['listing_id', 'slug']);
            $table->index('listing_id');
        });

        Schema::create('listing_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('business_location_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longText('image')->nullable();
            $table->integer('duration_minutes')->default(60);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->boolean('deposit_required')->default(false);
            $table->boolean('allows_online_booking')->default(true);
            $table->string('whatsapp_contact', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['listing_id', 'slug']);
            $table->index('listing_id');
            $table->index('category_id');
        });

        Schema::create('listing_service_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('listing_service_id');
            $table->string('path');
            $table->string('filename');
            $table->string('original_name');
            $table->string('extension', 20)->nullable();
            $table->string('mime_type', 150)->nullable();
            $table->bigInteger('size')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_service_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_service_images');
        Schema::dropIfExists('listing_services');
        Schema::dropIfExists('listing_service_categories');
    }
};
