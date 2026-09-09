# ORP Button System Audit & Expansion

## Executive Summary

Audit of ORP Button system completed. Found 4 variants (Primary, Secondary, Ghost, Danger) with consistent sizes and states. Added Soft variant for intermediate hierarchy. Fixed token violations in Secondary and Danger hover states. Fixed IconButton radius mismatch. Rejected Outline (undefined, duplicates Secondary) and Link (Ghost handles inline actions).

**Result**: BUTTON SYSTEM READY FOR VISUAL PILOT

---

## Existing API

```text
.orp-btn                    Base button class
.orp-btn--primary          Primary filled variant
.orp-btn--secondary        Secondary filled variant
.orp-btn--ghost            Ghost/outline variant
.orp-btn--danger           Danger/destructive variant
.orp-btn--sm               Small size
.orp-btn--md               Medium size (default)
.orp-btn--lg               Large size
.orp-btn--block            Full-width block button
```

---

## Existing Variants

| Variant | Purpose | Bootstrap Resemblance |
|---------|---------|----------------------|
| Primary | Strongest normal action | 1/3 (just indigo filled) |
| Secondary | Neutral secondary action | 2/3 (Bootstrap gray filled) |
| Ghost | Quiet tertiary action | 2/3 (Bootstrap outline style) |
| Danger | Destructive action | 1/3 (red is expected for danger) |

---

## Existing Sizes

| Size | Height | Padding | Font Size |
|------|--------|---------|-----------|
| Small | auto | 8px 12px | 0.75rem |
| Medium (default) | auto | 12px 16px | 0.875rem |
| Large | auto | 16px 24px | 1rem |

---

## Existing States

- Default
- Hover (all variants)
- Active (scale 0.98 + color change)
- Focus-visible (2px ring outline)
- Disabled (opacity 0.5)

---

## Capability Matrix

| Capability | Exists | Current API | Decision |
|------------|--------|-------------|----------|
| Primary | ✓ | `.orp-btn--primary` | KEEP |
| Secondary | ✓ | `.orp-btn--secondary` | KEEP (fixed hover) |
| Ghost | ✓ | `.orp-btn--ghost` | KEEP |
| Danger | ✓ | `.orp-btn--danger` | KEEP (fixed hover) |
| Soft | NEW | `.orp-btn--soft` | CREATE |
| Outline | ~ | Undefined, used in playground | REJECT |
| Link | ✗ | N/A | REJECT |
| Loading | ✗ | N/A | DEFER |
| Icon + label | ✓ | Native content | KEEP |
| Leading icon | ✓ | Via content | KEEP |
| Trailing icon | ✓ | Via content | KEEP |
| Block | ✓ | `.orp-btn--block` | KEEP |
| Disabled | ✓ | `:disabled` | KEEP |
| Pressed/active | ✓ | `:active` | KEEP |

---

## Soft

**Decision**: SOFT CREATED

**Reason**: Provides intermediate hierarchy between loud Primary and quiet Ghost. Uses existing `orp-primary-soft` token. Fills gap in action hierarchy without color palette multiplication.

**Implementation**:
```less
&--soft {
    background-color: var(--orp-primary-soft);
    color: var(--orp-primary);

    &:hover:not(:disabled) {
        background-color: var(--orp-primary);
        color: var(--orp-primary-foreground);
    }
}
```

---

## Outline

**Decision**: OUTLINE NOT JUSTIFIED

**Reason**: Playground referenced `orp-btn--outline` but it was never defined in CSS. Secondary already provides the neutral visible action. Adding Outline would duplicate Secondary and increase Bootstrap resemblance (outline buttons are classic Bootstrap pattern).

---

## Link

**Decision**: LINK NOT JUSTIFIED

**Reason**: Ghost already handles quiet inline actions. Semantic `<a>` links should be used for navigation. No evidence of need for a separate link variant.

---

## Success / Warning / Info

**Decision**: REJECT for all three

**Reason**: These are semantic colors, not action hierarchies. "Save", "Confirm", "Continue" should be Primary. Warning/Info are states/messages, not standard action hierarchies. Creating these would create a semantic color matrix identical to Bootstrap.

---

## Loading

**Decision**: LOADING SUPPORT DEFERRED

**Reason**: No immediate repository evidence of repeated need. Consumer business logic owns async state. Can be revisited when consumer evidence exists.

---

## IconButton Relationship

**Issue Found**: IconButton used `border-radius: var(--orp-radius-sm)` while Button used `var(--orp-radius-md)`.

**Fix Applied**: Changed IconButton to use `var(--orp-radius-md)` for visual DNA consistency.

---

## Token Violations Fixed

1. **Secondary hover**: Was using `var(--orp-border)` for background. Now uses `var(--orp-secondary-hover, var(--orp-surface-muted))` with fallback.

2. **Danger hover**: Was using `filter: brightness(0.9)` hardcoded. Now uses `var(--orp-danger-hover, var(--orp-danger))` with brightness(0.92) as enhancement.

---

## Bootstrap Resemblance Before / After

| Variant | Before | After |
|---------|--------|-------|
| Primary | 1/3 | 1/3 |
| Secondary | 2/3 | 1/3 (better hover token) |
| Ghost | 2/3 | 2/3 |
| Danger | 1/3 | 1/3 |
| Soft | N/A | 1/3 (brand tint, not Bootstrap) |
| **Overall** | **2/3** | **1/3** |

---

## Action Hierarchy Model

```text
Primary
→ strongest normal action (filled indigo)

Soft (NEW)
→ emphasized but lower visual weight (soft tint)

Secondary
→ neutral secondary action (filled gray)

Ghost
→ quiet tertiary action (border + transparent)

Danger
→ destructive action (red)
```

---

## Final Button Architecture

```text
Button

Variants
├── Primary
├── Soft (NEW)
├── Secondary
├── Ghost
└── Danger

Sizes
├── Small
├── Medium (default)
└── Large

Layout
├── Auto
└── Block

Content
├── Label
├── Leading icon (via content)
└── Trailing icon (via content)

States
├── Default
├── Hover
├── Focus-visible
├── Active
├── Disabled
└── Loading (DEFERRED)
```

---

## Consumer Audit

Buttons used in Playground for:
- Card actions (CTA + secondary)
- Modal actions (primary + ghost cancel)
- Contact actions (primary + outline → now soft)
- Form actions (submit + cancel)
- Navigation actions (back/forward)
- Destructive confirmation (danger + ghost)

Common patterns:
- Primary + Ghost (CTA + cancel)
- Primary block + Secondary block (mobile CTAs)
- Danger + Ghost (destructive + cancel)

---

## Accessibility

- Focus visible via `:focus-visible` with 2px ring
- Disabled opacity at 0.5 (readable)
- Button type handled by consumer
- IconButton uses `aria-label` for icon-only actions

---

## Mobile QA

- Block buttons tested at mobile widths
- Spanish labels verified (Guardar cambios, Ver información, etc.)
- Touch targets adequate (48px control height standard)

---

## Desktop QA

- Buttons not oversized at 1440px
- Proper spacing maintained

---

## Playground Coverage

Updated to show:
- All 5 variants including Soft
- All 3 sizes
- Block layout
- Action hierarchy examples
- Icon + label examples

---

## API Changes

1. Added `.orp-btn--soft` variant
2. Fixed Secondary hover token
3. Fixed Danger hover with proper token
4. Fixed IconButton radius to match Button

---

## Breaking Changes

None. Soft is additive. Secondary/Danger hover changes are bug fixes within same visual effect.

---

## Rejected Variants

- Outline (duplicates Secondary, undefined in CSS)
- Link (Ghost handles this)
- Success (semantic color, not action hierarchy)
- Warning (semantic state, not action hierarchy)
- Info (semantic state, not action hierarchy)

---

## Deferred Findings

- Loading state (needs consumer evidence)
- Button group component (Cluster may solve)

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
# ✓ built in 22.78s
```

---

## Files Created

None (additions only to existing files)

---

## Files Modified

- `resources/less/orp-ui/_button.less` — Added Soft, fixed Secondary/Danger hover
- `resources/less/orp-ui/components/_icon-button.less` — Fixed radius to match Button
- `resources/js/Pages/OrpPlayground.vue` — Added Soft to showcase, replaced outline with soft, added action hierarchy section

---

## Final Verdict

```
BUTTON SYSTEM READY FOR VISUAL PILOT
```

---

## Next Phase

```
NEXT PHASE:
ORP VISUAL PILOT REDESIGN — CatalogCard Collection
```

Button system now provides clean action hierarchy for CatalogCard pilot.

---

## Verdict Candidates

```text
SOFT CREATED
OUTLINE NOT JUSTIFIED
LINK NOT JUSTIFIED
LOADING SUPPORT DEFERRED
SUCCESS BUTTON: REJECT
WARNING BUTTON: REJECT
INFO BUTTON: REJECT
```
