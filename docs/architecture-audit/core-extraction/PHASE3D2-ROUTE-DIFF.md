# PHASE 3D.2 - ROUTE DIFF

## Route Count Comparison

| Metric | Before | After |
|--------|--------|-------|
| Total Routes | 958 | 958 |
| Product Routes | 45 | 45 |
| Service Routes | ~30 | ~30 |

## Product Routes Preserved

| Route Name | Controller |
|------------|------------|
| member.listings.products.index | Modules\ListingProducts\Http\Controllers\Member\ProductController@index |
| member.listings.products.create | Modules\ListingProducts\Http\Controllers\Member\ProductController@create |
| member.listings.products.store | Modules\ListingProducts\Http\Controllers\Member\ProductController@store |
| member.listings.products.edit | Modules\ListingProducts\Http\Controllers\Member\ProductController@edit |
| member.listings.products.update | Modules\ListingProducts\Http\Controllers\Member\ProductController@update |
| member.listings.products.destroy | Modules\ListingProducts\Http\Controllers\Member\ProductController@destroy |
| member.listings.products.clone | Modules\ListingProducts\Http\Controllers\Member\ProductController@clone |
| member.listings.products.reorder | Modules\ListingProducts\Http\Controllers\Member\ProductController@reorder |
| member.listings.products.bulk-delete | Modules\ListingProducts\Http\Controllers\Member\ProductController@bulkDelete |
| member.listings.products.images.store | Modules\ListingProducts\Http\Controllers\ListingProductImageController@store |
| member.listings.products.images.destroy | Modules\ListingProducts\Http\Controllers\ListingProductImageController@destroy |
| member.product.categories.index | Modules\ListingProducts\Http\Controllers\Member\ProductCategoryController@index |
| member.product.categories.store | Modules\ListingProducts\Http\Controllers\Member\ProductCategoryController@store |
| member.product.categories.update | Modules\ListingProducts\Http\Controllers\Member\ProductCategoryController@update |
| member.product.categories.destroy | Modules\ListingProducts\Http\Controllers\Member\ProductCategoryController@destroy |

## Service Routes Preserved

| Route Name | Controller |
|------------|------------|
| member.listings.services.index | Modules\ListingServices\Http\Controllers\Member\ServiceController@index |
| member.listings.services.create | Modules\ListingServices\Http\Controllers\Member\ServiceController@create |
| member.listings.services.store | Modules\ListingServices\Http\Controllers\Member\ServiceController@store |
| member.listings.services.edit | Modules\ListingServices\Http\Controllers\Member\ServiceController@edit |
| member.listings.services.update | Modules\ListingServices\Http\Controllers\Member\ServiceController@update |
| member.listings.services.destroy | Modules\ListingServices\Http\Controllers\Member\ServiceController@destroy |
| member.listings.services.clone | Modules\ListingServices\Http\Controllers\Member\ServiceController@clone |
| member.listings.services.reorder | Modules\ListingServices\Http\Controllers\Member\ServiceController@reorder |
| member.listings.services.images.store | Modules\ListingServices\Http\Controllers\ServiceImageController@store |
| member.listings.services.images.destroy | Modules\ListingServices\Http\Controllers\ServiceImageController@destroy |
| member.listings.service-categories.index | Modules\ListingServices\Http\Controllers\Member\ServiceCategoryController@index |
| member.listings.service-categories.store | Modules\ListingServices\Http\Controllers\Member\ServiceCategoryController@store |
| member.listings.service-categories.update | Modules\ListingServices\Http\Controllers\Member\ServiceCategoryController@update |
| member.listings.service-categories.destroy | Modules\ListingServices\Http\Controllers\Member\ServiceCategoryController@destroy |

## Missing Routes: 0
## Duplicate Routes: 0
## Unexpected New Routes: 0
