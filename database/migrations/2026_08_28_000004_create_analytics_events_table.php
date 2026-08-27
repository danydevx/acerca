<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained('analytics_visitors')->onDelete('cascade');
            $table->foreignId('session_id')->constrained('analytics_sessions')->onDelete('cascade');
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');

            $table->string('event_name', 100);
            $table->string('event_category', 100)->nullable();
            $table->string('url', 2000)->nullable();
            $table->string('path', 500)->nullable();

            $table->json('metadata')->nullable();

            $table->boolean('is_bot')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['listing_id', 'created_at']);
            $table->index(['listing_id', 'event_name']);
            $table->index(['session_id']);
            $table->index(['visitor_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
