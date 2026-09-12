# miniwebs/reviews

Reviews module for MiniWebs SaaS platform.

## Module

- **ListingReviews** - Business reviews management

## Version

0.1.0 (Pilot - Experimental)

## Installation

```bash
composer require miniwebs/reviews:@dev
```

For local development with path repository:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/miniwebs/reviews",
            "options": { "symlink": true }
        }
    ],
    "require": {
        "miniwebs/reviews": "@dev"
    }
}
```

## Dependencies

This package depends on:
- `miniwebs/core` (Listings) - will be resolved when Core is extracted

Currently the module uses:
- `Modules\Listings\Models\Listing`
- `Modules\ListingLocations\Models\ListingLocation`

## Routes

- Admin routes for review management
- Member routes for review CRUD
- API routes for admin

## Migrations

1 migration: creates `listing_reviews` table

## Development

```bash
cd packages/miniwebs/reviews
# Edit module files
# Changes reflected via symlink in vendor/
```

## Git Commands (when ready)

```bash
cd packages/miniwebs/reviews
git init
git add .
git commit -m "Initial extraction of ListingReviews"
git branch -M main
git remote add origin git@github.com:danydevx/miniwebs-reviews.git
git push -u origin main
git tag v0.1.0
git push --tags
```
