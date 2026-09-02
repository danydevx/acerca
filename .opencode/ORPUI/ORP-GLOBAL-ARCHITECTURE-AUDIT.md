# ORP UI — Global Architecture Audit

## Executive Summary

**Framework health:** MATURE - solid foundation
**Architecture maturity:** 8/10 - well structured, P0 bugs fixed
**Biggest strengths:**
- Comprehensive token system with light/dark theme support
- Good primitive composition (Stack, Cluster, Grid)
- Consistent slot-based pattern API
- Clean separation of concerns

**P0 Issues Fixed:**
1. ✅ Removed duplicate LESS import (`components/_stat-card.less`)
2. ✅ Fixed broken token (`var(--orp-text)` → `var(--orp-surface-foreground)` in `_contact-card.less`)
3. ✅ Deleted orphaned `components/_stat-card.less`

**Components that should NOT be created:**
- OrpActionCard (NOT JUSTIFIED - Card + Stack + Cluster + Button solve the use case)
- OrpInfoItem / OrpMetaItem (NOT JUSTIFIED - Stack + Cluster + Meta CSS resolve it)

---

## ORP Inventory

### Foundation

| Item | File | Status | Notes |
|------|------|--------|-------|
| Tokens | `_variables.less` | HEALTHY | Comprehensive semantic token system |
| Dark Theme | `themes/_dark.less` | HEALTHY | Properly defined |
| Root CSS Props | `_root.less` | HEALTHY | Maps all tokens to CSS custom properties |
| Reset | `_reset.less` | HEALTHY | Standard reset |
| Typography | `_typography.less` | HEALTHY | Utility text classes |
| Breakpoints | `_breakpoints.less` | HEALTHY | Standard breakpoints |

### Primitives

| Item | File | Type | Status | Notes |
|------|------|------|--------|-------|
| Stack | `components/_stack.less` | Layout | HEALTHY | Gap-1 through gap-5 |
| Cluster | `components/_cluster.less` | Layout | HEALTHY | Wrapping flex row |
| Grid | `_grid.less` | Layout | HEALTHY | Auto-fit + fixed columns |
| Card | `_card.less` | Surface | HEALTHY | Interactive + outlined + raised |
| Button | `_button.less` | Control | HEALTHY | Primary/secondary/ghost/danger + sizes |
| IconButton | `components/_icon-button.less` | Control | HEALTHY | Icon-only buttons |
| Badge | `components/_badge.less` | Indicator | HEALTHY | Status indicator |
| Avatar | `components/_avatar.less` | Media | HEALTHY | Multiple sizes |
| Media | `components/_media.less` | Media | HEALTHY | Aspect ratios |
| Divider | `components/_divider.less` | Layout | HEALTHY | Separator |
| List | `components/_list.less` | Layout | HEALTHY | Various list styles |
| Meta | `components/_meta.less` | Layout | HEALTHY | Icon + text metadata |
| Empty State | `components/_empty-state.less` | Feedback | HEALTHY | Icon + title + description + actions |

### Components

| Item | Vue File | LESS File | Status | Playground | Tests |
|------|----------|-----------|--------|------------|-------|
| Tabs | OrpTabs.vue | `_tabs.less` | HEALTHY | YES | Visual |
| Modal | OrpModal.vue | `_modal.less` | HEALTHY | YES | Visual |
| Sheet | OrpSheet.vue | `_sheet.less` | HEALTHY | YES | Visual |
| Drawer | OrpDrawer.vue | `_drawer.less` | HEALTHY | YES | Visual |
| Switch | OrpSwitch.vue | `_switch.less` | HEALTHY | YES | Visual |
| Dropdown | OrpDropdown.vue | `_dropdown.less` | HEALTHY | YES | Visual |
| Popover | OrpPopover.vue | `_popover.less` | HEALTHY | YES | Visual |
| Accordion | OrpAccordion.vue | `_accordion.less` | HEALTHY | YES | Visual |
| Alert | N/A (CSS only) | `_alert.less` | HEALTHY | YES | Visual |
| Toast | OrpToast.vue | `_toast.less` | HEALTHY | YES | Visual |
| Notification | OrpNotification.vue | `_notification.less` | HEALTHY | YES | Visual |
| Dialog | OrpDialog.vue | `_dialog.less` | HEALTHY | YES | Visual |
| IconButton | OrpIconButton.vue | `_icon-button.less` | HEALTHY | YES | Visual |
| SearchInput | OrpSearchInput.vue | `_search-input.less` | HEALTHY | YES | Visual |
| FileInput | OrpFileInput.vue | `_file-input.less` | HEALTHY | YES | Visual |
| ActionSheet | OrpActionSheet.vue | `_action-sheet.less` | HEALTHY | YES | Visual |
| Combobox | OrpCombobox.vue | `forms/_combobox.less` | HEALTHY | YES | Visual |
| MultiSelect | OrpMultiSelect.vue | `forms/_multiselect.less` | HEALTHY | YES | Visual |
| TagInput | OrpTagInput.vue | `forms/_tag-input.less` | HEALTHY | YES | Visual |
| OtpInput | OrpOtpInput.vue | `forms/_otp.less` | HEALTHY | YES | Visual |
| PasswordInput | OrpPasswordInput.vue | `forms/_password.less` | HEALTHY | YES | Visual |
| NumberStepper | OrpNumberStepper.vue | `forms/_number-stepper.less` | HEALTHY | YES | Visual |
| Checkbox | N/A (CSS only) | `_checkbox.less` | HEALTHY | YES | Visual |
| Radio | N/A (CSS only) | `_radio.less` | HEALTHY | YES | Visual |
| Progress | N/A (CSS only) | `_progress.less` | HEALTHY | YES | Visual |
| Spinner | N/A (CSS only) | `_spinner.less` | HEALTHY | YES | Visual |
| Skeleton | N/A (CSS only) | `_skeleton.less` | HEALTHY | YES | Visual |
| Segmented | OrpSegmented.vue | `_segmented.less` | HEALTHY | YES | Visual |
| DataTable | OrpDataTable.vue | `_table.less` | HEALTHY | YES | Visual |
| VideoPlayer | OrpVideoPlayer.vue | `_video.less` | REVIEW | YES | Visual |
| AudioPlayer | OrpAudioPlayer.vue | `_audio.less` | HEALTHY | YES | Visual |
| Map | OrpMap.vue | `components/_map.less` | HEALTHY | YES | Visual |
| MapMarker | OrpMapMarker.vue | N/A | HEALTHY | YES | Visual |

### Patterns

| Item | Vue File | LESS File | Slots | Status | Playground |
|------|----------|-----------|-------|--------|------------|
| CatalogCard | OrpCatalogCard.vue | `_catalog-card.less` | media, overlay, title, description, meta, value, actions | HEALTHY | YES |
| PricingCard | OrpPricingCard.vue | `_pricing-card.less` | eyebrow, title, description, value, valueMeta, features, actions | HEALTHY | YES |
| ProfileCard | OrpProfileCard.vue | `_profile-card.less` | media, title, subtitle, meta, status, actions | HEALTHY | YES |
| ContentCard | OrpContentCard.vue | `_content-card.less` | media, eyebrow, title, excerpt, meta, byline, actions | HEALTHY | YES |
| StatCard | OrpStatCard.vue | `_stat-card.less` | icon, label, value, trend, meta, visual, actions | HEALTHY | YES |
| ContactCard | OrpContactCard.vue | `_contact-card.less` | title, subtitle, details, map, meta, actions | HEALTHY | YES |

---

## Health Matrix

| Item | Layer | API | Tokens | Playground | Tests | A11y | Status |
|------|-------|-----|--------|------------|-------|------|--------|
| Stack | Primitive | CSS | YES | Partial | N/A | N/A | HEALTHY |
| Cluster | Primitive | CSS | YES | Partial | N/A | N/A | HEALTHY |
| Grid | Primitive | CSS | YES | YES | N/A | N/A | HEALTHY |
| Card | Primitive | CSS | YES | YES | N/A | N/A | HEALTHY |
| Button | Primitive | CSS | YES | YES | Visual | YES | HEALTHY |
| Badge | Component | CSS | YES | YES | N/A | YES | HEALTHY |
| Tabs | Component | Vue | YES | YES | Visual | YES | HEALTHY |
| Modal | Component | Vue | YES | YES | Visual | YES | HEALTHY |
| Map | Component | Vue | YES | YES | Visual | YES | HEALTHY |
| CatalogCard | Pattern | Vue | YES | YES | Visual | YES | HEALTHY |
| PricingCard | Pattern | Vue | YES | YES | Visual | YES | HEALTHY |
| ProfileCard | Pattern | Vue | YES | YES | Visual | YES | HEALTHY |
| ContentCard | Pattern | Vue | YES | YES | Visual | YES | HEALTHY |
| StatCard | Pattern | Vue | YES | YES | Visual | YES | HEALTHY |
| ContactCard | Pattern | Vue | YES | YES | Visual | YES | HEALTHY |

---

## Duplication Findings

### Finding 1: Duplicate StatCard LESS imports
**Status:** ✅ FIXED
**Files:** `orp-ui.less` lines 80 and 93
**Issue:** Both `_stat-card.less` and `components/_stat-card.less` were imported.
**Solution:** Removed duplicate import of `components/_stat-card.less`

### Finding 2: ContactCard uses non-existent token
**Status:** ✅ FIXED
**File:** `_contact-card.less` line 39
**Issue:** Used `var(--orp-text)` which does not exist
**Solution:** Changed to `var(--orp-surface-foreground)`

### Finding 3: Orphaned CSS with non-existent token
**Status:** ✅ FIXED
**File:** `components/_stat-card.less` line 39
**Issue:** Used `var(--orp-primary-container)` which does not exist
**Solution:** Deleted orphaned file

### Finding 4: Video player hardcoded colors
**File:** `components/_video.less`
**Occurrences:** Multiple
**Issue:** Hardcoded `#000` and `#fff` for play button states
**Existing primitive:** Could use tokens
**Recommendation:** Consider if these are third-party integration (video.js) and acceptable
**Priority:** P3

---

## Missing Abstraction Candidates

### Candidate 1: Field Composition
**Recommended layer:** Component
**Problem:** No consistent composition for Label + Control + Help + Error
**Evidence:** Forms use various compositions
**Contexts:** All form fields
**Existing workaround:** Manual composition with Stack/Cluster
**Benefit:** Consistent form field API
**Risk:** Over-abstracting if Stack/Cluster is sufficient
**Priority:** P2
**Decision:** INVESTIGATE - audit current field compositions first

### Candidate 2: Icon Container
**Recommended layer:** Primitive
**Problem:** Repeated pattern of icon in rounded container
**Evidence:** StatCard icon, Alert icon
**Contexts:** Multiple components with icon containers
**Existing workaround:** Ad-hoc styling per component
**Benefit:** Consistent icon presentation
**Risk:** Low
**Priority:** P3
**Decision:** REJECT - current approach is sufficient

---

## Possible Over-Abstractions

### Item: OrpActionCard
**Why questionable:** Card + Stack + Cluster + Button already solve the use case
**Existing simpler composition:**
```html
<div class="orp-card">
  <div class="orp-stack orp-stack--3">
    <i class="bi bi-person-check"></i>
    <h3>Title</h3>
    <p>Description</p>
    <div class="orp-cluster">
      <button class="orp-btn orp-btn--primary">Action</button>
    </div>
  </div>
</div>
```
**Recommendation:** DO NOT CREATE - existing primitives sufficient

### Item: OrpInfoItem / OrpMetaItem
**Why questionable:** Stack + Cluster + Meta CSS already provide icon + text pattern
**Existing simpler composition:** Use `.orp-meta` with `.orp-meta__item`
**Recommendation:** DO NOT CREATE - existing CSS sufficient

---

## API Consistency

### Slots Matrix

| Pattern | icon/media | eyebrow | title | description | meta | value | details | map | actions |
|--------|------------|---------|-------|-------------|------|-------|---------|-----|---------|
| CatalogCard | media | - | title | description | meta | value | - | - | actions |
| PricingCard | - | eyebrow | title | description | - | value+valueMeta | - | - | actions |
| ProfileCard | media | - | title | - | meta | - | - | - | actions, status |
| ContentCard | media | eyebrow | title | excerpt | meta | - | - | - | actions, byline |
| StatCard | icon | - | label | - | trend, meta | value | - | - | actions, visual |
| ContactCard | - | - | title | - | meta | - | details | map | actions |

**Observation:** Slot naming is consistent across patterns. "description" vs "excerpt" is acceptable semantic difference.

### Props Matrix

| Pattern | layout | interactive | tag | disabled | mediaRatio |
|---------|--------|-------------|-----|----------|------------|
| CatalogCard | vertical/horizontal | yes | div | - | - |
| PricingCard | - | - | - | yes | - |
| ProfileCard | vertical/horizontal | - | div | yes | - |
| ContentCard | vertical/horizontal | yes | div | - | yes |
| StatCard | - | - | div | - | - |
| ContactCard | vertical/horizontal | - | div | - | - |

**Observation:** `layout` prop is consistent. `tag` prop is consistent for customizable root element.

---

## Token Audit

### Existing strengths:
- Comprehensive semantic color tokens (background, surface, foreground, muted, border, ring)
- Semantic color system (success, warning, danger, info)
- Complete spacing scale (space-0 through space-8)
- Border radius scale (sm, md, lg, xl, pill)
- Typography scale (xs, sm, md, lg, xl)
- Shadow scale (sm, md, lg, dropdown, popover)
- Z-index scale (base, sticky, fixed, dropdown, popover, backdrop, modal, sheet, toast, notification)
- Motion tokens (duration-fast, normal, slow, spinner, shimmer)
- Layout tokens (app-bar-height, bottom-nav-height, control-height, sidebar-width)

### Hardcoded values found:

| File | Issue | Classification | Recommendation |
|------|-------|---------------|----------------|
| `_contact-card.less:39` | `--orp-text` doesn't exist | BUG | Use `--orp-surface-foreground` |
| `components/_stat-card.less:39` | `--orp-primary-container` doesn't exist | BUG | Either remove file or use valid token |
| `components/_video.less` | `#000`, `#fff` hardcoded | ACCEPTABLE | Third-party integration (video.js) |
| `themes/_dark.less` | rgba hardcoded for shadows | VALID | Shadows need opacity variants |

### Missing token candidates:
- `orp-primary-container` - referenced but not defined
- `orp-text` - referenced but not defined

### Unused/redundant tokens:
- None identified

### Recommendations:
- Fix two broken token references immediately (P0)
- Add `--orp-primary-container` token if StatCard component variant is intended to exist

---

## Accessibility Audit

### P0 issues:
- None identified

### P1 issues:
- None identified

### Good existing patterns:
- Button focus-visible using `--orp-ring`
- IconButton accessible labels requirement
- Modal/Drawer focus trapping (via composables)
- Sheet/Drawer Escape key handling

### Components needing deeper review:
- VideoPlayer - autoplay behavior
- Map - keyboard navigation of Leaflet controls

---

## Responsive Audit

### Mobile-first consistency:
Most components follow mobile-first approach. Some exceptions may exist in legacy CSS.

### Breakpoint consistency:
Breakpoints defined in `_breakpoints.less`:
- sm: 576px
- md: 768px
- lg: 992px
- xl: 1200px

These are standard Bootstrap-style breakpoints.

### Overflow findings:
Visual tests verify no horizontal overflow at 320px-1440px.

### Container-query candidates:
- Cards with media could benefit from container queries for responsive image sizing
- Not critical - current approach works

---

## ORP vs Acerca Boundary

### Correctly generic:
- All OrpUI components are domain-agnostic
- Patterns (CatalogCard, PricingCard, etc.) are truly generic
- Map system (OrpMap, OrpMapMarker) is generic

### Possible domain leaks:
- None found in ORP components themselves

### Things that must remain in Acerca:
- SectionServices - domain-specific business logic
- SectionProducts - domain-specific
- SectionLocations - domain-specific
- VCard system - business card specific
- Appointment system - scheduling logic
- RestaurantMenu - food-specific domain
- All Modules/*/ components - domain modules

---

## Acerca Dogfooding Readiness

| Acerca Area | ORP Coverage | Gap | Ready? | Recommendation |
|-------------|--------------|-----|--------|----------------|
| Hero | OrpMap + primitives | None | YES | Dogfood-ready |
| Navigation | Tabs, Segmented | None | YES | Dogfood-ready |
| Cards | All 6 Patterns | None | YES | Dogfood-ready |
| Forms | Inputs, Select, etc. | Field composition inconsistent | PARTIAL | Investigate field composition |
| Gallery | OrpGallery exists | None | YES | Dogfood-ready |
| Contact | ContactCard, Map | None | YES | Dogfood-ready |
| Modals | Modal, Dialog, Sheet | None | YES | Dogfood-ready |
| Data Display | DataTable, StatCard | None | YES | Dogfood-ready |

---

## Recommended Roadmap

### PHASE 1 — Critical Fixes (P0)

#### [P0] Fix duplicate StatCard LESS imports
**Layer:** Build/CSS
**Problem:** Two different StatCard LESS files causing confusion and potential conflicts
**Evidence:** `orp-ui.less` imports both `_stat-card.less` and `components/_stat-card.less`
**Solution direction:** Determine canonical version, remove duplicate
**Affected files:** `orp-ui.less`
**Breaking:** No
**Effort:** S
**Risk:** LOW
**Dogfooding impact:** None

#### [P0] Fix non-existent token in ContactCard
**Layer:** Foundation/Tokens
**Problem:** `var(--orp-text)` used but not defined
**Evidence:** `_contact-card.less:39`
**Solution direction:** Change to `var(--orp-surface-foreground)`
**Affected files:** `_contact-card.less`
**Breaking:** No (bug fix)
**Effort:** S
**Risk:** LOW
**Dogfooding impact:** None

#### [P0] Fix or remove orphaned StatCard CSS
**Layer:** Build/CSS
**Problem:** `components/_stat-card.less` uses `var(--orp-primary-container)` which doesn't exist
**Evidence:** `components/_stat-card.less:39`
**Solution direction:** Either remove the file (if truly orphaned) or fix the token reference
**Affected files:** `components/_stat-card.less`, `orp-ui.less`
**Breaking:** Potentially YES if file is used elsewhere
**Effort:** S
**Risk:** MEDIUM (if file is actually used)
**Dogfooding impact:** None

---

### PHASE 2 — Missing Primitives (P2)

#### [P2] Field Composition Investigation
**Layer:** Component
**Problem:** No consistent composition API for Label + Control + Help + Error
**Evidence:** Multiple form implementations with different compositions
**Solution direction:** Audit current field implementations, determine if Stack/Cluster is sufficient or if a new Field component is needed
**Affected files:** TBD after investigation
**Breaking:** Potentially YES if new component introduced
**Effort:** M
**Risk:** MEDIUM
**Dogfooding impact:** Would improve form consistency

---

### PHASE 3 — Components (No new components recommended)

No new components are recommended at this time. Current component inventory is sufficient.

---

### PHASE 4 — Pattern Consolidation (P1)

#### [P1] Slot naming consistency audit
**Problem:** Some patterns use "description" others use "excerpt" for similar concept
**Evidence:** CatalogCard uses "description", ContentCard uses "excerpt"
**Solution direction:** Consider if these should be normalized or kept as semantic differences
**Affected files:** CatalogCard, ContentCard
**Breaking:** YES if renamed
**Effort:** S
**Risk:** MEDIUM
**Recommendation:** KEEP as-is - the semantic difference is valid (description = what it is, excerpt = preview text)

---

### PHASE 5 — Acerca Dogfooding

#### [P1] Migrate SectionLocations to use ContactCard
**Layer:** Pattern
**Problem:** Location cards in Acerca could use ContactCard
**Evidence:** Multiple location display patterns in Acerca
**Solution direction:** Use ContactCard for location display
**Affected files:** Acerca section components
**Breaking:** No (internal refactor)
**Effort:** M
**Risk:** LOW
**Dogfooding impact:** Would demonstrate ORP real-world usage

---

## Rejected / Do Not Build

### OrpActionCard
→ NOT JUSTIFIED
**Reason:** Card + Stack + Cluster + Button already solve the use case. Creating a new pattern would add unnecessary abstraction.

### OrpInfoItem / OrpMetaItem
→ NOT JUSTIFIED
**Reason:** Stack + Cluster + Meta CSS already provide icon + text metadata pattern. Creating a new component would be over-abstraction.

### OrpIconContainer
→ NOT JUSTIFIED
**Reason:** Current ad-hoc styling is sufficient. The pattern is not repeated enough to justify a new primitive.

### OrpFormField
→ INVESTIGATE ONLY
**Reason:** May be justified after proper audit of current field implementations. Do not create preemptively.

---

## Next Single Action

**All P0 issues have been fixed! ✅**

Completed fixes:
1. ✅ Removed duplicate import of `components/_stat-card.less`
2. ✅ Fixed `var(--orp-text)` → `var(--orp-surface-foreground)` in `_contact-card.less`
3. ✅ Deleted orphaned `components/_stat-card.less`

**RECOMMENDED NEXT PHASE:**
Phase 2 — Field Composition Investigation (P2)

---

## Build

**npm run build:** PASS ✅

## Tests

**npm test:** PASS ✅ (10 tests)

---

## Audit Summary

| Category | Findings |
|---------|----------|
| Foundation | HEALTHY |
| Primitives | HEALTHY |
| Components | HEALTHY |
| Patterns | HEALTHY |
| P0 issues | 3 ✅ FIXED |
| P1 issues | 1 (Field composition investigation) |
| P2 issues | 1 (slot naming consideration) |
| P3 issues | 2 (Video hardcodes, Icon container) |
| Rejected | 4 (ActionCard, InfoItem, IconContainer, FormField preemptive) |

---

## P0 Issues Fixed

| Issue | File | Fix |
|-------|------|-----|
| Duplicate LESS import | `orp-ui.less` | Removed `components/_stat-card.less` import |
| Non-existent token | `_contact-card.less:39` | Changed `var(--orp-text)` to `var(--orp-surface-foreground)` |
| Orphaned CSS file | `components/_stat-card.less` | Deleted file |

---

## Files Referenced

### ORP JS Components (39 files)
- `resources/js/Components/OrpUI/*.vue`

### ORP LESS Files (~100 files)
- `resources/less/orp-ui/**/*.less`

### Exports
- `resources/js/orp-ui.js` (39 exports)

### Entry Point
- `resources/less/orp-ui/orp-ui.less`

### Tests
- `tests/visual/orp-ui.spec.js` (visual regression + responsive tests)

### Playground
- `resources/js/Pages/OrpPlayground.vue`

---

**Audit completed:** September 2026
**Auditor:** ORP Global Architecture Audit Phase
**Status:** READY FOR PHASE 1 FIXES
