# ORP UI — CONTAINER PRIMITIVE DISCOVERY & IMPLEMENTATION
# Next Primary Primitive phase
# Run after Divider / Surface Discovery
# Goal: standardize page width, horizontal gutters and content measure without recreating Bootstrap containers

## Context

ORP UI is building a small, deliberate set of layout and visual primitives.

Current conceptual architecture:

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
│   ├── Section
│   ├── Card
│   ├── Media
│   ├── Avatar
│   ├── Badge
│   ├── Price
│   ├── List
│   ├── Divider
│   ├── Surface        ← only if previous audit justified it
│   └── Container      ← THIS PHASE
│
├── Components
└── Patterns
```

ORP's visual direction is:

- modern 2026
- mobile-first
- app-like
- calm and restrained
- hierarchy before decoration
- whitespace before borders
- fewer boxed layouts
- fewer unnecessary Cards
- responsive by composition rather than Bootstrap breakpoint imitation
- token-driven
- themeable

This phase must determine how ORP controls:

```text
viewport
→ page gutter
→ maximum content width
→ content measure
→ internal layout
```

without creating a Bootstrap-like container system.

---

# 1. Objective

Audit the real repository and determine whether ORP needs a generic `Container` primitive.

If justified, implement the smallest useful Container API.

The primary responsibilities are potentially:

- horizontal viewport gutters
- maximum page/content width
- horizontal centering
- fluid responsive behavior
- a stable page composition boundary

Container must NOT become:

- Grid
- Section
- Stack
- Surface
- Card
- spacing utility system
- responsive breakpoint utility system

Follow:

```text
DISCOVER
→ INVENTORY
→ CLASSIFY
→ DEFINE OWNERSHIP
→ IMPLEMENT ONLY JUSTIFIED API
→ PLAYGROUND
→ RESPONSIVE QA
→ REPORT
→ STOP
```

---

# 2. Critical Question

Before creating anything answer:

> Who currently owns horizontal page spacing in ORP?

Search whether it is currently controlled by:

- Section
- page wrappers
- theme layouts
- Grid
- component-specific padding
- Pattern-specific padding
- Acerca Minisite layout
- arbitrary local CSS
- Bootstrap leftovers
- `max-width`
- `margin-inline: auto`
- `padding-inline`
- `width: calc(...)`

If horizontal spacing ownership is fragmented, Container may be justified.

---

# 3. Desired Responsibility Model

The target conceptual ownership is:

```text
Viewport
   ↓
Container
   → page gutters
   → max content width
   → horizontal centering

Section
   → vertical chapter rhythm

Stack
   → vertical internal relationships

Cluster
   → inline/wrapped relationships

Grid
   → bidimensional/repetitive layout

Surface
   → visual plane, if justified

Card
   → discrete content object
```

Avoid overlapping responsibilities.

---

# 4. The Main Problem to Prevent

Do not allow this:

```text
viewport
+ Section horizontal padding
+ Container horizontal padding
+ Grid horizontal padding
+ Surface horizontal padding
+ Card padding
```

At 375px this produces a narrow, over-padded interface.

One responsibility must have one primary owner.

---

# 5. Mandatory Repository Audit

Search the real repository for:

```text
container
wrapper
content-width
page-width
max-width
margin-inline: auto
margin-left: auto
margin-right: auto
padding-inline
padding-left
padding-right
width: min(
clamp(
calc(100%
```

Also inspect:

- Foundation spacing tokens
- breakpoint tokens
- Section
- Grid
- Stack
- Cluster
- Surface if it exists
- Card
- Playground layout shell
- ORP documentation
- theme files
- global layout styles

Do not create Container before understanding existing behavior.

---

# 6. Read-Only Acerca Evidence

Inspect Acerca/minisite READ-ONLY for evidence.

Look at:

- MinisiteLayout
- Hero
- Navigation
- Footer
- Services
- Products
- Gallery
- Locations
- Contact
- long-form sections

Identify repeated local patterns such as:

```css
max-width: ...;
margin: 0 auto;
padding-inline: ...;
width: calc(...);
```

Do NOT modify Acerca.

---

# 7. Discovery Matrix

Before implementation produce:

| Concept | Existing solution | Files | Repeated contexts | Current owner | Problem | Decision |
|---|---|---|---:|---|---|---|
| Page gutter | ? | ? | ? | ? | ? | ? |
| Max content width | ? | ? | ? | ? | ? | ? |
| Centering | ? | ? | ? | ? | ? | ? |
| Narrow content | ? | ? | ? | ? | ? | ? |
| Wide content | ? | ? | ? | ? | ? | ? |
| Full-width content | ? | ? | ? | ? | ? | ? |
| Section horizontal padding | ? | ? | ? | ? | ? | ? |
| Local wrappers | ? | ? | ? | ? | ? | ? |

Use:

```text
REUSE
EXTEND
CREATE
KEEP LOCAL
DEFER
REJECT
```

---

# 8. Container Acceptance Test

Create Container only if it provides a clear generic responsibility.

It should satisfy most/all:

1. Domain-independent.
2. Useful across multiple pages/contexts.
3. Owns horizontal page width/gutter clearly.
4. Removes repeated wrapper CSS.
5. Distinct from Section.
6. Distinct from Grid.
7. Distinct from Surface.
8. Small API.
9. Responsive without huge breakpoint matrices.
10. Themeable through ORP tokens.

A valid audit result is:

```text
CONTAINER PRIMITIVE NOT JUSTIFIED
```

if existing architecture already solves this cleanly.

---

# 9. Prefer CSS Primitive

Strongly prefer:

```html
<div class="orp-container">
    ...
</div>
```

Do NOT create:

```vue
<OrpContainer>
```

just to render a `<div>`.

Vue requires real behavioral/API value.

---

# 10. Default Container

Conceptually the default may behave like:

```css
.orp-container {
    width: min(
        calc(100% - (var(--orp-page-gutter) * 2)),
        var(--orp-container-max)
    );

    margin-inline: auto;
}
```

This is an example, NOT mandatory implementation.

Validate against existing ORP tokens and browser support.

---

# 11. Modern Responsive Strategy

Prefer fluid behavior over a Bootstrap-style breakpoint table.

Avoid blindly reproducing:

```text
sm → 540px
md → 720px
lg → 960px
xl → 1140px
xxl → 1320px
```

ORP should determine width from:

- available viewport
- page gutter
- content intent
- maximum measure

rather than continuously switching fixed container widths.

---

# 12. Page Gutter

Audit whether ORP already has a page-gutter token.

If missing and repeatedly needed, consider a Foundation token conceptually like:

```text
--orp-page-gutter
```

It may use responsive CSS such as `clamp()` if appropriate.

Do not create separate arbitrary gutter values in every component.

---

# 13. Mobile Gutter

Mobile gutter must remain usable at:

```text
320
375
390
430
```

Do not make the content touch the viewport.

Do not over-pad.

The design should preserve useful content width.

---

# 14. Desktop Gutter

Desktop should not merely increase padding endlessly.

Once content reaches its intended maximum width, outer whitespace naturally increases.

---

# 15. Max Width Token

Audit whether ORP already defines a page/content maximum.

If a reusable decision exists, centralize it as a Foundation token.

Conceptually:

```text
--orp-container-max
```

Do not hardcode the same `1200px`, `1280px`, etc. across files.

---

# 16. Exact Width Is Not Prescribed

Do NOT assume the correct maximum is:

```text
1140px
1200px
1280px
1320px
1440px
```

Determine it from ORP's actual visual system and existing layouts.

The prompt does not prescribe a number.

---

# 17. Container Variants

Potential candidates:

```text
default
narrow
wide
fluid
```

These are hypotheses only.

Each variant must be justified independently.

---

# 18. Default

Default should cover the majority of application/page composition.

If consumers constantly need a variant, the default may be wrong.

---

# 19. Narrow

A narrow container may be useful for:

- long-form reading
- forms
- focused content
- legal/help content

BUT first ask whether this is actually a typography `measure` concern rather than a page Container concern.

Do not mix them casually.

---

# 20. Wide

A wider container may be useful for:

- dashboards
- galleries
- large grids
- data-heavy interfaces

Only create if there are real generic contexts.

---

# 21. Fluid

A fluid mode may be useful when content should use the full available width while retaining gutters.

But clarify terminology.

`fluid` must not mean:

```text
remove all safe viewport spacing
```

unless that is explicitly the desired behavior.

---

# 22. Avoid Variant Explosion

Do NOT create:

```text
container-xs
container-sm
container-md
container-lg
container-xl
container-xxl
```

unless extraordinary evidence exists.

That would reproduce Bootstrap.

---

# 23. Container vs Content Measure

This distinction is important.

Container:

```text
page/layout width boundary
```

Readable measure:

```text
line-length constraint for text
```

Do not force all paragraphs to use the same max-width as the page.

A wide page can contain a narrower prose measure.

---

# 24. Container vs Section

Section owns chapter/section rhythm.

Container owns horizontal page boundary.

Preferred composition:

```html
<section class="orp-section">
    <div class="orp-container">
        ...
    </div>
</section>
```

Do not make both independently apply the same horizontal gutter.

---

# 25. Audit Existing Section

Inspect `.orp-section`.

Determine whether it currently owns:

- horizontal padding
- max-width
- centering
- vertical padding

If it currently mixes these responsibilities, document the migration implication.

Do NOT mass-refactor all Section consumers in this task.

---

# 26. Container vs Grid

Grid controls children.

Container controls the page/content boundary.

Correct:

```html
<div class="orp-container">
    <div class="orp-grid">
        ...
    </div>
</div>
```

Grid should not need to know the viewport gutter.

---

# 27. Container vs Stack

Stack owns vertical relationships.

Container owns horizontal boundary.

They compose naturally:

```html
<div class="orp-container">
    <div class="orp-stack">
        ...
    </div>
</div>
```

---

# 28. Container vs Surface

If Surface exists:

```html
<section class="orp-section">
    <div class="orp-container">
        <div class="orp-surface">
            ...
        </div>
    </div>
</section>
```

But sometimes a Surface may intentionally be full-width while its inner content uses Container.

Evaluate both composition directions.

Do not hardwire Surface into Container.

---

# 29. Full-Bleed Composition

ORP may need layouts where:

```text
background/surface → full viewport width
content → constrained container
```

Example conceptually:

```html
<section class="orp-section orp-surface">
    <div class="orp-container">
        ...
    </div>
</section>
```

Only use actual class combinations supported by ORP.

Do not create a full-bleed system automatically.

Document the recommended composition.

---

# 30. Container vs Card

Card should never be used as the page-width controller.

Avoid:

```css
.orp-card {
    max-width: 1200px;
    margin-inline: auto;
}
```

unless a specific Card composition intentionally requires it.

---

# 31. Container Should Not Own Vertical Spacing

Container should generally NOT own:

- section margin
- section padding-block
- Stack gap

Keep its responsibility horizontal.

---

# 32. One Axis, One Owner

Apply:

```text
Horizontal page boundary → Container
Vertical section rhythm → Section
Internal vertical gap → Stack
Inline/wrapped gap → Cluster
Grid gap → Grid
Component inset → Component/Surface/Card
```

Document any exception.

---

# 33. Padding vs Width Strategy

Evaluate both common implementation models:

## Model A

```css
width: min(calc(100% - gutters), max-width);
margin-inline: auto;
```

## Model B

```css
width: 100%;
max-width: ...;
margin-inline: auto;
padding-inline: gutter;
```

Compare implications for:

- nested containers
- backgrounds
- width calculations
- Grid
- Surface
- full bleed
- box sizing
- mobile

Choose intentionally.

---

# 34. Nested Containers

Container nesting should generally be discouraged.

Test what happens if it occurs accidentally.

Do not produce doubled gutters.

Document:

```text
Avoid nesting Container unless there is an explicit reason.
```

---

# 35. Container and Safe Areas

Evaluate mobile safe-area support only if ORP targets installed/PWA/fullscreen layouts where it matters.

Possible concern:

```css
env(safe-area-inset-left)
env(safe-area-inset-right)
```

Do NOT add complexity without evidence.

If relevant, document/defer.

---

# 36. Logical Properties

Prefer:

```css
margin-inline
padding-inline
```

over physical left/right properties when practical.

This improves future RTL compatibility.

---

# 37. Breakpoints

Audit ORP's existing breakpoint system.

Do not create a second breakpoint taxonomy just for Container.

If Container needs responsive adjustments, reuse existing Foundation decisions.

---

# 38. Container Queries

Do not introduce container queries merely because the primitive is named Container.

CSS Container Queries are a different concept.

Only use them if there is an actual architectural reason.

---

# 39. Custom Property Escape Hatch

Evaluate whether advanced consumers need a controlled override such as:

```css
--orp-container-max
```

at local scope.

This can sometimes be better than adding many variants.

Only expose it if consistent with ORP's token strategy.

---

# 40. Hardcoded Values

Avoid repeated raw:

```text
max-width
padding-inline
margin
```

when Foundation tokens can represent the design decision.

Behavioral CSS values are acceptable when they are not design tokens.

---

# 41. No Bootstrap Clone

Do not create:

```text
.container
.container-sm
.container-md
.container-lg
.container-xl
.container-xxl
.container-fluid
```

as an ORP-prefixed copy.

The goal is a smaller modern system.

---

# 42. No Tailwind Clone

Do not create dozens of:

```text
max-w-*
mx-auto
px-*
w-full
```

helpers to construct Container manually.

Container should encode the generic layout responsibility.

---

# 43. No Utility Soup

Consumers should be able to write:

```html
<div class="orp-container">
```

not:

```html
<div class="orp-w-full orp-max-w-xl orp-mx-auto orp-px-4">
```

That is precisely the abstraction Container should avoid.

---

# 44. Playground

Add a dedicated Container section under Primitives / Primary.

---

# 45. Playground — Default

Show viewport boundaries and Container boundary clearly.

Use realistic content.

Do not rely only on colored debug boxes.

---

# 46. Playground — Responsive

Demonstrate default Container across widths.

The demo should make clear:

- mobile gutter
- fluid growth
- max width
- desktop centering

---

# 47. Playground — With Section

Show:

```text
Section
└── Container
```

to establish ownership.

---

# 48. Playground — With Grid

Show:

```text
Container
└── Grid
    ├── item
    ├── item
    └── item
```

Verify Grid does not duplicate horizontal page padding.

---

# 49. Playground — With Surface

Only if Surface exists.

Show a useful composition.

---

# 50. Playground — Full-Width Background

If supported by existing primitives, demonstrate:

```text
full-width section/surface
└── constrained Container
```

This is an important modern page composition.

Do not create new primitives solely for the demo.

---

# 51. Playground — Variants

Only show variants that passed the audit.

Do not create `narrow/wide/fluid` simply to make the Playground richer.

---

# 52. Visual QA

Use browser tooling if available.

Inspect actual rendered output.

Do not claim visual QA from LESS inspection.

---

# 53. Responsive QA

Required widths:

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

- page gutters
- max width
- centering
- long Spanish content
- Grid inside Container
- Surface inside/outside Container if applicable
- Cards
- no horizontal page overflow
- no double padding
- no unexpectedly tiny content

---

# 54. 320px Is Important

At 320px specifically verify:

```text
viewport gutter
+ Surface inset
+ Card inset
```

still leaves practical content width.

Do not optimize only for 390px+.

---

# 55. Large Desktop

At 1440px verify that content does not become excessively wide merely because space exists.

The design should feel intentional rather than stretched.

---

# 56. Accessibility

Container itself should normally require no ARIA role.

Do not add:

```html
role="main"
role="region"
```

automatically.

Semantic landmarks belong to consumer markup.

---

# 57. HTML Element

Container CSS should ideally work on:

```html
div
main
section
header
footer
nav
```

where semantically appropriate.

Do not tie visual behavior to a single HTML element unnecessarily.

---

# 58. Interaction

Container has no interaction behavior.

Do not create:

- hover
- selected
- disabled
- clickable

variants.

---

# 59. Radius / Border / Shadow

Container should NOT own:

- border
- radius
- shadow
- background

Those belong to Surface/Card/components/helpers.

Container is layout.

---

# 60. Tests

Run existing ORP tests.

If Container is pure CSS, do not create meaningless Vue unit tests.

Use visual/browser tests where available.

---

# 61. Build

Run:

```bash
npm run build
```

Must pass.

---

# 62. Scope Restrictions

DO NOT:

- modify Acerca
- migrate Minisite sections
- modify Laravel/backend
- create new Card Patterns
- create Skeleton
- create Progress
- create Status
- expand Map
- redesign Media in this phase
- start Visual Direction Audit
- start Global Architecture Audit
- create responsive utility matrices

Acerca may be inspected read-only.

---

# 63. Existing API Compatibility

Do not break existing:

- Section
- Grid
- Stack
- Cluster
- Card
- Surface
- Playground layouts

If existing ownership conflicts with Container, document it rather than performing a mass migration.

---

# 64. Migration Findings

If the audit reveals that existing Section/local layouts currently own Container responsibilities, report:

```text
CURRENT
→ TARGET
```

Example:

```text
CURRENT:
Section = vertical spacing + horizontal gutter + max width

TARGET:
Section = vertical rhythm
Container = horizontal gutter + max width
```

Do not automatically refactor all consumers.

---

# 65. Required Report

Generate:

```text
ORP-CONTAINER-PRIMITIVE-REPORT.md
```

---

# 66. Report Structure

```text
# ORP Container Primitive Report

## Executive Summary

## Existing Layout Primitive Inventory

## Horizontal Spacing Ownership Audit

## Discovery Matrix

## Existing Wrapper Patterns

## Read-Only Acerca Evidence

## Container Acceptance Test

## Decision

## Default Container Behavior

## Page Gutter Strategy

## Max Width Strategy

## Responsive Strategy

## Container vs Section

## Container vs Grid

## Container vs Stack / Cluster

## Container vs Surface

## Container vs Card

## Content Measure Distinction

## Full-Bleed Composition

## Nested Container Behavior

## Variants Considered

## Variants Implemented

## Variants Rejected

## Token Usage

## Hardcoded Values

## Playground Coverage

## Mobile QA

## Desktop QA

## Accessibility

## Tests

## Build

## Files Created

## Files Modified

## Compatibility / Migration Notes

## Deferred Findings

## Final Primitive Architecture

## Next Recommended Phase
```

---

# 67. Required Verdict

End Container analysis with exactly one:

```text
CONTAINER PRIMITIVE CREATED
```

or:

```text
CONTAINER PRIMITIVE EXTENDED
```

or:

```text
CONTAINER PRIMITIVE ALREADY ADEQUATE
```

or:

```text
CONTAINER PRIMITIVE NOT JUSTIFIED
```

Explain evidence.

---

# 68. Final Primitive Architecture

Report the actual architecture after this phase.

Example only:

```text
Primitives / Primary
├── Stack
├── Cluster
├── Grid
├── Container
├── Section
├── Divider
├── Surface
├── Card
├── Media
├── Avatar
├── Badge
├── Price
└── List
```

Do not claim Surface exists if its previous audit rejected it.

---

# 69. Next Phase

After Container, do NOT immediately create another primitive.

The recommended next step should be:

```text
MEDIA CAPABILITY AUDIT
```

The purpose of that later audit will be to verify whether existing Media already adequately handles:

- aspect ratio
- object-fit
- responsive media
- placeholders/fallbacks
- overlays
- captions relationship
- loading states
- media composition

Do NOT perform that audit now.

---

# 70. STOP CONDITION

STOP after:

1. repository audit
2. horizontal spacing ownership analysis
3. discovery matrix
4. Container decision
5. implementation only if justified
6. Playground examples
7. responsive QA
8. accessibility QA
9. tests
10. `npm run build`
11. report
12. recommendation for Media Capability Audit

Do not continue automatically.

---

# FINAL INSTRUCTION

Build Container as a true ORP layout primitive, not a Bootstrap clone.

1. Audit the repository first.
2. Determine who currently owns page gutters.
3. Find repeated `max-width + auto margins + horizontal padding`.
4. Inspect Acerca read-only for real evidence.
5. Separate horizontal page boundary from vertical Section rhythm.
6. Separate Container from Grid.
7. Separate Container from Surface.
8. Separate Container from Card.
9. Distinguish page width from readable text measure.
10. Prefer fluid modern responsive behavior.
11. Avoid breakpoint-specific container matrices.
12. Reuse ORP breakpoint/tokens if needed.
13. Keep mobile gutters useful at 320–430px.
14. Prevent double horizontal padding.
15. Prevent nested Container gutter multiplication.
16. Prefer logical CSS properties.
17. Keep Container free of border/background/radius/shadow.
18. Keep Container free of interaction.
19. Prefer CSS primitive over Vue wrapper.
20. Add only evidence-backed variants.
21. Do not recreate Bootstrap `.container-*`.
22. Do not recreate Tailwind max-width/spacing utilities.
23. Add Playground examples.
24. Test Section + Container.
25. Test Container + Grid.
26. Test full-width region + constrained content if existing architecture supports it.
27. Verify 320/375/390/430/768/1200/1440.
28. Run tests.
29. Run `npm run build`.
30. Generate `ORP-CONTAINER-PRIMITIVE-REPORT.md`.
31. Recommend Media Capability Audit as the next phase.
32. STOP.

