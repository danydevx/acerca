<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('listing_type')->nullable();
            $table->longText('system_prompt_template')->nullable();
            $table->string('chatbot_name_template')->nullable();
            $table->text('greeting_message')->nullable();
            $table->text('fallback_message')->nullable();
            $table->string('personality', 50)->default('friendly');
            $table->string('language', 10)->default('es');
            $table->json('configuration')->nullable();
            $table->json('initial_suggestions')->nullable();
            $table->json('context_ids')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false);
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index('is_active');
            $table->index('listing_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_presets');
    }
};
