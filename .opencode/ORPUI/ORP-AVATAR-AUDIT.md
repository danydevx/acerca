# ORP Avatar Primitive Audit

## Executive Summary

Audit of ORP Avatar component completed. Avatar provides a clean, generic identity primitive with appropriate sizes, image handling, initials fallback, and status overlay capability. The component handles its responsibilities without overreaching into business logic.

**Finding**: AVATAR ALREADY ADEQUATE

**No changes required.**

---

## Existing API

```text
.orp-avatar                     Base avatar (circle, sm md lg xl)
.orp-avatar--sm               32px
.orp-avatar--md               40px (default)
.orp-avatar--lg               56px
.orp-avatar--xl              72px
.orp-avatar__image            Image with object-fit: cover
.orp-avatar__fallback         Initials/text fallback
.orp-avatar__status           Presence indicator overlay
.orp-avatar__status--online   Green dot
.orp-avatar__status--offline  Gray dot
.orp-avatar__status--busy     Red dot

AvatarGroup:
.orp-avatar-group              Horizontal flex container
.orp-avatar-group__item       Stacked avatar with border
.orp-avatar-group__overflow    Count overflow indicator
.orp-avatar-group--sm         Small size variant
.orp-avatar-group--md         Medium size variant
.orp-avatar-group--lg         Large size variant

AvatarUpload:
.orp-avatar-upload            Upload composition wrapper
.orp-avatar-upload__actions   Action buttons
.orp-avatar-upload__info      Status text
```

---

## Capability Matrix

| Capability | Exists | Visual Purpose | Decision |
|------------|--------|----------------|----------|
| Base Avatar | ✓ | Identity container | KEEP |
| Size sm | ✓ | 32px compact | KEEP |
| Size md | ✓ | 40px default | KEEP |
| Size lg | ✓ | 56px prominent | KEEP |
| Size xl | ✓ | 72px large | KEEP |
| Image | ✓ | Photo display | KEEP |
| Fallback | ✓ | Initials/text | KEEP |
| Status overlay | ✓ | Presence indicator | KEEP |
| AvatarGroup | ✓ | Grouped avatars | KEEP |
| AvatarUpload | ✓ | Upload composition | KEEP |

---

## Audit Findings

### Are sizes sufficient?

**Finding**: Yes. 4 sizes (sm:32px, md:40px, lg:56px, xl:72px) cover the range from compact lists to prominent profile displays.

**Decision**: KEEP current sizes.

---

### Is fallback behavior generic?

**Finding**: Yes. The `__fallback` element accepts any content (initials, icons, text). Consumer provides the fallback content.

**Decision**: KEEP.

---

### Are initials supported/needed?

**Finding**: Yes. `__fallback` uses uppercase text-transform for initials. Example from Playground: `<span class="orp-avatar__fallback">DL</span>`.

**Decision**: KEEP.

---

### Is icon fallback supported/needed?

**Finding**: Yes. The fallback slot can contain icons. Example from Playground: `<span class="orp-avatar__fallback">SM</span>` for text, but consumer can use icons.

**Decision**: KEEP.

---

### Is image fit correct?

**Finding**: Yes. `object-fit: cover` ensures images fill the circle without distortion.

**Decision**: KEEP.

---

### Is radius hardcoded?

**Finding**: Yes. `border-radius: 50%` is hardcoded for circle shape. This is intentional and correct for avatars.

**Decision**: ACCEPT (circle is correct for avatars).

---

### Are decorative rings/borders overused?

**Finding**: No. AvatarGroup uses `border: 2px solid var(--orp-surface)` to create visual separation between stacked avatars. This is functional, not decorative.

**Decision**: KEEP.

---

### Does Avatar need status/presence overlay?

**Finding**: Avatar already HAS a status overlay (`__status`) with online/offline/busy states. This is used in Playground for presence indication.

**Decision**: KEEP existing status overlay.

---

### Would status overlay duplicate Badge?

**Finding**: No. The status overlay is geometrically positioned on the avatar (bottom-right corner), providing presence indication that cannot be replicated by Badge. Badge provides text labels for states; Avatar status provides visual presence signals.

**Decision**: NOT a duplicate. Both have distinct roles.

---

### Are loading/error states application-owned?

**Finding**: Yes. Avatar itself doesn't own loading/error states. AvatarUpload demonstrates an upload pattern with loading spinner, but Avatar component remains stateless.

**Decision**: KEEP application-owned.

---

## Responsibility Boundaries

**Avatar owns:**
- Circle shape
- Image containment with object-fit
- Fallback presentation (consumer provides content)
- Size variants
- Status overlay positioning

**Avatar does NOT own:**
- Profile business data
- Social links
- Presence system logic
- User fetching
- Upload behavior
- Crop editor

---

## AvatarGroup

AvatarGroup provides stacked avatar display with:
- Negative margin for overlap
- Surface border for separation
- Overflow indicator for "+N" count

Used in Playground for team/group displays.

---

## AvatarUpload

AvatarUpload is a composition wrapper for avatar change workflows:
- Shows current avatar
- Upload action
- Loading state during upload

This is a consumer-owned pattern, not Avatar primitive responsibility.

---

## Bootstrap Resemblance

| Component | Score | Explanation |
|----------|-------|-------------|
| Avatar | 0/3 | Generic identity primitive, no Bootstrap resemblance |
| AvatarGroup | 0/3 | Standard grouping pattern, not Bootstrap-specific |
| **Overall** | **0/3** | Clean identity primitives |

---

## Accessibility

- Images use `alt` attribute (consumer responsibility)
- Fallback text is meaningful
- Status overlay is purely visual (presence indicator)
- No automatic aria labeling

---

## Playground

Avatar is showcased with:
- All sizes (sm, md, lg, xl)
- Image avatars
- Initials avatars
- Status overlay (online, offline, busy)
- AvatarGroup (sm, md, lg variants)
- AvatarUpload with loading state

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
# ✓ built in 22.18s
```

---

## Console

No new errors or warnings.

---

## Files Modified

None. Avatar is already adequate.

---

## Final Verdict

```
AVATAR ALREADY ADEQUATE
```

---

## Variant Decisions Summary

| Variant | Decision | Reason |
|---------|----------|--------|
| Sizes (sm/md/lg/xl) | KEEP | Appropriate range |
| Image handling | KEEP | Correct object-fit |
| Fallback | KEEP | Generic content slot |
| Status overlay | KEEP | Geometric presence, not duplicate Badge |
| AvatarGroup | KEEP | Useful grouping pattern |
| AvatarUpload | KEEP | Consumer composition |
| Additional sizes | REJECT | Current range is sufficient |
| Icon prop | REJECT | Fallback slot handles this |
