# ORP UI — MEDIA CAPABILITY AUDIT
# Primitive capability review
# Run after Container
# Goal: determine whether the existing Media primitive is complete enough for modern ORP composition

## Context

ORP UI already has a Primary / Primitive layer that includes concepts such as:

```text
ORP UI
├── Foundation
│   ├── Tokens
│   ├── Typography
│   ├── Content
│   └── Visual Foundation
│
├── Primitives / Primary
│   ├── Stack
│   ├── Cluster
│   ├── Grid
│   ├── Container
│   ├── Section
│   ├── Divider
│   ├── Surface        ← only if justified previously
│   ├── Card
│   ├── Media          ← THIS PHASE
│   ├── Avatar
│   ├── Badge
│   ├── Price
│   └── List
│
├── Components
└── Patterns
```

ORP already uses media heavily through:

- CatalogCard
- ContentCard
- ProfileCard
- ContactCard
- Cards
- galleries
- hero content
- minisite sections
- maps
- images
- video embeds
- external lightbox integrations

The next phase is NOT to create another Media component blindly.

The objective is to audit the existing Media primitive and determine whether it adequately handles the generic responsibilities ORP needs.

---

# 1. Objective

Evaluate the existing Media primitive against these capability areas:

```text
Aspect Ratio
Object Fit
Responsive Media
Media Cropping
Fallback / Empty State
Overlay Composition
Caption Relationship
Loading State
Image Semantics
Interactive Media
External Integrations
```

Then classify each capability as:

```text
ADEQUATE
EXTEND
DEFER
REJECT
BELONGS ELSEWHERE
```

Only extend Media where evidence justifies it.

A valid final result is:

```text
MEDIA PRIMITIVE ALREADY ADEQUATE
```

Do not change code just to produce activity.

---

# 2. Core Rule

Follow:

```text
DISCOVER
→ INVENTORY
→ CLASSIFY RESPONSIBILITY
→ COMPARE REAL USE CASES
→ EXTEND ONLY GAPS
→ PLAYGROUND
→ VERIFY
→ REPORT
→ STOP
```

Do not begin by adding props or variants.

---

# 3. Media Responsibility

A Media primitive should potentially solve:

```text
visual media container
+
aspect ratio
+
cropping behavior
+
responsive containment
+
generic overlay positioning
```

It should NOT become responsible for:

- product galleries
- service galleries
- avatars
- lightbox business behavior
- CMS sanitization
- image uploads
- asset storage
- backend image processing
- lazy-loading orchestration system
- video player framework
- carousel behavior
- image editor behavior

---

# 4. Mandatory Repository Audit

Inspect the real Media implementation.

Find:

- CSS classes
- Vue components
- LESS files
- props
- slots
- modifiers
- token dependencies
- tests
- docs
- Playground examples

Search for:

```text
orp-media
Media
mediaRatio
aspect-ratio
object-fit
object-position
cover
contain
overflow-hidden
picture
source
img
video
iframe
figcaption
overlay
loading
lazy
placeholder
skeleton
fallback
```

Do not rely on assumed APIs.

---

# 5. Audit Existing Consumers

Inspect actual ORP usage in:

- Card
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard
- other Patterns
- Playground

Then inspect Acerca READ-ONLY for evidence in:

- Hero
- Services
- Products
- Gallery
- Locations
- Reviews
- Packages
- Properties
- Restaurant Menu
- vCards
- profile images
- logos
- cover images

Do NOT modify Acerca.

---

# 6. Required Discovery Matrix

Produce:

| Capability | Existing solution | Files | Used by | Problem | Owner | Decision |
|---|---|---|---|---|---|---|
| Aspect ratio | ? | ? | ? | ? | Media? | ? |
| Object fit | ? | ? | ? | ? | Media? | ? |
| Object position | ? | ? | ? | ? | Media? | ? |
| Responsive width | ? | ? | ? | ? | Media? | ? |
| Overflow clipping | ? | ? | ? | ? | Media? | ? |
| Overlay | ? | ? | ? | ? | Media? | ? |
| Caption | ? | ? | ? | ? | Content/Media? | ? |
| Fallback | ? | ? | ? | ? | Media/Component? | ? |
| Loading | ? | ? | ? | ? | Browser/Skeleton? | ? |
| Interactive media | ? | ? | ? | ? | Consumer? | ? |
| Lightbox | ? | ? | ? | ? | Integration? | ? |
| Video | ? | ? | ? | ? | Media/Consumer? | ? |

Use:

```text
REUSE
EXTEND
CREATE
KEEP LOCAL
DEFER
REJECT
BELONGS ELSEWHERE
```

---

# 7. Aspect Ratio

Audit whether Media already supports predictable aspect ratios.

Potential generic needs:

```text
square
portrait
landscape
wide
custom
```

Do not create these names automatically.

Determine whether ORP should use:

A. semantic variants

or:

B. CSS custom property

or:

C. both

---

# 8. Prefer Small Ratio API

Avoid a giant ratio catalog.

Do NOT create:

```text
ratio-1x1
ratio-4x3
ratio-3x2
ratio-16x9
ratio-21x9
ratio-2x3
ratio-3x4
ratio-9x16
...
```

unless repeated evidence supports it.

A modern ORP primitive may work better with a custom property.

Example conceptually:

```css
--orp-media-ratio: 16 / 9;
```

Do not adopt this blindly; audit first.

---

# 9. Aspect Ratio Ownership

If Media handles visual media ratios well, Visual Helpers should NOT create a parallel aspect-ratio system for media.

Prefer one clear owner.

---

# 10. Object Fit

Audit whether Media controls:

```text
cover
contain
```

Generic media often needs both.

Default should be determined from actual ORP use.

Do not create domain-specific behaviors.

---

# 11. Object Position

Audit whether repeated consumers need:

```text
center
top
bottom
left/right
custom focal point
```

Be conservative.

If arbitrary object position is needed only in application data, consumer CSS/style may be a better owner.

Do not create 20 position modifiers.

---

# 12. Focal Point

If Acerca has image focal-point data or similar, document it as application evidence.

Do NOT add business/data APIs to Media unless the need is generic and stable.

Potentially a CSS custom property could serve as an escape hatch.

But only if justified.

---

# 13. Responsive Media

The primitive should behave predictably across containers.

Audit whether images/media:

- fill their media container
- preserve ratio
- avoid horizontal overflow
- resize with Grid/Card
- work inside narrow mobile cards
- work inside wide layouts

---

# 14. Image Width

Avoid requiring consumers to repeatedly write:

```css
width: 100%;
height: 100%;
display: block;
```

if these are fundamental Media responsibilities.

---

# 15. Media Height

Do not hardcode component-specific heights inside generic Media.

Prefer:

```text
ratio
container sizing
consumer composition
```

over fixed heights.

---

# 16. Overflow Clipping

Media often needs clipping for:

- crop
- radius
- overlay

Audit whether Media owns:

```css
overflow: hidden;
```

If yes, test focus/accessibility implications when media contains interactive descendants.

Do not blindly clip controls.

---

# 17. Radius

Determine who owns corner radius.

Potential models:

```text
Card owns outer shape
Media inherits/clips appropriately
```

or:

```text
Media owns generic media radius
```

Avoid duplicate radius responsibility.

Do not create a large Media-specific radius API.

---

# 18. Card Media Relationship

Audit `.orp-card__media` and generic Media.

Determine whether:

```text
Card media slot/style
```

and:

```text
Media primitive
```

duplicate responsibilities.

This is important.

Document:

```text
Card owns composition position
Media owns media behavior
```

if that is the intended architecture.

---

# 19. Overlay Composition

Audit repeated overlay needs:

- Badge over image
- Icon action over image
- status
- gradient/readability layer
- label
- favorite action
- play button

Media may need a generic overlay region.

But do not create business semantics.

---

# 20. Overlay Must Remain Generic

Acceptable concept:

```html
<div class="orp-media">
    <img ...>

    <div class="orp-media__overlay">
        ...
    </div>
</div>
```

Potentially.

Not acceptable:

```text
orp-media__sale-badge
orp-media__favorite
orp-media__stock
orp-media__product-actions
```

---

# 21. Overlay Position API

Avoid creating a huge matrix:

```text
top-left
top-center
top-right
center-left
center
center-right
bottom-left
bottom-center
bottom-right
```

without evidence.

If positioning is repeatedly needed, choose the smallest useful strategy.

Could be composition via Cluster/Stack or a small token/custom property.

Audit first.

---

# 22. Gradient Overlay

Do not add a decorative gradient overlay by default.

Only add a generic readability layer if multiple real contexts need text over imagery.

Even then, ensure it is optional.

---

# 23. Caption

Determine whether captions belong to:

```text
Media
```

or semantic content:

```html
<figure>
    <img>
    <figcaption>
```

Typography & Content primitives may already solve this.

Do not create a competing caption system.

---

# 24. Figure / Figcaption

Audit whether ORP already styles:

```text
figure
figcaption
```

inside `.orp-prose` or Typography & Content.

If yes:

REUSE.

Media should not duplicate prose semantics.

---

# 25. Caption in UI Cards

A UI card's title/description is NOT automatically a media caption.

Keep these concepts separate.

---

# 26. Fallback / Empty Media

Audit what happens when:

- image URL absent
- image fails
- no profile photo
- no cover
- media slot omitted

Determine whether generic Media should render fallback behavior.

A CSS primitive cannot know whether an image failed.

Do not force Vue simply to create a fallback system unless repeated need strongly justifies it.

---

# 27. Fallback Ownership

Possible owners:

```text
Avatar → avatar fallback
Application → domain fallback image
Pattern → optional media slot
Media → generic visual placeholder only if justified
```

Do not centralize all fallback behavior in Media.

---

# 28. Broken Image

Do not attempt complicated runtime broken-image recovery unless ORP actually needs it.

A primitive should not become an asset management framework.

---

# 29. Loading

Audit current use of:

```html
loading="lazy"
```

This is normally a consumer/image attribute responsibility.

Do not create a Media JS lazy-loader if the browser already solves it.

---

# 30. Skeleton Relationship

If loading placeholders are needed:

document as evidence for the future:

```text
Skeleton Component
```

Do not embed an entire Skeleton system into Media.

---

# 31. Native Image Attributes

Document recommended consumer usage for:

```text
loading
decoding
width
height
srcset
sizes
fetchpriority
```

where relevant.

Do not necessarily abstract native HTML attributes away.

---

# 32. Responsive Images

Audit whether ORP needs to help with:

```html
<picture>
<source>
srcset
sizes
```

Likely these remain consumer/content responsibilities.

Media should not prevent their use.

---

# 33. `<picture>` Compatibility

Ensure Media works when the direct child is:

```html
<picture>
```

rather than only:

```html
<img>
```

if real consumers need it.

---

# 34. Video Compatibility

Audit use of:

```html
video
iframe
```

inside media containers.

Media may support containment generically.

Do NOT create a full video player API.

---

# 35. Embedded Video

If iframe/video is supported, verify:

- responsive dimensions
- aspect ratio
- overflow
- fullscreen
- pointer interaction

Do not break YouTube/Vimeo/etc. even if they are not current ORP dependencies.

---

# 36. External Integrations

Known integrations may include:

- GLightbox
- Leaflet
- Swiper

Media should not absorb their behavior.

Architecture:

```text
Media
→ visual media primitive

GLightbox
→ external interaction integration

Swiper
→ carousel/scroll composition

Leaflet
→ Map component
```

---

# 37. GLightbox

Audit whether Media markup/classes interfere with GLightbox anchors.

Do not build GLightbox directly into Media.

The consumer owns lightbox lifecycle.

---

# 38. Clickable Media

Media itself should NOT be clickable by default.

Interactive semantics belong to:

```text
<a>
<button>
Pattern/component consumer
```

Do not create nested interactive traps.

---

# 39. Media Link Example

Generic composition should remain possible:

```html
<a href="..." class="...">
    <div class="orp-media">
        <img ...>
    </div>
</a>
```

or equivalent accessible structure.

Media should not force anchor semantics.

---

# 40. Alt Text

Media must not invent alt text.

The consumer owns:

```html
alt=""
```

or meaningful alternative text.

Document this.

---

# 41. Decorative Images

Document that decorative imagery should use appropriate empty alt when using `<img>`.

Do not infer semantics from filename/domain.

---

# 42. Background Images

Audit whether Media currently uses CSS background images.

Prefer semantic `<img>` for meaningful content.

Background images may remain valid for decorative cases, but do not make them the default Media API.

---

# 43. Media Queries vs Container Queries

Do not introduce container queries without a concrete need.

Responsive media often works through:

```text
width: 100%
aspect-ratio
object-fit
```

alone.

---

# 44. Media Token Audit

Inspect whether Media uses hardcoded:

- ratios
- radius
- background
- borders
- spacing
- overlays

Move reusable design decisions to existing Foundation tokens where appropriate.

Do not create tokens for every CSS declaration.

---

# 45. Background/Fallback Surface

If Media uses a placeholder background, use ORP surface tokens.

Avoid literal gray values.

---

# 46. Border

Media should not automatically have a border unless there is a clear visual reason.

Border likely belongs to Card/Surface/component context.

---

# 47. Shadow

Media should not have default shadow.

Elevation belongs to the surface containing it or explicit overlay behavior.

---

# 48. Media and Dominant Imagery

ORP's visual direction encourages dominant imagery when media matters.

Audit whether Media allows:

- edge-to-edge imagery
- large image ratios
- horizontal editorial media
- compact thumbnail media

without creating bespoke CSS every time.

---

# 49. Media Must Not Force Card-Like Shape

Do not make every image:

- rounded
- bordered
- shadowed
- inset

by default.

Some compositions need edge-to-edge media.

---

# 50. Media Layout Modes

Audit whether ORP needs structural concepts such as:

```text
block
inline thumbnail
full bleed
```

Be careful: these may belong to Pattern composition rather than Media.

Do not add modes until responsibility is clear.

---

# 51. Profile Images

Avatar owns identity imagery.

Do not extend Media to replace Avatar.

---

# 52. Gallery Images

Gallery owns collection behavior/layout.

Media may be used for each item.

Do not merge Gallery into Media.

---

# 53. Content Images

Typography/Prose may own spacing/caption around editorial images.

Media may own ratio/crop when intentionally wrapped.

Do not require all prose images to become `.orp-media`.

---

# 54. Map Is Not Media

Do not attempt to use Media for Leaflet maps.

Map remains its own Component.

---

# 55. Required Capability Decisions

The final audit must explicitly decide:

```text
Aspect Ratio
Object Fit
Object Position
Overflow/Cropping
Overlay
Caption
Fallback
Loading
Responsive Images
Video
Interactive Media
External Lightbox Integration
```

No capability may be silently ignored.

---

# 56. API Philosophy

If Media is a CSS primitive, prefer CSS classes/custom properties.

If a Vue component already exists, evaluate whether its API adds real value.

Do not create a second parallel API.

---

# 57. Vue Component Audit

If `OrpMedia.vue` exists, inspect:

- whether it merely renders a wrapper
- whether it adds semantic value
- whether slots are useful
- whether props are generic
- whether props duplicate CSS modifiers
- whether it supports native media composition

Do not rewrite it without evidence.

---

# 58. Prop Explosion Guardrail

Reject APIs like:

```text
src
alt
title
caption
badge
favorite
sale
price
stock
loadingText
fallbackImage
videoUrl
lightbox
gallery
```

for generic Media.

Those mix domain and interaction responsibilities.

---

# 59. Generic Props Only

If Vue Media requires props, likely generic concepts might include:

```text
ratio
fit
position
```

but even these must be justified against CSS classes/custom properties.

---

# 60. Slot-First Where Needed

If Media is Vue and overlay composition is justified, prefer a generic slot:

```vue
<template #overlay>
    ...
</template>
```

over overlay-specific business props.

Follow actual ORP slot conventions.

---

# 61. Custom Property Escape Hatches

Evaluate generic escape hatches such as:

```css
--orp-media-ratio
--orp-media-position
```

only if they reduce variant explosion and remain understandable.

Do not create dozens of arbitrary public custom properties.

---

# 62. Playground

Expand the existing Media Playground area.

Do not create a separate duplicate primitive if Media already has demos.

---

# 63. Playground — Base Media

Show simple responsive image behavior.

---

# 64. Playground — Ratios

Show only approved ratio approaches.

Use the same source image where possible so crop differences are visible.

---

# 65. Playground — Cover vs Contain

If both are supported, demonstrate clearly.

Use an image where the difference is obvious.

---

# 66. Playground — Long/Wide Layout

Place Media inside a wide Container/Grid/Card context.

---

# 67. Playground — Mobile Card

Place Media in a narrow card at 320–390px.

---

# 68. Playground — Overlay

Only if generic overlay capability is justified.

Show neutral examples:

- Badge
- IconButton
- text readability

Do not make it product-specific.

---

# 69. Playground — No Media

Patterns with optional media should still work without creating an empty Media container.

This may be tested in Pattern demos rather than Media itself.

---

# 70. Playground — Figure/Caption

If figure/caption is already handled by Typography/Content, link/document that instead of duplicating it.

---

# 71. Playground — Video

Only if Media intentionally supports generic video/iframe containment.

Do not add a video library.

---

# 72. Playground — Edge Cases

Use:

- portrait image in landscape ratio
- landscape image in square ratio
- transparent PNG
- very small source image
- long overlay text if overlay exists
- missing alt warning/documentation
- no fixed height parent

---

# 73. Realistic Assets

Use existing local/dev placeholder strategy.

Do not add unnecessary external dependencies.

---

# 74. Responsive QA

Test:

```text
320
375
390
430
768
1200
1440
```

Check:

- crop
- ratio
- overflow
- Grid resizing
- Card integration
- Surface integration
- Container integration
- no layout shift from bad sizing where avoidable
- no horizontal page overflow

---

# 75. Portrait Mobile

At 320–430px check that media does not dominate cards excessively unless intended.

The Pattern controls hierarchy; Media should enable it.

---

# 76. Desktop

At 1200–1440 verify large media remains crisp/composed and does not stretch due to missing max constraints in the parent composition.

Media itself should not necessarily impose page max width.

---

# 77. Accessibility QA

Verify:

- meaningful images support alt
- decorative images can use empty alt
- clickable media has correct anchor/button semantics
- overlays do not hide focus indicators
- text overlays maintain contrast
- focus is not clipped by overflow
- video/iframe usage remains accessible when consumer provides proper semantics

---

# 78. Reduced Motion

Media itself should not add motion.

If hover zoom currently exists, audit whether it belongs in Media or interactive Pattern/Card.

Respect reduced motion.

---

# 79. Hover Zoom

Do NOT make image zoom-on-hover a default Media behavior.

That is decoration/interactivity and may belong to specific interactive contexts.

---

# 80. Loading Performance

Audit whether Media encourages dimensions/ratio that reduce layout shift.

Document good usage.

Do not create a performance framework.

---

# 81. Image Optimization

Do not implement:

- server resizing
- CDN transformations
- image compression
- WebP conversion
- AVIF pipeline

These belong outside ORP UI.

---

# 82. CSS Hardcode Audit

After changes search Media styles for:

- raw colors
- arbitrary radius
- arbitrary shadows
- arbitrary spacing
- fixed component heights
- z-index literals

Use Foundation tokens where these are genuine design decisions.

---

# 83. Z-Index

Overlay z-index should use ORP layering strategy if a token exists.

Do not introduce random:

```text
z-index: 999
```

---

# 84. Browser Verification

Use actual rendered browser QA if tooling exists.

Capture before/after screenshots if Media is materially changed.

At minimum inspect:

```text
390px
1440px
```

plus the full responsive QA set.

---

# 85. Tests

Run existing ORP tests.

Add tests only for real public behavior/API.

Do not write meaningless tests for static CSS declarations.

---

# 86. Build

Run:

```bash
npm run build
```

Must pass.

---

# 87. No Acerca Migration

Do NOT update minisite consumers to use new Media capabilities during this task.

Acerca is READ-ONLY evidence.

Dogfooding happens later.

---

# 88. No New Pattern

Do not create:

```text
ImageCard
MediaCard
GalleryCard
VideoCard
```

unless one already exists and is being audited.

This phase is only Media capability.

---

# 89. No Gallery Expansion

Do not create:

- carousel
- thumbnails
- lightbox manager
- gallery navigation
- zoom viewer

---

# 90. No Skeleton Yet

If loading placeholders are clearly missing, record:

```text
Skeleton Component candidate
```

Do NOT implement it in this phase.

---

# 91. No Container Changes

Do not redesign Container here.

If Media reveals a layout issue, document it separately.

---

# 92. No Typography Changes

Do not create a competing caption/prose system.

Reuse Typography & Content.

---

# 93. No Visual Helper Duplication

If aspect-ratio/overflow helpers already exist:

determine whether Media should consume/reuse concepts.

Do not expose two conflicting APIs for the same responsibility.

---

# 94. Required Report

Generate:

```text
ORP-MEDIA-CAPABILITY-AUDIT.md
```

---

# 95. Report Structure

```text
# ORP Media Capability Audit

## Executive Summary

## Existing Media API

## Files Audited

## Consumers Audited

## Discovery Matrix

## Media Responsibility

## Aspect Ratio
Current:
Decision:
Changes:

## Object Fit
Current:
Decision:
Changes:

## Object Position
Current:
Decision:
Changes:

## Responsive Behavior

## Cropping / Overflow

## Radius Ownership

## Card Media Relationship

## Overlay Capability

## Caption / Figure Relationship

## Fallback Strategy

## Loading Strategy

## Native Image Attributes

## Responsive Images / Picture

## Video / Iframe

## Interactive Media

## GLightbox / External Integration

## Accessibility

## Performance Considerations

## Token Usage

## Hardcoded Values

## API Added

## API Reused

## API Rejected

## Playground Coverage

## Responsive QA

## Tests

## Build

## Files Created

## Files Modified

## Deferred Findings

## Final Media Architecture

## Next Recommended Phase
```

---

# 96. Required Final Verdict

End with exactly one:

```text
MEDIA PRIMITIVE ALREADY ADEQUATE
```

or:

```text
MEDIA PRIMITIVE EXTENDED
```

or:

```text
MEDIA PRIMITIVE NEEDS FOLLOW-UP
```

If follow-up is needed, identify ONE focused issue.

---

# 97. Deferred Findings

Potential future candidates may include:

```text
Skeleton
Progress / Meter
Status
Content image guidance
Responsive image documentation
Media loading guidance
```

Do not implement them here.

---

# 98. Recommended Next Phase

If Media is adequate after this audit, STOP creating Primary Primitives temporarily.

Recommended next direction:

```text
COMPONENT GAP REVIEW
```

with likely candidates:

```text
Skeleton
Progress / Meter
Status — only after Badge audit
```

Do not automatically create them.

The purpose is to switch from primitive growth to evidence-based missing Components.

---

# 99. STOP CONDITION

STOP after:

1. repository audit
2. consumer audit
3. discovery matrix
4. capability-by-capability decisions
5. minimal justified Media extensions
6. Playground updates
7. accessibility QA
8. responsive QA
9. tests
10. `npm run build`
11. report
12. final verdict
13. one recommended next phase

Do not continue automatically.

---

# FINAL INSTRUCTION

Perform a real capability audit of ORP Media.

1. Inspect the existing implementation first.
2. Inspect real ORP consumers.
3. Inspect Acerca read-only for evidence.
4. Define Media's exact responsibility.
5. Audit aspect ratio.
6. Audit object-fit.
7. Audit object-position.
8. Audit responsive sizing.
9. Audit cropping/overflow.
10. Audit radius ownership.
11. Audit Card media overlap.
12. Audit generic overlay composition.
13. Keep overlays domain-independent.
14. Audit caption vs semantic Figure/Content.
15. Audit fallback behavior.
16. Keep Avatar fallback outside Media when appropriate.
17. Audit loading behavior.
18. Prefer native browser image capabilities.
19. Keep Skeleton separate.
20. Support `<picture>` when appropriate.
21. Audit video/iframe containment.
22. Keep GLightbox external.
23. Keep carousel/gallery behavior external.
24. Keep Media non-interactive by default.
25. Preserve accessible HTML semantics.
26. Avoid prop explosion.
27. Avoid ratio variant explosion.
28. Use tokens.
29. Avoid Bootstrap/Tailwind-style helper matrices.
30. Update Playground only with justified capabilities.
31. Test 320/375/390/430/768/1200/1440.
32. Run tests.
33. Run `npm run build`.
34. Generate `ORP-MEDIA-CAPABILITY-AUDIT.md`.
35. End with a clear Media verdict.
36. Recommend Component Gap Review next.
37. STOP.

