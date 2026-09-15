# Database Backup & Recovery Procedure

## Backup Command

```bash
# Create a compressed backup of laravel_acerca
mysqldump -u root -pazda030780 laravel_acerca | gzip > /tmp/laravel_acerca_backup_$(date +%Y%m%d_%H%M%S).sql.gz
```

## Restoration Command

```bash
# Restore from backup
zcat /tmp/laravel_acerca_backup_YYYYMMDD_HHMMSS.sql.gz | mysql -u root -pazda030780 laravel_acerca
```

## Backup Location
All backups are stored in `/tmp/` with timestamp naming convention.

## Pre-destructive Operation Checklist

Before running any destructive command (`migrate:fresh`, `migrate:refresh`, `db:wipe`):

1. **Create a backup first**:
   ```bash
   mysqldump -u root -pazda030780 laravel_acerca | gzip > /tmp/laravel_acerca_backup_$(date +%Y%m%d_%H%M%S).sql.gz
   ```

2. **Verify the command target**:
   - Check `DB_DATABASE` in `.env`
   - Confirm you are NOT in `APP_ENV=production` for destructive ops
   - Use the `testing` connection explicitly: `--database=testing`

3. **Use the safe-fresh script** (recommended):
   ```bash
   ./scripts/safe-fresh.sh --force
   ```

## Safe Fresh Script

Located at: `scripts/safe-fresh.sh`

Usage:
```bash
./scripts/safe-fresh.sh --force           # Fresh schema without seeds
./scripts/safe-fresh.sh --force --with-seed  # Fresh schema with seeds
```

This script:
- Creates a backup before any destructive operation
- Refuses to run in production environment
- Uses the dedicated test database (`laravel_acerca_test`)
- Provides clear progress output

## Testing Database Connection

A dedicated `testing` connection is available in `config/database.php`:

```bash
php artisan migrate --database=testing
php artisan db:seed --database=testing
```

This connection uses `TEST_DB_DATABASE` from `.env` (defaults to `laravel_acerca_test`).
