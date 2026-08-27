<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_visitors', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id')->unique();
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            $table->timestamp('first_seen_at')->useCurrent();
            $table->timestamp('last_seen_at')->useCurrent();
            $table->string('user_agent', 500)->nullable();
            $table->boolean('is_bot')->default(false);
            $table->string('country_code', 2)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->timestamps();

            $table->index(['visitor_id', 'listing_id']);
            $table->index(['listing_id', 'last_seen_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_visitors');
    }
};
