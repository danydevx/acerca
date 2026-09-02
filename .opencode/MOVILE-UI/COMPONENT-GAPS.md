# ORP UI Component Gaps

**Version:** 0.1.0 Readiness Audit  
**Date:** 2026-09-02

---

## Gap Analysis Summary

| Status | Count | Description |
|--------|-------|-------------|
| MISSING | 4 | Components that don't exist but may be needed |
| INCOMPLETE | 6 | Components that exist but lack features |
| NOT EXPORTED | 6 | Vue components that exist but aren't in public API |
| REGRESSION | 2 | Features that previously worked but may be broken |
| DEFER v0.2 | 8 | Complex components to consider for v0.2 |
| EXTERNAL | 3 | Handled by external libraries |

---

## MISSING Components (Candidate for v0.1)

| Component | Needed | v0.1 | v0.2 | External | Reason |
|-----------|--------|:----:|:----:|:--------:|--------|
| Tooltip | ⚠️ MEDIUM | ❌ | ✅ | - | Common primitive, but native title often sufficient |
| Visually Hidden (sr-only) | ⚠️ LOW | ❌ | ✅ | - | Easy utility, could be added quickly |
| Aspect Ratio Helper | ✅ LOW | ❌ | ✅ | - | orp-media may already cover this |
| Rating Input (interactive) | ⚠️ MEDIUM | ❌ | ✅ | - | Display rating exists, input version missing |

### Missing Components Analysis

#### Tooltip
- **Decision:** DEFER v0.2
- **Reason:** Native `title` attribute works for simple cases. Floating patterns require significant work.
- **Evidence:** No tooltip LESS or Vue component found in codebase
- **Accessibility Complexity:** HIGH - requires focus management, viewport detection, touch strategy

#### Visually Hidden
- **Decision:** REQUIRED v0.1
- **Reason:** Standard accessibility utility needed for screen reader-only content
- **Evidence:** No `orp-sr-only` class found in utilities
- **Complexity:** LOW - simple CSS utility

#### Rating Input
- **Decision:** DEFER v0.2
- **Reason:** OrpRating exists as display component; interactive version needs research
- **Evidence:** Rating CSS exists but no interactive version
- **Complexity:** MEDIUM - requires keyboard navigation, ARIA

---

## INCOMPLETE Components

| Component | Issue | Severity | Fix Priority |
|-----------|-------|----------|--------------|
| Spacing Utilities (orp-p-*, orp-m-*, orp-gap-*) | Regression suspected | HIGH | IMMEDIATE |
| Focus Ring | Implementation inconsistent | MEDIUM | HIGH |
| Grid | No playground demo | LOW | MEDIUM |
| Input/Textarea/Select | Missing disabled readonly states verification | MEDIUM | HIGH |

### Incomplete Analysis

#### Spacing Utilities Regression
- **Issue:** Detected in skill doc section 10 - "Spacing regression"
- **Severity:** HIGH
- **Impact:** Core utilities may not work in compiled CSS
- **Recommended Fix:** Verify orp-ui.less compiles correctly, check for conflicts

#### Focus Ring
- **Issue:** Not consistent across all interactive components
- **Severity:** MEDIUM
- **Impact:** Accessibility - keyboard users can't see focus
- **Recommended Fix:** Audit all components for `:focus-visible` implementation

---

## NOT EXPORTED Components

These Vue components exist in the codebase but are NOT exported from `orp-ui.js`:

| Component | File | Exists | Exported | Priority |
|-----------|------|:------:|:--------:|----------|
| OrpCombobox.vue | ✅ | ❌ | HIGH | Form component |
| OrpMultiSelect.vue | ✅ | ❌ | HIGH | Form component |
| OrpTagInput.vue | ✅ | ❌ | HIGH | Form component |
| OrpNumberStepper.vue | ✅ | ❌ | MEDIUM | Form component |
| OrpOtpInput.vue | ✅ | ❌ | MEDIUM | Form component |
| OrpPasswordInput.vue | ✅ | ❌ | MEDIUM | Form component |

### Missing Export Fix

These components need to be added to `orp-ui.js`:

```javascript
export { default as OrpCombobox } from './Components/OrpUI/OrpCombobox.vue'
export { default as OrpMultiSelect } from './Components/OrpUI/OrpMultiSelect.vue'
export { default as OrpTagInput } from './Components/OrpUI/OrpTagInput.vue'
export { default as OrpNumberStepper } from './Components/OrpUI/OrpNumberStepper.vue'
export { default as OrpOtpInput } from './Components/OrpUI/OrpOtpInput.vue'
export { default as OrpPasswordInput } from './Components/OrpUI/OrpPasswordInput.vue'
```

---

## DEFER to v0.2

Complex components that should wait for v0.2:

| Component | Reason for Deferral |
|-----------|---------------------|
| Date Picker | Native `input[type=date]` is sufficient for v0.1 |
| Time Picker | Native `input[type=time]` is sufficient for v0.1 |
| DateTime Picker | Combination of above, complex interaction |
| Calendar | Requires significant work, no current use case |
| Color Picker | Native `input[type=color]` is sufficient |
| Tree View | Complex accessibility surface, no current use case |
| Carousel | Swiper handles this use case |
| Rich Text Editor | Out of scope for core UI |

### Native-First Decision Notes

For v0.1, prefer native browser functionality:
- `input[type=date]` - Sufficient for most date selection
- `input[type=time]` - Sufficient for time selection
- `input[type=color]` - Sufficient for color selection
- Native `<select>` - Should be styled, not replaced

---

## EXTERNAL / OUT OF SCOPE

Components handled by external libraries:

| Component | Library | Status |
|-----------|---------|--------|
| Carousel | Swiper | ✅ Integrated |
| Lightbox | GLightbox | ✅ Integrated |
| Charts | Chart.js/ApexCharts | ✅ Integration docs only |
| Maps | Leaflet | ✅ Integration docs only |

---

## Component Gap Matrix (Candidates)

| Candidate | Exists | Needed | v0.1 | v0.2 | External | Reason |
|-----------|:------:|:------:|:----:|:----:|:--------:|--------|
| Tooltip | ❌ | ⚠️ | ❌ | ✅ | - | Native title sufficient |
| Visually Hidden | ❌ | ✅ | ✅ | - | - | Simple utility |
| Aspect Ratio | ⚠️ PARTIAL | ✅ | ❌ | ✅ | - | orp-media may cover |
| Rating Input | ❌ | ⚠️ | ❌ | ✅ | - | Display exists |
| Date Picker | ❌ | ⚠️ | ❌ | ✅ | - | Native sufficient |
| Time Picker | ❌ | ⚠️ | ❌ | ✅ | - | Native sufficient |
| Color Picker | ❌ | ⚠️ | ❌ | ✅ | - | Native sufficient |
| Tree View | ❌ | ❌ | ❌ | ❌ | - | No use case |
| Carousel | ❌ | ❌ | ❌ | ❌ | ✅ | Swiper handles |
| Code Block | ❌ | ❌ | ❌ | ❌ | - | Docs-only |

---

## Regression Issues

| Issue | Severity | Area | Recommended Action |
|-------|----------|------|-------------------|
| Spacing utilities | HIGH | Utilities | Verify compilation and CSS output |
| Focus ring | MEDIUM | Accessibility | Audit all interactive components |

---

## Technical Debt

| ID | Area | Severity | Description | Impact | Recommended Fix |
|----|------|----------|-------------|--------|----------------|
| TD-001 | Exports | HIGH | 6 Vue components not exported | Public API incomplete | Add to orp-ui.js exports |
| TD-002 | Tests | HIGH | No component tests | Quality risk | Add Playwright visual tests |
| TD-003 | Spacing | HIGH | Utility regression possible | Core utilities broken | Verify CSS compilation |
| TD-004 | Focus | MEDIUM | Inconsistent focus-visible | A11y issues | Audit and fix all components |
| TD-005 | Playgroun | MEDIUM | Grid component missing demo | Incomplete coverage | Add Grid demo |

---

## v0.1 Readiness Checklist

- [ ] Fix spacing utility regression
- [ ] Export 6 missing Vue components
- [ ] Add component tests for: Modal, Sheet, Drawer, Dropdown, Tabs, Dialog
- [ ] Audit focus-visible across all interactive components
- [ ] Add Grid playground demo
- [ ] Verify all buttons/textinputs work in dark mode
- [ ] Add Visually Hidden utility (orp-sr-only)

---

*Generated by ORP UI Gap Audit - Parte 21.9*
