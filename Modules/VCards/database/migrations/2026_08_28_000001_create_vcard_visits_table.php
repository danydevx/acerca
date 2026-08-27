<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vcard_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vcard_id')->constrained('vcards')->onDelete('cascade');
            $table->string('ip_hash', 64)->nullable();
            $table->char('country_code', 2)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('browser_version', 30)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('language', 10)->nullable();
            $table->unsignedSmallInteger('screen_width')->nullable();
            $table->unsignedSmallInteger('screen_height')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();

            $table->index('vcard_id');
            $table->index(['vcard_id', 'visited_at']);
            $table->index('country_code');
            $table->index('device_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vcard_visits');
    }
};
