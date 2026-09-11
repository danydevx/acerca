# FASE 3D.9A — FAQS


## Routes moved: 10

Breakdown:
- FAQ Categories (4): index, store, update, destroy
- FAQs (6): index, create, store, edit, update, destroy

## Admin controllers created

- Modules/ListingFaqs/app/Http/Controllers/Admin/FaqController.php
- Modules/ListingFaqs/app/Http/Controllers/Admin/FaqCategoryController.php

## Route file created

- Modules/ListingFaqs/routes/admin.php

## RouteServiceProvider updated

- Modules/ListingFaqs/app/Providers/RouteServiceProvider.php
  - Added mapAdminRoutes() call in map()
  - Added mapAdminRoutes() method

## Routes removed from web.php

Lines 741-761 (10 routes):
- Route::get('/listings/{listing}/faqs')
- Route::get('/listings/{listing}/faqs/create')
- Route::post('/listings/{listing}/faqs')
- Route::get('/listings/{listing}/faqs/{faq}/edit')
- Route::put('/listings/{listing}/faqs/{faq}')
- Route::delete('/listings/{listing}/faqs/{faq}')
- Route::get('/listings/{listing}/faq-categories')
- Route::post('/listings/{listing}/faq-categories')
- Route::put('/listings/{listing}/faq-categories/{category}')
- Route::delete('/listings/{listing}/faq-categories/{category}')

## Runtime owner

ListingFaqs module

## Status

PASS


## Checkpoint

| SUBPHASE | MOVED | AGGREGATOR REMAINING | ROUTES TOTAL | NEW FAILURES |
|----------|-------|----------------------|--------------|---------------|
| 3D.9A    | 10    | 46                   | 972          | 0             |
