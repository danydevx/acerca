<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Listings\Models\Listing;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('listing_module_definitions')->updateOrInsert(
            ['key' => 'analytics'],
            [
                'name' => 'Analytics',
                'description' => 'Estadísticas y métricas de visitantes',
                'icon' => 'bi bi-graph-up',
                'sort_order' => 50,
                'is_active' => true,
                'is_premium' => false,
                'has_settings' => true,
                'settings_url' => '/member/listings/{id}/analytics/settings',
                'show_in_menu' => true,
                'menu_title' => 'Analytics',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $moduleDef = DB::table('listing_module_definitions')->where('key', 'analytics')->first();
        if ($moduleDef) {
            $listings = Listing::where('is_active', true)->get();
            foreach ($listings as $listing) {
                DB::table('listing_modules')->updateOrInsert(
                    [
                        'listing_id' => $listing->id,
                        'module_definition_id' => $moduleDef->id,
                    ],
                    [
                        'module_key' => 'analytics',
                        'module_name' => 'Analytics',
                        'is_enabled' => true,
                        'show_in_menu' => true,
                        'menu_title' => 'Analytics',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    public function down(): void
    {
        DB::table('listing_module_definitions')->where('key', 'analytics')->delete();
    }
};
