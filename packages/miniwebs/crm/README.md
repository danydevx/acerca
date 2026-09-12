# miniwebs/crm

CRM module for MiniWebs - Leads and Clients management.

## Modules

- **ListingLeads** - Lead capture and management
- **ListingClients** - Client management

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/crm", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/crm": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (Listings) - future
- `miniwebs/locations` (ListingLocations) - future

## Routes

- Leads: Admin, Member, Public, API routes
- Clients: Admin API, Member routes

## Migrations

- Leads: creates `listing_leads` table
- Clients: creates `listing_clients` table

## Git Commands (when ready)

```bash
cd packages/miniwebs/crm
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-crm.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
