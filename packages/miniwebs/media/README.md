# miniwebs/media

Media module for MiniWebs - Gallery and image management.

## Module

- **ListingGallery** - Image gallery management for listings

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/media", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/media": "@dev"
    }
}
```

## Dependencies

- `miniwebs/locations` (ListingLocations) - for location-based gallery organization
- `Modules\Listings` (local) - CORE

## Routes

- Admin gallery routes
- Member gallery routes
- Public gallery routes
- API routes

## Migrations

- `listing_galleries` table
- `listing_gallery_images` table

## Git Commands (when ready)

```bash
cd packages/miniwebs/media
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-media.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
