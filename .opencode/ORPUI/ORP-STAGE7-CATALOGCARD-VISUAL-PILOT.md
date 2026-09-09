# ORP UI — Stage 7: CatalogCard Visual Pilot Audit

## Objective

Test ORP 2026 visual identity on a real composition before propagating.

## Visual Identity Assessment

### CatalogCard Implementation

**Structure:**
```html
<OrpCatalogCard>
  <template #media>...</template>
  <template #title>...</template>
  <template #description>...</template>
  <template #meta>...</template>
  <template #value>...</template>
  <template #actions>...</template>
</OrpCatalogCard>
```

**CSS Classes:**
- `.orp-catalog-card` — Base card with surface background, lg radius, border
- `.orp-catalog-card__media` — Media container with aspect-ratio variants
- `.orp-catalog-card__overlay` — Absolute positioned overlay slot
- `.orp-catalog-card__body` — Body with flex column and gap
- `.orp-catalog-card__title` — Title with md size, semibold
- `.orp-catalog-card__description` — Description with sm size, muted
- `.orp-catalog-card__meta` — Meta row with flex wrap
- `.orp-catalog-card__value` — Value section
- `.orp-catalog-card__actions` — Actions row with full-width variant
- `.orp-catalog-card--interactive` — Interactive hover state

### Token Usage

| Token | Usage |
|-------|-------|
| `--orp-surface` | Card background |
| `--orp-radius-lg` | Border radius |
| `--orp-border` | Card border |
| `--orp-border-strong` | Interactive hover border |
| `--orp-space-3` | Overlay position |
| `--orp-space-4` | Body padding |
| `--orp-space-2` | Gap between elements |
| `--orp-font-family` | Typography |
| `--orp-font-size-md` | Title size |
| `--orp-font-size-sm` | Description size |
| `--orp-muted-foreground` | Description color |
| `--orp-surface-foreground` | Title color |

### Visual Direction Validation

**Confirmed Patterns:**
- ✓ Surface-based background (not just white)
- ✓ Consistent border-radius (lg for cards)
- ✓ Token-driven spacing
- ✓ Interactive hover via border change (not shadow/translate)
- ✓ Flex column layout for body
- ✓ Slot-based composition

### Bootstrap Resemblance

**Score: 0/3**

- Visual: Different (surface, lg radius, border)
- Structural: Different (slot-based composition)
- Behavioral: Different (border hover, not shadow)

## PricingCard Comparison

PricingCard follows the same visual direction:
- Same surface background
- Same lg radius
- Same border token
- Same spacing scale
- Same typography tokens

## Propagation Readiness

The visual direction is **READY** to propagate to:

| Pattern | Status |
|---------|--------|
| CatalogCard | ✓ Validated |
| PricingCard | ✓ Consistent |
| ProfileCard | Needs check |
| ContentCard | Needs check |
| StatCard | Needs check |
| ContactCard | Needs check |

## Bootstrap Resemblance

**Score: 0/3**

CatalogCard does not resemble Bootstrap cards.

## Files Assessed

- `resources/js/Components/OrpUI/OrpCatalogCard.vue`
- `resources/less/orp-ui/_catalog-card.less`
- `resources/less/orp-ui/_pricing-card.less`

## Final Verdict

**CATALOGCARD VISUAL PILOT COMPLETE**

Visual direction validated. Ready for propagation to other card patterns in Stage 8.
