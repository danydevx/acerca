<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsModuleSeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('listing_module_definitions')->where('key', 'projects')->exists();
        if ($exists) {
            $this->command->info('Projects module already exists.');
            return;
        }

        DB::table('listing_module_definitions')->insert([
            'key' => 'projects',
            'name' => 'Proyectos',
            'description' => 'Gestión de proyectos y portafolio de trabajo',
            'icon' => 'bi bi-folder',
            'sort_order' => 30,
            'is_active' => 1,
            'is_premium' => 0,
            'has_settings' => 0,
            'show_in_menu' => 1,
            'menu_title' => 'Proyectos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $moduleDef = DB::table('listing_module_definitions')->where('key', 'projects')->first();

        $listings = DB::table('listings')->pluck('id');
        foreach ($listings as $listingId) {
            $existsForListing = DB::table('listing_modules')
                ->where('listing_id', $listingId)
                ->where('module_key', 'projects')
                ->exists();

            if (!$existsForListing) {
                DB::table('listing_modules')->insert([
                    'listing_id' => $listingId,
                    'module_definition_id' => $moduleDef->id,
                    'module_key' => 'projects',
                    'module_name' => 'Proyectos',
                    'is_enabled' => 1,
                    'show_in_menu' => 1,
                    'menu_title' => 'Proyectos',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Projects module seeded successfully.');
    }
}
