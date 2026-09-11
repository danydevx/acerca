<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('guest_id')->nullable()->constrained('listing_guests')->nullOnDelete();
            $table->timestamp('checkin_time')->nullable();
            $table->integer('plus_ones_checked_in')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('listing_id');
            $table->index('guest_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_checkins');
    }
};
