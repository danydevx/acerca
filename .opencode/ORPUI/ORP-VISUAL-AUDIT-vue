# ORP UI — VISUAL HELPERS AUDIT & FOUNDATION
# Borders, radius, elevation, overflow, visibility and small generic helpers
# Run after Typography & Content Primitives and before the Visual Direction Audit

## Context

ORP UI already has a growing architecture:

```text
ORP UI
├── Foundation
│   ├── Tokens
│   ├── Typography
│   ├── Content styles
│   └── Visual foundation
│
├── Primitives / Primary
│   ├── Stack
│   ├── Cluster
│   ├── Grid
│   ├── Section
│   ├── Card
│   └── ...
│
├── Components
├── Patterns
└── Helpers
```

The framework now needs an audit of small, generic visual behaviors that are useful across many contexts but do NOT justify creating a Vue component or a new layout primitive.

Examples:

- borders
- border removal
- border sides
- radius
- full/pill radius
- elevation/shadows
- overflow
- visibility
- truncation
- line clamp
- visually hidden content

The objective is NOT to recreate Bootstrap Utilities or Tailwind.

The objective is to create a SMALL, DELIBERATE, TOKEN-DRIVEN helper layer.

---

# 1. Core Principle

Use this responsibility model:

```text
Foundation
→ design decisions and tokens

Helpers
→ one small generic visual/behavioral adjustment

Primitives
→ layout and structural composition

Components
→ reusable UI behavior/semantics

Patterns
→ recurring higher-level compositions

Application
→ domain/business styling
```

A helper should modify ONE focused characteristic.

---

# 2. Critical Anti-Utility-Soup Rule

This is acceptable:

```html
<img class="orp-rounded-lg" src="..." alt="...">
```

This may also be acceptable:

```html
<div class="orp-overflow-x-auto">
    ...
</div>
```

This is a warning sign:

```html
<div
    class="
        orp-border
        orp-rounded-lg
        orp-shadow-sm
        orp-p-4
        orp-mb-3
        orp-bg-white
        orp-text-dark
        orp-flex
        orp-items-center
    "
>
```

If consumers repeatedly need long chains of helpers, ORP is missing a:

- Primitive
- Component
- Pattern

Do NOT solve architectural gaps by adding more utilities.

---

# 3. Workflow

Follow:

```text
DISCOVER
   ↓
INVENTORY
   ↓
CLASSIFY
   ↓
CONSOLIDATE
   ↓
IMPLEMENT ONLY JUSTIFIED HELPERS
   ↓
PLAYGROUND
   ↓
VERIFY
```

Do not begin by creating classes.

---

# 4. Audit Existing ORP First

Search the real repository for existing:

- border helpers
- border tokens
- radius helpers
- radius tokens
- shadow helpers
- elevation tokens
- overflow helpers
- visibility helpers
- truncate helpers
- line-clamp helpers
- visually-hidden helpers
- aspect-ratio helpers
- width/height helpers
- position helpers
- opacity helpers
- cursor helpers
- spacing helpers
- display/flex helpers
- color helpers

Also inspect these concepts inside component LESS.

The goal is to find both:

1. existing public helpers
2. repeated local CSS that may indicate a missing generic helper

---

# 5. Required Discovery Matrix

Before implementation create an inventory:

| Concept | Existing helper | Existing token | Repeated local use | Candidate layer | Decision | Reason |
|---|---|---|---:|---|---|---|
| Border | ? | ? | ? | Helper | ? | ? |
| Border sides | ? | ? | ? | Helper | ? | ? |
| Radius | ? | ? | ? | Helper | ? | ? |
| Elevation | ? | ? | ? | Helper/Foundation | ? | ? |
| Overflow | ? | ? | ? | Helper | ? | ? |
| Visibility | ? | ? | ? | Helper | ? | ? |
| Truncate | ? | ? | ? | Helper | ? | ? |
| Line clamp | ? | ? | ? | Helper | ? | ? |
| Visually hidden | ? | ? | ? | Helper | ? | ? |
| Aspect ratio | ? | ? | ? | Media/Helper | ? | ? |

Use decisions:

```text
REUSE
EXTEND
CREATE
KEEP LOCAL
DEFER
REJECT
```

---

# 6. Helper Acceptance Test

Before adding any helper ask:

1. Is it domain-independent?
2. Is it useful in at least two contexts?
3. Does it solve one focused behavior?
4. Is its API stable?
5. Can it consume ORP tokens?
6. Would a Vue component be unnecessary?
7. Would a layout primitive be excessive?
8. Does it reduce real repeated CSS?
9. Can it exist without encouraging utility soup?

If several answers are NO:

DO NOT CREATE IT.

---

# 7. Border Helpers

Audit whether ORP needs generic border helpers.

Potential minimal candidates:

```text
.orp-border
.orp-border-0
.orp-border-top
.orp-border-bottom
```

These are conceptual names only.

Follow actual ORP naming conventions.

---

# 8. Border Tokens

Border helpers MUST use ORP tokens.

Conceptually:

```css
border: 1px solid var(--orp-border);
```

Do not hardcode:

```css
border: 1px solid #e5e7eb;
```

inside helper classes.

---

# 9. Border Strength

Evaluate whether a stronger generic border is actually needed.

Possible concept:

```text
.orp-border-strong
```

Only create it if multiple real contexts require it.

Do not create:

```text
border-primary
border-secondary
border-success
border-warning
border-danger
border-info
```

just because Bootstrap has them.

Semantic border color should normally be owned by the relevant component/state.

---

# 10. Border Sides

Potentially useful:

```text
border-top
border-bottom
```

Be much more cautious with:

```text
border-left
border-right
```

because physical directions can be problematic for RTL.

If side helpers are justified, consider logical properties:

```text
block-start
block-end
inline-start
inline-end
```

according to ORP's actual browser/support strategy.

Do not overengineer if ORP does not support RTL yet, but document the decision.

---

# 11. No Border Width Matrix

Do not create:

```text
border-1
border-2
border-3
border-4
border-5
```

unless there is strong evidence.

The default design system should usually have one standard structural border width.

---

# 12. Border Radius Helpers

Radius is a strong candidate for a small helper family.

Audit the approved Default Theme 2026 radius tokens.

Potential conceptual API:

```text
.orp-rounded-sm
.orp-rounded
.orp-rounded-lg
.orp-rounded-full
.orp-rounded-0
```

Only keep levels backed by real ORP radius tokens.

---

# 13. Radius Must Be Token-Driven

Conceptually:

```css
.orp-rounded-sm {
    border-radius: var(--orp-radius-sm);
}

.orp-rounded {
    border-radius: var(--orp-radius-md);
}

.orp-rounded-lg {
    border-radius: var(--orp-radius-lg);
}
```

Do not repeat literal radius values.

---

# 14. Full Radius

A full/pill helper may be useful for:

- avatars
- circular media
- tags
- custom user content

But do not let `rounded-full` become the default solution for every control.

---

# 15. No Radius Explosion

Do not create:

```text
rounded-xs
rounded-sm
rounded-md
rounded-lg
rounded-xl
rounded-2xl
rounded-3xl
rounded-4xl
```

unless ORP genuinely has that token scale.

A restrained framework needs fewer radius decisions.

---

# 16. Corner-Specific Radius

Do NOT initially create:

```text
rounded-top
rounded-bottom
rounded-start
rounded-end
rounded-top-start
...
```

unless actual repeated composition requires them.

Media/Card composition should preferably be handled by the relevant primitive/component.

---

# 17. Elevation, Not Decoration

Treat shadow as:

ELEVATION.

Do not treat shadow as a generic "make it prettier" effect.

The conceptual hierarchy should remain:

```text
flat
↓
border
↓
surface contrast
↓
shadow/elevation
```

---

# 18. Elevation Tokens

Audit current:

```text
--orp-shadow-*
```

or equivalent.

Determine whether the approved 2026 theme should expose a small hierarchy such as:

```text
none
subtle
raised
overlay
```

Do not create more levels than the system needs.

---

# 19. Shadow Helper Naming

Classes may remain familiar:

```text
.orp-shadow-none
.orp-shadow-sm
.orp-shadow
.orp-shadow-lg
```

if that matches ORP conventions.

But documentation must explain that these represent elevation levels.

Alternative naming like:

```text
orp-elevation-*
```

may be considered only if it fits the existing API better.

Do not rename existing public APIs casually.

---

# 20. Shadow Rules

Every shadow helper must use tokens.

No helper may contain arbitrary custom shadows.

Do not create:

```text
shadow-primary
shadow-success
shadow-purple
shadow-glow
shadow-neon
```

---

# 21. Default Components vs Shadow Helpers

Do not use helpers internally to compensate for a poorly designed component default.

Example:

If Modal should always have overlay elevation, Modal should own that through its component styling/token contract.

Consumers should not need:

```html
<OrpModal class="orp-shadow-lg">
```

to make Modal correct.

---

# 22. Overflow Helpers

Overflow is a good candidate because it represents small generic behavior.

Audit need for:

```text
.orp-overflow-hidden
.orp-overflow-auto
.orp-overflow-x-auto
```

Possibly:

```text
.orp-overflow-y-auto
```

only if evidence exists.

---

# 23. Overflow Hidden

`overflow: hidden` is commonly useful with:

- custom media
- clipping
- radius
- content containers

But ensure it does not accidentally clip:

- focus rings
- menus
- popovers
- badges
- positioned actions

Document the risk.

---

# 24. Horizontal Overflow

`overflow-x-auto` is particularly useful for:

- code blocks
- semantic tables
- compact horizontal content

Do not use it to hide broken responsive layouts.

---

# 25. Visibility Helpers

Audit whether ORP needs a minimal visibility layer.

Potential generic candidates:

```text
hidden
visually-hidden
```

Do not automatically build responsive Bootstrap-like classes:

```text
d-none
d-sm-block
d-md-none
...
```

---

# 26. Hidden vs Visually Hidden

These are fundamentally different.

Hidden:

```css
display: none;
```

Removes content visually and from normal accessibility exposure.

Visually hidden:

keeps content available to assistive technology.

Do not confuse them.

---

# 27. Visually Hidden / SR Only

A visually-hidden helper is strongly justified if ORP does not already have one.

Conceptual name:

```text
.orp-sr-only
```

or:

```text
.orp-visually-hidden
```

Choose according to actual ORP conventions.

Use a proven accessible implementation.

---

# 28. Truncate

Coordinate with the Typography & Content Primitives phase.

If already implemented there:

REUSE.

Do not create a second version.

Conceptual:

```text
.orp-truncate
```

for single-line ellipsis.

---

# 29. Line Clamp

If already implemented:

REUSE.

If not, only create a small justified set.

Likely candidates:

```text
.orp-line-clamp-2
.orp-line-clamp-3
```

Do not generate 1–12.

---

# 30. Aspect Ratio

Audit existing ORP Media before creating any aspect-ratio helper.

If Media already solves:

- square
- portrait
- landscape
- custom ratio

then REUSE Media.

Do not create parallel helpers.

---

# 31. Aspect Ratio Escape Hatch

Only create a generic aspect-ratio helper if there are legitimate non-Media contexts requiring it.

Potential concept:

```text
.orp-aspect-square
```

or custom-property-based behavior.

Do not create a Tailwind-style ratio catalog without evidence.

---

# 32. Width and Height Helpers

Be highly conservative.

Do not automatically create:

```text
w-25
w-50
w-75
w-100
h-100
min-vh-100
```

because Bootstrap has them.

Layout belongs primarily to ORP primitives and component composition.

---

# 33. Full Width

If `width: 100%` is repeatedly needed generically and not already solved by component APIs such as `.orp-btn--block`, evaluate a single focused helper.

Do not create a sizing utility framework.

---

# 34. Position Helpers

Do NOT automatically create:

```text
relative
absolute
fixed
sticky
top-0
start-0
```

These can quickly become utility soup.

Positioning should usually belong to the component/composition that owns it.

Only create a helper if repeated framework evidence is strong.

---

# 35. Z-Index

Never create arbitrary z-index helpers like:

```text
z-10
z-20
z-50
z-9999
```

ORP already has/should have semantic z-index tokens.

Components such as Modal/Drawer should own their layer.

---

# 36. Opacity Helpers

Do not create a generic opacity scale unless real use cases justify it.

Opacity can harm:

- contrast
- disabled states
- nested content

Prefer semantic state styling.

---

# 37. Cursor Helpers

Do not create a large cursor utility API.

Components should own correct cursor behavior.

Potential exceptions require evidence.

---

# 38. Background Helpers

Do NOT recreate Bootstrap/Tailwind color helpers such as:

```text
bg-primary
bg-success
bg-danger
bg-light
bg-dark
```

Component semantics and surfaces should use tokens through components/primitives.

---

# 39. Text Color Helpers

Do NOT automatically create:

```text
text-primary
text-success
text-danger
text-muted
```

Typography roles and semantic components should solve most cases.

A generic helper must have strong evidence.

---

# 40. Spacing Helpers

Do NOT create Bootstrap-style:

```text
m-0
mt-1
mb-3
p-4
px-2
gap-5
```

as part of this phase.

ORP uses:

- Stack
- Cluster
- Grid
- component spacing
- Foundation tokens

If a spacing utility system is ever considered, it requires a separate architectural decision.

---

# 41. Display Helpers

Do NOT automatically create:

```text
d-flex
d-grid
d-block
d-inline
```

ORP already has structural primitives.

Use:

```text
Stack
Cluster
Grid
```

where they express layout intent.

---

# 42. Flex Helpers

Do NOT recreate:

```text
justify-content-between
align-items-center
flex-wrap
flex-column
```

unless the architecture audit later proves ORP needs a controlled layout-helper layer.

Stack/Cluster/Grid should remain the primary vocabulary.

---

# 43. Visual Helper Budget

Keep the initial public helper API intentionally small.

Target:

roughly 10–20 genuinely useful helpers,

NOT 150 utility classes.

This is a guideline, not a quota.

Do not create weak helpers merely to reach a number.

---

# 44. Candidate Initial Family

Audit this candidate set:

```text
Border
├── border
├── border-0
├── border-top / block-start (?)
└── border-bottom / block-end (?)

Radius
├── rounded-0
├── rounded-sm
├── rounded
├── rounded-lg
└── rounded-full

Elevation
├── shadow-none
├── shadow-sm
├── shadow
└── shadow-lg

Overflow
├── overflow-hidden
├── overflow-auto
└── overflow-x-auto

Content
├── truncate
├── line-clamp-2
└── line-clamp-3

Accessibility
└── visually-hidden / sr-only
```

This is a CANDIDATE inventory.

Do not implement every item automatically.

---

# 45. Token Contract

Helpers must consume the same Foundation tokens used by components.

Example:

```text
Card
        ┐
Button  ├── uses --orp-radius-*
Helper  ┘
```

There must not be:

```text
Component radius system
+
Helper radius system
```

---

# 46. Themeability

Helpers must respond correctly when consumers override ORP tokens.

Example:

If Acerca changes:

```css
--orp-radius-lg
```

then a generic large-radius helper should follow automatically.

No duplicate hardcoded values.

---

# 47. Default Theme 2026 Integration

The helper layer must respect the approved:

- neutral palette
- border system
- radius scale
- elevation system
- typography
- focus strategy

Do not create helpers based on the old visual theme.

---

# 48. CSS Organization

Determine an appropriate ORP location such as:

```text
resources/less/orp-ui/helpers/
```

or the repository's existing convention.

Possible conceptual structure:

```text
_helpers.less
_border.less
_radius.less
_elevation.less
_overflow.less
_accessibility.less
```

Do not create unnecessary file fragmentation if one small file is cleaner.

Follow the repository.

---

# 49. Public Entry

Ensure justified helper styles are included through the normal ORP LESS entry.

Do not require consumers to import five hidden helper files manually unless that is already ORP's architecture.

---

# 50. Naming

Use the existing ORP prefix and naming conventions.

Names should be:

- obvious
- stable
- short
- generic

Avoid clever names.

---

# 51. No Vue Components

Visual helpers should NOT become Vue components.

Do not create:

```text
OrpRounded
OrpShadow
OrpBorder
OrpOverflow
```

These are CSS concerns.

---

# 52. Components Still Own Defaults

Helpers are optional adjustments.

A correct component should look correct without consumer helper chains.

Example:

```vue
<OrpCard />
```

must remain valid without:

```html
orp-border orp-rounded orp-shadow
```

---

# 53. Pattern CSS

Do not refactor every Pattern to use helper classes internally.

Patterns may continue using token-driven LESS.

Helpers primarily exist for consumers and small composition escape hatches.

Avoid turning Vue templates into class soup.

---

# 54. Duplication Discovery

However, if the audit finds the SAME tiny rule duplicated across many Pattern styles, decide whether a helper or shared token/mixin is more appropriate.

A public helper is not automatically the answer to internal CSS duplication.

---

# 55. Public Helper vs LESS Mixin

Explicitly distinguish:

PUBLIC HELPER
→ consumer uses class in markup

LESS MIXIN
→ internal authoring reuse

TOKEN
→ shared design decision

Do not expose an internal implementation concern as public API without need.

---

# 56. Public Helper vs Primitive

Example:

```text
overflow-x-auto
```

may be a helper.

But:

```text
responsive horizontal item arrangement with gap and wrapping
```

is probably Cluster/Grid, not a collection of helpers.

---

# 57. Public Helper vs Component

Example:

```text
rounded-lg
```

may be a helper.

But:

```text
border + radius + padding + title + actions
```

is likely a Component/Pattern.

---

# 58. Repeated Helper Chain Detection

During repository audit search for repeated combinations such as:

```text
border + radius + shadow
border + padding
overflow + radius
```

If the same combination represents a stable concept:

flag it for architectural review.

Do NOT automatically create a combined helper.

---

# 59. Bootstrap Resemblance

Helpers themselves should not push ORP toward Bootstrap.

Specifically avoid copying Bootstrap's entire:

- border utility API
- rounded utility API
- shadow utility API
- display utilities
- spacing utilities
- flex utilities
- color utilities

Coverage should come from ORP needs.

---

# 60. Tailwind Resemblance

Likewise, do not generate atomic classes for every token/value.

ORP is component/primitives-first.

Helpers are an escape hatch, not the primary authoring model.

---

# 61. Documentation Rule

Every helper family must explain:

WHEN TO USE

and:

WHEN NOT TO USE.

This is important to prevent future coding agents from abusing helpers.

---

# 62. Border Documentation

Example principle:

Use border helpers for small generic separation/containment.

Do not use them to construct entire Cards manually.

---

# 63. Radius Documentation

Example principle:

Use radius helpers for standalone/custom content requiring token-consistent clipping/shape.

Components already own their radius.

---

# 64. Elevation Documentation

Example principle:

Use elevation helpers when a custom surface genuinely occupies a raised layer.

Do not add shadows merely to make content feel premium.

---

# 65. Overflow Documentation

Example principle:

Use overflow helpers for intentional clipping/scroll containers.

Do not hide broken responsive layout.

---

# 66. Accessibility Documentation

Visually hidden content must be documented with examples such as:

```html
<button>
    <i class="bi bi-x" aria-hidden="true"></i>
    <span class="orp-visually-hidden">Cerrar</span>
</button>
```

Use actual final helper naming.

---

# 67. Playground

Add a dedicated Playground section:

```text
Helpers
```

or follow the actual Playground information architecture.

---

# 68. Playground — Borders

Demonstrate only implemented border helpers.

Show neutral examples.

Do not create colorful demo decoration that hides the real visual system.

---

# 69. Playground — Radius

Show each approved radius level on equivalent surfaces.

This should make inconsistencies obvious.

---

# 70. Playground — Elevation

Show elevation levels side by side.

Include explanatory labels such as:

```text
Flat
Subtle
Raised
Overlay
```

if those are the actual semantic levels.

The demo should teach that stronger shadow means stronger layer separation.

---

# 71. Playground — Overflow

Demonstrate:

- clipping
- horizontal scrolling
- long content

Do not use overflow to conceal layout bugs.

---

# 72. Playground — Content Helpers

If truncate/line-clamp exist, demonstrate realistic long Spanish content.

---

# 73. Playground — Accessibility

Demonstrate visually-hidden helper through an accessible icon-only control.

Do not make the hidden text visible merely for the demo.

Document how to inspect it.

---

# 74. Playground Anti-Pattern Example

Optionally include documentation showing:

```text
DON'T:
chain many helpers to manually construct a component.

DO:
use the appropriate ORP primitive/component/pattern.
```

This can be documentation rather than executable UI.

---

# 75. Responsive QA

Test:

320
375
390
430
768
1200
1440

Particularly inspect:

- horizontal overflow
- clipping
- focus rings around overflow-hidden containers
- rounded media
- long truncated text

---

# 76. Focus QA

Check that:

```text
overflow-hidden
rounded
```

do not accidentally hide focus indicators on interactive descendants.

This is a critical edge case.

---

# 77. Accessibility QA

Verify:

- visually hidden content is exposed correctly
- hidden content semantics are understood
- truncation does not hide essential information without an alternative
- borders are not the sole semantic state indicator
- elevation is not the sole semantic signal

---

# 78. Build

Run:

```bash
npm run build
```

Must pass.

---

# 79. Tests

Run existing ORP tests.

Do not add meaningless Vue tests for CSS-only helpers.

If the project has visual/snapshot/browser tests, use them where appropriate.

---

# 80. Hardcode Audit

After implementation search helper files for:

- raw colors
- raw radius values
- raw shadows
- arbitrary spacing
- arbitrary z-index

Shared visual decisions must come from tokens.

Some CSS behavior literals such as:

```text
overflow: hidden
display: none
white-space: nowrap
```

are naturally acceptable because they are behavior, not design tokens.

---

# 81. No Business Logic

Do not modify:

- Laravel
- routes
- controllers
- models
- APIs
- Inertia data
- database

---

# 82. No Acerca Migration

Do not update Minisite components to use the new helpers yet.

This phase establishes ORP.

Dogfooding comes later.

---

# 83. No Pattern Expansion

Do not create new Card Patterns.

Do not resurrect:

```text
OrpActionCard
```

It remains:

```text
ACTION CARD PATTERN NOT JUSTIFIED
```

unless a future independent architecture audit provides extraordinary new evidence.

---

# 84. No Map Expansion

Do not add:

- popup
- geolocation
- routing
- clustering
- polygons
- map controls

This task is unrelated.

---

# 85. Required Report

Generate:

```text
ORP-VISUAL-HELPERS-REPORT.md
```

---

# 86. Report Structure

```text
# ORP Visual Helpers Report

## Executive Summary

## Existing Helper Inventory

## Discovery Matrix

## Existing Token Coverage

## Border

Implemented:
Rejected:
Reason:

## Radius

Implemented:
Rejected:
Reason:

## Elevation

Implemented:
Rejected:
Reason:

## Overflow

Implemented:
Rejected:
Reason:

## Visibility

Implemented:
Rejected:
Reason:

## Truncation

Implemented:
Reused:
Rejected:

## Accessibility Helpers

Implemented:
Reused:
Rejected:

## Aspect Ratio

Decision:
Reason:

## Width / Height

Decision:
Reason:

## Position

Decision:
Reason:

## Color Helpers

Decision:
Reason:

## Spacing Helpers

Decision:
Reason:

## Display / Flex Helpers

Decision:
Reason:

## Public Helpers Added

Complete list.

## Existing Helpers Reused

Complete list.

## Helpers Rejected

Complete list.

## Helper Chains Found

Repeated chains discovered:

Architectural concerns:

## Token Usage

## Hardcoded Values

## Playground Coverage

## Accessibility QA

## Responsive QA

## Tests

## Build

## Files Created

## Files Modified

## Final Helper Architecture

## Readiness for Visual Direction Audit
```

---

# 87. Final Helper Architecture

Report the actual resulting API.

Example only:

```text
ORP Helpers
├── Border
│   ├── orp-border
│   └── orp-border-0
│
├── Radius
│   ├── orp-rounded-sm
│   ├── orp-rounded
│   ├── orp-rounded-lg
│   └── orp-rounded-full
│
├── Elevation
│   ├── orp-shadow-none
│   ├── orp-shadow-sm
│   └── orp-shadow-lg
│
├── Overflow
│   ├── orp-overflow-hidden
│   └── orp-overflow-x-auto
│
└── Accessibility
    └── orp-visually-hidden
```

Do NOT force this exact output.

---

# 88. Explicit Rejected Families

The report must explicitly state whether these were rejected/deferred:

```text
Spacing utilities
Display utilities
Flex utilities
Color utilities
Background utilities
Opacity scale
Z-index utilities
Position utilities
Large sizing utilities
Large responsive utility matrix
```

This prevents future agents from casually adding them.

---

# 89. Readiness Verdict

Finish with one:

```text
READY FOR VISUAL DIRECTION AUDIT
```

or:

```text
VISUAL HELPER FOUNDATION NEEDS FOLLOW-UP
```

If follow-up is required:

recommend ONE focused next task.

---

# 90. Sequence

The intended ORP sequence is now:

```text
DEFAULT THEME 2026
        ↓
TYPOGRAPHY & CONTENT PRIMITIVES
        ↓
VISUAL HELPERS
        ↓
VISUAL DIRECTION AUDIT
        ↓
ONE PILOT REDESIGN
        ↓
GLOBAL ARCHITECTURE AUDIT
        ↓
PRIORITIZED ORP CORRECTIONS
        ↓
ACERCA DOGFOODING
```

Do not skip directly into Acerca.

---

# 91. STOP CONDITION

STOP after:

1. repository audit
2. helper discovery matrix
3. classification
4. implementation of only justified helpers
5. Playground examples
6. accessibility QA
7. responsive QA
8. tests
9. build
10. report
11. readiness verdict

Do not begin the Visual Direction Audit automatically.

---

# FINAL INSTRUCTION

Build a deliberately small ORP Visual Helpers layer.

1. Audit the repository before creating classes.
2. Reuse existing helpers where possible.
3. Use ORP Foundation tokens.
4. Audit Border helpers.
5. Audit Radius helpers.
6. Treat Shadow as Elevation.
7. Audit Overflow helpers.
8. Audit Visibility helpers.
9. Reuse Typography helpers such as truncate/line-clamp if already created.
10. Ensure a visually-hidden accessibility helper exists.
11. Audit Aspect Ratio against the existing Media primitive.
12. Be conservative with width/height helpers.
13. Reject speculative position/z-index helpers.
14. Do not create color utility matrices.
15. Do not create spacing utilities.
16. Do not create display/flex utility systems.
17. Do not recreate Bootstrap Utilities.
18. Do not recreate Tailwind.
19. Keep helpers focused on one behavior.
20. Detect repeated helper chains that may indicate a missing abstraction.
21. Keep component defaults inside components.
22. Do not fill Pattern templates with helper chains.
23. Document WHEN and WHEN NOT to use each family.
24. Add Playground examples.
25. Verify focus clipping with radius/overflow.
26. Verify accessibility.
27. Verify mobile.
28. Run tests.
29. Run `npm run build`.
30. Generate `ORP-VISUAL-HELPERS-REPORT.md`.
31. End with a readiness verdict.
32. STOP.

