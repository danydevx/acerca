<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_social_networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('platform', 50);
            $table->string('url');
            $table->string('username')->nullable();
            $table->string('icon_class')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('show_on_hero')->default(false);
            $table->boolean('show_on_footer')->default(true);
            $table->boolean('show_on_contact')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('listing_id');
            $table->index('platform');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_social_networks');
    }
};
