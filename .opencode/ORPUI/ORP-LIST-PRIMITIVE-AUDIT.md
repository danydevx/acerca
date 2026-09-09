# ORP List Primitive Audit

## Executive Summary

Audit of ORP List primitive completed. List provides a clean, well-structured UI list primitive for structured repeated interface rows. The component properly separates concerns (leading content, content, trailing content) and uses semantic elements for interactive rows.

**Finding**: LIST ALREADY ADEQUATE

**Issue Found**: Undefined CSS classes `orp-list--bordered` and `orp-list__divider` are used in Playground but not defined in the List CSS. These are dead code.

**No changes required to List primitive itself.**

---

## Existing API

```text
.orp-list                        Base list container
.orp-list__item                 List row
.orp-list__item--interactive     Interactive row (uses <button>)
.orp-list__item--active         Active/selected state
.orp-list__leading              Leading content slot
.orp-list__content              Main content slot
.orp-list__title                Title text
.orp-list__subtitle             Subtitle text
.orp-list__trailing             Trailing content slot
.orp-list__media                Media thumbnail helper
.orp-list--divided              Divided variant
.orp-list--inset               Inset variant (for icon rows)
```

---

## Capability Matrix

| Capability | Exists | Visual Purpose | Decision |
|------------|--------|----------------|----------|
| Default list | ✓ | Row container | KEEP |
| Interactive row | ✓ | Clickable row | KEEP |
| Active/selected | ✓ | Selected state | KEEP |
| Leading slot | ✓ | Avatar/icon slot | KEEP |
| Content slot | ✓ | Title + subtitle | KEEP |
| Trailing slot | ✓ | Actions/meta | KEEP |
| Media thumbnail | ✓ | Image thumbnail | KEEP |
| Divided | ✓ | Separated rows | KEEP |
| Inset | ✓ | Icon-aware padding | KEEP |
| Dense mode | ✗ | N/A | REJECT |
| Bordered | ~ | Undefined | REMOVE |
| Divider element | ~ | Undefined | REMOVE |

---

## Audit Findings

### Is `.orp-list` merely Stack with borders?

**Finding**: No. List has specific row structure (`__item`) with leading/content/trailing anatomy that Stack lacks. Stack is a spacing utility; List is a structured row component.

**Decision**: KEEP dedicated List.

---

### Is a dedicated List primitive justified?

**Finding**: Yes. List provides structured row anatomy that generic Stack cannot. Used extensively in Playground for contacts, settings, navigation-like rows.

**Decision**: KEEP.

---

### Is divided behavior duplicated?

**Finding**: No. The `--divided` variant provides clean row separation. This is distinct from a standalone Divider component.

**Decision**: KEEP `--divided`.

---

### Are row paddings consistent?

**Finding**: Yes. Row padding is `var(--orp-space-3) var(--orp-space-4)` = 12px 16px. Token-driven and consistent.

**Decision**: KEEP.

---

### Is interactive state generic?

**Finding**: Yes. Interactive rows use `<button>` element with `appearance: none` reset. Proper semantic HTML.

**Decision**: KEEP.

---

### Is selected state needed?

**Finding**: Yes. `--active` and `[aria-current="true"]` provide selected state using soft primary tint (`color-mix(in srgb, var(--orp-primary) 8%, transparent)`).

**Decision**: KEEP.

---

### Is dense mode needed?

**Finding**: No evidence in Playground or patterns for dense mode. Single size works.

**Decision**: REJECT dense mode.

---

### Are leading/trailing areas repeated?

**Finding**: No. Each row can have leading (avatar/icon) and trailing (badge/action) independently.

**Decision**: KEEP.

---

### Does List overlap Navigation too much?

**Finding**: No. Navigation has different responsibilities (nav element, aria roles, page structure). List is for data rows, not navigation structure.

**Decision**: No overlap.

---

### Does it resemble Bootstrap list-group?

**Finding**: No. Differences:
- No boxed/bordered styling per row
- No active blue row color (uses soft primary tint)
- No "list-group-item" equivalent
- Row anatomy is different (leading/content/trailing vs single content)

**Decision**: NOT Bootstrap-like.

---

## Bootstrap Resemblance

| Aspect | Score | Explanation |
|--------|-------|-------------|
| Overall | 0/3 | Clean UI list, not Bootstrap list-group |

---

## Issues Found

### Undefined CSS Classes

The following classes are used in Playground but NOT defined in List CSS:

1. `.orp-list--bordered` - used in Notification Center section
2. `.orp-list__divider` - used in Notification Center section

These are dead code - CSS does nothing for them.

**Recommendation**: Remove these undefined classes from Playground or implement them if needed.

---

## Playground Usage

List is showcased with:
- Default (contact list with avatars)
- Divided (settings-like rows)
- Inset (icon-based rows)
- Interactive (button rows)
- Active state
- Disabled state
- Media thumbnails

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
# ✓ built in 22.64s
```

---

## Console

No new errors or warnings.

---

## Files Modified

None. List is already adequate.

---

## Final Verdict

```
LIST ALREADY ADEQUATE
```

---

## Deferred Issues

| Issue | Action |
|-------|--------|
| `orp-list--bordered` undefined | Remove from Playground or implement if needed |
| `orp-list__divider` undefined | Remove from Playground or implement if needed |

---

## Variant Decisions Summary

| Variant | Decision | Reason |
|---------|----------|--------|
| Default | KEEP | Clean row container |
| Interactive | KEEP | Semantic button rows |
| Active/selected | KEEP | Soft primary tint |
| Leading/trailing | KEEP | Flexible content slots |
| Media thumbnail | KEEP | Image previews |
| Divided | KEEP | Clean row separation |
| Inset | KEEP | Icon-aware padding |
| Dense mode | REJECT | No evidence needed |
| Bordered | REMOVE | Undefined/dead code |
| Divider element | REMOVE | Undefined/dead code |
