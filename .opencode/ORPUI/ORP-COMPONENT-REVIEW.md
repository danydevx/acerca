# ORP UI — COMPONENT GAP REVIEW
# Review missing reusable UI components after Primitive foundation stabilization
# Candidates: Skeleton, Progress / Meter, Status
# Run after MEDIA CAPABILITY AUDIT

## Context

ORP UI has completed a major Primitive / Foundation consolidation sequence:

```text
Default Theme 2026
        ↓
Typography & Content Primitives
        ↓
Visual Helpers
        ↓
Divider / Surface Discovery
        ↓
Container
        ↓
Media Capability Audit
```

The Media audit completed successfully:

```text
Build: PASS
Report: .opencode/ORPUI/ORP-MEDIA-CAPABILITY-AUDIT.md
Next recommended phase: COMPONENT GAP REVIEW
```

This phase must stop creating primitives and instead review whether ORP is missing reusable behavior/state-oriented Components.

Primary candidates:

```text
Skeleton
Progress / Meter
Status
```

These are CANDIDATES.

Do not create all three automatically.

The goal is:

```text
DISCOVER
→ INVENTORY
→ COMPARE EXISTING ORP
→ VALIDATE 2+ GENERIC CONTEXTS
→ CLASSIFY
→ CREATE ONLY JUSTIFIED COMPONENTS
→ PLAYGROUND
→ TEST
→ REPORT
→ STOP
```

---

# 1. Objective

Perform a focused ORP Component Gap Review.

Determine whether ORP needs:

1. `Skeleton`
2. `Progress / Meter`
3. `Status`

For each candidate decide:

```text
CREATE
EXTEND EXISTING
REUSE EXISTING
KEEP LOCAL
DEFER
REJECT
```

A valid result may be:

```text
NO NEW COMPONENT REQUIRED
```

Do not grow ORP for completeness.

---

# 2. Architecture Reminder

Use this responsibility model:

```text
Foundation
→ design decisions/tokens

Helpers
→ one focused generic visual adjustment

Primitives
→ structural/layout building blocks

Components
→ reusable UI state, behavior or semantic unit

Patterns
→ recurring higher-level composition

Application
→ domain/business rules
```

The reviewed candidates belong in `Components` only if they have real reusable behavior/semantics.

---

# 3. Mandatory Repository Audit

Before creating code inspect:

```text
resources/js/Components/OrpUI/
resources/less/orp-ui/
Playground
tests
docs
```

Search for:

```text
skeleton
placeholder
loading
progress
meter
status
state
badge
loading-state
shimmer
spinner
busy
percentage
completion
aria-busy
aria-valuenow
role="progressbar"
<meter>
<progress>
```

Also inspect:

- Badge
- Alert
- Empty
- StatCard
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- ContactCard
- Forms
- Buttons
- Media

Do not assume these concepts are missing merely because component names do not exist.

---

# 4. Read-Only Acerca Evidence

Inspect Acerca/minisite/admin READ-ONLY for real recurring use cases.

Search for:

- loading placeholders
- shimmer CSS
- fake gray cards
- inline progress bars
- profile completion
- upload progress
- step completion
- stock/capacity meters
- status dots
- online/offline
- active/inactive
- published/draft
- pending/approved/rejected
- availability
- service state
- appointment state

Do NOT modify Acerca.

Business-specific state names are evidence only.

---

# 5. Required Gap Matrix

Produce:

| Candidate | Existing ORP solution | Generic contexts found | Existing duplication | Semantic/behavior need | Decision | Reason |
|---|---|---:|---:|---|---|---|
| Skeleton | ? | ? | ? | ? | ? | ? |
| Progress | ? | ? | ? | ? | ? | ? |
| Meter | ? | ? | ? | ? | ? | ? |
| Status | ? | ? | ? | ? | ? | ? |
| Spinner/loading | ? | ? | ? | ? | ? | ? |

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

# PART A — SKELETON

# 6. Skeleton Definition

Skeleton represents temporary placeholder UI while content is loading.

It is NOT:

- an Empty State
- a Spinner
- a disabled Card
- a fake final layout
- a loading business workflow
- a data fetching system

---

# 7. Skeleton Acceptance Test

Create Skeleton only if ORP has repeated generic loading-placeholder needs in at least two contexts such as:

- card
- avatar/profile
- media
- text rows
- list item
- dashboard statistic

Do not create it only because modern frameworks often have one.

---

# 8. Skeleton Responsibility

Potential responsibilities:

```text
placeholder shape
size
radius consistency
optional animation
accessibility guidance
```

It should NOT know:

- what data is loading
- fetch lifecycle
- retry
- API state
- domain object
- product/service/user semantics

---

# 9. CSS vs Vue

Strongly evaluate whether Skeleton should be:

A. CSS primitive/helper

or:

B. Vue Component

A Vue component is justified if it provides a useful semantic/API contract such as:

- shape
- width/height
- animation
- accessibility behavior

But do not create Vue merely for wrapper markup.

---

# 10. Skeleton Shapes

Potential generic concepts:

```text
text
rect
circle
```

These are hypotheses only.

Do not create:

```text
product
profile
article
pricing
service
```

variants.

Pattern-specific skeleton compositions should be composed from generic Skeleton pieces.

---

# 11. Skeleton Size

Avoid huge size utility APIs.

Prefer:

- natural container sizing
- small generic props
- CSS custom properties
- consumer width constraints

Do not recreate Tailwind width utilities.

---

# 12. Skeleton Animation

If animation is justified:

- subtle
- quiet
- not flashy
- no strong gradients
- respect `prefers-reduced-motion`

Evaluate:

```text
pulse
shimmer
none
```

Do not support multiple animations without need.

---

# 13. Reduced Motion

Required.

If animation exists:

```css
@media (prefers-reduced-motion: reduce)
```

must disable or simplify it.

---

# 14. Skeleton Color

Use ORP neutral/surface tokens.

No hardcoded gray palette.

Skeleton must fit Default Theme 2026.

---

# 15. Skeleton Accessibility

Skeleton itself should generally not be read as content.

Document recommended parent behavior:

```text
aria-busy="true"
```

where appropriate.

Do not add noisy ARIA labels to every rectangle.

---

# 16. Skeleton Composite Patterns

Do NOT create:

```text
OrpCardSkeleton
OrpProfileSkeleton
OrpCatalogSkeleton
```

in this phase.

Playground may demonstrate composition:

```text
Skeleton avatar
+ Skeleton text
+ Skeleton action
```

without introducing new public components.

---

# PART B — PROGRESS / METER

# 17. Critical Distinction

Do not assume `Progress` and `Meter` are the same.

They communicate different semantics.

### Progress

Represents completion of a task/process.

Examples:

```text
upload 65%
setup 3/5
course completion
processing
```

### Meter

Represents a scalar measurement within a known range.

Examples:

```text
storage usage
capacity
score
signal
quota
```

This distinction must be preserved if both are needed.

---

# 18. Native HTML Audit

Inspect whether native:

```html
<progress>
<meter>
```

can satisfy ORP needs with styling.

Do not create Vue abstractions before evaluating native semantics.

---

# 19. Progress Acceptance Test

Create/extend a Progress component only if ORP needs reusable behavior beyond a styled `<progress>`.

Possible needs:

- normalized API
- labels
- accessible value contract
- indeterminate mode
- size variants
- reusable visual behavior

But keep API small.

---

# 20. Progress Semantics

If determinate:

communicate:

```text
min
max
value
```

correctly.

If indeterminate:

do not invent fake percentages.

---

# 21. Native `<progress>`

Prefer native semantics when possible.

If a custom visual wrapper is needed, preserve accessibility:

```text
role="progressbar"
aria-valuemin
aria-valuemax
aria-valuenow
```

only when native `<progress>` is not being used.

Do not duplicate roles unnecessarily.

---

# 22. Progress API Guardrail

Do NOT create domain props:

```text
profileCompletion
courseProgress
uploadProgress
storageProgress
orderProgress
```

Generic API only.

---

# 23. Progress Label

Audit whether the component should own labels.

Possible composition:

```vue
<OrpProgress :value="65">
    <template #label>...</template>
</OrpProgress>
```

But first inspect ORP slot conventions.

Do not force a label if adjacent Typography/Stack solves it cleanly.

---

# 24. Progress Percentage

Do not automatically format every value as `%`.

The consumer may display:

```text
3 of 5
65%
8 GB of 20 GB
```

Component visual value and displayed text are separate concerns.

---

# 25. Indeterminate Progress

Audit whether real contexts require indeterminate progress.

If yes, it may justify Component behavior.

If no, do not implement merely for completeness.

---

# 26. Progress Color

Default should use primary/accent intentionally.

Semantic variants:

```text
success
warning
danger
```

should NOT be added automatically.

A progress bar is not inherently a status message.

Add semantic intent only if cross-context evidence justifies it.

---

# 27. Progress Size

Potential minimal sizes:

```text
sm
md
lg
```

only if real usage requires multiple sizes.

Do not create an extensive scale.

---

# 28. Progress Radius

Use ORP radius tokens.

Do not automatically make every progress track a full pill unless that matches the approved visual system.

---

# 29. Meter Acceptance Test

Create a Meter abstraction only if real use cases require semantic measurement distinct from task completion.

Do not create `OrpMeter` because HTML has `<meter>`.

Evidence first.

---

# 30. Meter Semantics

Native `<meter>` supports concepts such as:

```text
min
max
low
high
optimum
value
```

Audit whether this is useful for ORP.

Be careful: low/high/optimum can imply semantic meaning.

Do not invent domain defaults.

---

# 31. Progress vs StatCard

StatCard displays a metric.

Progress/Meter displays range/completion visually.

Example:

```text
StatCard:
Visitors
12,420

Meter:
Storage used
72 / 100 GB
```

Do not merge them.

---

# 32. Visual Slot in StatCard

StatCard already has/had a generic `#visual` concept.

If Progress/Meter is created, it can be composed inside StatCard.

Do NOT hardwire StatCard to Progress.

---

# PART C — STATUS

# 33. Status Must Be Audited Against Badge

This is the most important candidate check.

ORP already has Badge.

Known generic variants include concepts such as:

```text
primary
secondary
success
warning
danger
outline
```

Before creating Status ask:

> Is Status genuinely different from Badge?

---

# 34. Badge Definition

Badge generally represents a compact label/tag/category/state.

Examples:

```text
New
Featured
Premium
Draft
```

But some current use may already include status semantics.

Audit real repository usage.

---

# 35. Potential Status Definition

Status would represent current state/condition rather than a generic label.

Potential examples:

```text
Online
Offline
Available
Unavailable
Active
Inactive
Pending
```

These examples are for semantic analysis only.

Do not add them as built-in values.

---

# 36. Status Acceptance Test

Create Status only if it offers something meaningful beyond Badge, such as:

- dedicated state semantics
- indicator dot
- consistent icon/state pattern
- accessibility treatment
- compact live-state representation
- generic intent separate from category/tag badges

If it is simply:

```text
Badge + dot
```

with no additional semantic value, it may not justify a new Component.

---

# 37. Status vs Semantic Intent

If Status exists, distinguish:

```text
state
```

from:

```text
visual intent
```

State examples are consumer-owned.

Visual intent might be:

```text
neutral
positive
warning
negative
info
```

But do not force this vocabulary without checking existing ORP naming.

---

# 38. Avoid Domain State Enum

Do NOT create built-ins such as:

```text
active
inactive
online
offline
pending
approved
rejected
available
unavailable
```

Those belong to applications.

ORP may style intent; consumer provides text/state.

---

# 39. Status Dot

Audit repeated usage of:

```text
small colored dot + label
```

across multiple contexts.

If strongly repeated, Status may be justified.

Otherwise keep it composed from existing primitives.

---

# 40. Color Is Not Enough

If Status exists, state must not rely solely on color.

Use:

- visible label
- icon/shape where appropriate
- accessible text

A green/red dot with no label is not sufficient in many contexts.

---

# 41. Live Status

Do not automatically use:

```text
aria-live
```

Status is not necessarily dynamic.

Applications own announcement behavior when state changes need to be announced.

---

# 42. Status vs Alert

Status:

```text
compact state representation
```

Alert:

```text
message requiring attention/context
```

Keep distinct.

---

# 43. Status vs Badge

The report MUST explicitly conclude one of:

```text
STATUS IS DISTINCT FROM BADGE
```

or:

```text
BADGE ALREADY COVERS STATUS
```

or:

```text
BADGE SHOULD BE EXTENDED INSTEAD
```

No ambiguous conclusion.

---

# 44. Component Extraction Rule

A new Component requires:

- clear responsibility
- domain independence
- 2+ contexts
- stable semantics
- stable visual behavior
- small API
- meaningful reduction of duplication
- not already solved by ORP

Do not overextract.

---

# 45. Cross-Candidate Comparison

Check if all three candidates share repeated concepts:

- label/value
- neutral track
- state intent
- animation
- visually hidden text

Reuse existing Foundation/Helpers.

Do not create unnecessary shared abstractions during this phase.

---

# 46. Spinner / Loading Indicator

While auditing Skeleton, inspect whether ORP already has a spinner/loading indicator.

Do NOT automatically create one.

Classify:

```text
REUSE
DEFER
REJECT
```

Skeleton and Spinner solve different loading experiences.

---

# 47. Skeleton vs Spinner

Skeleton:

```text
content-shaped placeholder
```

Spinner:

```text
generic waiting/activity indicator
```

Do not replace one with the other indiscriminately.

---

# 48. Component APIs

For any component created:

- follow actual ORP naming conventions
- follow existing props conventions
- follow slot conventions
- keep defaults predictable
- avoid domain props
- preserve themeability
- use Foundation tokens
- provide accessibility contract

---

# 49. No Component Zoo

Do NOT end with:

```text
OrpSkeleton
OrpSkeletonText
OrpSkeletonCircle
OrpSkeletonCard
OrpProgress
OrpProgressBar
OrpMeter
OrpStatus
OrpStatusDot
OrpStatusLabel
```

unless repository evidence truly justifies each.

Prefer small APIs and composition.

---

# 50. Playground

Create/update the `Components` area of ORP Playground.

Every new Component needs its own independent demo.

---

# 51. Skeleton Playground

If created, show:

- line/text
- rectangular media placeholder
- circular/avatar-like placeholder
- composed generic loading block
- reduced-motion behavior documented

Do not create domain-specific card skeleton components.

---

# 52. Progress Playground

If created, show:

- determinate
- low progress
- high progress
- optional label if API supports it
- indeterminate only if supported
- narrow mobile context

Use realistic non-domain-specific labels.

---

# 53. Meter Playground

Only if Meter is justified.

Show why it is NOT Progress.

Use measurement examples such as:

```text
capacity
quality
resource usage
```

without tying component API to those domains.

---

# 54. Status Playground

Only if Status is justified.

Show:

- neutral
- positive
- warning
- negative

or actual approved intent vocabulary.

Also compare:

```text
Badge vs Status
```

The difference should be obvious.

---

# 55. Badge Comparison Is Mandatory

If Status is created, Playground/documentation must show:

```text
Badge
→ label/tag/category

Status
→ current state/condition
```

If this distinction cannot be demonstrated clearly:

do not create Status.

---

# 56. Mobile-First QA

Test all created/extended Components at:

```text
320
375
390
430
```

before desktop.

Check:

- label wrapping
- progress readability
- narrow tracks
- skeleton overflow
- status labels
- touch/interaction if any

---

# 57. Desktop QA

Also inspect:

```text
768
1200
1440
```

Components should remain compact and not scale awkwardly.

---

# 58. Accessibility QA

Required.

Skeleton:
- no meaningless screen-reader content
- reduced motion
- loading context guidance

Progress:
- correct native/ARIA semantics
- determinate/indeterminate correctness

Meter:
- correct semantics
- value interpretation

Status:
- not color-only
- visible state text
- no unnecessary aria-live

---

# 59. Contrast

Check Default Theme 2026 contrast for:

- Skeleton against surface
- Progress track/value
- Status labels/dots
- disabled/neutral states

Do not use low-contrast gray just because the UI is restrained.

---

# 60. Motion

Any animation must be:

- purposeful
- subtle
- short/continuous only when appropriate
- reduced-motion aware

No decorative glow or flashy shimmer.

---

# 61. Tokens

Use existing ORP tokens for:

- surface
- muted surface
- primary
- semantic intent
- text
- border
- radius
- motion

Do not create a parallel palette.

---

# 62. Hardcode Audit

Search created files for:

- raw colors
- raw shadows
- arbitrary radius
- arbitrary spacing
- arbitrary durations

Promote only genuine reusable design decisions to Foundation tokens.

---

# 63. No Acerca Migration

Do NOT update application code to use new components.

Acerca is read-only evidence only.

Dogfooding remains later.

---

# 64. No Primitive Expansion

Do NOT create new primitives during Component Gap Review.

If a primitive gap is discovered, document it.

---

# 65. No Pattern Expansion

Do not create new Card Patterns.

Do not create loading-specific Patterns.

---

# 66. No Business Logic

Do not modify:

- APIs
- Laravel
- routes
- models
- database
- Inertia data
- state management

---

# 67. No Third-Party Libraries

Do not add a library for:

- Skeleton
- Progress
- Status

These are foundational UI concepts and should remain lightweight.

---

# 68. Tests

For each actual Vue Component created/extended, add meaningful tests for:

- public API
- accessibility
- variants
- emitted behavior only if relevant

Do not test implementation details.

---

# 69. CSS-Only Result

If a candidate is best solved as CSS/native HTML rather than Vue:

do not force a Component.

Document why.

---

# 70. Build

Run:

```bash
npm run build
```

Must pass.

---

# 71. Browser QA

Use real browser rendering if tooling exists.

Do not claim visual QA based only on code inspection.

---

# 72. Required Report

Generate:

```text
ORP-COMPONENT-GAP-REVIEW.md
```

following the project's ORP documentation convention.

---

# 73. Report Structure

```text
# ORP Component Gap Review

## Executive Summary

## Existing Component Inventory

## Gap Matrix

## Read-Only Application Evidence

## Skeleton

### Existing solution
### Generic use cases
### Decision
### API
### Accessibility
### Rejected ideas

## Progress

### Existing solution
### Native progress analysis
### Generic use cases
### Decision
### API
### Accessibility

## Meter

### Progress vs Meter
### Native meter analysis
### Generic use cases
### Decision

## Status

### Existing Badge behavior
### Badge usage audit
### Status use cases
### Status vs Badge
### Decision
### API if created
### Accessibility

## Spinner / Loading Indicator

### Existing solution
### Decision

## New Components Created

## Existing Components Extended

## Candidates Rejected

## Candidates Deferred

## Token Usage

## Hardcoded Values

## Playground Coverage

## Mobile QA

## Desktop QA

## Accessibility QA

## Tests

## Build

## Files Created

## Files Modified

## Final Component Architecture

## Next Recommended Phase
```

---

# 74. Required Verdicts

For Skeleton report one:

```text
SKELETON CREATED
SKELETON EXTENDED
SKELETON ALREADY ADEQUATE
SKELETON NOT JUSTIFIED
SKELETON DEFERRED
```

For Progress:

```text
PROGRESS CREATED
PROGRESS EXTENDED
PROGRESS ALREADY ADEQUATE
PROGRESS NOT JUSTIFIED
PROGRESS DEFERRED
```

For Meter:

```text
METER CREATED
METER EXTENDED
METER ALREADY ADEQUATE
METER NOT JUSTIFIED
METER DEFERRED
```

For Status:

```text
STATUS CREATED
STATUS EXTENDED
BADGE ALREADY COVERS STATUS
BADGE SHOULD BE EXTENDED INSTEAD
STATUS NOT JUSTIFIED
STATUS DEFERRED
```

---

# 75. Final Architecture

Report actual Components after decisions.

Example only:

```text
Components
├── Modal
├── Drawer
├── Accordion
├── Map
│   ├── OrpMap
│   └── OrpMapMarker
├── Skeleton
└── Progress
```

Do not list components that were rejected.

---

# 76. Recommended Next Phase

After this review, do NOT continue blindly creating Components.

Recommended next phase should be one of:

```text
VISUAL DIRECTION AUDIT
```

if Foundation/Primitives/Components are now sufficiently complete,

or:

```text
ONE FOCUSED COMPONENT FOLLOW-UP
```

if the audit identifies one blocking architectural gap.

Prefer moving to Visual Direction Audit rather than endless component expansion.

---

# 77. STOP CONDITION

STOP after:

1. repository audit
2. application evidence audit
3. gap matrix
4. Skeleton decision
5. Progress decision
6. Meter decision
7. Status vs Badge decision
8. minimal implementation of justified candidates
9. Playground
10. mobile QA
11. desktop QA
12. accessibility QA
13. tests
14. `npm run build`
15. report
16. one next-phase recommendation

Do not continue automatically.

---

# FINAL INSTRUCTION

Perform an evidence-based Component Gap Review.

1. Audit existing ORP first.
2. Do not assume Skeleton is missing.
3. Do not assume Progress requires Vue.
4. Distinguish Progress from Meter.
5. Evaluate native `<progress>` and `<meter>`.
6. Audit Badge before creating Status.
7. Explicitly decide Status vs Badge.
8. Do not add domain-specific states.
9. Require 2+ generic contexts.
10. Keep APIs small.
11. Prefer native semantics.
12. Preserve accessibility.
13. Respect reduced motion.
14. Use ORP tokens.
15. Do not create a component zoo.
16. Do not create domain loading components.
17. Keep Skeleton separate from fetching logic.
18. Keep Progress separate from StatCard.
19. Keep Status separate from Alert.
20. Keep application state outside ORP.
21. Update Playground only for justified components.
22. Test mobile first.
23. Run tests.
24. Run `npm run build`.
25. Generate `ORP-COMPONENT-GAP-REVIEW.md`.
26. Recommend Visual Direction Audit if the component layer is sufficiently complete.
27. STOP.

