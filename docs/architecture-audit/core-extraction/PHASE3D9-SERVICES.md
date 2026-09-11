# FASE 3D.9C — SERVICES


## Routes moved: 10

Breakdown:
- Service Categories (4): index, store, update, destroy
- Services (6): index, create, store, edit, update, destroy

## Admin controllers created

- Modules/ListingServices/app/Http/Controllers/Admin/ServiceController.php
- Modules/ListingServices/app/Http/Controllers/Admin/ServiceCategoryController.php

## Route file created

- Modules/ListingServices/routes/admin.php

## RouteServiceProvider updated

- Modules/ListingServices/app/Providers/RouteServiceProvider.php
  - Added mapAdminRoutes() call in map()
  - Added mapAdminRoutes() method

## Routes removed from web.php

Lines 715-739 (10 routes):
- Route::get('/listings/{listing}/services')
- Route::get('/listings/{listing}/services/create')
- Route::post('/listings/{listing}/services')
- Route::get('/listings/{listing}/services/{service}/edit')
- Route::put('/listings/{listing}/services/{service}')
- Route::delete('/listings/{listing}/services/{service}')
- Route::get('/listings/{listing}/service-categories')
- Route::post('/listings/{listing}/service-categories')
- Route::put('/listings/{listing}/service-categories/{category}')
- Route::delete('/listings/{listing}/service-categories/{category}')

Note: Service image routes (admin.business.services.images.*) already used the module's controller and were not affected.

## Runtime owner

ListingServices module

## Status

PASS


## Checkpoint

| SUBPHASE | MOVED | AGGREGATOR REMAINING | ROUTES TOTAL | NEW FAILURES |
|----------|-------|----------------------|--------------|---------------|
| 3D.9A    | 10    | 46                   | 972          | 0             |
| 3D.9B    | 10    | 36                   | 972          | 0             |
| 3D.9C    | 10    | 26                   | 970          | 0             |
