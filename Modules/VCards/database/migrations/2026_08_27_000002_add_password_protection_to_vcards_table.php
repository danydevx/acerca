<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->boolean('password_protected')->default(false)->after('ai_chat_enabled');
            $table->string('password_salt', 64)->nullable()->after('password_protected');
            $table->text('password_encrypted')->nullable()->after('password_salt');
        });
    }

    public function down(): void
    {
        Schema::table('vcards', function (Blueprint $table) {
            $table->dropColumn(['password_protected', 'password_salt', 'password_encrypted']);
        });
    }
};
