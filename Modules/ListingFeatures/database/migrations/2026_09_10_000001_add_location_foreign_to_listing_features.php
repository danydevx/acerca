<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listing_features', function (Blueprint $table) {
            $table->foreign('location_id')
                ->references('id')
                ->on('listing_locations')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('listing_features', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
    }
};
