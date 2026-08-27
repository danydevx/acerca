<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listing_ai_settings', function (Blueprint $table) {
            $table->boolean('scheduled_pause_enabled')->default(false)->after('intent_cta');
            $table->string('scheduled_pause_start', 5)->nullable()->after('scheduled_pause_enabled');
            $table->string('scheduled_pause_end', 5)->nullable()->after('scheduled_pause_start');
            $table->json('scheduled_pause_days')->nullable()->after('scheduled_pause_end');
        });
    }

    public function down(): void
    {
        Schema::table('listing_ai_settings', function (Blueprint $table) {
            $table->dropColumn([
                'scheduled_pause_enabled',
                'scheduled_pause_start',
                'scheduled_pause_end',
                'scheduled_pause_days',
            ]);
        });
    }
};
