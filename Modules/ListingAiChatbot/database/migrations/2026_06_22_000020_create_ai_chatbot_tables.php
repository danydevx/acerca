<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_contexts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('name');
            $table->text('content');
            $table->string('source_type', 50)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_id');
        });

        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable();
            $table->string('session_id');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();

            $table->index('listing_id');
            $table->index('session_id');
        });

        Schema::create('ai_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('conversation_id');
            $table->foreignId('user_id')->nullable();
            $table->string('role', 20);
            $table->longText('content');
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');

            $table->index('conversation_id');
        });

        Schema::create('ai_embeddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('source_type', 50);
            $table->unsignedBigInteger('source_id');
            $table->longText('chunk_text');
            $table->text('embedding');
            $table->string('content_hash', 64)->nullable();
            $table->timestamps();

            $table->index(['listing_id', 'source_type', 'source_id']);
        });

        Schema::create('chatbot_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->date('date');
            $table->string('event_type', 50);
            $table->unsignedInteger('count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['listing_id', 'date', 'event_type']);
            $table->index('date');
        });

        Schema::create('chatbot_personalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('system_prompt');
            $table->string('greeting');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['listing_id', 'slug']);
        });

        Schema::create('chatbot_top_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('times_asked')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_id');
        });

        Schema::create('chatbot_widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('name');
            $table->string('api_key', 64)->unique();
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index('listing_id');
        });

        Schema::create('chatbot_widget_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('widget_id');
            $table->date('date');
            $table->string('event_type', 50);
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();

            $table->unique(['widget_id', 'date', 'event_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_widget_analytics');
        Schema::dropIfExists('chatbot_widgets');
        Schema::dropIfExists('chatbot_top_questions');
        Schema::dropIfExists('chatbot_personalities');
        Schema::dropIfExists('chatbot_analytics');
        Schema::dropIfExists('ai_embeddings');
        Schema::dropIfExists('ai_messages');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('ai_contexts');
    }
};
