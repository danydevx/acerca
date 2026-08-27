<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_pageviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained('analytics_visitors')->onDelete('cascade');
            $table->foreignId('session_id')->constrained('analytics_sessions')->onDelete('cascade');
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');

            $table->string('url', 2000);
            $table->string('path', 500);
            $table->string('query_string', 1000)->nullable();
            $table->string('page_title', 500)->nullable();
            $table->string('referrer', 2000)->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->string('ip_hash', 64)->nullable();

            $table->string('country', 100)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('user_agent', 500)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('browser_version', 30)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('language', 10)->nullable();

            $table->integer('screen_width')->nullable();
            $table->integer('screen_height')->nullable();

            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('utm_term', 100)->nullable();
            $table->string('utm_content', 100)->nullable();

            $table->boolean('is_bot')->default(false);

            $table->timestamp('created_at')->useCurrent();

            $table->index(['listing_id', 'created_at']);
            $table->index(['listing_id', 'path']);
            $table->index(['listing_id', 'visitor_id']);
            $table->index(['session_id']);
            $table->index(['visitor_id']);
            $table->index(['country_code']);
            $table->index(['device_type']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_pageviews');
    }
};
