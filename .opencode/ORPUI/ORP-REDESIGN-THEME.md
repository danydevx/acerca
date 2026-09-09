# ORP UI — DEFAULT THEME 2026 FOUNDATION REDESIGN
# Redesign the default visual scheme before the Visual Direction Audit
# This phase MAY modify ORP Foundation and global visual tokens

## Context

ORP UI already has a solid architectural base with primitives, components and generic Patterns.

However, the current default visual scheme still feels too close to Bootstrap.

The problem is no longer only component architecture.

We need to redefine the DEFAULT visual foundation so every ORP primitive, component and Pattern inherits a more distinctive 2026 product/SaaS identity.

This phase happens BEFORE:

1. ORP Visual Direction Audit
2. Pilot visual redesign
3. ORP Global Architecture Audit
4. Acerca dogfooding

This is NOT a redesign of Acerca.

This is a redesign of the default ORP visual foundation.

---

# 1. Objective

Redesign the ORP default theme around:

- a more contemporary 2026 palette
- a stronger neutral system
- a new typography direction
- flatter surfaces
- restrained elevation
- coherent radii
- quieter borders
- better focus states
- more refined controls
- less Bootstrap visual DNA

The result should feel:

- modern
- premium without decoration
- product-oriented
- mobile-first
- calm
- sharp
- intentional
- recognizable as ORP

It must NOT feel like:

- Bootstrap recolored
- Material Design clone
- Tailwind UI clone
- generic admin template
- neon crypto dashboard
- 2022 purple-gradient SaaS
- glassmorphism everywhere

---

# 2. Important: Audit Before Editing

Before changing tokens, inspect physically:

- ORP token files
- typography
- base/reset
- Button
- IconButton
- Input
- Select
- Textarea
- Checkbox/Radio/Switch if present
- Card
- Badge
- Alert
- Empty State
- Modal
- Drawer
- Accordion
- Grid
- Stack
- Cluster
- Map
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard
- ORP Playground

Also search every consumer of foundation tokens.

DO NOT change a token without knowing what currently consumes it.

---

# 3. Preserve Architecture

Do not rewrite component APIs merely to change appearance.

Preserve unless there is a concrete reason:

- slots
- props
- events
- accessibility behavior
- component responsibilities
- Pattern architecture
- Map lifecycle
- third-party integrations

This phase primarily changes:

FOUNDATION + VISUAL SYSTEM.

---

# 4. Proposed Default Direction

Use this as the starting hypothesis, NOT as values to blindly paste:

```css
--orp-primary: #635bff;
--orp-primary-hover: #5148e5;
--orp-primary-soft: #f0efff;

--orp-surface: #ffffff;
--orp-surface-subtle: #f7f7f8;
--orp-surface-muted: #f1f1f3;

--orp-text: #18181b;
--orp-text-secondary: #52525b;
--orp-text-muted: #71717a;

--orp-border: #e4e4e7;
--orp-border-strong: #d4d4d8;

--orp-success: #16a34a;
--orp-warning: #d97706;
--orp-danger: #dc2626;
--orp-info: #0284c7;
```

Direction:

ELECTRIC INDIGO + NEUTRAL/ZINC-LIKE SURFACES.

The exact final values must be validated for:

- contrast
- states
- existing components
- light surfaces
- focus
- accessibility
- visual balance

Do not blindly copy Tailwind Zinc or another framework palette.

ORP should own its values.

---

# 5. Primary Color

Current Bootstrap-like blue should not remain the visual identity if that is what the repository currently uses.

Evaluate an Electric Indigo direction centered approximately around:

#635BFF

The primary must work for:

- primary buttons
- selected states
- active controls
- focus relationship
- links where appropriate
- small identity accents

It must NOT paint the entire interface.

---

# 6. Primary Scale

Do not define only:

primary
primary-hover

if the actual system needs more states.

Audit whether ORP requires a coherent scale such as:

primary
primary-hover
primary-active
primary-soft
primary-border
primary-contrast

Only create tokens with actual consumers.

Avoid giant 50–950 scales unless ORP genuinely needs them.

---

# 7. Neutral Palette

Create/revise a neutral system appropriate for:

- canvas
- surfaces
- elevated surfaces
- subtle fills
- primary text
- secondary text
- metadata
- borders
- hover
- pressed

Prefer neutral grays without obvious blue-gray Bootstrap/admin-template character.

Do not import another framework's neutral scale wholesale.

---

# 8. Canvas and Surfaces

Evaluate at minimum:

canvas
surface
surface-subtle
surface-muted
surface-elevated if justified

Default direction:

canvas should not require every section to become a Card.

Surface differences should be subtle.

Use whitespace and composition before adding containers.

---

# 9. Semantic Palette

Preserve clear semantic roles:

success
warning
danger
info

Semantic colors must remain distinguishable.

Do not convert semantic states into indigo.

Do not make all semantic colors pastel to the point of poor contrast.

---

# 10. Semantic Soft States

If Badge/Alert/etc. repeatedly require soft backgrounds, evaluate generic semantic companion tokens.

Example concept:

success
success-soft
success-border

Only if evidence exists.

Do not generate enormous unused token matrices.

---

# 11. Typography Direction

Evaluate replacing the current default typography with:

MANROPE

as the preferred new ORP default direction.

Conceptually:

```css
--orp-font-family: "Manrope", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
```

But audit current font loading strategy before implementation.

---

# 12. Manrope Validation

Before adopting Manrope, test:

- 320px mobile
- buttons
- inputs
- long headings
- metadata
- prices
- StatCard values
- modal titles
- navigation
- card titles
- long Spanish text

Check:

- wrapping
- x-height
- weight availability
- visual density
- numeric clarity

---

# 13. Font Loading

Do not casually introduce blocking font loading.

Inspect current project conventions.

Prefer a performant strategy.

If external Google Fonts are not appropriate for ORP core, consider:

- consumer-provided font
- documented optional import
- system fallback

The framework should not unexpectedly create a hard external dependency without justification.

---

# 14. Typography Fallback Decision

If Manrope cannot be responsibly made the ORP default because of framework portability/performance:

document that decision.

Possible strategy:

ORP recommends Manrope
but exposes:

--orp-font-family

and keeps a robust system fallback.

Do not force a network dependency just to satisfy this prompt.

---

# 15. Font Weights

Prefer a restrained hierarchy.

Conceptual:

Body:
400

Controls:
500

Titles:
500–600

Large headings:
600

Avoid 700–900 as the default visual language.

Validate actual Manrope weights available.

---

# 16. Type Scale

Audit existing font sizes.

Create or normalize a small ORP scale if needed.

Do not invent dozens of typography tokens.

The system should comfortably support:

- meta
- label
- body
- supporting
- title
- heading
- display

without arbitrary component-specific sizes.

---

# 17. Numeric Typography

Inspect:

- prices
- statistics
- metrics
- quantities

Consider:

font-variant-numeric: tabular-nums

only where useful.

Do not globally force it onto normal prose.

---

# 18. Radius System

Audit every radius currently used.

The new direction should be:

RESTRAINED, NOT BOXY, NOT BUBBLY.

Avoid giant 20–32px radii as the default for ordinary controls/cards.

Possible conceptual hierarchy:

small
medium
large
pill

Do not blindly replace existing values.

---

# 19. Radius Roles

Define which components should generally consume which radius level.

Example concept:

Badge:
pill or small depending role

Button:
medium

Input:
medium

Card:
large but restrained

Modal:
large

Media:
inherits/coordinates with container

IconButton:
shape based on component system

The exact mapping must come from audit.

---

# 20. Pill Reduction

Audit current pill usage.

Identify ordinary controls that look Bootstrap-like because of excessive pill treatment.

Do not remove pills where their role is appropriate.

---

# 21. Border System

Audit current borders.

The new scheme should prefer:

- low-contrast neutral borders
- stronger borders only where interaction/state requires them
- fewer unnecessary boxes

Evaluate tokens like:

border
border-strong
border-focus

only when useful.

---

# 22. Shadow System

Audit all shadows.

New default direction:

FLAT FIRST.

Most Cards should not need visible elevation merely to exist.

Reserve stronger elevation for:

- Modal
- Drawer
- floating controls
- overlays
- genuinely raised interactive layers

---

# 23. Shadow Tokens

If existing shadow tokens are too Bootstrap-like/heavy:

refine them.

Possible hierarchy:

none
subtle
raised
overlay

Do not add multiple decorative shadow variants.

---

# 24. Button Redesign

Buttons are one of the highest-impact Bootstrap signals.

Audit:

- height
- radius
- padding
- font
- font weight
- border
- primary fill
- secondary
- ghost
- danger
- icon gap
- loading
- disabled
- focus
- hover
- pressed

The new Button should immediately communicate the new ORP visual direction.

---

# 25. Primary Button

Target characteristics:

- Electric Indigo identity
- medium font weight
- controlled radius
- no unnecessary shadow
- clear hover
- clear pressed state
- visible focus
- strong contrast

Avoid the visual language of `.btn-primary`.

---

# 26. Secondary Button

Do not simply reproduce Bootstrap:

white background
gray border
gray text

without evaluating hierarchy.

Secondary should be quieter than Primary but clearly interactive.

---

# 27. Ghost Button

Ghost actions should remain discoverable without becoming visually dominant.

Check hover and focus carefully.

---

# 28. Danger Button

Danger remains semantic.

Do not recolor destructive actions with primary indigo.

---

# 29. Button Sizes

Audit existing sm/md/lg.

Ensure they have:

- coherent heights
- coherent icon sizing
- coherent padding
- touch usability

Do not proliferate sizes.

---

# 30. IconButton

Align IconButton visually with Button.

Check:

- radius
- dimensions
- icon optical size
- hover
- pressed
- focus
- danger
- touch targets

Avoid tiny Bootstrap-style icon controls.

---

# 31. Form Controls

Inputs are another strong design-system signal.

Audit:

- Input
- Textarea
- Select
- checkbox
- radio
- switch

Target:

- neutral surfaces
- quiet borders
- strong focus
- restrained radius
- readable typography
- consistent control heights

---

# 32. Input Focus

Do NOT recreate Bootstrap's large blue glow.

Use a more refined ORP focus treatment.

Requirements:

- highly visible
- accessible
- consistent
- brand-related where appropriate
- not decorative

---

# 33. Input Background

Evaluate whether controls should be:

white + border

or

subtle neutral fill + quieter border

based on actual ORP composition.

Do not change solely for novelty.

---

# 34. Cards

Audit Card after the foundation changes.

Target:

- flatter default
- subtle border/surface distinction
- restrained radius
- little/no default shadow

Raised remains available when elevation has meaning.

---

# 35. Card Variants

Review existing:

interactive
outlined
raised

Ensure each variant still has a clear purpose.

Do not create new visual variants during this phase unless required by the foundation.

---

# 36. Pattern Impact

Inspect:

CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard

after changing Foundation.

Do NOT individually redesign all Patterns yet.

The purpose is to see how much improvement comes from better shared foundations.

---

# 37. Badge

Audit Badge against the new scheme.

Avoid overly saturated colored pills everywhere.

Semantic badges may use soft semantic surfaces.

Neutral/outline badges should remain quiet.

---

# 38. Alert

Preserve semantic distinction.

Refine:

- background intensity
- border
- icon
- typography

only if needed.

Do not make Alerts visually indistinguishable in pursuit of restraint.

---

# 39. Empty State

Check whether typography/buttons now feel consistent with the new foundation.

Do not redesign its composition unless foundation changes expose a real problem.

---

# 40. Modal / Drawer

Audit how new:

- surfaces
- shadows
- radius
- typography
- buttons

affect overlays.

Overlays should remain clearly elevated from the page.

---

# 41. Map

Do not visually rewrite Leaflet.

Only ensure ORP's map container integrates with:

- radius
- border
- surrounding surfaces

Do not interfere with Leaflet functionality or OpenStreetMap attribution.

---

# 42. Icons

Bootstrap Icons remain allowed.

Do not change icon library during this phase.

Instead normalize:

- sizes
- color hierarchy
- alignment
- icon button treatment

---

# 43. Spacing

Audit existing spacing tokens.

Do NOT rebuild the spacing scale merely because the palette changed.

Only adjust spacing foundation if it is genuinely contributing to the Bootstrap-like appearance or inconsistency.

---

# 44. Default Theme vs Brand Themes

This phase redesigns:

ORP DEFAULT THEME.

ORP must still allow consumers such as Acerca to override brand tokens.

Do not hardwire Electric Indigo into component CSS.

Components consume tokens.

---

# 45. Themeability

Verify changing:

--orp-primary

still correctly propagates through the system.

No component should directly contain:

#635bff

except foundation/default theme definition if that is the chosen architecture.

---

# 46. No Component Hardcodes

Search after implementation for new hardcoded:

primary colors
neutral colors
radii
shadows
font families

inside individual components.

Move shared visual decisions into Foundation/tokens.

---

# 47. Dark Mode Compatibility

Even if ORP dark mode is not currently implemented, avoid decisions that make future dark mode unnecessarily difficult.

If dark theme already exists:

audit it explicitly.

Do NOT redesign dark mode blindly from light values.

---

# 48. Contrast

Validate key combinations:

primary button
primary link
body text
secondary text
metadata where meaningful
input borders/focus
badges
alerts
disabled controls

Accessibility takes priority over subtle aesthetics.

---

# 49. Disabled States

Do not make disabled controls indistinguishable from enabled controls.

Do not use container opacity that unintentionally reduces all descendant contrast.

Prefer explicit state tokens/styles.

---

# 50. Hover

Hover states should be subtle.

Avoid dramatic:

shadow
translateY
scale

for ordinary controls.

---

# 51. Pressed

Pressed state should feel immediate.

Prefer:

- controlled fill shift
- border shift
- very subtle transform only if already part of ORP motion language

---

# 52. Focus

Focus must be visually stronger than hover.

Do not hide it.

Keyboard users must immediately understand location.

---

# 53. Motion

Do not use this redesign as an excuse to add animations.

Foundation motion should remain:

quiet
fast
functional

---

# 54. Playground First

Apply the new default Foundation to ORP Playground.

The Playground is the primary visual evaluation environment.

Do NOT modify Acerca.

---

# 55. Playground Review Areas

After Foundation changes inspect:

- colors
- typography
- buttons
- forms
- badges
- alerts
- Card
- Patterns
- Modal
- Drawer
- Map
- Empty State

---

# 56. Before Screenshots

Before modifying the Foundation, capture representative Playground screenshots at:

390px
1440px

If tooling allows, also:

375
768

These establish baseline.

---

# 57. After Screenshots

Capture the same routes/states after changes.

Compare side-by-side.

Do not claim improvement from code alone.

---

# 58. Bootstrap Resemblance Test

After the redesign answer:

Does the Playground still look like Bootstrap with different variables?

Score:

LOW
MEDIUM
HIGH

Explain the remaining signals.

---

# 59. Typography Test

Explicitly compare:

CURRENT FONT

vs

MANROPE

in the Playground before finalizing if feasible.

Evaluate:

- personality
- readability
- density
- wrapping
- controls
- Spanish copy
- numbers

Do not choose Manrope solely because this prompt suggested it.

---

# 60. Palette Test

If practical, compare at least:

A. current default
B. Electric Indigo proposal

Do not build a permanent theme switcher unless ORP already has one.

This can be temporary development evaluation.

---

# 61. No Three-Theme Scope Creep

Do NOT turn this phase into building a full theme marketplace.

We are choosing/refining ONE new default theme.

---

# 62. Preserve Semantic Behavior

Do not break:

- focus
- error
- success
- warning
- selected
- disabled
- destructive

for aesthetic consistency.

---

# 63. Preserve Component APIs

A visual foundation redesign should ideally not require consumer changes.

If a breaking API change appears necessary:

STOP and document it before proceeding.

---

# 64. No Acerca Changes

Do not modify:

- Minisite
- Dashboard
- vCards
- Services
- Products
- Locations
- Hero
- Navigation
- Footer
- domain LESS

Acerca dogfooding comes later.

---

# 65. No Business Logic

Do not modify:

Controllers
Models
Routes
API
database
Inertia payloads

---

# 66. Build

Run:

npm run build

after implementation.

Must pass.

---

# 67. Tests

Run existing ORP tests.

Foundation changes must not break behavior.

---

# 68. Browser QA

Test at minimum:

320
375
390
430
768
1200
1440

Focus visual review on:

390
1440

---

# 69. Console QA

No:

Vue warnings
missing font errors
asset 404
Leaflet errors
CSS loading errors
horizontal overflow

---

# 70. Performance

If a new font is introduced:

document:

- loading method
- weights loaded
- network impact
- fallback behavior

Do not load unnecessary font weights.

---

# 71. Foundation Report

Generate:

ORP-DEFAULT-THEME-2026-REPORT.md

---

# 72. Report Structure

# ORP DEFAULT THEME 2026 — REPORT

## Previous Visual Foundation

Primary:

Neutral system:

Typography:

Radius:

Shadows:

Buttons:

Forms:

Bootstrap resemblance:

## Audit Findings

Primary palette:

Neutral palette:

Typography:

Radius:

Borders:

Shadows:

Controls:

## New Default Foundation

Primary:

Primary hover:

Primary active:

Primary soft:

Canvas:

Surface:

Surface subtle:

Text:

Secondary text:

Muted text:

Border:

Strong border:

Success:

Warning:

Danger:

Info:

## Typography Decision

Previous font:

Candidate:

Final font:

Reason:

Loading strategy:

Weights:

Fallback:

## Radius System

Tokens:

Usage:

## Shadow System

Tokens:

Usage:

## Button Changes

Primary:

Secondary:

Ghost:

Danger:

Sizes:

Focus:

Pressed:

## Form Changes

Input:

Textarea:

Select:

Focus:

Disabled:

Error:

## Component Impact

Card:

Badge:

Alert:

Empty:

Modal:

Drawer:

CatalogCard:

PricingCard:

ProfileCard:

ContentCard:

StatCard:

ContactCard:

Map:

## Hardcoded Values Introduced

NONE

or list + justification.

## Accessibility

Primary contrast:
PASS / FAIL

Body:
PASS / FAIL

Secondary:
PASS / FAIL

Focus:
PASS / FAIL

Semantic states:
PASS / FAIL

Disabled:
PASS / FAIL

## Responsive QA

320:
375:
390:
430:
768:
1200:
1440:

## Build

npm run build:
PASS / FAIL

## Tests

PASS / FAIL

## Console

PASS / FAIL

## Bootstrap Resemblance

BEFORE:
LOW / MEDIUM / HIGH

AFTER:
LOW / MEDIUM / HIGH

Remaining Bootstrap signals:

## Screenshots

Before mobile:

After mobile:

Before desktop:

After desktop:

## Acerca Changes

NONE

## Breaking Changes

NONE

or STOP and document.

## Final Verdict

DEFAULT THEME ACCEPTED

or

NEEDS VISUAL REVISION

---

# 73. Acceptance Criteria

The redesign succeeds if:

- ORP no longer defaults to Bootstrap-like blue visual identity
- typography feels more intentional
- Buttons clearly feel different from Bootstrap
- form focus does not resemble Bootstrap glow
- Cards feel flatter and less template-like
- neutral surfaces are coherent
- semantic states remain strong
- primary color is restrained
- tokens remain themeable
- Patterns inherit the new language without individual hacks
- mobile feels intentional
- accessibility remains intact

---

# 74. Important Restraint

Do not try to solve the entire ORP visual identity in Foundation.

Foundation provides the language.

Composition still matters.

After this phase we will run:

ORP VISUAL DIRECTION AUDIT

to identify structural Bootstrap signals that tokens alone cannot solve.

---

# 75. Next Phase

After successful human review:

ORP VISUAL DIRECTION AUDIT

Then:

ONE PILOT REDESIGN

Then:

ORP GLOBAL ARCHITECTURE AUDIT

Then:

ACERCA DOGFOODING

Do not start any of these automatically.

---

# FINAL INSTRUCTION

Redesign the ORP default visual Foundation for 2026.

1. Audit the actual token system before editing.
2. Audit every consumer of major Foundation tokens.
3. Evaluate Electric Indigo around #635BFF as the new default primary.
4. Build a neutral modern surface/text/border system.
5. Evaluate Manrope as the new default typography.
6. Do not force Manrope if framework portability/performance makes it a bad default.
7. Normalize typography hierarchy.
8. Audit and refine radius.
9. Make the system flat-first.
10. Reduce unnecessary default shadows.
11. Redesign Button appearance carefully.
12. Redesign form-control appearance carefully.
13. Replace Bootstrap-like focus glow with an accessible ORP focus treatment.
14. Preserve semantic colors and accessibility.
15. Preserve component APIs.
16. Keep all shared visual decisions token-driven.
17. Do not hardcode #635BFF inside components.
18. Do not modify Acerca.
19. Capture before/after Playground views.
20. Verify mobile independently.
21. Run tests.
22. Run npm run build.
23. Generate ORP-DEFAULT-THEME-2026-REPORT.md.
24. Report remaining Bootstrap visual signals.
25. STOP for human review.

