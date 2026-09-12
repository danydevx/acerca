<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->boolean('track_visits')->default(true)->after('ai_chat_enabled');
            $table->boolean('store_ip_hash')->default(false)->after('track_visits');
            $table->unsignedInteger('retention_days')->default(365)->after('store_ip_hash');
        });
    }

    public function down(): void
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->dropColumn(['track_visits', 'store_ip_hash', 'retention_days']);
        });
    }
};
