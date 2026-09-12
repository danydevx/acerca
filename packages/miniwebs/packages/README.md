# miniwebs/packages

Packages module for MiniWebs SaaS platform.

## Module

- **ListingPackages** - Business packages with features

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/packages", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/packages": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (Listings) - future

## Routes

- Admin API routes
- Member routes for package CRUD

## Migrations

1 migration: `listing_packages`, `listing_package_features` tables

## Git Commands (when ready)

```bash
cd packages/miniwebs/packages
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-packages.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
