# PHASE 4A — EXTRACTION ORDER

## Rationale for Order

Extraction order matters because:

1. **Dependencies**: Packages that others depend on should be extracted first
2. **Risk**: Low-risk, autonomous packages first to build confidence
3. **Complexity**: Simple packages before complex ones
4. **Rollback**: If something goes wrong, least impact to other packages

---

## Extraction Phases

### PHASE 4B: Pilot Package
1. `miniwebs/shared` (ListingOfficeHours - simplest, zero deps)

### PHASE 4C: Shared Domain Packages
2. `miniwebs/reviews`
3. `miniwebs/team`
4. `miniwebs/packages`
5. `miniwebs/marketing`

### PHASE 4D: Complex Shared Packages
6. `miniwebs/guests`
7. `miniwebs/crm`
8. `miniwebs/catalog`

### PHASE 4E: Appointments & Calendar
9. `miniwebs/appointments`

### PHASE 4F: Location Packages
10. `miniwebs/locations`

### PHASE 4G: Media Package
11. `miniwebs/media`

### PHASE 4H: Minisite Packages
12. `miniwebs/minisite`

### PHASE 4I: Vertical Packages
13. `miniwebs/orders`
14. `miniwebs/properties`
15. `miniwebs/vcards`
16. `miniwebs/restaurant`
17. `miniwebs/fidelity`
18. `miniwebs/projects`

### PHASE 4J: Optional Packages
19. `miniwebs/analytics`
20. `miniwebs/ai-chatbot`
21. `miniwebs/checkin`
22. `miniwebs/features`
23. `miniwebs/tasks`

### PHASE 4K: Core Package
24. `miniwebs/core`

---

## Why this Order?

### Pilot First: miniwebs/shared (ListingOfficeHours)

| Criteria | Score | Reason |
|----------|-------|--------|
| Dependencies | 0 | No other modules depend on it |
| Complexity | Low | Simple time slots, no complex logic |
| Migrations | 0 | Zero migrations (stateless) |
| Frontend | None | No assets |
| Circular deps | 0 | None |
| Tests | Easy | Simple unit tests |

**Why ListingOfficeHours as pilot?**
- Completely standalone
- No FK to other module tables
- Just stores time ranges
- Easy to verify extraction worked
- No breaking risk

### Last: miniwebs/core

| Criteria | Score | Reason |
|----------|-------|--------|
| Dependencies | 33 | Everything depends on it |
| Complexity | Highest | God object problem |
| Migrations | Many | Core tables |
| Circular deps | Most | All cycles flow through it |

Core must be extracted LAST because:
1. All other packages depend on it
2. Breaking changes in core affect everything
3. Need stable extraction pattern first

---

## Per-Phase Activities

### Each Phase Includes:

1. **Extract module(s) to package**
   - Create package structure
   - Copy module files
   - Update namespace if needed
   - Create composer.json

2. **Set up package repository**
   - Create GitHub repo
   - Initial commit
   - Tag v1.0.0

3. **Update product to use package**
   - Add repository to composer.json
   - Update require
   - Verify install works

4. **Test extraction**
   - Run migrations
   - Run seeders
   - Run tests
   - Manual smoke test

5. **Document**
   - Package README
   - Changelog entry
   - Update architecture docs

---

## Pilot Package Details

### miniwebs/shared

**Contains**: `ListingOfficeHours`

**Why it's safe**:
- 0 migrations
- No PHP imports from other modules
- No other modules depend on it
- Simple CRUD for office hours

**Files to move**:
```
Modules/ListingOfficeHours/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       └── Member/
│   └── Models/
├── database/
│   └── seeders/
├── resources/
├── routes/
└── module.json
```

**Verification**:
```bash
cd products/miniwebs-saas
composer require miniwebs/shared:^1.0
php artisan module:enable ListingOfficeHours
php artisan migrate
# Visit settings, verify office hours work
```

---

## Risk Assessment Per Phase

| Phase | Packages | Risk | Rollback Complexity |
|-------|----------|------|---------------------|
| 4B Pilot | 1 | Very Low | Trivial |
| 4C Shared v1 | 5 | Low | Low |
| 4D Shared v2 | 3 | Medium | Medium |
| 4E Appointments | 1 | Medium | Medium |
| 4F Locations | 1 | Medium | Medium |
| 4G Media | 1 | Low | Low |
| 4H Minisite | 1 | High | High |
| 4I Vertical | 6 | High | High |
| 4J Optional | 5 | Medium | Medium |
| 4K Core | 1 | Very High | Very High |

**Note**: Minisite (4H) and Core (4K) are high risk due to:
- Large number of dependencies
- Complex routing
- Frontend integration

---

## Validation Checklist Per Phase

Before declaring phase complete:

- [ ] Package installs via Composer
- [ ] Module enables for test listing
- [ ] Migrations run successfully
- [ ] Seeders run successfully
- [ ] Routes register correctly
- [ ] Controllers resolve
- [ ] Views render
- [ ] API endpoints respond
- [ ] Policies authorize correctly
- [ ] Tests pass
- [ ] Frontend builds
- [ ] No PHP errors in logs
- [ ] Package version tagged

---

## Parallel Extraction

Some phases can run in parallel if different developers are working:

```
Developer A: Phase 4C (shared v1)
Developer B: Phase 4D (shared v2)
Developer C: Phase 4E (appointments)
```

But sequential within a phase (packages depend on each other).

---

## Exit Criteria

### For each phase:
- All packages in phase pass validation checklist
- Product still functional with new packages
- Documentation updated

### For entire 4A-4K:
- All 25 packages extracted
- All 3 product repos work
- Zero regressions
- CI/CD green on all repos
