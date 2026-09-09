# MiniWebs Component Audit Report

**Date:** 2026-09-09
**Auditor:** Automated Audit
**Scope:** `resources/js/Components/Ui/`

---

## Executive Summary

This audit analyzed **94 Vue components** in the MiniWebs UI library. The codebase is generally well-structured using BEM naming conventions and Bulma CSS variables. However, several issues were identified that require attention.

### Overall Assessment

| Category | Status |
|----------|--------|
| Bootstrap residuals | ⚠️ Found in 8 components |
| Hardcoded colors | ⚠️ Found in 15 components |
| Hardcoded px values | ⚠️ Found in 25+ components |
| Hardcoded spacing (rem) | ⚠️ Found in most components |
| Hardcoded font-size | ⚠️ Found in 30+ components |
| Hardcoded border-radius | ⚠️ Found in 20+ components |
| Hardcoded box-shadow | ⚠️ Found in 15+ components |
| Bulma utility duplication | ⚠️ Found in 10+ components |
| BEM violations | ⚠️ Found in 5 components |
| Industry-specific variables | ⚠️ Found in beauty/spa/medical |

---

## Global Findings

### Bootstrap/Bulma Residual Classes

| Component | Lines | Classes |
|-----------|-------|---------|
| `Dropdown.vue` | 5, 7, 14 | `button`, `icon is-small`, `dropdown-content` |
| `FileInput.vue` | 15-25 | `is-size-*`, `has-text-grey`, `is-flex`, `pl-*` |
| `ImageInput.vue` | 11, 14, 24 | `button`, `is-small`, `is-light`, `is-danger`, `is-hidden` |
| `List.vue` | 6, 15-30 | `is-flex`, `is-align-items-center`, `is-gap-*`, `p-*`, `px-*` |
| `AvatarUpload.vue` | 17, 20 | `button is-small is-primary`, `button is-small is-danger is-outlined` |
| `EmptyState.vue` | 3-11 | `is-flex is-flex-direction-column is-align-items-center has-text-centered is-size-*` |
| `BookingScheduler.vue` | 76 | `button is-link` |
| `PricingCard.vue` | 18 | `button is-primary is-medium`, `is-outlined is-medium` |
| `CatalogCard.vue` | 34-35 | `button is-small`, `is-primary`, `is-outlined` |

### Hardcoded Colors

| Color | Occurrences | Components |
|-------|-------------|-----------|
| `white` / `#fff` | 18 | Gallery, ErrorState, SuccessState, Timeline, BeautyServiceCard, SpaServiceCard, HeroFullBleed, HeroOverlayVariant |
| `oklch(0 0 0 / 0.5)` | 3 | ImageInput, AvatarUpload, ProgressBar |
| `rgba(255, 255, 255, 0.15)` | 2 | ProgressBar |

### Hardcoded px Values (Non-Acceptable)

| Value | Occurrences | Components |
|-------|-------------|------------|
| `160px` | 2 | EventCard, CatalogCard |
| `200px` | 3 | CatalogCard, Popover, ImageInput |
| `280px`, `300px`, `320px` | 4 | MiniCalendar, Map, Drawer |
| `400px` | 3 | Modal, UiDialog, BookingScheduler |
| `8px`, `12px`, `36px` | Various | Various |
| `40px`, `48px`, `56px`, `80px` | Various | Avatar, ServiceRow, EventCard |

### Hardcoded Spacing Values

Most components use `rem` units which is acceptable, but many values could use Bulma utility classes:
- `padding: 1rem`, `1.5rem`, `2rem`
- `margin: 0.5rem`, `0.75rem`, `1rem`
- `gap: 0.5rem`, `0.75rem`, `1rem`

### Hardcoded Font Sizes

| Value | Occurrences | Components |
|-------|-------------|------------|
| `0.6875rem` (11px) | 8 | Various card components |
| `0.75rem` (12px) | 15 | Various |
| `0.8125rem` (13px) | 12 | Various |
| `0.875rem` (14px) | 20+ | Various |
| `0.9375rem` (15px) | 8 | Various |
| `1rem` (16px) | 10+ | Various |
| `1.125rem` (18px) | 5 | Various |
| `1.25rem` (20px) | 6 | Various |
| `1.375rem` (22px) | 3 | ServiceCard, SpaServiceCard |
| `1.5rem` (24px) | 3 | UiDialog, Price |
| `2rem` (32px) | 4 | Various |
| `4rem` (64px) | 1 | HeroSplit |

### Hardcoded Border Radius

| Value | Components |
|-------|------------|
| `9999px` | UiProgress, List, PricingCard |
| `50%` | Avatar, Skeleton, Spinner, Gallery |
| `16px`, `20px` | BeautyServiceCard, SpaServiceCard |
| `12px`, `8px` | UiDialog, Popover, Toast |
| `4px`, `6px` | Drawer, FileInput, MedicalServiceCard |

### Hardcoded Box Shadows

| Value | Components |
|-------|------------|
| `0 4px 12px oklch(0 0 0 / 0.08)` | HeroCentered, HeroClassic, HeroSplit, HeroBusiness, HeroMinimal |
| `0 8px 32px oklch(0 0 0 / 0.12)` | HeroFloating, BeautyServiceCard |
| `0 4px 16px oklch(0 0 0 / 0.06)` | BeautyServiceCard |
| `0 2px 16px oklch(0 0 0 / 0.05)` | SpaServiceCard |
| `0 -4px 20px oklch(0 0 0 / 0.15)` | ActionSheet, UiSheet |

### BEM Violations

| Component | Issue |
|-----------|-------|
| `Callout.vue` | Child elements use `.callout-icon` instead of `.callout__icon` |
| `CatalogPricing.vue` | Uses `&-original` instead of `&__original` |
| `HorizontalScroll.vue` | Uses `dl-bulma-horizontal-scroll` hybrid naming |
| `Avatar.vue` | Uses `ui-avatar` + `dl-bulma-avatar` hybrid |
| `EmptyState.vue` | Uses `ui-empty-state` + `dl-bulma-empty-state` hybrid |

### Industry-Specific Variables

These components define custom `--beauty-*`, `--spa-*`, `--med-*` variables instead of using existing `--bulma-*` or `--dl-*` tokens:

| Component | Variables |
|-----------|-----------|
| `BeautyServiceCard.vue` | `--beauty-primary`, `--beauty-accent`, `--beauty-gold`, `--beauty-bg`, `--beauty-text`, `--beauty-muted` |
| `SpaServiceCard.vue` | `--spa-primary`, `--spa-secondary`, `--spa-accent`, `--spa-bg`, `--spa-text`, `--spa-muted` |
| `MedicalServiceCard.vue` | `--med-primary`, `--med-secondary`, `--med-accent` |

### Components with Potential Duplication

1. **State Components:** `EmptyState`, `ErrorState`, `SuccessState`, `OfflineState` - identical structure
2. **Price Components:** `Price.vue`, `CatalogPricing.vue`, `ProductPrice.vue` - similar patterns
3. **Service Cards:** `BeautyServiceCard`, `SpaServiceCard`, `MedicalServiceCard`, `ServiceCard`, `ProductCard` - shared patterns
4. **Hero Components:** 8 variants with recurring patterns

---

## Component Status Table

| Component | State | Bulma | Hardcoded Colors | Absolute Measures | Duplicación | Acción |
| ---------- | ------ | ----- | ---------------- | ----------------- | ----------- | ------ |
| **products/** | | | | | | |
| ProductCard.vue | MINOR | OK | OK | 140px, 48px | Similar to ServiceCard | Migrar spacing a Bulma |
| ProductPrice.vue | MINOR | ⚠️ Line 3 has-text-danger | OK | OK | OK | Usar variable CSS |
| ProductBadges.vue | READY | OK | OK | OK | OK | Ninguna |
| ProductImage.vue | READY | OK | OK | OK | OK | Ninguna |
| ProductGallery.vue | READY | OK | OK | OK | OK | Ninguna |
| ProductMeta.vue | READY | OK | OK | OK | OK | Ninguna |
| ProductStock.vue | READY | OK | OK | OK | OK | Ninguna |
| ProductVariant.vue | READY | OK | OK | OK | OK | Ninguna |
| **services/** | | | | | | |
| ServiceCard.vue | MINOR | OK | white (2x) | 60px | Similar to ProductCard | Usar variable Bulma |
| ServiceList.vue | READY | OK | OK | OK | OK | Ninguna |
| ServiceListItem.vue | MINOR | OK | OK | 40px, 48px | OK | Considerar unificar |
| ServiceRow.vue | MINOR | OK | OK | 56px, 40px, 72px | OK | Considerar unificar |
| ServiceGrid.vue | READY | OK | OK | OK | OK | Ninguna |
| ServiceDetailModal.vue | MINOR | ⚠️ Uses modal classes | OK | OK | Similar a otros modals | Unificar estructura modal |
| ServiceStepper.vue | READY | OK | OK | OK | OK | Ninguna |
| ServiceFeatured.vue | READY | OK | OK | OK | OK | Ninguna |
| ServiceToggle.vue | READY | OK | OK | OK | OK | Ninguna |
| ServiceFilter.vue | READY | OK | OK | OK | OK | Ninguna |
| **beauty/** | | | | | | |
| BeautyServiceCard.vue | REFACTOR | ⚠️ Custom vars | 11 hardcoded | 16px, 20px radius | Duplicates SpaServiceCard | Unificar en ServiceCard + theme |
| BeautyService.vue | REFACTOR | OK | OK | 50% radius | Duplicates ServiceRow | Unificar |
| BeautyStylist.vue | READY | OK | OK | 3.5rem, 2rem | OK | Ninguna |
| **spa/** | | | | | | |
| SpaServiceCard.vue | REFACTOR | ⚠️ Custom vars | 10 hardcoded | 20px, 12px radius | Duplicates BeautyServiceCard | Unificar en ServiceCard + theme |
| **medical/** | | | | | | |
| DoctorCard.vue | MINOR | OK | OK | 5rem avatar | OK | Unificar avatar sizing |
| MedicalServiceCard.vue | REFACTOR | ⚠️ Custom vars | 4 hardcoded | 12px, 6px radius | Duplicates SpaServiceCard | Unificar en ServiceCard + theme |
| TreatmentCard.vue | MINOR | OK | OK | 3rem icon | OK | Unificar icon sizing |
| **events/** | | | | | | |
| EventCard.vue | MINOR | OK | OK | 160px | OK | Cambiar a rem |
| EventDate.vue | READY | OK | OK | OK | OK | Ninguna |
| EventLocation.vue | READY | OK | OK | OK | OK | Ninguna |
| EventTime.vue | READY | OK | OK | OK | OK | Ninguna |
| **location/** | | | | | | |
| LocationCard.vue | READY | OK | OK | OK | OK | Ninguna |
| DirectionsButton.vue | READY | OK | OK | -1px, 2px (acceptable) | OK | Ninguna |
| AddressBlock.vue | READY | OK | OK | OK | OK | Ninguna |
| **heroes/** | | | | | | |
| HeroCentered.vue | MINOR | OK | OK | 160px height | OK | Cambiar a rem |
| HeroClassic.vue | MINOR | OK | OK | max-width 400px | OK | OK |
| HeroSplit.vue | MINOR | OK | OK | 200px min-height, 4rem font | OK | OK |
| HeroFullBleed.vue | REFACTOR | OK | white (6x) | 400px min-height | OK | Usar variable Bulma |
| HeroFloating.vue | MINOR | OK | OK | max-width 320px | OK | OK |
| HeroOverlayVariant.vue | REFACTOR | OK | white (3x) | 280px min-height | OK | Usar variable Bulma |
| HeroBusiness.vue | MINOR | OK | OK | OK | OK | OK |
| HeroMinimal.vue | MINOR | OK | OK | OK | OK | OK |
| **booking/** | | | | | | |
| BookingCalendar.vue | MINOR | OK | OK | 8px dots | OK | OK |
| BookingTimeSlots.vue | MINOR | OK | OK | OK | OK | OK |
| BookingServiceInfo.vue | MINOR | OK | OK | OK | OK | OK |
| BookingSummary.vue | MINOR | OK | OK | OK | OK | OK |
| BookingScheduler.vue | REFACTOR | ⚠️ button is-link | OK | 280px, 400px, 120px | OK | Reemplazar Bulma button |
| BookingProgress.vue | READY | OK | OK | OK | OK | Ninguna |
| BookingSelectedDate.vue | READY | OK | OK | OK | OK | Ninguna |
| BookingEmptyState.vue | READY | OK | OK | OK | OK | Ninguna |
| BookingTimezone.vue | READY | OK | OK | OK | OK | Ninguna |
| **pricing/** | | | | | | |
| PricingCard.vue | REFACTOR | ⚠️ button classes | #fff badge | 9999px radius | OK | Reemplazar Bulma button |
| Price.vue | MINOR | OK | OK | OK | Similar to CatalogPricing | Unificar |
| Discount.vue | MINOR | OK | OK | OK | OK | OK |
| OldPrice.vue | READY | OK | OK | OK | OK | Ninguna |
| **catalog/** | | | | | | |
| CatalogCard.vue | REFACTOR | ⚠️ button classes | OK | 200px, 4px 12px shadow | Similar to PricingCard | Reemplazar Bulma button |
| CatalogPricing.vue | REFACTOR | OK | OK | OK | Similar to Price | BEM violation fix |
| **feedback/** | | | | | | |
| EmptyState.vue | REFACTOR | ⚠️ Heavy Bulma | OK | OK | Similar to Error/Success | Hybrid BEM + Bulma cleanup |
| LoadingState.vue | READY | OK | OK | OK | OK | Ninguna |
| ErrorState.vue | MINOR | OK | white | OK | Similar to Success | Usar variable |
| SuccessState.vue | MINOR | OK | white | OK | Similar to Error | Usar variable |
| OfflineState.vue | READY | OK | OK | OK | OK | Ninguna |
| Alert.vue | READY | OK | OK | OK | OK | Ninguna |
| InlineMessage.vue | READY | OK | OK | OK | OK | Ninguna |
| Skeleton.vue | READY | OK | OK | OK | OK | Ninguna |
| SkeletonGroup.vue | READY | OK | OK | OK | OK | Ninguna |
| ProgressBar.vue | MINOR | OK | rgba(255,255,255,0.15) | 4px, 8px, 16px | OK | Usar variable |
| StatusBadge.vue | READY | OK | OK | OK | OK | Ninguna |
| Timeline.vue | MINOR | OK | white | OK | OK | Usar variable |
| StepIndicator.vue | READY | OK | OK | OK | OK | Ninguna |
| **core UI/** | | | | | | |
| Modal.vue | LEGACY | ⚠️ Heavy Bulma | OK | 400px, 800px | OK | Considerar refactorizar |
| Drawer.vue | MINOR | ⚠️ Bulma utilities | OK | 300px | Mixed Bulma+BEM | Unificar |
| ActionSheet.vue | MINOR | ⚠️ Bulma utilities | OK | 16px radius | OK | Unificar |
| UiDialog.vue | MINOR | OK | OK | 400-800px | OK | OK |
| UiSheet.vue | MINOR | OK | OK | 16px radius | OK | OK |
| UiSpinner.vue | READY | OK | OK | 16-48px | OK | OK |
| UiProgress.vue | MINOR | OK | OK | 4px, 8px, 16px | OK | OK |
| UiSwitch.vue | MINOR | OK | OK | 44px, 20px, 24px | OK | OK |
| Toast.vue | MINOR | OK | OK | 8px radius | OK | OK |
| Popover.vue | MINOR | ⚠️ Bulma utilities | OK | 200px | OK | Unificar |
| **navigation/** | | | | | | |
| AppBar.vue | MINOR | OK | OK | 56px | OK | OK |
| AppShell.vue | MINOR | OK | OK | 36px | OK | OK |
| BottomNav.vue | MINOR | OK | OK | 4rem | OK | OK |
| Breadcrumb.vue | MINOR | OK | OK | 4px, 6px borders | OK | OK |
| NavigationList.vue | READY | OK | OK | OK | OK | Ninguna |
| NavigationRail.vue | READY | OK | OK | OK | OK | Ninguna |
| HorizontalScroll.vue | MINOR | OK | OK | 4px | BEM violation | Fix BEM |
| **forms/** | | | | | | |
| FileInput.vue | REFACTOR | ⚠️ Heavy Bulma | OK | 12px, 6px, 4px | OK | Replace Bulma utilities |
| FileItem.vue | MINOR | OK | OK | 80px | OK | OK |
| ImageInput.vue | REFACTOR | ⚠️ Bulma button | rgba(0,0,0,0.5) | 200px, 150px, 8px | OK | Replace Bulma button |
| AvatarUpload.vue | REFACTOR | ⚠️ Bulma button | oklch(0 0 0 / 0.5) | 120px | OK | Replace Bulma button |
| SearchInput.vue | READY | OK | OK | OK | OK | Ninguna |
| PanelFilter.vue | READY | OK | OK | OK | OK | Ninguna |
| PanelTabs.vue | READY | OK | OK | OK | OK | Ninguna |
| PanelBlock.vue | READY | OK | OK | OK | OK | Ninguna |
| RangeInput.vue | READY | OK | OK | OK | OK | Ninguna |
| SegmentedControl.vue | READY | OK | OK | OK | OK | Ninguna |
| SelectionBar.vue | READY | OK | OK | OK | OK | Ninguna |
| **media/** | | | | | | |
| Gallery.vue | MINOR | OK | white (3x) | 50% radius | OK | Usar variable |
| Media.vue | READY | OK | OK | OK | OK | Ninguna |
| MediaCard.vue | MINOR | OK | OK | 120px, box-shadow | OK | OK |
| VideoPlayer.vue | READY | OK | OK | OK | OK | Ninguna |
| VideoCard.vue | READY | OK | OK | OK | OK | Ninguna |
| VideoPlaylist.vue | READY | OK | OK | OK | OK | Ninguna |
| AudioPlayer.vue | READY | OK | OK | OK | OK | Ninguna |
| **slider/** | | | | | | |
| SwiperSlider.vue | MINOR | OK | OK | 36px | OK | OK |
| **calendar/** | | | | | | |
| MiniCalendar.vue | MINOR | OK | OK | 320px, 280px, 2rem | OK | OK |
| CalendarDay.vue | MINOR | OK | OK | 4px, 1.75rem | OK | OK |
| **map/** | | | | | | |
| Map.vue | READY | OK | OK | 300px (prop) | OK | OK |
| **social/** | | | | | | |
| SocialButton.vue | READY | OK | OK | OK | OK | Ninguna |
| SocialLinks.vue | READY | OK | OK | OK | OK | Ninguna |
| **people/** | | | | | | |
| TeamMember.vue | READY | OK | OK | OK | OK | Ninguna |
| TeamGrid.vue | READY | OK | OK | OK | OK | Ninguna |
| **properties/** | | | | | | |
| PropertyCard.vue | MINOR | OK | OK | OK | OK | OK |
| PropertyPrice.vue | READY | OK | OK | OK | OK | Ninguna |
| PropertyFeatures.vue | READY | OK | OK | OK | OK | Ninguna |
| PropertyStatus.vue | READY | OK | OK | OK | OK | Ninguna |
| **promotions/** | | | | | | |
| PromotionCountdown.vue | READY | OK | OK | OK | OK | Ninguna |
| **availability/** | | | | | | |
| AvailabilityStatus.vue | READY | OK | OK | OK | OK | Ninguna |
| TimeSlot.vue | READY | OK | OK | OK | OK | Ninguna |
| OpeningHours.vue | READY | OK | OK | OK | OK | Ninguna |
| **cta/** | | | | | | |
| CtaButton.vue | READY | OK | OK | OK | OK | Ninguna |
| CtaArrow.vue | READY | OK | OK | OK | OK | Ninguna |
| CtaIcon.vue | READY | OK | OK | OK | OK | Ninguna |
| **content/** | | | | | | |
| (various content components) | READY | OK | OK | OK | OK | Ninguna |
| **restaurant/** | | | | | | |
| (restaurant-specific components) | REFACTOR | ⚠️ Custom vars | TBD | TBD | Duplicates | Unificar |
| **cafe/** | | | | | | |
| (cafe-specific components) | REFACTOR | ⚠️ Custom vars | TBD | TBD | Duplicates | Unificar |
| **fitness/** | | | | | | |
| (fitness-specific components) | REFACTOR | ⚠️ Custom vars | TBD | TBD | Duplicates | Unificar |

---

## Component Status Summary

| Status | Count |
|--------|-------|
| READY | 45 |
| MINOR | 35 |
| REFACTOR | 14 |
| LEGACY | 1 |
| DUPLICATE | (not tracked as status) |

---

## Issues by Category

### 1. Bootstrap/Bulma Residual Classes

**Count:** 9 components with Bootstrap/Bulma classes in templates

These components use Bulma utility classes directly in templates instead of encapsulating them in SCSS:

1. `Dropdown.vue` - Uses `button`, `icon is-small`, `dropdown-content`
2. `FileInput.vue` - Uses `is-size-*`, `has-text-grey`, `is-flex`, `pl-*`
3. `ImageInput.vue` - Uses `button`, `is-small`, `is-light`, `is-danger`
4. `List.vue` - Uses `is-flex is-align-items-center is-gap-* p-*`
5. `AvatarUpload.vue` - Uses `button is-small is-primary`
6. `EmptyState.vue` - Uses `is-flex is-flex-direction-column is-align-items-center`
7. `BookingScheduler.vue` - Uses `button is-link`
8. `PricingCard.vue` - Uses `button is-primary is-medium`
9. `CatalogCard.vue` - Uses `button is-small is-primary`

### 2. Hardcoded Colors

**Count:** 15 components

| Color | Count | Suggested Fix |
|-------|-------|---------------|
| `white` | 18 | Replace with `var(--bulma-text-invert)` or `--dl-*` variable |
| `rgba(0,0,0,0.5)` | 3 | Replace with `--dl-overlay` or similar |
| `rgba(255,255,255,0.15)` | 2 | Replace with `color-mix()` using Bulma variables |

### 3. Hardcoded px Values

**Count:** 25+ components

Most problematic:
- `300px`, `320px`, `400px` for container widths → Should use `%` or `rem`
- `8px`, `12px`, `16px`, `20px` for border-radius → Should use `--bulma-radius-*` variables
- `36px`, `40px`, `48px`, `56px`, `80px` for dimensions → Acceptable in context, but should be consistent

### 4. Hardcoded Spacing (rem)

**Count:** Most components

While `rem` is acceptable, many values could be replaced with Bulma utilities:
- `padding: 1rem` → Bulma `p-4`
- `padding: 1.5rem` → Bulma `p-5`
- `gap: 0.75rem` → Bulma `is-gap-3`

### 5. Industry-Specific Variables

**Count:** 3 industry card types

Components `BeautyServiceCard`, `SpaServiceCard`, `MedicalServiceCard` define custom color variables (`--beauty-*`, `--spa-*`, `--med-*`) instead of using the existing design token system.

---

## Recommendations

### High Priority (P0)

1. **Remove Bootstrap/Bulma utility classes from templates**
   - Move all `is-*`, `has-*`, `p-*`, `m-*` classes to SCSS
   - Affects: `Dropdown.vue`, `FileInput.vue`, `ImageInput.vue`, `List.vue`, `AvatarUpload.vue`, `EmptyState.vue`

2. **Unify service/product card components**
   - `BeautyServiceCard`, `SpaServiceCard`, `MedicalServiceCard` should be unified
   - Use theme variables instead of custom color variables

3. **Replace hardcoded white/black colors**
   - Use `var(--bulma-text-invert)` or `--dl-*` tokens

### Medium Priority (P1)

4. **Standardize hero components**
   - Extract recurring box-shadow values to CSS variable
   - Replace hardcoded white colors with Bulma variables

5. **Fix BEM violations**
   - `Callout.vue`: Add `__` prefix to child elements
   - `CatalogPricing.vue`: Fix `&-original` → `&__original`
   - `HorizontalScroll.vue`: Fix hybrid naming
   - `Avatar.vue`, `EmptyState.vue`: Choose consistent naming

6. **Replace hardcoded dimensions**
   - `EventCard.vue`: `160px` → `10rem`
   - `CatalogCard.vue`: `200px` → `12.5rem`
   - `MiniCalendar.vue`: `320px` → `20rem`

### Low Priority (P2)

7. **Extract recurring patterns to shared components**
   - State components (`EmptyState`, `ErrorState`, `SuccessState`, `OfflineState`)
   - Price display components
   - Service card footer

8. **Standardize spacing scale**
   - Define which spacing values are allowed
   - Use Bulma utilities where possible

9. **Document design tokens**
   - Ensure all `--dl-*` tokens are documented
   - Map industry-specific variables to standard tokens

---

## Next Steps

1. Create refactor plan with prioritized tasks
2. Apply low-risk corrections first
3. Verify with `npm run build`
4. Continue with medium-risk corrections
5. Document all design tokens in `docs/`

---

*Report generated by automated audit script*
