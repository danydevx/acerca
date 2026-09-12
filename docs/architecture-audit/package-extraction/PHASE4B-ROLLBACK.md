# PHASE 4B — ROLLBACK STRATEGY

## If Package Extraction Fails

### Rollback Steps

```bash
# 1. Remove package requirement from composer.json
#    Remove from "require":
#    "miniwebs/shared": "@dev"

# 2. Remove repository from composer.json
#    Remove entire "repositories" section entry for miniwebs/shared

# 3. Restore local module
git checkout Modules/ListingOfficeHours/

# 4. Restore nwidart scan config (if modified)
#    Revert config/modules.php changes to scan paths

# 5. Update composer
composer update miniwebs/shared

# 6. Clear caches
php artisan optimize:clear

# 7. Verify
php artisan module:list | grep office
# Should show Modules/ListingOfficeHours
```

## What Was Modified

### Files Changed
1. `composer.json` - Added repository + require
2. `config/modules.php` - Added scan paths

### Files Added
1. `packages/miniwebs/shared/` - Entire package directory

### Files Removed
1. `Modules/ListingOfficeHours/` - Moved to package

## Rollback Commands Summary

```bash
# Remove from composer.json
# Edit require section - remove "miniwebs/shared"
# Edit repositories section - remove miniwebs/shared entry
# Revert config/modules.php scan paths

composer update
php artisan optimize:clear
```

## Conclusion

Rollback strategy: **DOCUMENTED**
