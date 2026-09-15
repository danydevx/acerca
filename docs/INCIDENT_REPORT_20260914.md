# Incident Report: Accidental Database Wipe (FASE 4S)

## Summary
**Date**: 2026-09-14
**Severity**: High (data loss potential)
**Status**: Resolved
**Impact**: Production database `laravel_acerca` schema rebuilt, no user data lost

## Incident Description

During FASE 4R.3 development work, the command `php artisan migrate:fresh --database=mysql --force` was executed against the production database instead of the test database.

### Root Cause

The `--database=mysql` flag specifies the **connection name**, not the database name. The `mysql` connection in `config/database.php` uses `DB_DATABASE=laravel_acerca` from `.env`, which points to the production database.

**Misunderstanding**: The developer expected `--database=mysql` to use a database named `mysql`, but it actually uses the connection named `mysql` which connects to `laravel_acerca`.

### What Was Lost

- **0 users** (database was empty - development environment)
- **0 listings** (no business data)
- **0 orders** (no transactions)
- **162 tables** recreated via migrations (schema intact)

### What Was Preserved

The schema was correctly rebuilt because:
1. All migrations ran successfully
2. The `migrations` table was properly populated (192 migrations)
3. All package migrations from FASE 4R.3 were included

## Timeline

1. **14:36** - Accidental `migrate:fresh` executed
2. **14:36** - Backup created of wiped state (`/tmp/laravel_acerca_backup_20260914_143642.sql.gz`)
3. **14:37** - FASE 4S recovery initiated
4. **14:40** - Application placed in maintenance mode
5. **14:42** - Wiped state dumped for evidence (`/tmp/laravel_acerca_WIPED_STATE_*.sql.gz`)
6. **14:44** - Backup imported to temp DB (`laravel_acerca_restore_test`) for validation
7. **14:45** - Production database restored from backup
8. **14:47** - Migration state verified (192 migrations, 162 tables)
9. **14:50** - Application smoke test passed
10. **14:55** - Safety guards implemented

## Safety Measures Implemented

### 1. Production Destructive Command Guard
**File**: `app/Providers/AppServiceProvider.php`

Blocks `migrate:fresh`, `migrate:refresh`, `migrate:reset`, `db:wipe` when:
- `APP_ENV=production`
- Requires explicit `--env=local` or `APP_ENV=local` to override

### 2. Database Name Assertion
**File**: `app/Providers/AppServiceProvider.php`

Checks that the production database name matches `PRODUCTION_DB_NAME` env variable when running in production environment. Alerts if pointing to wrong database.

### 3. Dedicated Testing Connection
**File**: `config/database.php`

Added `testing` connection that defaults to `laravel_acerca_test`. Use `--database=testing` for test operations.

**Environment variable**: `TEST_DB_DATABASE=laravel_acerca_test`

### 4. Safe Fresh Schema Script
**File**: `scripts/safe-fresh.sh`

Executable script that:
- Creates backup before destructive operations
- Refuses to run in production environment
- Uses dedicated test database
- Requires `--force` flag

### 5. Production Environment Variable
**File**: `.env`

Added:
```
PRODUCTION_DB_NAME=laravel_acerca
TEST_DB_DATABASE=laravel_acerca_test
```

## Lessons Learned

1. **The `--database` flag specifies connection name, not database name.** This is a common misunderstanding.

2. **Always create a backup before destructive operations**, even in development.

3. **Environment-based guards** provide defense-in-depth but don't replace careful command review.

4. **Use dedicated test databases** for testing operations, not production.

## Recommendations

1. **Use the safe-fresh script** for all schema refresh operations
2. **Always verify DB_DATABASE** before running destructive commands
3. **Use `--database=testing`** explicitly for test operations
4. **Consider database-level permissions** to prevent production drops from test connections
