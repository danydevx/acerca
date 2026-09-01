<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chatbot_personalities', function (Blueprint $table) {
            $table->foreignId('listing_id')->nullable()->after('id')->constrained('listings')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('chatbot_personalities', function (Blueprint $table) {
            $table->dropForeign(['listing_id']);
            $table->dropColumn('listing_id');
        });
    }
};
