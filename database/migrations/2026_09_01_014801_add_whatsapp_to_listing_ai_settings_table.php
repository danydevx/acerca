<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listing_ai_settings', function (Blueprint $table) {
            $table->boolean('whatsapp_enabled')->default(false)->after('lead_capture_trigger');
            $table->string('whatsapp_number', 20)->nullable()->after('whatsapp_enabled');
            $table->string('whatsapp_prefill_message', 500)->nullable()->after('whatsapp_number');
            $table->integer('whatsapp_trigger_after')->default(7)->after('whatsapp_prefill_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listing_ai_settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_enabled', 'whatsapp_number', 'whatsapp_prefill_message', 'whatsapp_trigger_after']);
        });
    }
};
