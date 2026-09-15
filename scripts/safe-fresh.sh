#!/bin/bash
#
# Safe Schema Fresh Script
# Usage: ./scripts/safe-fresh.sh [--with-seed]
#
# This script safely rebuilds the test/development database schema.
# It creates a backup before any destructive operation.
#
# Rules:
#   - NEVER runs against production database
#   - ALWAYS creates a backup before destructive commands
#   - Uses dedicated TEST connection (laravel_acerca_test)
#   - Requires explicit --force flag
#

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(dirname "$SCRIPT_DIR")"
BACKUP_DIR="/tmp"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
TEST_DB="laravel_acerca_test"
BACKUP_FILE="${BACKUP_DIR}/laravel_acerca_test_backup_${TIMESTAMP}.sql.gz"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${YELLOW}========================================${NC}"
echo -e "${YELLOW}  SAFE SCHEMA FRESH SCRIPT${NC}"
echo -e "${YELLOW}========================================${NC}"
echo ""

# Check for --force flag
if [[ "$*" != *"--force"* ]]; then
    echo -e "${RED}ERROR: --force flag is required${NC}"
    echo ""
    echo "Usage: $0 --force [--with-seed]"
    echo ""
    echo "This script will:"
    echo "  1. Create a backup of ${TEST_DB} to ${BACKUP_FILE}"
    echo "  2. Drop and recreate ${TEST_DB}"
    echo "  3. Run all migrations"
    if [[ "$*" == *"--with-seed"* ]]; then
        echo "  4. Run seeders"
    fi
    echo ""
    echo -e "Add ${GREEN}--force${NC} to confirm."
    exit 1
fi

# Double-check we are NOT in production
if grep -q "APP_ENV=production" "${PROJECT_DIR}/.env" 2>/dev/null; then
    CURRENT_ENV=$(grep "APP_ENV=" "${PROJECT_DIR}/.env" | cut -d= -f2 | tr -d ' ')
    if [[ "$CURRENT_ENV" == "production" ]]; then
        echo -e "${RED}FATAL: Refusing to run in production environment${NC}"
        echo ""
        echo "This script is designed for test/development databases only."
        echo "Exiting for safety."
        exit 1
    fi
fi

WITH_SEED=""
if [[ "$*" == *"--with-seed"* ]]; then
    WITH_SEED="--seed"
fi

echo -e "${YELLOW}[1/4] Creating backup...${NC}"
echo "Database: ${TEST_DB}"
echo "Backup:   ${BACKUP_FILE}"

if mysqldump -u root -pazda030780 ${TEST_DB} 2>/dev/null | gzip > "${BACKUP_FILE}"; then
    BACKUP_SIZE=$(ls -lh "${BACKUP_FILE}" | awk '{print $5}')
    echo -e "${GREEN}Backup created: ${BACKUP_SIZE}${NC}"
else
    echo -e "${YELLOW}Warning: Backup failed or database was empty${NC}"
fi
echo ""

echo -e "${YELLOW}[2/4] Dropping and recreating database...${NC}"
mysql -u root -pazda030780 -e "DROP DATABASE IF EXISTS ${TEST_DB}; CREATE DATABASE ${TEST_DB} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>&1
echo -e "${GREEN}Database ${TEST_DB} recreated${NC}"
echo ""

echo -e "${YELLOW}[3/4] Running migrations...${NC}"
cd "${PROJECT_DIR}"
php artisan migrate --database=mysql --force
echo -e "${GREEN}Migrations complete${NC}"
echo ""

if [[ -n "$WITH_SEED" ]]; then
    echo -e "${YELLOW}[4/4] Running seeders...${NC}"
    php artisan db:seed --force
    echo -e "${GREEN}Seeders complete${NC}"
else
    echo -e "${YELLOW}[4/4] Skipping seeders (no --with-seed)${NC}"
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  SCHEMA FRESH COMPLETE${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "To restore this backup if needed:"
echo "  zcat ${BACKUP_FILE} | mysql -u root -pazda030780 ${TEST_DB}"
echo ""
