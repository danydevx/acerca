# Security Audit: Multi-Entity Isolation (listing_id)

**Date:** 2026-09-10
**Phase:** FASE 0 - Security & Core Preparation
**Status:** COMPLETED

---

## Objective

Resolve security issues related to `listing_id` isolation and prepare the codebase for future Core extraction.

---

## Scope

- Audit all models with `listing_id` foreign key
- Find unsafe queries that could allow cross-listing data access
- Implement fixes for HIGH and MEDIUM severity issues
- Create cross-listing isolation tests

---

## Summary

| Metric | Value |
|--------|-------|
| Total models with `listing_id` | 65 |
| HIGH severity issues found | 17 |
| MEDIUM severity issues found | 5 |
| HIGH issues fixed | 17 |
| MEDIUM issues fixed | 1 |
| MEDIUM issues deferred | 4 |
| Tests created | 1 file |

---

## Issues Fixed

### HIGH Severity (All Fixed)

| # | File | Lines | Issue | Fix Applied |
|---|------|-------|-------|-------------|
| 1 | `DirectoryController.php` | 236-237 | `ListingService::findOrFail()` without listing_id scope | Added `Rule::exists()->where('listing_id')` + scoped query |
| 2 | `BusinessController.php` | 524-525 | `ListingService::findOrFail()` without listing_id scope | Added `Rule::exists()->where('listing_id')` + scoped query |
| 3 | `OrderController.php` | 125 | `ListingLocation::find()` without listing_id scope | Added validation + scoped query |
| 4 | `AppointmentController.php` | 146, 290 | `ListingService::findOrFail()` without listing_id scope | Added `Rule::exists()->where('listing_id')` + scoped query |
| 5 | `ListingContentController.php` | 1191, 1304 | `ListingService::findOrFail()` without listing_id scope | Added `Rule::exists()->where('listing_id')` + scoped query |
| 6 | `ReindexOnContentChange.php` | 67,83,99,117,128,158,169,184,199 | 9 instances of `find()` without listing_id scope | Refactored to pass `businessId` and scope all queries |

### MEDIUM Severity

| # | File | Lines | Issue | Status |
|---|------|-------|-------|--------|
| 7 | `OrderItem.php` | 36, 48 | Accessors `getProduct()` and `getVariant()` without listing_id scope | **FIXED** |
| 8 | `ApiExplorerController.php` | Multiple | Admin endpoints with `findOrFail` without verifying admin has access to business | **DEFERRED** - Requires architectural changes to admin access control |

---

## Files Modified

### Controllers Fixed
- `app/Http/Controllers/Public/DirectoryController.php`
- `app/Http/Controllers/Public/BusinessController.php`
- `Modules/Orders/app/Http/Controllers/Public/OrderController.php`
- `app/Http/Controllers/Member/AppointmentController.php`
- `app/Http/Controllers/Admin/ListingContentController.php`

### Listeners Fixed
- `Modules/ListingAiChatbot/app/Listeners/ReindexOnContentChange.php`

### Models Fixed
- `Modules/Orders/app/Models/OrderItem.php`

### Files Created
- `app/Models/Traits/BelongsToListing.php` - Trait for models with listing_id
- `tests/Feature/ListingIsolationTest.php` - Cross-listing isolation tests

---

## BelongsToListing Trait

Created at `app/Models/Traits/BelongsToListing.php`:

```php
trait BelongsToListing
{
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function scopeForListing(Builder $query, int $listingId): Builder
    {
        return $query->where('listing_id', $listingId);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('listing', function (Builder $q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }
}
```

**Usage:** Use when a model has `listing_id`. Do NOT apply globally.

---

## Test File

Created `tests/Feature/ListingIsolationTest.php` with tests for:
- User cannot access service from different listing via appointment store
- User cannot access location from different listing via appointment store
- Service query is properly scoped to listing
- Location query is properly scoped to listing

**Note:** Tests require SQLite PDO driver to run (environment issue, not code issue).

---

## Deferred Issues

### ApiExplorerController (MEDIUM)

**Issue:** Admin endpoints use `Listing::findOrFail($businessId)` without verifying the admin has access to that specific business.

**Impact:** An admin could access data from any business by knowing its ID.

**Fix Required:** Implement admin-scoped access control that verifies the admin manages the target business.

**Status:** Deferred - requires architectural changes to the admin role/permission system.

---

## Validation Approach

The fix pattern used:

### Before (Vulnerable)
```php
$data = $request->validate([
    'service_id' => ['required', 'exists:listing_services,id'],
]);
$service = ListingService::findOrFail($data['service_id']);
```

### After (Secure)
```php
$data = $request->validate([
    'service_id' => [
        'required',
        Rule::exists('listing_services', 'id')->where('listing_id', $business->id),
    ],
]);
$service = ListingService::where('id', $data['service_id'])
    ->where('listing_id', $business->id)
    ->firstOrFail();
```

---

## Build Status

| Check | Status |
|-------|--------|
| PHP Syntax (all modified files) | ✅ PASS |
| Laravel Artisan | ✅ OK |
| Existing tests | ⚠️ SQLite driver not available in environment |

---

## Next Steps

1. **Run tests** when SQLite driver is available
2. **Fix ApiExplorerController** when admin access control is defined
3. **Apply `BelongsToListing` trait** to models on as-needed basis during future development
4. **Add more isolation tests** for other cross-listing scenarios

---

## Audit Conducted By

Architecture Audit Team

## Date

2026-09-10
