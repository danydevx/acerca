# ORP UI Component Matrix

**Version:** 0.1.0 Readiness Audit  
**Date:** 2026-09-02  
**Total Components:** 75+

## Inventory Legend

| Symbol | Meaning |
|--------|---------|
| ✅ | Complete |
| ⚠️ | Needs Polish |
| ❌ | Incomplete/Broken |
| 📦 | CSS-only (no Vue) |
| 🧩 | Vue component |
| 🎨 | In Playground |
| 📝 | Has Tests |
| 🚫 | Legacy/Duplicated |

---

## FOUNDATION

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Tokens/Variables | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Semantic Colors | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Spacing Scale | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Radius Scale | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Shadows | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Typography | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Motion/Duration | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Z-Index | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Breakpoints | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Reset | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Focus Ring | ✅ | N/A | N/A | N/A | ⚠️ NEEDS POLISH | |
| Safe Areas | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |

---

## UTILITIES

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Display | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Flex | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Gap | ✅ | N/A | N/A | N/A | ⚠️ NEEDS POLISH | Regression detected |
| Spacing (p-*, m-*) | ✅ | N/A | N/A | N/A | ⚠️ NEEDS POLISH | Regression detected |
| Sizing | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |
| Text | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |

---

## LAYOUT

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Container | ✅ | N/A | N/A | N/A | ⚠️ NEEDS POLISH | |
| Page | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | No tests |
| Section | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Stack | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Cluster | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Grid | ✅ | N/A | ❌ | ❌ | ❌ INCOMPLETE | No playground |
| Split | ❌ | N/A | ❌ | ❌ | ❌ MISSING | |
| Sidebar Layout | ❌ | N/A | ❌ | ❌ | ❌ MISSING | |
| Horizontal Scroll | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| App Shell | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Safe-area helpers | ✅ | N/A | N/A | N/A | ✅ COMPLETE | |

---

## NAVIGATION

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| AppBar | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| BottomNav | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Breadcrumb | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Pagination | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Nav | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Nav Rail | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Stepper | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Tabs | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Command Menu | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Context Menu | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Action Sheet | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## FORMS - BASIC

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Field | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | CSS-only wrapper |
| Input | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Textarea | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Select | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Checkbox | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Radio | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Switch | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## FORMS - ADVANCED

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Segmented | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| SearchInput | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| FileInput | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Combobox | 📦 | 🧩 | ❌ | ❌ | ❌ MISSING EXPORT | Not exported |
| MultiSelect | 📦 | 🧩 | ❌ | ❌ | ❌ MISSING EXPORT | Not exported |
| TagInput | 📦 | 🧩 | ❌ | ❌ | ❌ MISSING EXPORT | Not exported |
| OTP | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Password | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| NumberStepper | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Range | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | CSS-only |

---

## FEEDBACK

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Alert | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Callout | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Toast | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Spinner | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Progress | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Skeleton | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Empty State | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## NOTIFICATIONS

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Notification | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Notification Stack | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Notification Banner | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | CSS-only |
| Notification Host | N/A | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| useOrpNotifications | N/A | ✅ | N/A | ❌ | ⚠️ NEEDS POLISH | Composable |

---

## OVERLAYS

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Modal | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Sheet | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Drawer | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Dropdown | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Popover | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Dialog | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Dialog Host | N/A | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| useOrpDialog | N/A | ✅ | N/A | ❌ | ⚠️ NEEDS POLISH | Composable |

---

## DATA DISPLAY

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| List | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Avatar | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Avatar Group | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Badge | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Meta | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Price | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Rating | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Divider | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Status Dot | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Stat Card | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Trend | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Meter | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Distribution | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Chart Legend | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## TABLES

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Table | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | CSS-only |
| Table Pagination | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Data Table | N/A | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | Vue component |

---

## DATA VISUALIZATION

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Chart Shell | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Chart | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Trend | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Meter | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Distribution | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## MEDIA

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Media | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Media Card | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Hero | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Gallery | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Image Upload | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Avatar Upload | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Cover Upload | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Video Player | N/A | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Audio Player | N/A | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## FILES

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| FileInput | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Dropzone | 📦 | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| File Item | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## RICH UI

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Toolbar | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Quick Actions | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Selection Bar | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Comment | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Chip | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| FAB | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Icon Button | ✅ | 🧩 | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Icon | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |
| Keyboard | ✅ | N/A | ✅ | ❌ | ⚠️ NEEDS POLISH | |

---

## INTEGRATIONS

| Component | CSS | Vue | Playground | Tests | Status | Notes |
|-----------|:---:|:---:|:---:|:---:|--------|-------|
| Bootstrap Icons | ✅ | N/A | ✅ | N/A | ✅ COMPLETE | Integration only |
| Swiper | ✅ | N/A | ✅ | N/A | ✅ EXTERNAL | External dependency |
| GLightbox | ✅ | N/A | ✅ | N/A | ✅ EXTERNAL | External dependency |

---

## SUMMARY STATISTICS

| Category | Total | ✅ Complete | ⚠️ Needs Polish | ❌ Incomplete | 🚫 Legacy |
|----------|------:|:-----------:|:----------------:|:--------------:|:----------:|
| Foundation | 12 | 11 | 1 | 0 | 0 |
| Utilities | 6 | 4 | 2 | 0 | 0 |
| Layout | 9 | 2 | 5 | 2 | 0 |
| Navigation | 11 | 0 | 11 | 0 | 0 |
| Forms Basic | 7 | 0 | 7 | 0 | 0 |
| Forms Advanced | 9 | 1 | 6 | 2 | 0 |
| Feedback | 7 | 0 | 7 | 0 | 0 |
| Notifications | 5 | 0 | 5 | 0 | 0 |
| Overlays | 8 | 0 | 8 | 0 | 0 |
| Data Display | 13 | 0 | 13 | 0 | 0 |
| Tables | 3 | 0 | 3 | 0 | 0 |
| Data Viz | 5 | 0 | 5 | 0 | 0 |
| Media | 8 | 0 | 8 | 0 | 0 |
| Files | 3 | 0 | 3 | 0 | 0 |
| Rich UI | 9 | 0 | 9 | 0 | 0 |
| Integrations | 3 | 3 | 0 | 0 | 0 |
| **TOTAL** | **118** | **21** | **93** | **4** | **0** |

---

## v0.1 BLOCKERS

1. **Test Coverage** - No component tests exist
2. **Spacing Regression** - orp-p-*, orp-m-*, orp-gap-* may not work correctly in compiled CSS
3. **Missing Exports** - 6 form components not exported from orp-ui.js

## v0.1 REQUIRED FIXES

1. Fix spacing utility regression
2. Export missing Vue components (Combobox, MultiSelect, TagInput, NumberStepper, OtpInput, PasswordInput)
3. Add component tests for critical components
4. Verify focus-visible implementation across all interactive components

---

*Generated by ORP UI Gap Audit - Parte 21.9*
