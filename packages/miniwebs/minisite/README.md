# miniwebs/minisite

Minisite foundation module for MiniWebs - Content and presentation components.

## Modules

- **ListingAbout** - About section content
- **ListingBranding** - Branding settings (colors, fonts, logo)
- **ListingFaqs** - FAQ content and categories
- **ListingHero** - Hero section
- **ListingSeo** - SEO settings
- **ListingSocialMedia** - Social media links/feeds
- **ListingFeatures** - Feature listings

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/minisite", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/minisite": "@dev"
    }
}
```

## Dependencies

- `miniwebs/locations` (ListingLocations) - for location-based features
- `Modules\Listings` (local) - CORE

## Routes

All modules provide admin, member, and public routes for managing minisite content sections.

## Migrations

Each module has its own migrations for content tables.

## Excluded

- **MinisiteThemes** - DEAD code (references App\Models\MinisiteTheme, not functional)
- **ListingMinisite** - BLOCKED (depends on Properties and ListingContactForm)
- **ListingContactForm** - BLOCKED (depends on ListingLeads in miniwebs/crm)

## Git Commands (when ready)

```bash
cd packages/miniwebs/minisite
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-minisite.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
