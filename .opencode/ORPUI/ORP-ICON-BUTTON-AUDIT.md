# ORP Icon Button Audit

## Executive Summary

Audit of ORP IconButton component completed. IconButton provides icon-only actions with primary, ghost, and danger variants in three sizes. Clean and focused.

**Finding**: ICON BUTTON ALREADY ADEQUATE

**Note**: During the Button audit, IconButton's radius was fixed to match Button (changed from `radius-sm` to `radius-md`).

---

## Existing API

```text
.orp-icon-btn              Base icon button (md radius, 40px default)
.orp-icon-btn--sm        Small (32px)
.orp-icon-btn--md        Medium (40px)
.orp-icon-btn--lg        Large (48px)
.orp-icon-btn--primary   Primary color
.orp-icon-btn--ghost     Ghost muted color
.orp-icon-btn--danger    Danger color
```

---

## Capability Matrix

| Capability | Exists | Visual Purpose | Decision |
|------------|--------|----------------|----------|
| Base IconButton | ✓ | Icon-only action | KEEP |
| Size sm | ✓ | 32px | KEEP |
| Size md | ✓ | 40px | KEEP |
| Size lg | ✓ | 48px | KEEP |
| Primary variant | ✓ | Brand emphasis | KEEP |
| Ghost variant | ✓ | Quiet action | KEEP |
| Danger variant | ✓ | Destructive | KEEP |
| Secondary variant | ✗ | N/A | REJECT |
| Soft variant | ✗ | N/A | REJECT |
| Outline variant | ✗ | N/A | REJECT |

---

## Audit Findings

### Are variants sufficient?

**Finding**: Yes. Primary, Ghost, and Danger cover the action hierarchy needs. IconButton should not mirror every Button variant.

**Decision**: KEEP current variants.

---

### Does IconButton need Secondary or Soft?

**Finding**: No evidence. Ghost already provides the quiet action. Secondary/Soft would duplicate.

**Decision**: REJECT Secondary and Soft.

---

### Are sizes coherent with Button?

**Finding**: Yes. IconButton sizes (32/40/48px) align with Button sizes:
- sm → 32px
- md → 40px
- lg → 48px

Button control height is 48px, so lg IconButton matches Button height.

**Decision**: KEEP coherent sizes.

---

### Is ariaLabel required/enforced?

**Finding**: ariaLabel is the consumer's responsibility via `aria-label` attribute. IconButton uses `aria-hidden` on icons when label is provided via aria-label on the button.

**Decision**: ACCEPT (consumer responsibility).

---

### Are hit targets accessible?

**Finding**: Yes. Minimum touch target is 32px (sm) which meets accessibility guidelines. md (40px) and lg (48px) are even better.

**Decision**: KEEP.

---

### Does anchor icon-link styling need to remain CSS-only?

**Finding**: Yes. `.orp-icon-btn` can be applied to `<a>` elements for icon links. No special API needed.

**Decision**: ACCEPT CSS-only approach.

---

### Are hover/focus/active states coherent?

**Finding**: Yes. Hover uses color-mix for primary/danger and surface-muted for ghost. Focus uses standard ring. Active has no special styling (just pointer cursor).

**Decision**: KEEP.

---

### Does it visually resemble Bootstrap square buttons?

**Finding**: No. Uses `border-radius-md` (8px) and has proper hover states different from Bootstrap's default approach.

**Decision**: KEEP.

---

### Is icon optical sizing consistent?

**Finding**: Consumer controls icon size via Bootstrap Icons. No specific icon-size prop on IconButton.

**Decision**: ACCEPT consumer responsibility.

---

### Are circular/pill shapes overused?

**Finding**: No. Uses rounded rectangle (8px radius), not circle. Appropriate for icon buttons.

**Decision**: KEEP.

---

## Bootstrap Resemblance

| Aspect | Score | Explanation |
|--------|-------|-------------|
| Overall | 0/3 | Clean icon button, not Bootstrap square buttons |

---

## Tests

```bash
npm run test -- --run
# 3 test files passed (10 tests)
```

---

## Build

```bash
npm run build
# ✓ built in 22.58s
```

---

## Console

No new errors or warnings.

---

## Files Modified

None during this audit. (Button audit fixed IconButton radius to match Button.)

---

## Final Verdict

```
ICON BUTTON ALREADY ADEQUATE
```

---

## Variant Decisions Summary

| Variant | Decision | Reason |
|---------|----------|--------|
| Primary | KEEP | Brand emphasis |
| Ghost | KEEP | Quiet action |
| Danger | KEEP | Destructive |
| Secondary | REJECT | Ghost already covers quiet action |
| Soft | REJECT | Not needed |
| Outline | REJECT | Not needed |
| Size sm/md/lg | KEEP | Coherent with Button |
