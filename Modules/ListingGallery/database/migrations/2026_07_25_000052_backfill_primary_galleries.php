<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $listings = DB::table('listings')->select('id', 'name')->orderBy('id')->get();

        foreach ($listings as $listing) {
            $primaryId = DB::table('listing_galleries')
                ->where('listing_id', $listing->id)
                ->where('is_primary', true)
                ->value('id');

            if (! $primaryId) {
                $primaryId = DB::table('listing_galleries')->insertGetId([
                    'listing_id' => $listing->id,
                    'name' => 'Galería principal',
                    'description' => 'Galería principal de '.$listing->name,
                    'is_primary' => true,
                    'is_active' => true,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('listing_gallery_images')
                ->where('listing_id', $listing->id)
                ->whereNull('business_gallery_id')
                ->update(['business_gallery_id' => $primaryId]);
        }
    }

    public function down(): void
    {
        DB::table('listing_gallery_images')
            ->whereNull('business_gallery_id')
            ->update(['business_gallery_id' => null]);
    }
};
