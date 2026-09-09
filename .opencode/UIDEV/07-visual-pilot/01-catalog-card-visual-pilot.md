# ORP UI — VISUAL PILOT REDESIGN
# Pilot: CatalogCard Collection
# Run after ORP-VISUAL-DIRECTION-AUDIT.md
# Goal: prove the ORP 2026 visual direction on ONE representative composition before broader rollout

## Context

The ORP Visual Direction Audit completed successfully:

```text
Build: PASS
Report: .opencode/ORPUI/ORP-VISUAL-DIRECTION-AUDIT.md
Next Phase: ORP VISUAL PILOT REDESIGN — CatalogCard Collection
```

ORP architecture is considered stable.

This phase is NOT about adding framework capabilities.

It is a controlled visual redesign of one representative pilot:

```text
CatalogCard Collection
```

The purpose is to answer:

> Can the existing ORP architecture produce a modern, recognizable, mobile-first 2026 visual language without adding more framework layers?

The result will become evidence for the later visual rollout across the rest of ORP.

---

# 1. Source of Truth

Before editing anything, read:

```text
.opencode/ORPUI/ORP-VISUAL-DIRECTION-AUDIT.md
```

Also inspect the actual repository implementation of:

```text
Default Theme 2026
CatalogCard
Card
Media
Badge
Price
Button
IconButton
Grid
Container
Section
Stack
Cluster
Divider
Surface
Typography
Visual Helpers
Playground
```

The audit report is the visual problem statement.

The repository is the API/source-of-truth.

Do not invent APIs based on this prompt.

---

# 2. Objective

Redesign ONLY the CatalogCard Collection pilot.

The pilot must demonstrate:

- stronger ORP visual identity
- less Bootstrap resemblance
- stronger content hierarchy
- modern 2026 visual language
- better mobile composition
- purposeful imagery
- restrained use of Card chrome
- intentional spacing
- coherent typography
- restrained Electric Indigo/primary usage
- consistent radius
- meaningful borders
- meaningful elevation
- better action hierarchy
- better collection rhythm

without breaking:

- CatalogCard API
- genericity
- accessibility
- responsiveness
- existing ORP architecture

---

# 3. Critical Scope Rule

This is a VISUAL PILOT.

Do NOT:

- redesign the entire framework
- redesign every Pattern
- modify Acerca
- modify Laravel/backend
- create new Patterns
- create new Components
- create new Primitives
- create new helper families
- create new token systems
- introduce third-party UI libraries

If the pilot exposes a system-level issue, document it.

Only make a Foundation-level adjustment when it is absolutely necessary for the pilot and clearly supported by the Visual Direction Audit.

---

# 4. Do Not Solve Visual Problems by Growing ORP

Forbidden reaction:

```text
CatalogCard needs a different layout
→ create OrpCatalogGrid
→ create OrpCatalogMedia
→ create OrpCatalogActions
→ create more variants
```

Preferred reaction:

```text
CatalogCard
+ Media
+ Grid
+ Stack
+ Cluster
+ Typography
+ existing tokens
→ better composition
```

Prove that the existing system works.

---

# 5. Pilot Definition

The pilot is NOT one isolated CatalogCard.

The pilot is:

```text
Section / Collection
└── Container
    ├── Collection header
    └── Catalog collection
        ├── CatalogCard
        ├── CatalogCard
        ├── CatalogCard
        └── ...
```

This is important.

We need to evaluate the Pattern in real composition.

---

# 6. Build a Realistic Collection

Use realistic domain-neutral examples.

For example, the collection may visually represent:

- experiences
- services
- courses
- spaces
- memberships
- products
- destinations

But do not make CatalogCard API domain-specific.

Use enough content variation to expose layout behavior.

---

# 7. Required Pilot Content Cases

Include at least:

1. normal item
2. long title
3. long description
4. badge
5. no badge
6. value/price
7. no value
8. multiple metadata items
9. one action
10. multiple actions if supported safely
11. no media if CatalogCard supports optional media
12. portrait-ish source image
13. landscape source image
14. long Spanish content

Do not optimize the design only for perfect demo data.

---

# 8. Mobile First

Start visual work at:

```text
390px
```

Then verify:

```text
320
375
390
430
```

Only after mobile is correct move to:

```text
768
1200
1440
```

Do not design desktop first and collapse it.

---

# 9. Desired Mobile Feeling

The collection should feel closer to a modern native/app-like catalog than a Bootstrap card grid.

Target qualities:

- strong media
- easy scanning
- clear title/value hierarchy
- compact supporting metadata
- obvious but restrained actions
- comfortable touch spacing
- deliberate horizontal/vertical rhythm

---

# 10. Mobile Collection Strategy

Evaluate whether mobile should use:

```text
single-column vertical collection
```

or:

```text
horizontal scroll with next-card peek
```

or another existing ORP-supported composition.

Choose based on the Visual Direction Audit and current Playground purpose.

Do NOT add carousel behavior merely for visual novelty.

If horizontal scroll is used:

- use existing/native behavior
- next item should peek intentionally
- scrolling must be obvious
- no hidden essential content
- keyboard/accessibility must remain reasonable

---

# 11. Desktop Collection Strategy

Do not default to:

```text
4 equal cards in a rigid Bootstrap grid
```

without evaluating hierarchy.

Use existing Grid capabilities intentionally.

Check:

- column count
- card width
- media ratio
- whitespace
- collection density

Desktop should feel composed, not auto-generated.

---

# 12. Anti-Bootstrap Test

At every iteration ask:

> If all `orp-*` class names disappeared, would this still look like a Bootstrap card grid?

If yes, continue.

Identify the reason:

- border
- shadow
- radius
- equal-box repetition
- button style
- badge style
- media ratio
- typography
- spacing
- layout
- action placement

---

# 13. Card Chrome

CatalogCard should not depend on:

```text
white box
+ visible gray border
+ large radius
+ shadow
```

all at once.

Use the ORP grouping hierarchy:

```text
Spacing
→ Alignment
→ Typography
→ Divider
→ Surface
→ Card
```

CatalogCard is legitimately a Card Pattern, but its visual weight can still be restrained.

---

# 14. Elevation

Use:

```text
Flat
→ Border
→ Surface contrast
→ Shadow
```

Shadow only when elevation or interaction benefits from it.

Do not use shadow as default decoration.

---

# 15. Default Card State

Evaluate whether CatalogCard should be:

- flat
- quietly bordered
- subtly surfaced

rather than raised.

Use actual ORP Card variants/API.

Do not invent a CatalogCard-only visual system.

---

# 16. Interactive State

If CatalogCard is interactive, the interaction should become apparent through subtle:

- border change
- surface change
- media treatment
- translation
- shadow/elevation

Use the minimum necessary.

Do not combine all effects.

---

# 17. Hover

Hover only for appropriate pointer devices.

Keep it subtle.

No dramatic:

```text
translateY(-8px)
scale(1.05)
huge shadow
```

unless the audit provides extraordinary justification.

---

# 18. Media Is a Primary Visual Tool

CatalogCard is one of the Patterns where imagery can be dominant.

Use the stable Media primitive.

Evaluate:

- media ratio
- crop
- edge-to-edge vs inset
- relationship with Card radius
- overlay placement
- responsive height

---

# 19. Avoid Thumbnail Syndrome

Do not make meaningful imagery a tiny decorative rectangle if the catalog depends on visual recognition.

Allow media to establish hierarchy.

---

# 20. Avoid Universal Rounded Media

Do not automatically give the image its own large radius inside an already rounded Card.

This often produces:

```text
rounded box inside rounded box
```

and unnecessary visual weight.

Evaluate edge-to-edge media where appropriate.

---

# 21. Media Ratio

Use existing Media capabilities.

Do not create CatalogCard-specific ratio utilities.

Choose a ratio that works with:

- 320px
- collection density
- desktop Grid
- realistic content

---

# 22. Overlay

If Badge or actions appear over Media:

use existing generic Media overlay capability if available.

Keep overlay content minimal.

Do not turn the image into a control panel.

---

# 23. Gradient

Do not add a gradient merely because modern cards often use one.

Use a readability gradient only if actual text overlays require it.

---

# 24. Typography Hierarchy

CatalogCard should be understandable in this order:

```text
1. Media / identity
2. Title
3. Value or key decision information
4. Description / supporting context
5. Metadata
6. Actions
```

Exact order may vary by composition, but hierarchy must be obvious.

---

# 25. Title

Title should:

- have clear weight
- wrap gracefully
- avoid oversized typography
- remain readable with long Spanish content

Do not force one-line truncation unless the existing API/design explicitly requires it.

---

# 26. Description

Description is supporting content.

It should not visually compete with title/value.

If line clamping is used, use existing helpers and verify accessibility/content implications.

Do not add arbitrary clamp behavior solely to make cards equal height.

---

# 27. Metadata

Metadata should be compact.

Prefer:

- subtle text
- simple icon + text where useful
- controlled spacing

Avoid:

```text
badge badge badge badge
```

for ordinary metadata.

---

# 28. Badge

Badge is supporting information.

Audit:

- pill shape
- color saturation
- padding
- position
- weight

Do not make it look like a miniature Bootstrap button.

---

# 29. Value / Price

When present, value should be easy to find.

Use existing Price/value patterns.

Do not over-scale price until every CatalogCard looks like e-commerce.

The Pattern must remain generic.

---

# 30. Actions

Action hierarchy is critical.

Avoid a footer full of equally weighted buttons.

Prefer:

```text
one primary action
+ quieter secondary action
```

when the use case requires multiple actions.

Use existing Button/IconButton APIs.

---

# 31. Whole-Card Interaction

Respect the existing CatalogCard interaction strategy.

Do not introduce nested interactive elements.

If the entire card is clickable, actions inside it must remain semantically safe.

Do not change accessibility strategy casually.

---

# 32. Primary Color

Use the approved Default Theme 2026 primary intentionally.

Primary should emphasize:

- key CTA
- selected/active state
- focus
- important identity moment

Do not use primary for:

- every icon
- every title
- every badge
- every border
- every metadata item

---

# 33. Neutral Hierarchy

The majority of the CatalogCard should be carried by:

- white/neutral surfaces
- ink hierarchy
- spacing
- media
- subtle borders

not saturated colors.

---

# 34. Radius

Use approved radius tokens.

Audit:

- Card
- Media
- Badge
- Button

They should belong to one visual family.

Avoid making everything equally rounded.

---

# 35. Pills

Pills should be reserved for elements whose semantics benefit from the shape.

Do not convert every action and Badge to pills merely to appear modern.

---

# 36. Border

If Card uses a border:

keep it quiet.

The border should define structure, not become a visual feature.

---

# 37. Shadow

If Card uses shadow:

it must have a reason.

Potential reasons:

- hover elevation
- selected/floating state
- separation from complex background

Not:

```text
all cards need shadows
```

---

# 38. Collection Background

Evaluate the collection against:

- base canvas
- subtle Surface
- plain Section

Do not put a Surface behind Cards automatically.

Too many nested surfaces recreate template-like UI.

---

# 39. Section Header

The pilot collection should include a realistic header.

Use existing Section/Typography/Stack/Cluster.

Example content structure:

```text
Eyebrow or supporting label — only if useful
Heading
Supporting text
Optional quiet action
```

Do not create a hero.

---

# 40. Section Rhythm

Ensure visible relationship:

```text
section heading
↓
collection
↓
next section / page edge
```

Do not rely on giant arbitrary margins.

Use existing spacing tokens/primitives.

---

# 41. Container

Use the stable Container primitive.

Verify:

- mobile gutters
- desktop width
- no double padding
- Grid alignment with heading

---

# 42. Grid

Use stable Grid.

Do not create custom CSS Grid unless existing Grid cannot express the pilot.

If a limitation is found, document it rather than immediately expanding Grid.

---

# 43. Equal Heights

Do not force equal Card heights unless it genuinely improves the collection.

Modern collections can tolerate content variation when hierarchy remains strong.

If equal height is already part of Grid/Card behavior, evaluate rather than blindly removing.

---

# 44. Actions at Bottom

Do not use flex hacks merely to align every button at identical card bottoms unless that improves scanability.

Test both visual rhythm and content meaning.

---

# 45. Visual Weight Budget

For each CatalogCard count:

```text
background
border
radius
shadow
media
badge
icon container
price
primary CTA
secondary CTA
divider
```

Reduce simultaneous competing weights.

---

# 46. Recommended Visual Weight

A typical CatalogCard should ideally have only a few strong signals:

```text
media
title/value
primary action OR interaction affordance
```

Everything else should support those.

---

# 47. Pattern Identity

CatalogCard should emerge as:

```text
visual entity in a collection
```

not:

```text
generic Card with slots
```

without becoming domain-specific.

---

# 48. Genericity Test

After redesign, verify the same Pattern can plausibly represent:

- a service
- a product
- a course
- an experience
- a property
- a room
- a dish
- a membership

without visual assumptions breaking.

---

# 49. Do Not Hardcode Business Semantics

Do not add:

```text
sale
stock
duration
bedrooms
rating
teacher
category
availability
```

to CatalogCard.

The consumer owns content.

---

# 50. CSS Responsibility

Pattern-specific LESS may control:

- composition
- hierarchy
- media relationship
- internal layout
- responsive structure

It should NOT duplicate:

- Button styling
- Badge styling
- Price styling
- Grid
- Container
- global typography
- shadows
- generic radius helpers

---

# 51. Local CSS Reduction

If the redesign can remove Pattern-specific declarations because Foundation now solves them, do so.

But do not chase line-count reduction as the goal.

Clarity and ownership matter more.

---

# 52. Token Compliance

No hardcoded design values when an ORP token exists.

Audit for:

- colors
- spacing
- radius
- shadows
- typography
- borders
- motion

---

# 53. Hardcoded Values

Some structural values may be legitimate.

Document any new hardcoded value and why it is not a design token.

---

# 54. No Bootstrap Classes

The pilot must not use Bootstrap classes.

Search final pilot markup/styles for Bootstrap remnants.

---

# 55. No Utility Soup

Do not produce markup like:

```text
orp-border
orp-rounded-lg
orp-shadow-sm
orp-overflow-hidden
orp-text...
...
```

when a semantic Pattern/Primitive already owns the composition.

Helpers should remain occasional modifiers.

---

# 56. Accessibility

Preserve/improve:

- heading hierarchy
- link/button semantics
- alt text
- focus visibility
- keyboard navigation
- touch targets
- contrast
- non-color-only meaning

---

# 57. Focus State

CatalogCard links/actions must have visible focus.

Focus should feel ORP-native, not Bootstrap blue glow.

---

# 58. Touch Targets

At mobile widths, interactive targets should remain comfortably usable.

Do not shrink IconButtons/actions for visual neatness.

---

# 59. Reduced Motion

Any hover/motion changes must respect:

```text
prefers-reduced-motion
```

Reuse ORP motion strategy.

---

# 60. Responsive QA

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

At every width inspect actual browser rendering.

---

# 61. 320px QA

Specifically verify:

- Container gutter
- Card inset
- Media width
- title wrapping
- metadata wrapping
- value
- actions
- no accidental horizontal overflow

---

# 62. 390px QA

This is the primary mobile reference for the pilot.

Capture BEFORE and AFTER screenshots if tooling exists.

---

# 63. 768px QA

Check the transition from phone composition to larger collection layout.

Avoid awkward intermediate Card widths.

---

# 64. 1200 / 1440 QA

Check:

- max content width
- Grid column count
- Card density
- media scale
- excessive empty space
- repetitive visual rhythm

---

# 65. Content Stress Test

Use a stress-test card with:

```text
very long Spanish title
long supporting description
multiple metadata items
badge
value
two actions
```

The layout should degrade gracefully.

---

# 66. Missing Media Test

If media is optional in the existing CatalogCard API:

test without media.

Do not leave awkward empty space.

---

# 67. Missing Value Test

Test without value.

The Card should still feel balanced.

---

# 68. Missing Actions Test

If supported, test a card with no explicit action.

Do not leave empty footer structure.

---

# 69. Pattern Comparison

After redesign, place the redesigned CatalogCard near at least:

```text
ContentCard
ProfileCard
PricingCard
```

without redesigning those Patterns.

Check:

- CatalogCard now has clearer purpose
- it still shares ORP DNA
- it does not make the rest look like a different framework due to excessive stylistic novelty

Document the result.

---

# 70. Do Not Propagate Yet

Even if the pilot succeeds:

DO NOT immediately apply the changes to all Patterns.

The pilot must be reviewed first.

---

# 71. Before Screenshot

Capture the existing CatalogCard Collection before visual edits.

Required preferred widths:

```text
390
1440
```

If screenshot tooling is unavailable, document this limitation.

---

# 72. After Screenshot

Capture the redesigned pilot at the same widths.

Use equivalent content for meaningful comparison.

---

# 73. Side-by-Side Evaluation

Compare before/after using:

```text
Hierarchy
Bootstrap resemblance
Card visual weight
Media dominance
Typography
Spacing
Primary-color usage
Action hierarchy
Mobile usability
Pattern identity
```

---

# 74. Bootstrap Resemblance Score

Reuse the audit's 0–3 diagnostic scale.

Report:

```text
BEFORE: X/3
AFTER: X/3
```

for CatalogCard Collection.

Target:

meaningful reduction.

Do not manipulate the score without visual evidence.

---

# 75. Cohesion Evaluation

Rate before/after 1–5:

```text
Typography cohesion
Spacing cohesion
Surface cohesion
Control cohesion
Mobile cohesion
Brand cohesion
Pattern identity
```

---

# 76. Success Criteria

The pilot succeeds only if:

1. Bootstrap resemblance is visibly reduced.
2. Existing ORP architecture remains intact.
3. No unnecessary framework abstractions were added.
4. Mobile composition is materially better.
5. CatalogCard purpose is clearer.
6. Media hierarchy improves.
7. Typography hierarchy improves.
8. Card chrome is reduced or justified.
9. Primary color usage is more intentional.
10. Actions have clearer hierarchy.
11. Accessibility is preserved/improved.
12. Desktop remains coherent.
13. Build passes.
14. Existing tests pass.

---

# 77. Failure Criteria

The pilot fails if it becomes:

- visually trendy but less usable
- excessively minimal
- domain-specific
- dependent on many new variants
- helper soup
- visually disconnected from ORP
- inaccessible
- overly animated
- another rounded-card aesthetic
- dependent on new framework architecture

---

# 78. Remediation Order

When editing, use:

```text
1. Composition / flow
2. Hierarchy
3. Grouping
4. Remove unnecessary visual weights
5. Spacing / alignment / density
6. Typography
7. Media
8. Borders / radius / elevation
9. Color
10. Controls / states
11. Motion
```

Do not start with shadow/color tweaks.

---

# 79. Preserve Functionality

Do not alter CatalogCard behavior unless required for accessibility.

Preserve:

- props
- slots
- events
- interaction contract
- semantic structure where valid

If markup must change for visual composition, ensure API compatibility.

---

# 80. API Changes

Avoid public API changes.

If one is truly necessary, document:

```text
WHY
CURRENT API
PROPOSED API
BREAKING?
MIGRATION COST
```

Do not make it silently.

---

# 81. Playground Is the Pilot Environment

Implement the pilot in ORP Playground.

Do not use Acerca as the experimental environment.

---

# 82. Keep Playground Honest

Do not hide problematic states.

The Playground should show:

- normal
- dense
- long content
- missing optional regions
- responsive collection

---

# 83. Documentation

Update CatalogCard visual/composition guidance only if the pilot is accepted technically.

Document:

```text
When to use
Visual hierarchy
Media guidance
Action guidance
Collection guidance
When NOT to use
```

Do not document domain examples as API rules.

---

# 84. Tests

Run all relevant CatalogCard/ORP tests.

Add tests only if markup/API behavior changed in a meaningful way.

Do not test pixels through unit tests.

---

# 85. Build

Run:

```bash
npm run build
```

Must pass.

---

# 86. Console QA

Check Playground browser console.

No new:

- errors
- warnings
- missing assets
- Vue warnings

---

# 87. Required Report

Generate:

```text
.opencode/ORPUI/ORP-VISUAL-PILOT-CATALOG-CARD.md
```

---

# 88. Report Structure

```text
# ORP Visual Pilot — CatalogCard Collection

## Executive Summary

## Source Audit Findings Used

## Pilot Scope

## Files Audited

## Files Modified

## Existing CatalogCard API

## API Changes
None / details

## Before Visual Assessment

## Before Bootstrap Resemblance Score

## Problems Addressed

## Composition Changes

## Hierarchy Changes

## Card Chrome Changes

## Media Changes

## Typography Changes

## Spacing Changes

## Badge Changes

## Price / Value Changes

## Action Hierarchy Changes

## Color Changes

## Border / Radius / Elevation Changes

## Motion Changes

## Mobile Design

## Desktop Design

## Accessibility

## Genericity Validation

## Stress Test Results

## Pattern Family Comparison

## Before / After Screenshots

## Before / After Cohesion Scores

## Bootstrap Resemblance Before / After

## Token Compliance

## Hardcoded Value Audit

## Tests

## Build

## Console

## Success Criteria Results

## Rejected Ideas

## System-Level Findings Discovered

## Final Verdict

## Recommended Next Phase
```

---

# 89. Required Final Verdict

End with exactly one:

```text
CATALOG CARD VISUAL PILOT APPROVED
```

or:

```text
CATALOG CARD VISUAL PILOT NEEDS ITERATION
```

Explain why.

---

# 90. If Pilot Is Approved

Recommend:

```text
NEXT PHASE:
ORP VISUAL DIRECTION ROLLOUT PLAN
```

The rollout plan should determine which Foundation/Component/Pattern visual changes should propagate and in what order.

Do NOT execute rollout during this task.

---

# 91. If Pilot Needs Iteration

Recommend:

```text
NEXT PHASE:
CATALOG CARD VISUAL PILOT ITERATION
```

and list only the remaining blocking visual problems.

Do not broaden scope.

---

# 92. No Acerca Yet

Even after approval:

do not automatically migrate Acerca.

Expected sequence:

```text
Visual Pilot
↓
Visual Direction Rollout Plan
↓
ORP internal rollout
↓
Visual QA
↓
Acerca dogfooding
```

---

# 93. STOP CONDITION

STOP after:

1. reading Visual Direction Audit
2. inspecting existing CatalogCard
3. capturing before state
4. redesigning CatalogCard Collection only
5. mobile-first implementation
6. desktop adaptation
7. stress testing
8. accessibility QA
9. Pattern comparison
10. before/after comparison
11. tests
12. build
13. console QA
14. report
15. final verdict
16. one next-phase recommendation

Do not redesign another Pattern.

Do not migrate Acerca.

---

# FINAL INSTRUCTION

This phase must prove ORP's visual direction, not expand ORP.

Take the existing CatalogCard Collection and make it feel unmistakably more:

```text
ORP 2026
```

and less:

```text
Bootstrap with custom tokens
```

Use the architecture already built.

Prioritize:

```text
Composition
→ Hierarchy
→ Grouping
→ Spacing
→ Typography
→ Media
→ Restraint
→ Controls
→ Motion
```

Remember:

```text
Spacing
→ Alignment
→ Typography
→ Divider
→ Surface
→ Card
```

and:

```text
Flat
→ Border
→ Surface contrast
→ Shadow
```

Use dominant media when useful.

Use primary color intentionally.

Use fewer simultaneous visual weights.

Design mobile first.

Keep CatalogCard generic.

Preserve accessibility.

Preserve API compatibility.

Do not add new framework layers.

Capture before/after.

Generate the report.

STOP.
