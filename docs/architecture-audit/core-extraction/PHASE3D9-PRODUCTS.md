# FASE 3D.9B — PRODUCTS


## Routes moved: 10

Breakdown:
- Product Categories (4): index, store, update, destroy
- Products (6): index, create, store, edit, update, destroy

## Admin controllers created

- Modules/ListingProducts/app/Http/Controllers/Admin/ProductController.php
- Modules/ListingProducts/app/Http/Controllers/Admin/ProductCategoryController.php

## Route file created

- Modules/ListingProducts/routes/admin.php

## RouteServiceProvider updated

- Modules/ListingProducts/app/Providers/RouteServiceProvider.php
  - Added mapAdminRoutes() call in map()
  - Added mapAdminRoutes() method

## Routes removed from web.php

Lines 743-763 (10 routes):
- Route::get('/listings/{listing}/products')
- Route::get('/listings/{listing}/products/create')
- Route::post('/listings/{listing}/products')
- Route::get('/listings/{listing}/products/{product}/edit')
- Route::put('/listings/{listing}/products/{product}')
- Route::delete('/listings/{listing}/products/{product}')
- Route::get('/listings/{listing}/product-categories')
- Route::post('/listings/{listing}/product-categories')
- Route::put('/listings/{listing}/product-categories/{category}')
- Route::delete('/listings/{listing}/product-categories/{category}')

## Runtime owner

ListingProducts module

## Status

PASS


## Checkpoint

| SUBPHASE | MOVED | AGGREGATOR REMAINING | ROUTES TOTAL | NEW FAILURES |
|----------|-------|----------------------|--------------|---------------|
| 3D.9A    | 10    | 46                   | 972          | 0             |
| 3D.9B    | 10    | 36                   | 972          | 0             |
