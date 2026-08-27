<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->unique();
            $table->foreignId('visitor_id')->constrained('analytics_visitors')->onDelete('cascade');
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('last_activity_at');
            $table->timestamp('expires_at');
            $table->boolean('is_bot')->default(false);
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->timestamps();

            $table->index(['session_id', 'listing_id']);
            $table->index(['visitor_id', 'listing_id']);
            $table->index(['listing_id', 'started_at']);
            $table->index(['expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_sessions');
    }
};
