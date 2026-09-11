<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->longText('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('promo_price', 10, 2)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('whatsapp_message')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('listing_id');
            $table->index('is_active');
        });

        Schema::create('listing_package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('package_id');
            $table->string('text');
            $table->boolean('included')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('package_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_package_features');
        Schema::dropIfExists('listing_packages');
    }
};
