# FASE 3D.9E — LOCATIONS


## Routes moved: 6

Breakdown:
- Locations (6): index, create, store, edit, update, destroy

## Admin controllers created

- Modules/ListingLocations/app/Http/Controllers/Admin/LocationController.php

## Route file created

- Modules/ListingLocations/routes/admin.php

## RouteServiceProvider updated

- Modules/ListingLocations/app/Providers/ListingLocationsRouteServiceProvider.php
  - Added mapAdminRoutes() call in map()
  - Added mapAdminRoutes() method

## Routes removed from web.php

Lines 702-713 (6 routes):
- Route::get('/listings/{listing}/locations')
- Route::get('/listings/{listing}/locations/create')
- Route::post('/listings/{listing}/locations')
- Route::get('/listings/{listing}/locations/{location}/edit')
- Route::put('/listings/{listing}/locations/{location}')
- Route::delete('/listings/{listing}/locations/{location}')

## Runtime owner

ListingLocations module

## Status

PASS


## Checkpoint

| SUBPHASE | MOVED | AGGREGATOR REMAINING | ROUTES TOTAL | NEW FAILURES |
|----------|-------|----------------------|--------------|---------------|
| 3D.9A    | 10    | 46                   | 972          | 0             |
| 3D.9B    | 10    | 36                   | 972          | 0             |
| 3D.9C    | 10    | 26                   | 970          | 0             |
| 3D.9D    | 12    | 14                   | 970          | 0             |
| 3D.9E    | 6     | 8                    | 970          | 0             |
