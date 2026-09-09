# ORP Media Primitive Visual Audit

## Executive Summary

Audit of ORP Media primitive completed. Media provides a clean, minimal set of aspect ratio options, cover/contain behavior, and overlay capability. The component is lightweight (36 lines) and handles its responsibilities without overreaching.

**Finding**: MEDIA REMAINS ADEQUATE

**No changes required.**

---

## Existing API

```text
.orp-media                         Base media container
.orp-media--square               1:1 aspect ratio
.orp-media--portrait             3:4 aspect ratio
.orp-media--landscape            4:3 aspect ratio
.orp-media--wide                 16:9 aspect ratio
.orp-media--rounded              Optional border-radius
.orp-media__content              Image/video element (object-fit: cover)
.orp-media--contain              Contain mode modifier
.orp-media__overlay             Overlay slot for captions
```

---

## Capability Matrix

| Capability | Exists | Visual Purpose | Decision |
|------------|--------|----------------|----------|
| Square ratio | ✓ | 1:1 thumbnails | KEEP |
| Portrait ratio | ✓ | 3:4 images | KEEP |
| Landscape ratio | ✓ | 4:3 images | KEEP |
| Wide ratio | ✓ | 16:9 videos | KEEP |
| Cover fit | ✓ | Default fill | KEEP |
| Contain fit | ✓ | Letterbox option | KEEP |
| Rounded | ✓ | Optional radius | KEEP |
| Overlay | ✓ | Caption overlay | KEEP |
| Custom ratio | ~ | Escape hatch | N/A |

---

## Audit Findings

### Are available ratios sufficient?

**Finding**: Yes. Square (1:1), Portrait (3:4), Landscape (4:3), Wide (16:9) cover the common use cases for thumbnails, photos, and video.

**Decision**: KEEP.

---

### Is there a custom-property escape hatch?

**Finding**: Consumers can compose their own ratio using standard CSS `aspect-ratio`. Media provides the common cases; custom is consumer's responsibility.

**Decision**: ACCEPT.

---

### Are cover/contain clear?

**Finding**: Yes. Default is `cover` (fill area, crop if needed). `--contain` modifier provides letterbox behavior.

**Decision**: KEEP.

---

### Is object-position needed?

**Finding**: Consumer can apply `object-position` directly to `__content`. Not a built-in variant.

**Decision**: ACCEPT (consumer-owned).

---

### Is overlay generic?

**Finding**: Yes. `__overlay` provides a positioned slot at the bottom of the media for captions. No product-specific actions.

**Decision**: KEEP.

---

### Is radius owned correctly?

**Finding**: Yes. `orp-media--rounded` applies optional `border-radius`. Consumer chooses when to apply. Media doesn't force radius.

**Decision**: KEEP.

---

### Does Media add decorative chrome by default?

**Finding**: No. Media is just a container with overflow hidden and background. No borders, shadows, or decorative elements.

**Decision**: KEEP.

---

### Can Media be edge-to-edge inside Card?

**Finding**: Yes. Since Media doesn't force its own radius, it can be placed edge-to-edge inside a Card and let the Card provide the radius through `overflow: hidden`.

**Decision**: KEEP.

---

### Are responsive images semantically consumer-owned?

**Finding**: Yes. `srcset`, `loading="lazy"`, `alt` are consumer responsibilities.

**Decision**: ACCEPT.

---

### Are captions duplicated with Typography?

**Finding**: No. Media's `__overlay` is a visual overlay slot. For semantic captions, Typography's `figure`/`figcaption` is recommended. These serve different purposes.

**Decision**: NO DUPLICATION.

---

## Card vs Media

**Finding**: Card has its own `__media` with hardcoded 16:9 ratio, while standalone Media provides ratio options.

**Decision**: Both can coexist. Card `__media` is for inline card media. Media component is for standalone media composition.

---

## Bootstrap Resemblance

| Aspect | Score | Explanation |
|--------|-------|-------------|
| Overall | 0/3 | Clean, generic media primitive |

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
# ✓ built in 22.04s
```

---

## Console

No new errors or warnings.

---

## Files Modified

None. Media is already adequate.

---

## Final Verdict

```
MEDIA REMAINS ADEQUATE
```

---

## Variant Decisions Summary

| Variant | Decision | Reason |
|---------|----------|--------|
| Square | KEEP | 1:1 ratio |
| Portrait | KEEP | 3:4 ratio |
| Landscape | KEEP | 4:3 ratio |
| Wide | KEEP | 16:9 ratio |
| Rounded | KEEP | Optional radius |
| Cover | KEEP | Default fill |
| Contain | KEEP | Letterbox option |
| Overlay | KEEP | Caption slot |
| Additional ratios | REJECT | Current set sufficient |
| Custom sizing | ACCEPT | Consumer CSS-owned |
