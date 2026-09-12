<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('business_location_id')->nullable();
            $table->unsignedBigInteger('business_service_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status', 50)->default('pending');
            $table->text('notes')->nullable();
            $table->string('confirmation_token', 100)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index('listing_id');
            $table->index('status');
            $table->index('appointment_date');
        });

        Schema::create('listing_appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('business_service_id')->nullable();
            $table->unsignedBigInteger('business_location_id')->nullable();
            $table->tinyInteger('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slots_available')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_id');
            $table->index('day_of_week');
        });

        Schema::create('listing_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('business_location_id')->nullable();
            $table->string('day_of_week', 10);
            $table->time('open_time');
            $table->time('close_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_id');
        });

        Schema::create('listing_availability_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('business_location_id')->nullable();
            $table->date('exception_date');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->integer('slots_per_slot')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('listing_id');
            $table->index('exception_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_availability_exceptions');
        Schema::dropIfExists('listing_availability');
        Schema::dropIfExists('listing_appointment_slots');
        Schema::dropIfExists('listing_appointments');
    }
};
