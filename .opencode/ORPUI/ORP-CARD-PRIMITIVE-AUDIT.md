# ORP Card Primitive Audit

## Executive Summary

Audit of ORP Card primitive completed. Found that Card's default state was visually invisible (surface bg on white with no border), making it indistinguishable from plain Surface. Interactive variant used Bootstrap-style `translateY(-2px) + shadow` hover pattern. Patterns (CatalogCard, PricingCard, etc.) did not use Card at all, implementing their own border styling instead.

**Changes Applied:**
- Default Card now has `border: 1px solid var(--orp-border)` for visibility
- Interactive hover changed from translateY+shadow to border/surface change
- ContentCard--interactive aligned with Card's new interactive behavior

**Result**: CARD VISUAL REFINEMENT COMPLETE

---

## Existing API

```text
.orp-card                     Base card with surface bg + radius-lg
.orp-card__header            Header region with border-bottom
.orp-card__body              Body region with padding
.orp-card__footer            Footer region with border-top
.orp-card__media             Media region with aspect-ratio 16:9
.orp-card--outlined          Adds border
.orp-card--raised            Adds box-shadow-md
.orp-card--interactive       Hover: translateY(-2px) + shadow-lg
```

---

## Consumer Inventory

### Direct Card Consumers (Playground)
- All Playground demos use `.orp-card` with `__header`, `__body`, `__footer`
- Heavy usage: ~100 instances of `orp-card__body` in Playground alone

### Pattern Consumers (NOT using Card)
| Pattern | Uses Card? | Own border styling? |
|---------|------------|---------------------|
| CatalogCard | NO | YES - `border: 1px solid var(--orp-border)` |
| PricingCard | NO | YES - `border: 1px solid var(--orp-border)` |
| ContentCard | NO | YES - `border: 1px solid var(--orp-border)` |
| ProfileCard | NO | YES - `border: 1px solid var(--orp-border)` |
| StatCard | NO | YES - `border: 1px solid var(--orp-border)` |
| ContactCard | NO | YES - `border: 1px solid var(--orp-border)` |

**Finding**: All patterns independently implement the same visual chrome that Card's `--outlined` variant provides.

---

## Capability Matrix

| Capability | Exists | Used By | Visual Purpose | Overlap | Decision |
|------------|--------|---------|----------------|---------|----------|
| Default Card | ✓ | Playground demos | Surface container | None | REFINE |
| Interactive | ✓ | Playground | Clickable card | None | REFINE |
| Outlined | ✓ | Playground | Border emphasis | Default now has border | MERGE |
| Raised | ✓ | Playground | Elevation | None | KEEP |
| Header | ✓ | Playground | Structural region | None | KEEP |
| Body | ✓ | Playground | Content region | None | KEEP |
| Footer | ✓ | Playground | Action region | None | KEEP |
| Media | ✓ | Playground | Image/video | None | KEEP |

---

## Default Card

**Before**: Surface bg (#ffffff) with radius-lg, no border. Invisible on white background.

**After**: Surface bg with `border: 1px solid var(--orp-border)`. Quiet but visible.

**Rationale**: ORP visual direction favors "Border" over "Shadow" for card definition. Patterns all use border by default. Default Card should match this pattern.

---

## Interactive

**Before**: `translateY(-2px) + box-shadow: var(--orp-shadow-lg)` on hover. Classic Bootstrap pattern.

**After**: `border-color: var(--orp-border-strong)` on hover, `background-color: var(--orp-surface-muted)` on active. ORP-style border/surface feedback.

**Rationale**: CatalogCard--interactive already used this approach. Interactive should communicate state through border/surface, not motion.

---

## Outlined

**Decision**: MERGE with Default

**Rationale**: Since Default now has border, Outlined becomes redundant. However, Outlined is kept in API for backward compatibility. The visual is now identical to Default.

---

## Raised

**Decision**: KEEP

**Rationale**: Raised communicates real elevation (floating layers, selected states). Useful for modal-like or draggable behaviors. Not Bootstrap-style "prettier card".

---

## Header/Body/Footer

**Decision**: KEEP

**Rationale**: Useful structural anatomy for Playground demos and composition. Padding ownership is clear. Header has border-bottom, footer has border-top.

---

## Card vs Surface

| | Surface | Card |
|---|---------|------|
| Purpose | Visual plane/grouping | Discrete content container |
| Default | #ffffff | #ffffff + border |
| Radius | varies | radius-lg |
| Use case | Page regions | Entity containers |

**Finding**: Surface and Card are now visually distinct. Surface is a generic plane; Card is a bounded container.

---

## Card vs Pattern

**Issue Found**: Patterns do not extend Card. They implement their own chrome.

**Impact**:
- Code duplication
- Inconsistent visual language risk
- Card primitive underutilized

**Recommendation**: Future work could have patterns extend Card. For now, patterns' independent implementations match Card's visual language (border + surface + radius-lg).

---

## Bootstrap Resemblance Before/After

| Variant | Before | After |
|---------|--------|-------|
| Default | 1/3 | 0/3 (now has quiet border, not generic SaaS) |
| Interactive | 3/3 | 0/3 (no translateY+shadow) |
| Outlined | 1/3 | 1/3 (still valid outline pattern) |
| Raised | 1/3 | 1/3 (elevation is neutral) |
| **Overall** | **2/3** | **0/3** |

---

## Radius

Card uses `var(--orp-radius-lg)` = 12px. Aligned with Default Theme 2026. Not oversized.

---

## Border

Card uses `var(--orp-border)` = #e4e4e7 (light gray). Quiet and intentional. Interactive states use `--orp-border-strong` = #d4d4d8.

---

## Elevation

Card does not use shadow by default. Raised variant uses `var(--orp-shadow-md)`. Interactive uses surface/border changes, not shadow.

---

## Padding

- `__header`: `var(--orp-space-4)` = 16px
- `__body`: `var(--orp-space-3)` = 12px
- `__footer`: `var(--orp-space-4)` = 16px

Consistent with ORP spacing tokens. Body slightly less than header/footer for visual hierarchy.

---

## Mobile QA

Card is used extensively in Playground at mobile widths. The border-based approach works well at all sizes.

---

## Desktop QA

Card radius (12px) is appropriate for desktop. No giant card issues observed.

---

## Playground

Card is showcased in Playground with:
- Default Card (now with border)
- Outlined Card (redundant but present)
- Interactive Card (now with border hover)
- Card with Header/Body/Footer
- Card with Media

---

## Files Modified

- `resources/less/orp-ui/_card.less` — Added border to default, refined interactive hover
- `resources/less/orp-ui/_content-card.less` — Aligned interactive hover with Card

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
# ✓ built in 26.17s
```

---

## Console

No new errors or warnings.

---

## Final Verdict

```
CARD VISUAL REFINEMENT COMPLETE
```

---

## Next Phase

```
NEXT PHASE:
ORP VISUAL PILOT REDESIGN — CatalogCard Collection
```

Card primitive now provides clean visual foundation for patterns to extend.

---

## Variant Decisions Summary

| Variant | Decision | Reason |
|---------|----------|--------|
| Default | REFINE | Added border for visibility |
| Interactive | REFINE | Changed from translateY+shadow to border/surface |
| Outlined | MERGE | Redundant with Default (both now have border) |
| Raised | KEEP | For elevation use cases |
| Header/Body/Footer | KEEP | Useful structural anatomy |
| Media | KEEP | Useful for image/video composition |
