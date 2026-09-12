# PHASE 4B — COMPOSER INSTALLATION

## Path Repository Configuration

```json
// composer.json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/miniwebs/shared",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "miniwebs/shared": "@dev"
    }
}
```

## Installation Result

```
miniwebs/shared: Symlinking from packages/miniwebs/shared
```

### Symlink Created

```
vendor/miniwebs/shared -> ../../packages/miniwebs/shared/
```

### Composer.lock Entry

```json
{
    "name": "miniwebs/shared",
    "version": "dev-develop2",
    "dist": {
        "type": "path",
        "url": "packages/miniwebs/shared"
    }
}
```

## Verification

```bash
ls -la vendor/miniwebs/shared/
# lrwxrwxrwx shared -> ../../packages/miniwebs/shared/

php artisan module:list | grep office
# [Enabled] ListingOfficeHours packages/miniwebs/shared/Modules/ListingOfficeHours [0]
```

## Module Discovery Path

1. Composer installs package, creates symlink in vendor/
2. Nwidart's scan.enabled=true scans vendor/*/* and packages/*/*/Modules/*
3. Module found at packages/miniwebs/shared/Modules/ListingOfficeHours
4. Provider registered via extra.laravel.providers

## Key Finding

Using `type: library` instead of `type: metapackage` is essential:
- metapackage: No files, no autoload, no symlink
- library: Proper autoload, symlink created

