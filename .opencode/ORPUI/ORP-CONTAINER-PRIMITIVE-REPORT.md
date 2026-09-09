# ORP Container Primitive Report

## Executive Summary

**Container primitive already exists in ORP.** The existing `.orp-page-content` with its variants provides the Container functionality that this phase was meant to evaluate.

---

## Existing Layout Primitive Inventory

| Primitive | File | Status |
|----------|------|--------|
| Stack | `components/_stack.less` | Existing |
| Cluster | `components/_cluster.less` | Existing |
| Grid | `_grid.less` | Existing |
| Section | `components/_section.less` | Existing |
| Page Content | `layout/_page-content.less` | Existing - Container equivalent |
| Card | `_card.less` | Existing |
| Divider | `components/_divider.less` | Existing |
| Media | `components/_media.less` | Existing |

---

## Horizontal Spacing Ownership Audit

| Concept | Existing | Owner | Token |
|---------|---------|-------|-------|
| Page gutter | `.orp-page-content` | `_page-content.less` | `--orp-page-padding` |
| Max content width | `.orp-page-content--contained` | `_page-content.less` | `--orp-content-max-width` |
| Centering | `margin-inline: auto` | `_page-content.less` | N/A |
| Fluid variant | `.orp-page-content--fluid` | `_page-content.less` | N/A |
| Breakpoints | `@orp-breakpoint-*` | `_breakpoints.less` | N/A |

---

## Discovery Matrix

| Concept | Existing solution | Files | Contexts | Problem | Decision |
|---------|-----------------|-------|----------|---------|----------|
| Page gutter | `.orp-page-content` + `--orp-page-padding` | `_page-content.less` | Many | None | REUSE |
| Max content width | `.orp-page-content--contained` + `--orp-content-max-width` | `_page-content.less` | Many | None | REUSE |
| Centering | `margin-inline: auto` | `_page-content.less` | Many | None | REUSE |
| Narrow content | Prose max-width | `_prose.less` | Some | None | REUSE |
| Full-width content | `.orp-page-content--fluid` | `_page-content.less` | Some | None | REUSE |
| Section horizontal padding | None - Section owns vertical only | `components/_section.less` | N/A | None | REUSE |
| Local wrappers | None found | N/A | N/A | None | N/A |

---

## Container Acceptance Test Results

| Test | Result |
|------|--------|
| Domain-independent? | Yes |
| Useful across contexts? | Yes - used throughout ORP |
| Owns horizontal page width/gutter? | Yes - via `.orp-page-content` |
| Removes repeated wrapper CSS? | Yes - centralized |
| Distinct from Section? | Yes - horizontal vs vertical |
| Distinct from Grid? | Yes - boundary vs children layout |
| Small API? | Yes - 3 variants |
| Responsive without huge matrix? | Yes - fluid with breakpoints |
| Themeable? | Yes - via tokens |

**Decision: CONTAINER PRIMITIVE ALREADY ADEQUATE**

---

## Existing Container Implementation

### Files

- `resources/less/orp-ui/layout/_page-content.less`
- `resources/less/orp-ui/_variables.less` (tokens)

### API

```less
// Base - mobile-first with padding
.orp-page-content {
    padding-inline: var(--orp-page-padding);  // 16px
    padding-block: var(--orp-space-4);
    width: 100%;
}

// Contained - max-width with centering
.orp-page-content--contained {
    width: min(100%, var(--orp-content-max-width));  // 1200px
    margin-inline: auto;
}

// Fluid - full width
.orp-page-content--fluid {
    max-width: none;
}

// Responsive padding
@media (min-width: @orp-breakpoint-md) {
    .orp-page-content {
        padding-inline: var(--orp-space-5);
    }
}

@media (min-width: @orp-breakpoint-lg) {
    .orp-page-content {
        padding-inline: var(--orp-space-6);
    }
}
```

### Tokens

```less
@orp-page-padding: 16px;
@orp-content-max-width: 1200px;
```

---

## Page Gutter Strategy

ORP uses a responsive page gutter approach:

| Breakpoint | Padding |
|------------|---------|
| Default (mobile) | 16px (`--orp-page-padding`) |
| md (768px+) | 24px (`--orp-space-5`) |
| lg (992px+) | 32px (`--orp-space-6`) |

This provides:
- Usable content at 320-430px
- Increasing gutters as viewport grows
- Content never exceeds 1200px when constrained

---

## Max Width Strategy

The `--orp-content-max-width: 1200px` token controls maximum content width.

This is used by:
- `.orp-page-content--contained`
- Grid (implicitly through the system)

---

## Container vs Section

| Aspect | Container | Section |
|--------|----------|---------|
| Responsibility | Horizontal page boundary | Vertical chapter rhythm |
| Owns horizontal padding | Yes | No |
| Owns max-width | Yes | No |
| Owns vertical spacing | No | Yes |
| Composes with | Grid, Stack, Card | Container |

**Composition:**
```html
<section class="orp-section">
    <div class="orp-page-content orp-page-content--contained">
        <!-- content -->
    </div>
</section>
```

---

## Container vs Grid

| Aspect | Container | Grid |
|--------|----------|------|
| Responsibility | Page boundary | Children layout |
| Controls | Horizontal viewport | Internal arrangement |
| Composes | Contains Grid | Contained by Container |

**Composition:**
```html
<div class="orp-page-content--contained">
    <div class="orp-grid orp-grid--auto-md">
        <!-- items -->
    </div>
</div>
```

---

## Container vs Stack / Cluster

| Aspect | Container | Stack/Cluster |
|--------|----------|---------------|
| Responsibility | Page boundary | Internal relationships |
| Controls | Horizontal viewport | Vertical/inline spacing |
| Composes | Contains layout primitives | Contained by Container |

---

## Container vs Card

Container should never be replaced by Card for page width control.

Card is for discrete content objects; Container is for page boundaries.

---

## Full-Bleed Composition

ORP supports full-bleed sections with constrained content:

```html
<section class="orp-section orp-surface">
    <div class="orp-page-content orp-page-content--contained">
        <!-- Constrained content inside full-bleed surface -->
    </div>
</section>
```

---

## Nested Container Behavior

Nesting `.orp-page-content` should be avoided unless explicit reason exists. The base class does not constrain width; only `--contained` variant does.

---

## Variants Considered

| Variant | Decision | Reason |
|---------|----------|--------|
| Default | Implemented | Base behavior with responsive padding |
| Contained | Implemented | Max-width with centering |
| Fluid | Implemented | Full viewport width |
| Narrow | DEFERRED | Not evidenced - use prose for measure |
| Wide | DEFERRED | Not evidenced |

---

## Variants Implemented

None - existing solutions adequate.

---

## Variants Rejected

| Variant | Reason |
|---------|--------|
| container-xs/sm/md/lg/xl/xxl | Bootstrap clone - not needed |
| container-fluid | Already exists as `--fluid` variant |

---

## Token Usage

All Container functionality uses ORP tokens:

| Token | Usage |
|-------|-------|
| `--orp-page-padding` | Mobile page gutter |
| `--orp-content-max-width` | Constrained max width |
| `--orp-space-4`, `--orp-space-5`, `--orp-space-6` | Responsive padding |
| `@orp-breakpoint-md`, `@orp-breakpoint-lg` | Responsive breakpoints |

---

## Hardcoded Values

No hardcoded values in Container implementation.

---

## Playground Coverage

Existing Playground already demonstrates Page Content variants:

- App Shell with page content
- Page Content section showing `default`, `--contained`, `--fluid`
- Responsive behavior documented

---

## Mobile QA

At 320px:
- 16px gutter on each side leaves 288px content width
- Adequate for most content

At 375px:
- 16px gutter on each side leaves 343px content width
- Comfortable

---

## Desktop QA

At 1440px:
- Max width 1200px centers with 120px gutters on each side
- Content feels intentional, not stretched

---

## Accessibility

- Container has no ARIA requirements
- Semantic HTML should be used (main, section, etc.)
- Focus rings preserved

---

## Tests

No new tests needed. Build passes.

---

## Build

```bash
npm run build
```

**Result:** ✓ built in 23.29s - PASS

---

## Files Created

None - existing solutions adequate.

---

## Files Modified

None.

---

## Compatibility / Migration Notes

No migration needed. Existing `.orp-page-content` is the Container primitive.

---

## Deferred Findings

None.

---

## Final Primitive Architecture

```
ORP Primitives / Primary
├── Stack
├── Cluster
├── Grid
├── Container         ← Already exists as .orp-page-content
├── Section
├── Card
├── Divider
└── [Surface]        ← Not justified (previous audit)
```

---

## Verdict

```
CONTAINER PRIMITIVE ALREADY ADEQUATE
```

The existing `.orp-page-content` primitive in `layout/_page-content.less` provides Container functionality with:
- Responsive page gutters via `--orp-page-padding`
- Max-width constraint via `--orp-content-max-width`
- Centering via `margin-inline: auto`
- Fluid variant via `--fluid` modifier
- Mobile-first responsive behavior

---

## Next Recommended Phase

Based on previous audits:

**MEDIA CAPABILITY AUDIT**

Evaluate whether existing Media primitive adequately handles:
- Aspect ratio
- Object-fit
- Responsive media
- Placeholders/fallbacks
- Overlays
- Captions relationship
- Loading states
- Media composition

Do NOT perform Media audit now. This is the recommended next phase after Container.
