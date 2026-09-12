# miniwebs/properties

Properties module for MiniWebs - Real estate/property management.

## Module

- **Properties** - Property listings with custom fields, types, and values

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/properties", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/properties": "@dev"
    }
}
```

## Dependencies

- `Modules\Listings` (local) - CORE
- No package dependencies (self-contained)

## Routes

- Admin routes
- Member routes
- Public routes
- API routes

## Migrations

- Property types
- Property fields
- Property field sections
- Properties table
- Property values
- Property images
- General fields

## Architecture Note

Properties is a vertical module that provides property-specific functionality to the minisite system.

ListingMinisite depends on Properties for rendering property sections on minisites.

## Git Commands (when ready)

```bash
cd packages/miniwebs/properties
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-properties.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
