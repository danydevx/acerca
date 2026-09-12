# miniwebs/team

Team Members module for MiniWebs SaaS platform.

## Module

- **ListingTeamMembers** - Business team members and positions

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/team", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/team": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (Listings) - future

## Routes

- Admin API routes
- Member routes for team member CRUD

## Migrations

1 migration: `listing_team_members`, `listing_team_member_positions` tables

## Git Commands (when ready)

```bash
cd packages/miniwebs/team
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-team.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
