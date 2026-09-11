# PHASE 4A — LOCAL DEVELOPMENT

## Goal

Enable working on `miniwebs-saas` AND `miniwebs/catalog` simultaneously without committing/pushing every change.

---

## Option A: Composer Path Repositories (Recommended)

### Setup

In `miniwebs-saas/composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../packages/*",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "miniwebs/catalog": "*"
    }
}
```

### File Structure

```
development/
├── packages/
│   ├── miniwebs-core/
│   ├── miniwebs-catalog/
│   ├── miniwebs-appointments/
│   └── ...
└── products/
    ├── miniwebs-saas/
    ├── invitations-saas/
    └── realestate-saas/
```

### How it works

```bash
cd products/miniwebs-saas
composer install

# Composer creates symlinks to ../../packages/*/ directories
# instead of downloading from GitHub
```

Changes in `packages/miniwebs-catalog/` are immediately reflected in `products/miniwebs-saas/vendor/miniwebs/catalog/`.

### Pros
- Zero friction, instant reflection
- No git operations needed
- Native Composer support

### Cons
- Only works locally (CI/CD needs real VCS)
- Must remember to commit package changes

---

## Option B: Modman-style Symlinks

For projects not using Composer path repos:

```bash
# In miniwebs-saas project root
ln -sf ../../packages/miniwebs-catalog/Modules/ListingProducts ./Modules/ListingProducts
ln -sf ../../packages/miniwebs-catalog/Modules/ListingServices ./Modules/ListingServices
```

### Pros
- Works with any project structure
- Simple to understand

### Cons
- Manual, error-prone
- Hard to track which symlinks exist
- Doesn't work with nwidart's auto-discovery properly

**Verdict**: Not recommended

---

## Option C: NFS Mount (Team Scenario)

For teams sharing code:

```
# developer-machine-1
/srv/miniwebs-packages/  (NFS mount)

# developer-machine-2
/srv/miniwebs-packages/  (same NFS mount)
```

Each developer clones packages to shared mount.

### Pros
- Team can work on same packages
- Changes instantly visible to all

### Cons
- Requires NFS setup
- Conflict potential without good git workflow
- Network dependency

**Verdict**: Overkill for small teams

---

## Recommended Workflow: Option A

### Step-by-step setup

```bash
# 1. Create workspace directory
mkdir miniwebs-workspace && cd miniwebs-workspace

# 2. Clone all package repos
git clone git@github.com:danydevx/miniwebs-core.git packages/miniwebs-core
git clone git@github.com:danydevx/miniwebs-catalog.git packages/miniwebs-catalog
git clone git@github.com:danydevx/miniwebs-appointments.git packages/miniwebs-appointments
# ... clone all 25 packages

# 3. Clone product repos
git clone git@github.com:danydevx/miniwebs-saas.git products/miniwebs-saas
git clone git@github.com:danydevx/miniwebs-invitations.git products/invitations-saas
git clone git@github.com:danydevx/miniwebs-realestate.git products/realestate-saas

# 4. Configure miniwebs-saas to use local packages
cd products/miniwebs-saas
composer config repositories.path "../packages" --global=false
composer require miniwebs/core:* miniwebs/catalog:* miniwebs/appointments:* --no-update
composer update --prefer-source  # Creates symlinks

# 5. Now you can edit packages/ directly
# Changes immediately reflected in products/miniwebs-saas/vendor/
```

### Daily development flow

```bash
# Terminal 1: Work on catalog package
cd packages/miniwebs-catalog
# Edit Modules/ListingProducts/app/Http/Controllers/...
# Run tests: php artisan test --filter=ListingProducts

# Terminal 2: Test in product
cd products/miniwebs-saas
php artisan serve
# Visit http://localhost:8000
# See your catalog changes live
```

---

## Testing Packages Locally

### Within the package itself

```bash
cd packages/miniwebs-catalog
composer install
php artisan test
npm install && npm run build
```

Each package should have its own `phpunit.xml` and tests.

### Within a product

```bash
cd products/miniwebs-saas
php artisan test --filter=ListingProducts
# This runs tests from vendor/miniwebs/catalog/ too
```

---

## Switching Between Products

```bash
# Work on invitations-saas
cd products/invitations-saas
composer update --prefer-source
php artisan migrate
php artisan db:seed
php artisan serve  # http://localhost:8000

# Switch to realestate-saas
cd ../realestate-saas
composer update --prefer-source
php artisan migrate:fresh --seed
php artisan serve  # http://localhost:8001 (different port)
```

---

## Git Workflow with Path Repos

### Challenge

When you edit `packages/miniwebs-catalog/` and `products/miniwebs-saas/` simultaneously:
- Which repo do you commit to?
- How do you coordinate?

### Recommended workflow

**Phase 1: Develop in packages**

```bash
# All development happens in packages/
cd packages/miniwebs-catalog
# Make changes, run tests
git commit -m "Add featured products feature"
git push origin develop
```

**Phase 2: Update product to new version**

```bash
cd products/miniwebs-saas
composer require miniwebs/catalog:dev-develop --no-update
composer update miniwebs/catalog
git add composer.lock
git commit -m "Update catalog to latest"
```

**Phase 3: Release**

```bash
# In packages/miniwebs-catalog
git flow release start 1.3.0
git flow release finish 1.3.0
git push origin main --tags
```

---

## Handling Module Enable/Disable Locally

### Scenario: Working on ListingProducts in miniwebs-saas

```bash
# 1. Install miniwebs-saas with local catalog
cd products/miniwebs-saas
composer require miniwebs/catalog:* -w ../packages/miniwebs-catalog

# 2. ListingProducts is installed but disabled by default
# Enable it for testing
php artisan module:enable ListingProducts

# 3. Run migrations
php artisan migrate

# 4. Seed test data
php artisan db:seed --class=ListingProductsSeeder

# 5. Test your changes
php artisan serve
```

### Module is per-listing, not global

- `composer install` makes feature available on platform
- `module:enable` makes it available for specific listing
- This separation is preserved in path repo workflow

---

## IDE Support

### PHPStorm/VSCode

Add workspace to IDE:

```json
// .idea/workspace.xml or .vscode/settings.json
{
    "php.valueRoots": [
        "/path/to/workspace/packages",
        "/path/to/workspace/products/miniwebs-saas"
    ]
}
```

This enables:
- Go to definition across packages
- Refactoring across packages
- Autocomplete for package classes

---

## Summary

| Aspect | Recommendation |
|--------|----------------|
| Local linking | Composer path repositories |
| Directory structure | `packages/` and `products/` siblings |
| Testing | Test in package, then in product |
| Git workflow | Commit to package, update product |
| CI/CD | Use real VCS refs, not path |
