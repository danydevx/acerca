# miniwebs/shared

Office Hours module for MiniWebs SaaS platform.

## Module

- **ListingOfficeHours** - Manage office hours schedules for business locations

## Version

0.1.0 (Pilot - Experimental)

## Installation

```bash
composer require miniwebs/shared:@dev
```

For local development with path repository:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/miniwebs/shared",
            "options": { "symlink": true }
        }
    ],
    "require": {
        "miniwebs/shared": "@dev"
    }
}
```

## Requirements

- `miniwebs/core` (Listings)
- `miniwebs/locations` (ListingLocations)

These are typically provided by the product repository.

## Discovery

Nwidart module discovery must be enabled:

```php
// config/modules.php
'scan' => [
    'enabled' => true,
    'paths' => [
        base_path('vendor/*/*'),
        base_path('packages/*/*/Modules/*'),
    ],
],
```

## Usage

After installation, the module will be auto-discovered by nwidart and can be enabled per listing via the admin panel.

## Development

```bash
# Work on package
cd packages/miniwebs/shared

# Changes reflected immediately via symlink in vendor/
```

## Git Commands (when ready)

```bash
cd packages/miniwebs/shared
git init
git add .
git commit -m "Initial extraction of ListingOfficeHours"
git branch -M main
git remote add origin git@github.com:danydevx/miniwebs-shared.git
git push -u origin main
git tag v0.1.0
git push --tags
```

## Switching from Path to VCS

When the GitHub repository is ready:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:danydevx/miniwebs-shared.git"
        }
    ],
    "require": {
        "miniwebs/shared": "^0.1"
    }
}
```

Then `composer update miniwebs/shared` to switch from path to VCS.
