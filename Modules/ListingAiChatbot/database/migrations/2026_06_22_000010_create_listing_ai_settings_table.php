<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_ai_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('preset_id')->nullable();
            $table->string('provider', 50)->default('openai');
            $table->text('api_key')->nullable();
            $table->string('model', 100)->default('gpt-4o-mini');
            $table->string('embedding_model', 100)->default('text-embedding-3-small');
            $table->longText('system_prompt')->nullable();
            $table->string('chatbot_name')->nullable();
            $table->string('chatbot_avatar')->nullable();
            $table->string('personality', 50)->default('friendly');
            $table->string('response_length', 20)->default('medium');
            $table->boolean('expandable_responses')->default(true);
            $table->boolean('show_citations')->default(false);
            $table->integer('max_conversations_month')->default(100);
            $table->integer('max_messages_conversation')->default(50);
            $table->integer('max_tokens_response')->default(500);
            $table->string('widget_color', 20)->nullable();
            $table->string('widget_theme', 20)->default('light');
            $table->boolean('is_enabled')->default(false);
            $table->boolean('allow_reset_chat')->default(true);
            $table->integer('url_import_max_chars')->default(5000);
            $table->float('rag_min_similarity')->default(0.25);
            $table->integer('rag_max_results')->default(5);
            $table->boolean('lead_capture_enabled')->default(false);
            $table->string('lead_capture_trigger', 50)->nullable();
            $table->string('lead_capture_title')->nullable();
            $table->text('lead_capture_description')->nullable();
            $table->json('intent_cta')->nullable();
            $table->boolean('whatsapp_enabled')->default(false);
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('whatsapp_prefill_message')->nullable();
            $table->integer('whatsapp_trigger_after')->default(3);
            $table->json('additional_preset_ids')->nullable();
            $table->boolean('scheduled_pause_enabled')->default(false);
            $table->time('scheduled_pause_start')->nullable();
            $table->time('scheduled_pause_end')->nullable();
            $table->json('scheduled_pause_days')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_ai_settings');
    }
};
