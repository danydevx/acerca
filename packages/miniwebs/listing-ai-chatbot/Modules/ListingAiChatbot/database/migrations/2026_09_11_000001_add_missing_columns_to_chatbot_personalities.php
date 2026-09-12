<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chatbot_personalities', function (Blueprint $table) {
            if (!Schema::hasColumn('chatbot_personalities', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
            }
            if (!Schema::hasColumn('chatbot_personalities', 'display_name') && Schema::hasColumn('chatbot_personalities', 'name')) {
                $table->string('display_name')->nullable()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chatbot_personalities', function (Blueprint $table) {
            if (Schema::hasColumn('chatbot_personalities', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
            if (Schema::hasColumn('chatbot_personalities', 'display_name')) {
                $table->dropColumn('display_name');
            }
        });
    }
};
