<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_contact_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('shortcode')->unique();
            $table->text('success_message')->nullable();
            $table->boolean('show_phone')->default(false);
            $table->boolean('show_email')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_id');
            $table->index('shortcode');
            $table->index('is_active');
        });

        Schema::create('listing_contact_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_contact_form_id')->constrained('listing_contact_forms')->cascadeOnDelete();
            $table->string('label');
            $table->string('name');
            $table->string('type')->default('text');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->json('options')->nullable();
            $table->timestamps();

            $table->index('listing_contact_form_id');
            $table->index('is_active');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_contact_form_fields');
        Schema::dropIfExists('listing_contact_forms');
    }
};
