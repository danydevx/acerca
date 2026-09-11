<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_minisite_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('theme_key', 50)->default('default');
            $table->string('hero_layout', 20)->default('center');
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_background_image')->nullable();
            $table->boolean('hero_show_social')->default(true);
            $table->text('footer_text')->nullable();
            $table->boolean('footer_show_social')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('listing_minisite_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('section_type', 50);
            $table->string('section_key', 50);
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->json('config')->nullable();
            $table->json('buttons')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_social_links')->default(true);
            $table->timestamps();

            $table->index('listing_id');
            $table->index('section_type');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_minisite_sections');
        Schema::dropIfExists('listing_minisite_settings');
    }
};
