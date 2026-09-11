# PHASE 4A — VERSIONING STRATEGY

## Semantic Versioning (SemVer)

```
MAJOR.MINOR.PATCH
1.2.3

MAJOR: Breaking changes
MINOR: New features (backward compatible)
PATCH: Bug fixes (backward compatible)
```

---

## Versioning Rules Per Package Type

### Core Package (miniwebs/core)

| Change | Version Bump |
|--------|--------------|
| Remove or rename public API | MAJOR |
| Change routing structure | MAJOR |
| Add new required dependency | MINOR |
| Add new optional dependency | MINOR |
| Add new public method | MINOR |
| Fix bug | PATCH |

### Domain Packages (miniwebs/catalog, miniwebs/appointments, etc.)

| Change | Version Bump |
|--------|--------------|
| Remove module from package | MAJOR |
| Change module's public API | MAJOR |
| Add new module to package | MINOR |
| Add new module feature | MINOR |
| Fix module bug | PATCH |

### Product Repositories

Products don't version themselves - they version their package dependencies.

```json
{
    "require": {
        "miniwebs/core": "^1.0"
    }
}
```

---

## Version Constraints in Products

### Caret (^) - Recommended for most cases

```json
"miniwebs/core": "^1.0"
```

Allows: 1.0.0, 1.1.0, 1.9.9, 2.3.4
Blocks: 2.0.0+

### Tilde (~) - More conservative

```json
"miniwebs/core": "~1.0"
```

Allows: 1.0.0, 1.1.0, 1.9.9
Blocks: 2.0.0, 1.10.0

### Exact - Most conservative

```json
"miniwebs/core": "1.2.0"
```

Allows only: 1.2.0

### Recommendation

Use `^MAJOR.MINOR` for stable products:
```json
"miniwebs/core": "^1.0",
"miniwebs/catalog": "^1.2"
```

Use `dev-develop` for development:
```json
"miniwebs/core": "dev-develop",
"miniwebs/catalog": "dev-develop"
```

---

## Development Versions

### minimum-stability

```json
{
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

### Using dev-* versions safely

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:danydevx/miniwebs-core.git"
        }
    ],
    "require": {
        "miniwebs/core": "dev-develop as 1.5.0"
    }
}
```

This tells Composer:
- Use the `develop` branch
- Treat it as if it were version `1.5.0` for constraint checking

### Branch Aliases

In package's `composer.json`:

```json
{
    "extra": {
        "branch-alias": {
            "dev-develop": "1.5.x-dev"
        }
    }
}
```

This automatically aliases `dev-develop` to `1.5.x-dev`.

---

## Release Process

### 1. Patch Release (1.2.3 -> 1.2.4)

```bash
git flow release start 1.2.4
# Fix bug
git flow release finish 1.2.4
git push origin main --tags
```

### 2. Minor Release (1.2.3 -> 1.3.0)

```bash
git flow release start 1.3.0
# Add new feature
git flow release finish 1.3.0
git push origin main --tags
```

### 3. Major Release (1.2.3 -> 2.0.0)

```bash
git flow release start 2.0.0
# Make breaking changes
git flow release finish 2.0.0
git push origin main --tags
```

---

## Product Update Strategy

### Safe update (patch/minor)

```bash
composer update miniwebs/catalog
# Runs tests
# Deploys
```

### Major update (requires review)

```bash
composer require miniwebs/catalog:^2.0
# Review breaking changes
# Update code if needed
# Run tests
# Deploy
```

### Product can pin older versions

```json
{
    "require": {
        "miniwebs/catalog": "^1.2"  // Won't auto-update to 2.0
    }
}
```

This satisfies: "permanecer en una versión anterior de un paquete cuando sea necesario"

---

## Changelog

Each package should maintain `CHANGELOG.md`:

```markdown
## [1.2.0] - 2026-09-11

### Added
- New ListingProducts::getFeatured() method

### Changed
- ListingServices controller now uses FormRequest

### Fixed
- Fixed timezone issue in availability calculation
```

Use `git log --oneline --pretty="%s" 1.1.0..1.2.0` to generate automatically.

---

## Deprecation Policy

When removing features, mark as deprecated first:

```php
/**
 * @deprecated 1.2.0 Use getActiveListings() instead
 */
public function getPublishedListings()
{
    // ... existing code
    // Log deprecation warning
}
```

Then remove in next major version.
