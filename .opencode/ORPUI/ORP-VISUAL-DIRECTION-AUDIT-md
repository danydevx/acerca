# ORP UI — VISUAL DIRECTION AUDIT
# System-wide visual consistency audit
# Run after Foundation, Primitives and Components are confirmed stable
# DO NOT grow the framework during this phase

## Context

ORP UI has reached an important architectural checkpoint.

The framework foundation is now considered sufficiently complete for visual consolidation.

Confirmed stable areas include:

```text
Foundation
├── Default Theme 2026
├── Typography & Content
├── Visual Helpers
└── Tokens

Primitives / Primary
├── Stack
├── Cluster
├── Grid
├── Container
├── Section
├── Divider
├── Surface        ← if previous audit justified it
├── Card
├── Media
├── Avatar
├── Badge
├── Price
└── List

Components
├── Modal
├── Drawer
├── Accordion
├── Map
├── Skeleton
├── Progress
├── Meter
└── other confirmed existing ORP components

Patterns
├── CatalogCard
├── PricingCard
├── ProfileCard
├── ContentCard
├── StatCard
└── ContactCard
```

Previous conclusion:

```text
COMPONENT LAYER COMPLETE
```

Next recommended phase:

```text
VISUAL DIRECTION AUDIT
```

The focus now changes from:

```text
"What is ORP missing?"
```

to:

```text
"Does everything ORP already has feel like one coherent,
modern, recognizable visual system?"
```

---

# 1. Primary Objective

Audit ORP UI visually as a complete design system.

Determine:

- where ORP still resembles Bootstrap
- where components visually disagree with Default Theme 2026
- where hierarchy is weak
- where spacing is inconsistent
- where cards are overused
- where borders/shadows/radius are too heavy
- where typography lacks hierarchy
- where brand color is overused
- where controls look generic/framework-like
- where mobile layouts feel compressed desktop rather than intentionally mobile
- where Patterns do not feel related
- where Playground examples hide real visual problems

This phase is primarily:

```text
AUDIT
→ CLASSIFY
→ PRIORITIZE
→ SELECT ONE PILOT
→ STOP
```

NOT:

```text
AUDIT
→ REDESIGN EVERYTHING
```

---

# 2. Critical Rule

DO NOT create new:

- Foundation systems
- Primitives
- Components
- Patterns
- helper families
- Card variants
- utility systems

during this audit.

The architecture is considered stable enough.

If a genuine structural gap appears, document it as evidence.

Do not solve it immediately.

---

# 3. ORP Visual Direction

ORP should feel:

- modern 2026
- mobile-first
- app-like
- calm
- functional
- refined
- intentionally simple
- spacious without feeling empty
- expressive through hierarchy rather than decoration
- visually cohesive
- brand-aware without painting everything primary
- suitable for both application UI and minisite compositions

ORP should NOT feel like:

- Bootstrap with different colors
- admin template
- generic SaaS dashboard kit
- Material clone
- Tailwind component collection
- Vuetify clone
- Quasar clone
- giant rounded-card system
- pill-everything UI
- shadow-everything UI

---

# 4. Recognition Test

For every major component ask:

> If the ORP class names disappeared, could this easily be mistaken for Bootstrap?

If yes, identify why.

Possible causes:

- Bootstrap-like button proportions
- Bootstrap-like form controls
- Bootstrap-like blue focus
- generic `.card` composition
- repetitive border + radius + shadow
- Bootstrap spacing rhythm
- generic badge pills
- old-fashioned modal treatment
- rigid centered layouts
- weak typography hierarchy
- excessive boxes

Document the specific visual signal.

Do not merely write:

```text
"looks Bootstrap-like"
```

Explain WHY.

---

# 5. Audit Source of Truth

The primary visual reference must be:

```text
ORP Playground
```

The Playground should eventually become the canonical visual reference for ORP.

Audit it as a system, not component-by-component in isolation.

Also inspect ORP documentation and implementation.

Acerca may be inspected READ-ONLY to understand real composition pressure.

Do NOT migrate Acerca in this phase.

---

# 6. Browser Inspection Is Mandatory

If browser tooling exists, inspect the actual rendered Playground.

Code review alone is insufficient.

Capture or inspect before-state at minimum:

```text
390px
1440px
```

Also perform targeted responsive checks at:

```text
320
375
390
430
768
1200
1440
```

---

# 7. Audit Order

Follow this exact order:

```text
1. Page flow
2. Visual hierarchy
3. Grouping
4. Layout composition
5. Density
6. Typography
7. Spacing
8. Surfaces
9. Borders
10. Radius
11. Elevation / shadows
12. Color
13. Controls
14. States
15. Media
16. Patterns
17. Motion
18. Accessibility
19. Responsive behavior
20. Cross-component consistency
```

Do not begin by tweaking colors.

---

# 8. Grouping Priority

Use this hierarchy when evaluating grouping:

```text
1. Spacing
2. Alignment
3. Typography
4. Divider
5. Surface
6. Card
```

Flag places where ORP jumps directly to Card.

---

# 9. Elevation Priority

Evaluate visual elevation using:

```text
1. Flat
2. Border
3. Surface contrast
4. Shadow
```

Shadow requires a behavioral or layering reason.

Flag decorative shadows.

---

# 10. Default Theme 2026

Audit all components against the approved/default 2026 direction.

The theme direction includes:

```text
Primary:
Electric Indigo family

Foundation:
near-white / neutral surfaces

Text:
neutral ink hierarchy

Borders:
quiet neutral

Semantic:
success
warning
danger
info

Elevation:
restrained

Radius:
modern but not exaggerated
```

The exact repository tokens are the source of truth.

Do NOT replace them from this prompt.

---

# 11. Primary Color Audit

Inspect where primary color appears.

Classify every major use as:

```text
ESSENTIAL
USEFUL
EXCESSIVE
DECORATIVE
```

Primary should primarily communicate:

- main action
- selection
- focus
- active state
- identity/brand emphasis

It should NOT become universal paint.

---

# 12. Neutral Surface Audit

Inspect:

- canvas
- base surface
- subtle surface
- muted surface
- Card
- Modal
- Drawer
- forms
- tables
- map framing
- Pattern surfaces

Check whether enough hierarchy exists without relying on colored backgrounds.

---

# 13. Typography Audit

Audit actual typography implementation.

Evaluate:

- font family
- weight hierarchy
- size hierarchy
- line height
- letter spacing
- labels
- supporting text
- meta text
- headings
- numbers
- button text
- form text
- long Spanish text

---

# 14. Typography Roles

Verify that visual usage approximately maps to a coherent ladder such as:

```text
Display
Heading
Title
Body
Supporting
Label
Meta
```

Do not create seven Vue components.

This is a visual hierarchy audit.

---

# 15. Manrope / Approved Font

If Default Theme 2026 selected Manrope or another font:

verify that it is actually applied consistently.

Audit:

- fallback behavior
- loading
- performance
- forms
- buttons
- numeric values
- headings
- Playground

If the repository selected another typography decision, respect the actual approved implementation.

---

# 16. Font Weight Audit

Flag excessive reliance on:

```text
700
800
900
```

if hierarchy could be achieved more quietly.

Target direction is generally restrained.

Headings may often work around medium/semibold rather than ultra-bold.

Use actual theme decisions.

---

# 17. Text Hierarchy

Check whether:

```text
title
body
supporting
meta
```

are distinguishable without using excessive colors or font sizes.

---

# 18. Long Spanish Content

Use realistic long Spanish strings.

ORP must not only look good with:

```text
Title
Short description
```

Test:

- long names
- long labels
- multi-line descriptions
- prices
- metadata
- button labels
- form labels

---

# 19. Spacing Audit

Inspect spacing relationships, not isolated numbers.

Evaluate:

```text
related items
group spacing
component spacing
section spacing
page spacing
```

The difference between these levels should be understandable.

---

# 20. 8px Rhythm

Use the existing ORP spacing token system.

Evaluate whether the system maintains a coherent rhythm broadly compatible with an 8px-based design logic.

Do not force every value to exactly 8px multiples if optical adjustment is justified.

---

# 21. One Axis, One Spacing Owner

Detect conflicts such as:

```text
Stack gap
+ child margin-bottom
```

or:

```text
Section padding
+ Container padding
+ component outer padding
```

Flag duplicate ownership.

---

# 22. Card Audit

This is a HIGH PRIORITY area.

Inventory where Card appears in Playground.

Ask for each case:

> Does this content actually need Card containment?

Classify:

```text
CARD JUSTIFIED
SURFACE WOULD BE BETTER
DIVIDER/SPACING WOULD BE BETTER
PLAIN LAYOUT WOULD BE BETTER
PATTERN REQUIRES CARD
```

Do NOT refactor during the audit.

---

# 23. Card Visual Weight

Evaluate:

- border
- radius
- shadow
- background
- padding
- media treatment
- hover
- interactive treatment

A default Card should not visually scream:

```text
Bootstrap card
```

---

# 24. Pattern Card Repetition

Inspect:

- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard

Place them together.

Ask:

```text
Do these look like six variations of the same Bootstrap card?
```

If yes, determine which dimensions need differentiation.

---

# 25. Pattern Family Coherence

Patterns should share ORP DNA while maintaining purpose.

Expected distinctions:

```text
CatalogCard
→ entity/item discovery

PricingCard
→ value proposition / selection

ProfileCard
→ identity

ContentCard
→ editorial/content preview

StatCard
→ metric

ContactCard
→ contact/location
```

They should not differ only by slot names.

---

# 26. CatalogCard Audit

Evaluate:

- media dominance
- title hierarchy
- metadata density
- value emphasis
- actions
- mobile behavior

CatalogCard should feel suitable for visual collections.

---

# 27. PricingCard Audit

Evaluate:

- value hierarchy
- feature readability
- featured state
- CTA prominence
- comparison behavior

Avoid generic Bootstrap pricing-table appearance.

---

# 28. ProfileCard Audit

Evaluate:

- identity hierarchy
- Avatar/media relationship
- title/subtitle
- metadata
- status
- actions

Identity should be immediately clear.

---

# 29. ContentCard Audit

Evaluate:

- editorial hierarchy
- media
- eyebrow/category
- title
- excerpt
- byline/meta
- actions

It should feel content-led rather than commerce-led.

---

# 30. StatCard Audit

Evaluate:

- metric dominance
- label
- trend
- Progress/Meter composition
- supporting metadata

Avoid dashboard-template clichés.

---

# 31. ContactCard Audit

Evaluate:

- information scanability
- map integration
- actions
- details
- hierarchy

ContactCard should not merely look like CatalogCard with different text.

---

# 32. Surface Audit

If Surface exists:

audit whether it actually reduces Card overuse.

Check:

- visual difference from Card
- neutral grouping
- padding
- border
- radius
- nesting
- Section composition

If Surface is visually indistinguishable from Card, flag it.

---

# 33. Divider Audit

Check whether Divider is:

- subtle
- useful
- not overused
- visually quieter than a Card boundary

Spacing should still be preferred when sufficient.

---

# 34. Container Audit

Check:

- mobile gutters
- desktop max width
- centered content
- full-width section compositions
- nested padding
- wide grids

Container should not reproduce rigid Bootstrap breakpoint behavior visually.

---

# 35. Grid Audit

Evaluate collections at different widths.

Check whether Grid creates:

- cramped mobile cards
- too many desktop columns
- repetitive dashboard layouts
- weak hierarchy

A grid is not automatically the right composition just because multiple items exist.

---

# 36. Stack / Cluster Audit

Check whether these primitives are being used to create clear relationships.

Look for unnecessary custom margins that undermine them.

---

# 37. Media Audit

Media capability is stable.

Now evaluate visual usage:

- image dominance
- crop quality
- ratio consistency
- edge-to-edge vs inset
- excessive rounding
- overlays
- relationship with Card

Do not reopen Media architecture unless a critical problem is discovered.

---

# 38. Avatar Audit

Check:

- sizing
- radius
- fallback
- borders
- identity hierarchy

Avoid decorative rings unless semantically/visually justified.

---

# 39. Badge Audit

High-priority Bootstrap resemblance area.

Evaluate:

- pill shape
- padding
- font size
- weight
- color saturation
- border
- placement

Badges should be compact supporting information, not tiny buttons.

---

# 40. Status Through Badge

The Component Gap Review confirmed the final Status/Badge architecture.

Respect that decision.

Audit whether state representation is visually clear without creating a new Status component.

---

# 41. Price Audit

Check numeric hierarchy:

- amount
- currency
- period
- old/new value if applicable
- alignment
- tabular numbers if implemented

Avoid oversized commerce-template styling everywhere.

---

# 42. Buttons

This is another HIGH PRIORITY anti-Bootstrap area.

Audit:

- primary
- secondary
- ghost
- danger
- sizes
- icon buttons
- block buttons
- disabled
- loading if applicable
- focus
- pressed
- hover

---

# 43. Button Shape

Check whether buttons resemble Bootstrap because of:

- radius
- height
- padding
- font weight
- border
- primary blue/indigo fill
- hover treatment

ORP should have its own control proportions.

---

# 44. Button Hierarchy

On a screen with multiple actions:

there should normally be one obvious primary action.

Flag compositions with multiple equally loud filled buttons.

---

# 45. Ghost / Secondary Actions

Check whether secondary/ghost actions truly recede.

Do not use borders everywhere simply to differentiate actions.

---

# 46. IconButton

Audit:

- hit area
- icon optical size
- radius
- hover
- active
- focus
- relationship with regular buttons

Icon buttons should feel deliberate, not like square Bootstrap buttons.

---

# 47. Forms

HIGH PRIORITY.

Audit:

- input
- textarea
- select
- labels
- help text
- error
- disabled
- focus
- placeholder
- grouped controls

---

# 48. Bootstrap Form Signals

Flag:

- generic 1px gray input
- Bootstrap-like height
- large blue focus glow
- excessive rounded corners
- weak label hierarchy
- placeholder used instead of label
- default browser/select mismatch

---

# 49. Focus

Focus must be:

- visible
- accessible
- coherent
- ORP-branded where appropriate
- not Bootstrap's default blue glow

Do not reduce accessibility for visual restraint.

---

# 50. Alert

Audit:

- semantic colors
- icon
- title/message hierarchy
- border/background
- action composition

Alerts should communicate status without becoming large colored boxes unnecessarily.

---

# 51. Empty State

Audit:

- illustration/icon size
- title
- description
- actions
- whitespace

Empty State should feel intentional, not like a generic Bootstrap `.text-center py-5`.

---

# 52. Skeleton

Audit:

- neutral tone
- animation
- visual noise
- composition
- reduced motion

It should feel quiet.

---

# 53. Progress

Audit:

- track
- fill
- radius
- label
- percentage
- primary color usage

Avoid generic Bootstrap progress-bar appearance.

---

# 54. Meter

Audit whether Meter is visually distinguishable where semantic meaning requires it, while remaining in the same ORP family.

Do not over-style.

---

# 55. Modal

HIGH PRIORITY app-like component.

Audit:

- width
- mobile behavior
- backdrop
- radius
- header
- close control
- spacing
- footer/actions
- visual elevation

Avoid old desktop-dialog appearance on mobile.

---

# 56. Drawer

Audit:

- edge behavior
- spacing
- elevation
- close control
- mobile ergonomics
- relation to Modal

---

# 57. Accordion

Audit:

- row density
- dividers
- icon alignment
- open state
- typography
- unnecessary card boxing

Accordions often look better as structured rows than individual cards.

---

# 58. Map

Audit ORP Map framing:

- border
- radius
- controls
- attribution
- height
- integration inside ContactCard/Surface

Do not restyle Leaflet internals aggressively.

Keep external integration boundaries intact.

---

# 59. Lists

Distinguish:

```text
UI List
```

from:

```text
Prose list
```

Audit visual consistency without conflating responsibilities.

---

# 60. Typography & Content

Review:

- links
- ordered lists
- unordered lists
- nested lists
- blockquote
- code
- kbd
- mark
- tables
- figure/figcaption
- prose

Ensure they look native to Default Theme 2026.

---

# 61. Links

Check whether links are:

- identifiable
- restrained
- accessible
- consistent

Avoid Bootstrap default-link visual DNA.

---

# 62. Tables

Audit:

- density
- borders
- header
- zebra treatment if any
- horizontal overflow
- mobile

Do not redesign tables into Cards automatically.

---

# 63. Borders

Inventory visible border usage.

Classify:

```text
STRUCTURAL
INTERACTIVE
SEMANTIC
UNNECESSARY
```

Too many borders create framework/template appearance.

---

# 64. Radius

Inventory actual radius usage.

Check consistency across:

- buttons
- inputs
- cards
- surfaces
- modal
- drawer
- media
- badges
- map

Flag arbitrary radius values.

---

# 65. Pill Audit

Identify every `rounded-full` / pill treatment.

Classify:

```text
SEMANTICALLY APPROPRIATE
INTERACTION APPROPRIATE
DECORATIVE / UNNECESSARY
```

Pills are not the default ORP shape.

---

# 66. Shadows

Inventory shadows.

For each ask:

> What elevation/behavior does this shadow communicate?

If the answer is:

```text
"It looks nicer"
```

flag it.

---

# 67. Color Saturation

Check whether semantic/brand colors dominate too much of the screen.

ORP should remain primarily neutral with intentional accents.

---

# 68. Icons

Bootstrap Icons are allowed.

Audit consistency of:

- size
- stroke/fill visual weight
- icon container
- spacing
- alignment
- semantic use

Do not mix icon families casually.

---

# 69. Icon Containers

Check whether icons are unnecessarily placed in:

```text
colored rounded square
```

everywhere.

This is a common SaaS-template cliché.

Use only where hierarchy/recognition benefits.

---

# 70. Motion

Audit:

- hover transitions
- modal/drawer
- accordion
- interactive Card
- buttons
- Skeleton
- media hover

Motion should generally be quiet and purposeful.

Target direction:

```text
short
subtle
< ~300ms where appropriate
```

Use actual ORP motion tokens.

---

# 71. Hover

Hover behavior should only apply meaningfully to fine-pointer devices where appropriate.

Do not make mobile design depend on hover.

---

# 72. Reduced Motion

Verify:

```text
prefers-reduced-motion
```

where motion exists.

---

# 73. Mobile Philosophy

Mobile is NOT:

```text
desktop UI scaled smaller
```

Audit whether mobile preserves hierarchy intentionally.

---

# 74. Mobile Checks

At:

```text
320
375
390
430
```

evaluate:

- viewport gutter
- nested padding
- button width
- action wrapping
- media height
- Card density
- typography
- modal behavior
- tables
- form controls
- touch targets
- horizontal scrolling
- Grid collapse
- Pattern hierarchy

---

# 75. Horizontal Scroll

Where horizontal scrolling exists, verify it is intentional.

Good candidates may include:

- visual catalog
- tabs
- compact collections

Bad candidates:

- accidental page overflow
- forms
- text
- core actions

---

# 76. Desktop Philosophy

Desktop should use space to improve composition, not merely widen everything.

At:

```text
1200
1440
```

look for:

- excessive empty centers
- giant Cards
- stretched text
- over-wide forms
- repetitive grids
- weak page chapters

---

# 77. Long Page Rhythm

Build/inspect a Playground composition with multiple sections.

Check whether the page reads as chapters.

Prefer:

```text
clear section transitions
dominant moments
quiet supporting areas
```

over:

```text
card
card
card
card
card
```

---

# 78. Dominant Media

Where media matters, allow it to become visually dominant.

Do not make every image a small rounded thumbnail.

Audit CatalogCard and ContentCard especially.

---

# 79. Density

Classify major components:

```text
TOO DENSE
BALANCED
TOO LOOSE
```

Do not assume more whitespace is always better.

Whitespace must communicate relationships.

---

# 80. Visual Weight Inventory

For each major Playground region count visual weights such as:

- border
- background
- radius
- shadow
- icon container
- badge
- colored CTA
- divider
- image

Flag regions where too many compete simultaneously.

---

# 81. Visual Weight Rule

A component should rarely need all of:

```text
background
+ border
+ large radius
+ shadow
+ badge
+ colored icon box
+ filled CTA
```

to communicate hierarchy.

Simplify conceptually in recommendations.

---

# 82. Pattern Comparison Board

Create or inspect a Playground area showing all Patterns together:

```text
CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard
```

This is REQUIRED for the audit.

Do not redesign them yet.

Use it to evaluate family resemblance and differentiation.

---

# 83. Component Comparison Board

Also inspect representative:

```text
Button
Input
Badge
Alert
Progress
Meter
Skeleton
Modal
Accordion
```

together under the same theme.

---

# 84. State Coverage

Verify visual states:

```text
default
hover
focus
active/pressed
disabled
loading where relevant
error
success
selected where relevant
```

Not every component needs every state.

Audit only applicable states.

---

# 85. Semantic Color Integrity

Do not sacrifice semantic distinctions for monochrome aesthetics.

Preserve:

- danger
- warning
- success
- info

where meaning requires them.

---

# 86. Brand Integrity

Do not neutralize ORP until it becomes anonymous.

The goal is restraint, not absence of identity.

Electric Indigo/approved primary should remain recognizable through intentional moments.

---

# 87. Scandinavian Influence

Use Scandinavian-inspired principles as decision criteria, NOT as a literal style copy.

Borrow:

- calm
- clarity
- purposeful whitespace
- functional simplicity
- restrained decoration
- clear hierarchy
- deliberate materials/surfaces

Do NOT blindly enforce:

- monochrome
- serif removal
- neutralized branding
- extreme minimalism

ORP is not trying to become a Scandinavian website template.

---

# 88. Simplicity Is Not Minimalism

Do not remove useful:

- labels
- boundaries
- semantic colors
- focus states
- navigation cues
- controls

just to make screenshots cleaner.

---

# 89. Accessibility

Audit visual direction against:

- contrast
- focus visibility
- touch targets
- color-independent state
- text scaling
- reduced motion
- semantic structure
- readable line length

Accessibility takes priority over aesthetic restraint.

---

# 90. Playground Content Quality

Avoid auditing only toy examples.

Use realistic content:

- long Spanish names
- long descriptions
- prices
- metadata
- multiple actions
- missing media
- different states
- long form labels
- large numbers
- maps
- content excerpts

---

# 91. Before/After

This phase is primarily read-only.

Do NOT produce broad after screenshots by redesigning the entire framework.

Instead capture:

```text
CURRENT STATE
```

and later use one pilot for before/after.

---

# 92. Required Issue Classification

Every issue found must be classified:

```text
P0 — accessibility / broken visual behavior
P1 — system-wide visual inconsistency
P2 — significant Bootstrap/template resemblance
P3 — polish / local refinement
REJECTED — no change needed
```

---

# 93. Required Issue Categories

Each issue must also identify a category:

```text
FLOW
HIERARCHY
GROUPING
LAYOUT
DENSITY
TYPOGRAPHY
SPACING
SURFACE
BORDER
RADIUS
ELEVATION
COLOR
CONTROL
STATE
MEDIA
MOTION
ACCESSIBILITY
RESPONSIVE
PATTERN
```

---

# 94. Required Audit Matrix

Produce:

| Area | Current behavior | Problem | Bootstrap signal? | Severity | Scope | Recommended direction |
|---|---|---|---|---|---|---|
| Buttons | ? | ? | ? | ? | Foundation/Component | ? |
| Forms | ? | ? | ? | ? | ? | ? |
| Card | ? | ? | ? | ? | ? | ? |
| Badge | ? | ? | ? | ? | ? | ? |
| Modal | ? | ? | ? | ? | ? | ? |
| Patterns | ? | ? | ? | ? | ? | ? |

Expand for all relevant audited areas.

---

# 95. Bootstrap Resemblance Score

For major areas assign:

```text
0 = no meaningful resemblance
1 = minor generic similarity
2 = noticeable
3 = strong Bootstrap/template resemblance
```

Score at least:

```text
Buttons
Forms
Cards
Badges
Modal
Accordion
Tables
Patterns
Overall Playground
```

This is diagnostic, not scientific.

Explain each score.

---

# 96. Cohesion Score

Also rate 1–5:

```text
Typography cohesion
Spacing cohesion
Control cohesion
Surface cohesion
Pattern cohesion
Mobile cohesion
Brand cohesion
Overall visual identity
```

Explain weak scores.

---

# 97. Do Not Fix Locally First

If ten components share the same visual problem, recommend a Foundation-level fix.

Example:

```text
Problem:
all controls feel too rounded

Wrong:
edit Button, Input, Select, Modal separately

Correct:
audit radius tokens/default component policy
```

Prefer highest-leverage layer.

---

# 98. Remediation Order

Recommendations must follow:

```text
1. Flow / hierarchy / grouping
2. Layout restructuring
3. Remove unnecessary ornament/surfaces
4. Spacing / alignment / density
5. Typography
6. Tokens: color / borders / radius / elevation
7. Controls / states
8. Motion
```

Do not lead with micro-polish.

---

# 99. Pilot Selection

At the end select EXACTLY ONE pilot for the next phase.

The pilot should:

- expose many ORP primitives/components
- visibly suffer from current visual problems
- be representative
- be low enough risk to iterate
- allow mobile + desktop comparison
- demonstrate whether the new visual direction works

---

# 100. Possible Pilots

Candidates may include:

```text
ORP Playground composite page
CatalogCard collection
PricingCard comparison
ContactCard + Map composition
Form composition
Services section in Acerca later
```

Do not choose from this list automatically.

Use audit evidence.

---

# 101. Prefer ORP Playground Pilot First

Unless strong evidence says otherwise, prefer a self-contained ORP Playground composition as the first visual pilot.

This keeps visual experimentation inside ORP before Acerca dogfooding.

---

# 102. Pilot Must Not Be Implemented

IMPORTANT:

This audit only SELECTS the pilot.

Do NOT redesign the pilot yet.

The next independent task will be:

```text
ORP VISUAL PILOT REDESIGN
```

---

# 103. No Acerca Dogfooding Yet

Do not modify:

- SectionServices
- SectionProducts
- Hero
- Navigation
- Footer
- Minisite themes

Acerca comes after ORP visual direction is validated.

---

# 104. No Architecture Growth

Do not respond to visual problems by creating:

```text
OrpPanel
OrpBox
OrpFancyCard
OrpHeroCard
OrpActionCard
OrpStatus
```

unless a future independent architectural audit justifies them.

ActionCard remains NOT JUSTIFIED.

---

# 105. No New Utility Families

Do not solve visual inconsistency with dozens of helper classes.

Use existing Foundation, Helpers, Primitives and Components.

---

# 106. No Theme Switcher

Do not build a permanent theme comparison UI.

The goal is to validate Default Theme 2026.

---

# 107. No Full Redesign

Do not mass-edit ORP.

Small temporary/debug Playground adjustments are acceptable only if needed to expose comparison states.

Do not turn the audit into implementation.

---

# 108. Build Baseline

Run:

```bash
npm run build
```

before/after any audit-only Playground changes.

The baseline must pass.

---

# 109. Tests Baseline

Run existing relevant tests.

Record failures separately from visual findings.

Do not hide existing failures.

---

# 110. Console

Inspect browser console during Playground QA.

Record:

- errors
- warnings
- layout-related runtime problems
- missing assets

---

# 111. Required Report

Generate:

```text
.opencode/ORPUI/ORP-VISUAL-DIRECTION-AUDIT.md
```

Use the project's existing ORP report/documentation convention if different.

---

# 112. Required Report Structure

```text
# ORP UI Visual Direction Audit

## Executive Summary

## Audit Scope

## Architecture Baseline

## Default Theme 2026 Baseline

## Browser / Viewports Tested

## Overall Visual Assessment

## Bootstrap Resemblance Assessment

## Bootstrap Resemblance Scores

## Cohesion Scores

## Page Flow

## Hierarchy

## Grouping

## Layout Composition

## Density

## Typography

## Spacing

## Container / Section

## Divider / Surface

## Card

## Media

## Avatar

## Badge / Status Representation

## Price

## Buttons

## IconButton

## Forms

## Alert

## Empty State

## Skeleton

## Progress

## Meter

## Modal

## Drawer

## Accordion

## Map

## Lists

## Typography & Content

## Tables

## Borders

## Radius

## Elevation / Shadows

## Color / Brand

## Icons

## Motion

## Accessibility

## Mobile

## Tablet

## Desktop

## Pattern Family Comparison

### CatalogCard
### PricingCard
### ProfileCard
### ContentCard
### StatCard
### ContactCard

## Pattern Cohesion Findings

## Visual Weight Findings

## Audit Matrix

## P0 Issues

## P1 Issues

## P2 Issues

## P3 Issues

## Rejected Changes

## System-Level Recommendations

## Component-Level Recommendations

## Pattern-Level Recommendations

## Recommended Remediation Order

## Selected Visual Pilot

## Why This Pilot

## Pilot Success Criteria

## Build

## Tests

## Console

## Final Verdict

## Next Phase
```

---

# 113. Pilot Success Criteria

Define measurable/observable criteria for the selected pilot.

At minimum:

```text
- less Bootstrap resemblance
- clearer hierarchy
- fewer unnecessary visual weights
- better mobile composition
- stronger typography
- intentional primary-color usage
- coherent radius/border/elevation
- accessibility preserved/improved
- existing ORP API preserved where possible
```

---

# 114. Final Verdict

End with one:

```text
VISUAL DIRECTION READY FOR PILOT
```

or:

```text
VISUAL FOUNDATION NEEDS CORRECTION BEFORE PILOT
```

If correction is needed, identify only blocking P0/P1 issues.

---

# 115. Next Phase

If ready:

```text
NEXT PHASE:
ORP VISUAL PILOT REDESIGN — <selected pilot>
```

Do not execute it.

If not ready:

```text
NEXT PHASE:
FOUNDATION VISUAL CORRECTION — <specific blocking area>
```

Do not start it.

---

# 116. STOP CONDITION

STOP after:

1. inspecting actual Playground
2. auditing visual system
3. testing responsive widths
4. comparing Pattern family
5. comparing representative Components
6. identifying Bootstrap signals
7. scoring resemblance
8. scoring cohesion
9. classifying issues P0–P3
10. prioritizing system-level fixes
11. selecting exactly one pilot
12. defining pilot success criteria
13. running baseline tests/build
14. generating `ORP-VISUAL-DIRECTION-AUDIT.md`
15. reporting one next phase

Do not redesign the pilot.

Do not grow ORP.

---

# FINAL INSTRUCTION

ORP has enough building blocks.

Stop asking:

```text
"What component should we add next?"
```

Start asking:

```text
"Does this already feel like ORP?"
```

Audit the framework as one visual language.

Prioritize:

```text
comprehension
→ hierarchy
→ grouping
→ composition
→ spacing
→ typography
→ visual restraint
→ controls
→ states
→ motion
```

Use:

```text
Spacing
→ Alignment
→ Typography
→ Divider
→ Surface
→ Card
```

for grouping decisions.

Use:

```text
Flat
→ Border
→ Surface contrast
→ Shadow
```

for elevation decisions.

Preserve Default Theme 2026.

Preserve accessibility.

Preserve semantic colors.

Preserve useful brand identity.

Do not copy Scandinavian design literally.

Do not copy Bootstrap, Material, Vuetify, Quasar or Tailwind.

Do not add new framework architecture during this phase.

Find the highest-leverage visual inconsistencies.

Select ONE pilot.

Generate the audit report.

STOP.

