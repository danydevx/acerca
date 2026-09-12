# miniwebs/marketing

Promotions module for MiniWebs SaaS platform.

## Module

- **ListingPromotions** - Business promotions with QR codes

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/marketing", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/marketing": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (Listings) - future
- `endroid/qr-code` (external package already in product)

## Routes

- Admin routes for promotion management
- Member routes for promotion CRUD
- Public routes for promotion verification

## Migrations

1 migration: `listing_promotions`, `listing_promotion_images` tables

## Git Commands (when ready)

```bash
cd packages/miniwebs/marketing
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-marketing.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
