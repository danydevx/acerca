# FASE 3D.9D — GALLERY


## Routes moved: 12

Breakdown:
- Galleries (plural) (7): index, create, store, edit, update, destroy, setPrimary
- Gallery (singular) (5): index (twice - for /gallery and /gallery/{gallery}), store, update, destroy

## Admin controllers created

- Modules/ListingGallery/app/Http/Controllers/Admin/GalleryController.php
- Modules/ListingGallery/app/Http/Controllers/Admin/GalleryGroupController.php

## Route file created

- Modules/ListingGallery/routes/admin.php

## RouteServiceProvider updated

- Modules/ListingGallery/app/Providers/RouteServiceProvider.php
  - Added mapAdminRoutes() call in map()
  - Added mapAdminRoutes() method

## Routes removed from web.php

Lines 722-747 (12 routes):
- Route::get('/listings/{listing}/galleries')
- Route::get('/listings/{listing}/galleries/create')
- Route::post('/listings/{listing}/galleries')
- Route::get('/listings/{listing}/galleries/{gallery}/edit')
- Route::put('/listings/{listing}/galleries/{gallery}')
- Route::delete('/listings/{listing}/galleries/{gallery}')
- Route::post('/listings/{listing}/galleries/{gallery}/set-primary')
- Route::get('/listings/{listing}/gallery')
- Route::get('/listings/{listing}/gallery/{gallery}')
- Route::post('/listings/{listing}/gallery')
- Route::put('/listings/{listing}/gallery/{image}')
- Route::delete('/listings/{listing}/gallery/{image}')

## Runtime owner

ListingGallery module

## Status

PASS

Note: Pre-existing GalleryBulkUploadTest failures (6) were NOT introduced by this migration - they existed before.


## Checkpoint

| SUBPHASE | MOVED | AGGREGATOR REMAINING | ROUTES TOTAL | NEW FAILURES |
|----------|-------|----------------------|--------------|---------------|
| 3D.9A    | 10    | 46                   | 972          | 0             |
| 3D.9B    | 10    | 36                   | 972          | 0             |
| 3D.9C    | 10    | 26                   | 970          | 0             |
| 3D.9D    | 12    | 14                   | 970          | 0             |
