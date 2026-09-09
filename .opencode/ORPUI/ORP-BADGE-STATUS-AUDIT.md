# ORP Badge / Status Capability Audit

## Executive Summary

Audit of ORP Badge component completed. Badge provides a clean, minimal set of variants that cover both visual hierarchy (primary, secondary) and semantic state (success, warning, danger, info). All badges are pill-shaped which is appropriate for ORP's visual language. Primary badge had a redundant border that has been removed.

**Finding**: BADGE ALREADY COVERS STATUS

**Changes Applied:**
- Removed redundant border from `--primary` variant (soft bg already differentiates it)

**Result**: BADGE REFINED

---

## Existing API

```text
.orp-badge                     Base badge (pill, xs font, nowrap)
.orp-badge--primary           Soft indigo bg + indigo text (REFINED: removed border)
.orp-badge--secondary         Solid muted bg + dark text
.orp-badge--success           Soft green bg + green text + green border
.orp-badge--warning           Soft yellow bg + yellow text + yellow border
.orp-badge--danger            Soft red bg + red text + red border
.orp-badge--info              Soft blue bg + blue text + blue border
.orp-badge--outline           Transparent bg + gray border + dark text
.orp-badge--solid             Solid muted bg + muted text
```

---

## Capability Matrix

| Capability | Exists | Visual Purpose | Semantic? | Decision |
|------------|--------|----------------|-----------|----------|
| Primary | ✓ | Visual emphasis (brand) | No | KEEP (refined) |
| Secondary | ✓ | Quiet label | No | KEEP |
| Success | ✓ | Positive state | Yes | KEEP |
| Warning | ✓ | Warning state | Yes | KEEP |
| Danger | ✓ | Error/danger state | Yes | KEEP |
| Info | ✓ | Informational state | Yes | KEEP |
| Outline | ✓ | Metadata/category | No | KEEP |
| Solid | ✓ | Neutral/dimmed | No | KEEP |
| Icon + label | Via composition | Consumer-owned | N/A | KEEP |
| Status dot | ✗ | N/A | N/A | NOT NEEDED |

---

## Audit Findings

### Too pill-like?

**Finding**: All badges use `border-radius: var(--orp-radius-pill)` (999px).

**Decision**: Acceptable. Pill shape is consistent with ORP's soft, modern visual language. Not an issue.

---

### Semantic colors too saturated?

**Finding**: Semantic variants use soft backgrounds (`*-soft` tokens) with colored text.

- `--success`: `orp-success-soft` (#f0fdf4) bg + `#16a34a` text
- `--warning`: `orp-warning-soft` (#fffbeb) bg + `#d97706` text
- `--danger`: `orp-danger-soft` (#fef2f2) bg + `#dc2626` text
- `--info`: `orp-info-soft` (#f0f9ff) bg + `#0284c7` text

**Decision**: NOT too saturated. Soft backgrounds provide good contrast while remaining accessible. Color is not the only signal - text labels like "Active", "Warning", "Error" accompany the colors.

---

### Is outline useful?

**Finding**: Yes. Used in Playground for metadata:
- Time: "45 min", "60 min"
- Category: "Italian", "$$", "4.5 ★"
- Type: "Artículo", "Pro", "Featured"

**Decision**: KEEP. Outline provides quiet, non-semantic labeling.

---

### Is primary being overused?

**Finding**: Yes, in Playground primary is used for many non-state purposes:
- "Featured", "Best seller", "Premium", "Recommended", "Popular"
- Category labels: "Tecnología", "Artículo", "Podcast", "DevOps"

**Decision**: This is a usage problem, not a Badge problem. Primary badge is appropriate for brand-emphasized labels. Consumers should choose appropriately.

---

### Is there a neutral/default badge?

**Finding**: `--secondary` provides neutral appearance (solid gray bg).

**Decision**: Secondary serves as neutral badge. However, `--outline` and `--solid` also provide quiet alternatives for different visual weights.

---

### Icon + label combinations clean?

**Finding**: Badges are text-only. Consumers compose icon + label manually using flex layout.

**Decision**: KEEP as-is. No prop explosion needed. Consumers use `<span class="orp-badge">icon label</span>` or flex containers.

---

### Status dots being reinvented locally?

**Finding**: No. Badge handles state representation. Playground uses text badges like "Active", "Abierto", "Healthy" rather than dots.

**Decision**: No separate StatusDot component needed.

---

### Does Badge look like mini Button?

**Finding**: No. Differences:
- Badge uses `orp-radius-pill` (999px), Button uses `orp-radius-md` (8px)
- Badge padding is smaller (2px 8px)
- Badge has no active/pressed states

**Decision**: Badge and Button are visually distinct.

---

### Are sizes needed?

**Finding**: Single size works. Playground uses inline `style="font-size: 0.65rem"` for exceptions.

**Decision**: No separate size variants needed. Single compact size is appropriate for badges.

---

### Text truncation appropriate?

**Finding**: Badge uses `white-space: nowrap` to prevent text wrapping within the pill.

**Decision**: Correct behavior for badges. Consumers requiring truncation should use different components.

---

## Semantic vs Visual Intent

**Visual Variants** (express emphasis, not state):
- Primary: brand emphasis
- Secondary: quiet/neutral
- Outline: metadata/category
- Solid: dimmed/neutral

**Semantic Variants** (express state):
- Success: positive/complete
- Warning: caution
- Danger: error/critical
- Info: informational

---

## Status Representation

**Question**: Does Badge cover status?

**Answer**: YES. Semantic variants (success, warning, danger, info) cover state representation. Text labels accompany colors to ensure meaning is not lost for color-blind users or when color is not visible.

---

## Bootstrap Resemblance Before/After

| Variant | Before | After |
|---------|--------|-------|
| Primary | 1/3 | 0/3 (removed redundant border) |
| Semantic variants | 1/3 | 1/3 (soft bg approach is distinct) |
| Outline | 1/3 | 1/3 (standard pattern) |
| **Overall** | **1/3** | **0/3** |

---

## Playground

Badge is showcased with:
- All variants (primary, secondary, success, warning, danger, outline)
- In context: tables, cards, lists, contact info
- Used for: status (Active, Abiertos), metadata (45 min, Italian), categories (Featured, Premium)

---

## Files Modified

- `resources/less/orp-ui/components/_badge.less` — Removed redundant border from primary

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
# ✓ built in 22.61s
```

---

## Console

No new errors or warnings.

---

## Final Verdict

```
BADGE REFINED
```

---

## Status Conclusion

```
STATUS: BADGE ALREADY COVERS STATUS
```

Semantic badge variants (success, warning, danger, info) provide state representation. Text labels accompany colors for accessibility. No separate Status component needed.

---

## Variant Decisions Summary

| Variant | Decision | Reason |
|---------|----------|--------|
| Primary | KEEP (REFINED) | Soft bg sufficient, removed redundant border |
| Secondary | KEEP | Solid muted provides neutral |
| Success | KEEP | Semantic state |
| Warning | KEEP | Semantic state |
| Danger | KEEP | Semantic state |
| Info | KEEP | Semantic state |
| Outline | KEEP | Metadata/category |
| Solid | KEEP | Dimmed/neutral |
| Sizes | REJECT | Single size works |
| StatusDot | REJECT | Not needed |
| Icon props | REJECT | Consumer composition works |
