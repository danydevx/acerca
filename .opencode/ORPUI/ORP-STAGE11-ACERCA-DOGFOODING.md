# ORP UI — Stage 11: Acerca Dogfooding Audit

## Objective

Apply ORP in minisites/vCards/admin and record real gaps.

## Findings Summary

### Minisite Context

ORP components used:
- `orp-btn` (CSS classes)
- `orp-card` (CSS classes)
- `orp-input`, `orp-textarea`, `orp-select` (CSS classes)
- `OrpAccordion`, `OrpModal` (Vue components)
- ORP tokens throughout

**Gaps:**
- `OrpEmptyState` component exists but not used
- `OrpBadge` component exists but not used
- `OrpSpinner` / `OrpSkeleton` not used for loading states
- `OrpNotification` not used for form feedback

### Admin Context

**ORP components used:** Almost NONE (mostly Bootstrap)

**Gaps:**
| Gap | Issue |
|-----|-------|
| Cards | Uses `.card.border-0.shadow-sm` instead of `orp-card` |
| Buttons | Uses `.btn.btn-primary` instead of `orp-btn--primary` |
| Inputs | Uses `.form-control` instead of `orp-input` |
| Badges | Uses `.badge.text-bg-success` instead of `orp-badge--success` |
| Tables | Uses `.table.table-hover` instead of `OrpDataTable` |
| Alerts | Uses `.alert.alert-success` instead of `orp-alert--success` |
| Hardcoded colors | Linear gradients use hex like `#0d6efd` instead of tokens |

### Member Context

**ORP components used:** `orp-btn`, `orp-input`, `orp-textarea`, `orp-select` (CSS classes)

**Gaps:**
| Gap | Issue |
|-----|-------|
| `btn-gradient` | Custom class (60+ uses) not in ORP |
| `OrpEmptyState` | Not used, manual empty markup |
| `OrpBadge` | Not used, uses Bootstrap badges |
| `OrpStatCard` | Not used, custom stat cards |
| `OrpDataTable` | Not used, custom wrapper |
| `OrpNotification` | Not used |
| Hardcoded colors | Same gradient issue as Admin |

## Critical Gap: btn-gradient

The `btn-gradient` class is used extensively (~60+ times) in the Member area but is NOT part of ORP:

```less
// Current custom implementation (admin.less)
.btn-gradient {
    background: linear-gradient(90deg, #0d6efd, #0dcaf0);
    color: white;
    border: none;
}
```

**Options:**
1. Add `orp-btn--gradient` to ORP Button system
2. Replace with existing `orp-btn--primary`

## Migration Recommendations

### Phase 1: New Code
All new code should use ORP components and classes.

### Phase 2: Progressive Migration
Admin/Member areas should migrate progressively:
1. Replace cards → `orp-card`
2. Replace buttons → `orp-btn--*`
3. Replace inputs → `orp-input`
4. Replace badges → `orp-badge--*`
5. Replace alerts → `orp-alert--*`

### Phase 3: Token Adoption
Replace hardcoded colors with ORP tokens.

## Real Gaps for v1

1. **btn-gradient not in ORP** - Need to decide: add to ORP or deprecate
2. **Admin/Member migration** - Significant undertaking, needs dedicated sprint
3. **Component usage** - Many ORP components exist but aren't being used

## Verification

### Build
```
npm run build
✓ built in 21.84s
```

## Final Verdict

**DOGFOODING COMPLETE - GAPS DOCUMENTED**

Real gaps identified:
1. Admin/Member areas not using ORP (migration needed)
2. btn-gradient custom class needs ORP integration
3. Existing ORP components not being used in minisites

**Recommendation for v1**: Focus on ORP readiness for new development. Migration of existing Admin/Member to ORP is a separate initiative.
