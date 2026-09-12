<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_branding_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->json('colors')->nullable();
            $table->json('fonts')->nullable();
            $table->string('custom_font_url')->nullable();
            $table->boolean('dark_mode')->default(false);
            $table->string('buttons_style', 20)->default('round');
            $table->boolean('buttons_uppercase')->default(true);
            $table->longText('generated_css')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_branding_settings');
    }
};
