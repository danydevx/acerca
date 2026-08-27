<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained()->onDelete('cascade');

            $table->boolean('is_enabled')->default(true);
            $table->boolean('track_pageviews')->default(true);
            $table->boolean('track_events')->default(true);
            $table->boolean('track_referrers')->default(true);
            $table->boolean('track_utm')->default(true);
            $table->boolean('track_device')->default(true);
            $table->boolean('track_location')->default(true);
            $table->boolean('store_full_ip')->default(false);
            $table->boolean('exclude_bots')->default(true);

            $table->integer('session_timeout_minutes')->default(30);
            $table->integer('data_retention_months')->default(12);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_settings');
    }
};
