# miniwebs/guests

Guests and RSVP management module for MiniWebs.

## Module

- **ListingGuests** - Digital invitation guest management

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/guests", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/guests": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (future)

## Routes

- Member routes for guest/RSVP management

## Migrations

1 migration: guest management tables

## Git Commands (when ready)

```bash
cd packages/miniwebs/guests
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-guests.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
