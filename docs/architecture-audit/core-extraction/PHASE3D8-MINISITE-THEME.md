# PHASE3D8-MINISITE-THEME

## Controller: Admin\MinisiteThemeController

### Routes (2)

```
GET  member/listings/{listing}/minisite-theme  → MinisiteThemeController@index
PUT  member/listings/{listing}/minisite-theme/{theme} → MinisiteThemeController@update
```

### Classification: MODULE_OWNED

### Issue

This controller is in `App\Http\Controllers\Admin` but serves MEMBER routes. This is a structural anomaly.

### Module State

- `Modules/ListingMinisite` EXISTS and is enabled
- Has its own routes in `routes/member.php` for `/minisite` (not `/minisite-theme`)
- `member/listings/{listing}/minisite-theme` routes are NOT in the module

### What belongs to what

The `minisite-theme` routes should belong to `Modules\ListingMinisite` because:
1. They configure the minisite theme for a listing
2. They're part of the minisite feature set
3. The module already handles minisite sections and content

### Recommendation

**Action: MOVE_TO_EXISTING_MODULE**

Migrate `Admin\MinisiteThemeController` to `Modules\ListingMinisite\Http\Controllers\Member\MinisiteThemeController`

This would be a simple migration since:
1. The module already exists and is enabled
2. The routes follow the same pattern as other member routes
3. No model migration needed - just HTTP ownership

### Risks

- Low risk - straightforward route/controller migration
- No model changes
- No data migration

### Not Introducing Listing->Theme Coupling

Remember: Do NOT reintroduce `Listing::getThemeByListingType()` or similar coupling that was previously removed.
