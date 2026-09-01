<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_personalities', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();
            $table->string('display_name', 100);
            $table->text('description')->nullable();
            $table->text('system_prompt_hint')->nullable();
            $table->decimal('default_temperature', 4, 2)->nullable();
            $table->enum('default_response_length', ['short', 'medium', 'long'])->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_personalities');
    }
};
