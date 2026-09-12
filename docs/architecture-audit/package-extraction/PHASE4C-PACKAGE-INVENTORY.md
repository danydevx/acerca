# PHASE 4C — PACKAGE INVENTORY

## Extracted Packages (5 total)

| Package | Module | Routes | Status |
|---------|--------|--------|--------|
| miniwebs/shared | ListingOfficeHours | 7 | PASS |
| miniwebs/reviews | ListingReviews | 17 | PASS |
| miniwebs/team | ListingTeamMembers | 14 | PASS |
| miniwebs/packages | ListingPackages | 10 | PASS |
| miniwebs/marketing | ListingPromotions | 17 | PASS |

## Package Details

### miniwebs/shared
- **Module**: ListingOfficeHours
- **Routes**: 7 (schedules CRUD)
- **Migrations**: 0
- **Frontend**: None

### miniwebs/reviews
- **Module**: ListingReviews
- **Routes**: 17 (admin + member + API)
- **Migrations**: 1
- **Frontend**: None

### miniwebs/team
- **Module**: ListingTeamMembers
- **Routes**: 14 (admin API + member CRUD)
- **Migrations**: 1
- **Frontend**: None

### miniwebs/packages
- **Module**: ListingPackages
- **Routes**: 10 (admin API + member CRUD)
- **Migrations**: 1
- **Frontend**: None

### miniwebs/marketing
- **Module**: ListingPromotions
- **Routes**: 17 (admin + member + public verification)
- **Migrations**: 1
- **Frontend**: None
- **Special**: Uses endroid/qr-code (external)

## Ownership

All 5 modules now have single source of truth in `packages/miniwebs/*/` directories.

No duplicate local copies exist.

## Composer Dependencies Installed

```json
"miniwebs/shared": "dev-develop2"
"miniwebs/reviews": "dev-develop2"
"miniwebs/team": "dev-develop2"
"miniwebs/packages": "dev-develop2"
"miniwebs/marketing": "dev-develop2"
```

All installed via path repository with symlinks.
