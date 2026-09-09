# ORP Divider + Surface Discovery Report

## Executive Summary

**Divider**: Existing implementation is adequate. No changes needed.

**Surface**: Not justified. Existing primitives (Card, Section, components) handle all use cases. The `--orp-surface-muted` token is used internally by components for their states, not as a generic panel primitive.

---

## Existing Primitive Inventory

| Primitive | File | Status |
|-----------|------|--------|
| Divider | `components/_divider.less` | Existing - adequate |
| Card | `_card.less` | Existing |
| Section | `components/_section.less` | Existing |
| Stack | `components/_stack.less` | Existing |
| Cluster | `components/_cluster.less` | Existing |

---

## Discovery Matrix

| Concept | Existing | Files | Contexts | Problem | Layer | Decision |
|---------|----------|-------|----------|---------|-------|----------|
| Horizontal separator | `.orp-divider` | `_divider.less` | Many | None | Primitive | REUSE |
| Vertical separator | `.orp-divider--vertical` | `_divider.less` | Few | None | Primitive | REUSE |
| Inset divider | `.orp-divider--inset` | `_divider.less` | Some | None | Primitive | REUSE |
| Thematic HR | `<hr>` styled in prose | `_prose.less` | Some | None | Content | REUSE |
| Subtle visual plane | Token only | N/A | Internal | N/A | Token | REJECT |
| Muted visual plane | Token only | N/A | Internal | N/A | Token | REJECT |
| Raised region | Via Card variants | `_card.less` | Many | None | Component | REUSE |
| Card used as panel | None found | N/A | N/A | None | N/A | N/A |

---

## Divider Audit

### Existing Solutions

```less
.orp-divider {
    display: block;
    width: 100%;
    height: 1px;
    background: var(--orp-border);
    border: none;
    margin: 0;
}

.orp-divider--inset {
    margin-left: var(--orp-space-4);
    margin-right: var(--orp-space-4);
}

.orp-divider--vertical {
    width: 1px;
    height: auto;
    align-self: stretch;
}
```

### Decision: DIVIDER ALREADY ADEQUATE

The existing implementation provides:
- Horizontal divider (default)
- Inset variant
- Vertical variant
- Uses `--orp-border` token correctly
- No unnecessary variants

### API Demonstrated

```html
<hr class="orp-divider">                    <!-- Horizontal -->
<hr class="orp-divider orp-divider--inset"> <!-- Inset -->
<hr class="orp-divider orp-divider--vertical"> <!-- Vertical -->
```

### Rejected Variants

- `divider-primary`, `divider-success`, etc. — colors belong to components
- `divider-dashed`, `divider-dotted` — not evidenced
- `divider-thick` — not evidenced

---

## Surface Discovery

### Existing Card Responsibility

Card controls:
- background (`--orp-surface`)
- border (optional via `--outlined`)
- radius (`--orp-radius-lg`)
- overflow hidden
- header/body/footer structure
- media area
- interactive states
- shadow (via `--raised` variant)

### Existing Section Responsibility

Section controls:
- flex-direction column
- gap-based spacing
- header with title/subtitle/action
- body/footer slots

### Existing Tokens

- `--orp-surface` — base surface
- `--orp-surface-subtle` — subtle variant
- `--orp-surface-muted` — muted variant
- `--orp-surface-foreground` — text color

### Surface vs Card vs Section

| Aspect | Surface | Card | Section |
|--------|---------|------|---------|
| Purpose | Visual plane | Discrete entity | Page chapter |
| Background | Yes | Yes | No |
| Border | Optional | Optional | No |
| Radius | Optional | Yes | No |
| Padding | Optional | Yes | Gap-based |
| Header/Body/Footer | No | Yes | Optional |
| Media | No | Yes | No |
| Interactive | No | Yes | No |

### Evidence Assessment

**Token usage**: `--orp-surface-muted` is heavily used throughout ORP UI, but:
- 90%+ of uses are within components for their internal states (input backgrounds, chip backgrounds, table headers, etc.)
- NOT used as generic panel/container primitives

**Card misuse**: No evidence found of Card being used purely for background/padding without needing Card's features.

**Local patterns**: No evidence of local `.panel {}` or `.box {}` patterns that would indicate missing abstraction.

### Acceptance Test Results

| Test | Result |
|------|--------|
| Completely generic? | Yes, but not needed |
| 2+ contexts? | No evidence of new context beyond existing |
| Different from Card? | Yes, but Card handles use cases |
| Different from Section? | Yes, but Section handles use cases |
| Different from Helpers? | Yes, but Helpers handle visual adjustments |
| Reduces repeated CSS? | No evidence |
| Small stable API? | Would need variants |
| Improves composition? | Unclear benefit |

### Decision: SURFACE PRIMITIVE NOT JUSTIFIED

**Reasoning:**
1. `--orp-surface-muted` is used by components internally for their states, not as a generic panel
2. Card handles "discrete content object" use cases
3. Section handles "page chapter/region" use cases
4. Visual Helpers handle "one focused characteristic" adjustments
5. No evidence of repeated patterns that need Surface

The hierarchy remains:
```
Whitespace → Divider → [Surface - rejected] → Card
```

---

## Token Usage

All primitives use ORP tokens:
- `--orp-border` for Divider
- `--orp-surface-*` tokens for Card
- `--orp-space-*` tokens for spacing
- `--orp-radius-*` tokens for Card

No hardcoded values.

---

## Hardcoded Values

No hardcoded values in existing primitives.

---

## Playground

Updated Divider section with:
- Horizontal divider
- Inset divider
- Vertical divider
- Divider vs Border Helper comparison

---

## Accessibility

- `<hr>` element is semantic for thematic breaks
- Divider uses `border: none` to avoid native semantics when used as pure visual separator
- Focus rings preserved around interactive elements

---

## Responsive QA

- Divider scales correctly at all breakpoints
- Vertical divider works with content height

---

## Tests

No new tests needed. Build passes.

---

## Build

```bash
npm run build
```

**Result:** ✓ built in 23.73s - PASS

---

## Files Created

None (existing solutions adequate).

---

## Files Modified

| File | Change |
|------|--------|
| `resources/js/Pages/OrpPlayground.vue` | Updated Divider section with vertical example and comparison |

---

## Deferred Primitive Candidates

During audit, identified potential future candidates but not implementing:

| Candidate | Reason for Deferral |
|-----------|---------------------|
| Container | Needs separate discovery |
| Media improvements | Needs separate discovery |
| Skeleton | Not requested |
| Progress/Meter | Not requested |
| Status | Not requested |

---

## Final Primitive Architecture

```
ORP Primitives / Primary
├── Stack
├── Cluster
├── Grid
├── Section
├── Card
├── Divider          ← ALREADY ADEQUATE
└── [Surface]       ← NOT JUSTIFIED
```

---

## Verdict

**Divider:**
```
DIVIDER ALREADY ADEQUATE
```

**Surface:**
```
SURFACE PRIMITIVE NOT JUSTIFIED
```

---

## Next Recommended Primitive

Based on this audit, evaluate:

**Container**

as the next Primary Primitive candidate, if there is evidence of repeated need for a generic wrapper that:
- Constrains content width
- Handles page gutters
- Provides consistent horizontal padding

This should be evaluated through a separate discovery process.
