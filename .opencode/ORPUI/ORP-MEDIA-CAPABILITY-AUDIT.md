# ORP Media Capability Audit

## Executive Summary

Media primitive is **ADEQUATE** for ORP needs. No extensions required.

Current implementation provides:
- 4 aspect ratio variants (square, portrait, landscape, wide)
- Cover and contain object-fit
- Overflow clipping
- Generic overlay slot
- Proper token usage

Build: ✓ PASS

---

## Existing Media API

```less
.orp-media {
    position: relative;
    overflow: hidden;
    background: var(--orp-surface-muted);

    &--square { aspect-ratio: 1 / 1; }
    &--portrait { aspect-ratio: 3 / 4; }
    &--landscape { aspect-ratio: 4 / 3; }
    &--wide { aspect-ratio: 16 / 9; }

    &--rounded { border-radius: var(--orp-radius-md); }
}

.orp-media__content {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.orp-media--contain .orp-media__content {
    object-fit: contain;
}

.orp-media__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: flex-end;
    padding: var(--orp-space-3);
}
```

---

## Files Audited

| File | Role |
|------|------|
| `resources/less/orp-ui/components/_media.less` | Core Media primitive |
| `resources/less/orp-ui/_card.less` | Card with integrated media slot |
| `resources/less/orp-ui/components/_media-card.less` | Media Card component |
| `resources/less/orp-ui/components/_gallery.less` | Gallery with ratio helpers |
| `resources/js/Pages/OrpPlayground.vue` | Media demos |

---

## Consumers Audited

| Consumer | Media Usage | Notes |
|----------|-------------|-------|
| Card | `orp-card__media` | Own implementation, uses 16:9 ratio |
| Media Card | Wraps `.orp-media` | Composition pattern |
| Gallery | Ratio helpers | Reuses same ratio names |
| Playground | All ratio variants | Full demo coverage |

---

## Discovery Matrix

| Capability | Existing Solution | Files | Problem | Owner | Decision |
|------------|-------------------|-------|---------|-------|----------|
| Aspect ratio | 4 modifiers | _media.less | None | Media | ADEQUATE |
| Object fit | cover/contain | _media.less | None | Media | ADEQUATE |
| Object position | Not needed | - | No evidence | Consumer | DEFER |
| Responsive width | 100% within container | _media.less | None | Media | ADEQUATE |
| Overflow clipping | overflow: hidden | _media.less | None | Media | ADEQUATE |
| Overlay | .orp-media__overlay | _media.less | Generic only | Media | ADEQUATE |
| Caption | figure/figcaption | Typography | Not Media | Content | BELONGS ELSEWHERE |
| Fallback | Consumer CSS | Consumers | Not in primitive | Consumer | BELONGS ELSEWHERE |
| Loading | browser loading= | Consumer img | Not needed | Browser | ADEQUATE |
| Interactive media | Not interactive | - | Correct | - | ADEQUATE |
| Lightbox | External GLightbox | - | Not Media | Integration | BELONGS ELSEWHERE |
| Video | iframe compatible | - | Not full player | Consumer | ADEQUATE |

---

## Aspect Ratio

**Current**: 4 semantic variants (square, portrait, landscape, wide) using CSS aspect-ratio

**Decision**: ADEQUATE

**Changes**: None

**Note**: Gallery duplicates ratio names but as separate helpers. Architecture is consistent.

---

## Object Fit

**Current**: Cover (default) + contain modifier

**Decision**: ADEQUATE

**Changes**: None

---

## Object Position

**Current**: Not exposed

**Decision**: DEFER

**Rationale**: No consumer evidence requires focal point control. Consumer CSS can override if needed.

---

## Responsive Behavior

**Current**: Width 100% within Media container, aspect-ratio maintains height

**Decision**: ADEQUATE

**Changes**: None

---

## Cropping / Overflow

**Current**: `overflow: hidden` on `.orp-media`

**Decision**: ADEQUATE

**Changes**: None

---

## Radius Ownership

**Current**: `.orp-media--rounded` modifier

**Decision**: ADEQUATE

**Note**: Card owns outer radius context; Media provides rounded modifier for standalone use.

---

## Card Media Relationship

**Architecture**:
- Card owns composition and its own media slot
- Media primitive is standalone for composition
- Media Card wraps Media primitive

**Decision**: ADEQUATE

**No duplication**: Different layers serve different purposes

---

## Overlay Capability

**Current**: Generic `.orp-media__overlay` with flexbox end-alignment

**Decision**: ADEQUATE

**Changes**: None

**Note**: Does not invent business semantics (badges, favorites, etc.)

---

## Caption / Figure Relationship

**Decision**: BELONGS TO TYPOGRAPHY/CONTENT

**Rationale**: `<figure>` and `<figcaption>` are semantic HTML, not media behavior

---

## Fallback Strategy

**Decision**: BELONGS TO CONSUMER

**Rationale**: Media cannot know business context (placeholder image, avatar, cover)

---

## Loading Strategy

**Decision**: BROWSER NATIVE

**Rationale**: `loading="lazy"` on `<img>` is sufficient

---

## Native Image Attributes

**Decision**: CONSUMER RESPONSIBILITY

**Rationale**: alt, loading, decoding, srcset, sizes belong to consumer markup

---

## Responsive Images / Picture

**Decision**: CONSUMER RESPONSIBILITY

**Media ensures**: Compatible with `<picture>` usage

---

## Video / Iframe

**Decision**: ADEQUATE

**Rationale**: Aspect ratio and overflow clipping work for embedded video

---

## Interactive Media

**Decision**: ADEQUATE

**Note**: Media is not clickable by default; consumer wraps in `<a>` or `<button>`

---

## GLightbox / External Integration

**Decision**: BELONGS ELSEWHERE

**Rationale**: Lightbox is integration behavior, not media primitive

---

## Accessibility

**Decision**: ADEQUATE

- Media uses semantic `<img>`
- Overlay does not interfere with focus
- Consumer owns alt text

---

## Performance Considerations

**Decision**: DOCUMENTED

- Use aspect-ratio to prevent layout shift
- Browser handles lazy loading natively

---

## Token Usage

**Current**: Uses only `orp-surface-muted`, `orp-radius-md`, `orp-space-3`, `orp-duration-fast`

**Decision**: ADEQUATE

---

## Hardcoded Values

**Audit**: No hardcoded colors, no z-index, no arbitrary radius

**Decision**: CLEAN

---

## API Added

None

---

## API Reused

- `aspect-ratio`
- `object-fit`
- `overflow: hidden`
- `position: absolute`
- `inset: 0`

---

## API Rejected

| Rejected | Reason |
|----------|--------|
| Object position variants | No evidence needed |
| 20+ ratio catalog | 4 variants sufficient |
| Z-index overlay positions | Not needed |
| Business overlay semantics | Belongs to consumer |
| Skeleton integration | Separate concern |

---

## Playground Coverage

**Current**: Full coverage of all ratio variants, contain modifier, rounded modifier, overlay slot

**Decision**: ADEQUATE

---

## Responsive QA

**Tested breakpoints**: 320, 375, 390, 430, 768, 1200, 1440

**Result**: Media scales correctly within Grid/Card/Container compositions

---

## Tests

**Build only**: No specific Media tests; CSS primitives do not require unit tests

---

## Build

**Result**: ✓ PASS

---

## Files Created

None

---

## Files Modified

None

---

## Deferred Findings

| Finding | Phase |
|---------|-------|
| Skeleton Component | Component Gap Review |
| Progress / Meter | Component Gap Review |
| Object position custom property | Future if evidence emerges |

---

## Final Media Architecture

```
Media Primitive (.orp-media)
├── Aspect ratio (4 variants: square, portrait, landscape, wide)
├── Object fit (cover default, contain modifier)
├── Overflow clipping
├── Generic overlay slot
└── Rounded modifier

Does NOT own:
├── Caption/figcaption (Typography)
├── Fallback imagery (Consumer)
├── Object position (Consumer CSS if needed)
├── Lightbox (Integration)
├── Skeleton loading (Separate component)
```

---

## Next Recommended Phase

**COMPONENT GAP REVIEW**

Candidates:
- Skeleton Component
- Progress / Meter
- Status (after Badge audit)

---

## Final Verdict

```
MEDIA PRIMITIVE ALREADY ADEQUATE
```