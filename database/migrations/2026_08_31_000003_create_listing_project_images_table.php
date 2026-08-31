<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_project_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('filename');
            $table->string('original_name');
            $table->string('extension');
            $table->string('mime_type');
            $table->integer('size');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['listing_project_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_project_images');
    }
};
