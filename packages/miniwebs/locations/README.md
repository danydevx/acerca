# miniwebs/locations

Locations module for MiniWebs - Geography catalog and listing locations management.

## Modules

- **Locations** - Geographic system catalog (countries, states, municipalities)
- **ListingLocations** - Listing-owned business locations/addresses

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/locations", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/locations": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (Listings) - FUTURE (when extracted)
- Currently: `Modules\Listings` (local)

## Routes

### Locations (admin)
- Country management
- State management
- Municipality management

### ListingLocations
- Admin routes
- Member routes
- Public routes
- API routes

## Migrations

- Locations: `countries`, `states`, `municipalities` tables
- ListingLocations: `listing_locations` table

## Git Commands (when ready)

```bash
cd packages/miniwebs/locations
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-locations.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
