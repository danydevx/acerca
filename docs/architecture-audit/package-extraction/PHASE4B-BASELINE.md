# PHASE 4B — BASELINE

## Routes

| Metric | Count |
|--------|-------|
| Total routes | 963 |
| ListingOfficeHours routes | 7 |

## ListingOfficeHours Module Details

### Controllers
- `Modules\ListingOfficeHours\Http\Controllers\Member\ScheduleController`
- `Modules\ListingOfficeHours\Http\Controllers\Admin\Api\OfficeHoursApiController`

### Models
- `Modules\ListingOfficeHours\Models\ListingSchedule`

### Policies
- `Modules\ListingOfficeHours\Policies\ListingSchedulePolicy`

### Providers
- `Modules\ListingOfficeHours\Providers\ListingOfficeHoursServiceProvider`
- `Modules\ListingOfficeHours\Providers\RouteServiceProvider`

### Routes (7 total)
```
GET    member/listings/{listing}/locations/{location}/schedules
POST   member/listings/{listing}/locations/{location}/schedules
GET    member/listings/{listing}/locations/{location}/schedules/create
PUT    member/listings/{listing}/locations/{location}/schedules/{schedule}
DELETE member/listings/{listing}/locations/{location}/schedules/{schedule}
POST   member/listings/{listing}/locations/{location}/schedules/{schedule}/clone
GET    member/listings/{listing}/locations/{location}/schedules/{schedule}/edit
```

### Frontend Assets
- None (no Vue, JS, SCSS, Vite entries)

### Tests
- 0 specific tests for ListingOfficeHours

### Migrations
- 0 migrations (stateless module)

## Dependencies Analysis

### External Module Dependencies
| Module | Type | Package |
|--------|------|---------|
| `Modules\Listings` | CORE_REQUIRED | miniwebs/core |
| `Modules\ListingLocations` | BASE | miniwebs/locations |

### Core Dependencies (Allowed)
| Class | Type |
|-------|------|
| `App\Http\Controllers\Controller` | Core base controller |
| `App\Models\User` | Core user model |

## Conclusion

ListingOfficeHours is the ideal pilot package because:
- Zero migrations
- Zero frontend complexity
- Only depends on CORE modules (Listings, ListingLocations)
- No product-specific coupling
- Simple CRUD operations
