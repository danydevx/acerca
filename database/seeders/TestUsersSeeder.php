<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Modules\Listings\Models\Listing;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = Role::where('name', 'superadmin')->first();
        $admin = Role::where('name', 'admin')->first();
        $member = Role::where('name', 'member')->first();

        if (!$superadmin || !$admin || !$member) {
            $this->command->error('Roles not found. Run RolesAndPermissionsSeeder first.');
            return;
        }

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->syncRoles([$superadmin, $admin]);

        $memberUser = User::updateOrCreate(
            ['email' => 'member@demo.com'],
            [
                'name' => 'Member User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $memberUser->syncRoles([$member]);

        $existingListing = Listing::where('user_id', $memberUser->id)->first();
        if (!$existingListing) {
            $listing = Listing::create([
                'user_id' => $memberUser->id,
                'name' => 'Mi Negocio Demo',
                'slug' => 'mi-negocio-demo-' . $memberUser->id,
                'listing_type' => 'generic',
                'is_active' => true,
                'is_published' => true,
            ]);

            $moduleDefinitions = \App\Models\ModuleDefinition::where('is_active', true)->get();
            foreach ($moduleDefinitions as $def) {
                $listing->modules()->create([
                    'module_definition_id' => $def->id,
                    'module_key' => $def->key,
                    'module_name' => $def->name,
                    'is_enabled' => true,
                    'show_in_menu' => $def->show_in_menu ?? false,
                    'menu_title' => $def->menu_title,
                ]);
            }
        } else {
            $existingListing->update([
                'name' => 'Mi Negocio Demo',
                'slug' => 'mi-negocio-demo-' . $memberUser->id,
                'is_published' => true,
            ]);

            $moduleDefinitions = \App\Models\ModuleDefinition::where('is_active', true)->get();
            foreach ($moduleDefinitions as $def) {
                $existingListing->modules()->updateOrCreate(
                    ['module_key' => $def->key],
                    [
                        'module_definition_id' => $def->id,
                        'module_name' => $def->name,
                        'is_enabled' => true,
                        'show_in_menu' => $def->show_in_menu ?? false,
                        'menu_title' => $def->menu_title,
                    ]
                );
            }
        }

        $this->command->info('Test users created:');
        $this->command->info('  - admin@demo.com (superadmin + admin)');
        $this->command->info('  - member@demo.com (member) with listing configured');
    }
}
