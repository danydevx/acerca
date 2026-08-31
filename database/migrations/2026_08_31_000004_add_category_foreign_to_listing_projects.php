<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listing_projects', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('listing_project_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('listing_projects', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
};
