# ORP UI — BUTTON SYSTEM AUDIT & EXPANSION
# Focused visual/system audit before continuing Visual Pilot rollout
# Goal: complete Button hierarchy without recreating Bootstrap

## Context

ORP UI currently exposes a Button system approximately like:

```text
Variants
├── Primary
├── Secondary
├── Ghost
└── Danger

Sizes
├── Small
├── Medium
└── Large

Layout
└── Block
```

Before continuing the broader ORP visual rollout, Button needs a focused audit because actions are one of the strongest signals of a design system's identity.

The goal is NOT to add every familiar button variant.

The goal is to determine whether ORP needs additional action hierarchies for its 2026 visual direction.

Primary candidates:

```text
Soft
Outline
Link
Loading state
Icon + label composition
```

Secondary candidates that require a HIGH justification threshold:

```text
Success
Warning
Info
```

Do NOT automatically implement any candidate.

---

# 1. Objective

Audit and refine the complete ORP Button system.

Answer:

1. Are current variants visually and semantically distinct?
2. Is there a missing hierarchy between Primary and Ghost?
3. Is `Soft` useful?
4. Is `Outline` useful or does Secondary already solve it?
5. Is `Link` genuinely a Button responsibility?
6. Does Button need a loading state?
7. Are icon + text compositions already clean?
8. Are Small/Medium/Large coherent?
9. Is Block correctly implemented?
10. Do all states feel like ORP 2026 rather than Bootstrap?

Follow:

```text
DISCOVER
→ INVENTORY
→ COMPARE
→ CLASSIFY
→ EXTEND ONLY JUSTIFIED VARIANTS/STATES
→ PLAYGROUND
→ MOBILE QA
→ ACCESSIBILITY
→ REPORT
→ STOP
```

---

# 2. Critical Rule

Do NOT turn ORP into:

```text
btn-primary
btn-secondary
btn-success
btn-danger
btn-warning
btn-info
btn-light
btn-dark
btn-outline-primary
btn-outline-secondary
btn-outline-success
...
```

That is exactly the Bootstrap-style variant matrix ORP should avoid.

ORP Button variants should express ACTION HIERARCHY, not a color palette.

---

# 3. Mandatory Repository Audit

Inspect the actual implementation before editing:

```text
Button
OrpButton if it exists
.orp-btn
IconButton
Visual Helpers
Default Theme 2026 tokens
Typography
Stack
Cluster
Playground
tests
docs
```

Search for:

```text
orp-btn
button
primary
secondary
ghost
danger
outline
soft
link
loading
spinner
disabled
aria-busy
pressed
block
icon
```

The repository is the API source of truth.

---

# 4. Audit Real Consumers

Inspect ORP Patterns:

```text
CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard
Empty
Alert
Modal
Drawer
Forms
```

Then inspect Acerca READ-ONLY for recurring action hierarchy.

Do NOT modify Acerca.

---

# 5. Required Inventory Matrix

Produce:

| Capability | Exists | Current API | Generic contexts | Problem | Decision |
|---|---|---|---:|---|---|
| Primary | ? | ? | ? | ? | ? |
| Secondary | ? | ? | ? | ? | ? |
| Ghost | ? | ? | ? | ? | ? |
| Danger | ? | ? | ? | ? | ? |
| Soft | ? | ? | ? | ? | ? |
| Outline | ? | ? | ? | ? | ? |
| Link | ? | ? | ? | ? | ? |
| Loading | ? | ? | ? | ? | ? |
| Icon + label | ? | ? | ? | ? | ? |
| Leading icon | ? | ? | ? | ? | ? |
| Trailing icon | ? | ? | ? | ? | ? |
| Block | ? | ? | ? | ? | ? |
| Disabled | ? | ? | ? | ? | ? |
| Pressed/active | ? | ? | ? | ? | ? |

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

# 6. Button Hierarchy Model

Evaluate whether ORP can express:

```text
Primary
→ strongest normal action

Soft
→ emphasized but lower visual weight

Secondary
→ neutral secondary action

Ghost
→ quiet tertiary action

Danger
→ destructive action
```

This is a hypothesis.

Validate against actual ORP usage.

---

# 7. Primary

Primary should communicate the main action.

Audit:

- background
- foreground contrast
- hover
- active
- focus
- disabled
- height
- padding
- typography
- radius

It should NOT resemble Bootstrap merely because it is a filled indigo button.

---

# 8. Primary Usage

A composition should normally have one obvious Primary action.

Do not use Primary as universal decoration.

---

# 9. Secondary

Determine the actual visual responsibility of Secondary.

Possible role:

```text
neutral visible action
```

Ask whether it currently behaves like:

- outline button
- neutral filled button
- muted surface button

This decision affects whether `Outline` is actually needed.

---

# 10. Soft — Strong Candidate

Audit `Soft` seriously.

Potential responsibility:

```text
brand-emphasized action
with lower visual weight than Primary
```

Conceptually:

```text
soft primary-tinted surface
primary-colored text/icon
quiet hover
```

This could be valuable for ORP 2026 because it provides hierarchy without adding another loud filled action.

Do not implement until compared with Secondary and Ghost.

---

# 11. Soft Must Not Become Semantic Matrix

Do NOT create:

```text
soft-primary
soft-success
soft-danger
soft-warning
soft-info
```

during this phase.

If `Soft` exists, it should have one clear generic action-hierarchy role.

---

# 12. Outline — Audit Carefully

Outline is a familiar pattern, but also a strong Bootstrap visual signal.

Ask:

> What can Outline express that Secondary cannot?

If the answer is unclear:

```text
OUTLINE NOT JUSTIFIED
```

is the preferred result.

---

# 13. Outline Acceptance Test

Create Outline only if:

- it has a stable hierarchy role
- it appears in 2+ generic contexts
- Secondary is visually/semantically different
- it does not create duplicate choices
- it fits ORP 2026 visual direction

---

# 14. Link Variant — Audit Carefully

A link-looking button may be useful when an action semantically requires `<button>` but should visually resemble inline text.

Examples include:

- reveal
- retry
- show more
- secondary inline action

But do not use Button to replace semantic `<a>` links.

---

# 15. Link vs Anchor

If navigation is semantically a link:

use:

```html
<a>
```

not a Button styled as a link merely for consistency.

The audit must preserve HTML semantics.

---

# 16. Danger

Danger is not merely another color variant.

It communicates destructive action.

Audit whether it is appropriately reserved for:

- delete
- remove
- revoke
- destructive confirmation

Do not weaken the semantic distinction.

---

# 17. Success Candidate

Do NOT create Success automatically.

Ask:

> Is "success" an action hierarchy or merely a semantic color?

Often:

```text
Save
Confirm
Continue
```

should still be Primary.

A green button is usually unnecessary.

Require strong evidence.

---

# 18. Warning Candidate

Very high rejection threshold.

Warning is usually a state/message intent, not a standard action hierarchy.

Prefer:

```text
REJECT
```

unless real cross-context evidence proves otherwise.

---

# 19. Info Candidate

Same rule.

Do not create a blue/cyan Info button just because semantic info color exists.

---

# 20. Sizes

Audit:

```text
Small
Medium
Large
```

Check actual token/proportion consistency.

Evaluate:

- height
- horizontal padding
- icon size
- font size
- radius
- touch target
- visual hierarchy

---

# 21. Medium Is Default

The default Button should correspond cleanly to Medium or equivalent.

Consumers should not need to specify size constantly.

---

# 22. Small

Small must remain usable.

Do not make it visually neat but inaccessible.

Audit touch target implications.

Small may be appropriate for dense desktop UI but should be used carefully on mobile.

---

# 23. Large

Large should communicate prominent CTA scale without becoming oversized marketing-template UI.

---

# 24. Block

Audit existing Block behavior.

Expected responsibility:

```text
button takes available inline width
```

Do not make Block a visual variant.

---

# 25. Block on Mobile

Test Block at:

```text
320
375
390
430
```

Especially with:

- long Spanish labels
- icon + label
- loading
- disabled

---

# 26. Block Button Playground

Keep a clear Playground example:

```text
Block Button
```

But show it in realistic narrow/mobile context.

---

# 27. Icon + Label

Audit whether existing Button naturally supports:

```text
[icon] Label
```

using slot/content + existing layout.

Do not immediately add:

```text
leftIcon
rightIcon
iconName
```

props.

---

# 28. Leading Icon

Required test:

```text
[icon] Descargar
```

Verify:

- optical alignment
- gap
- icon size
- line-height
- all button sizes

---

# 29. Trailing Icon

Required test:

```text
Continuar [icon]
```

Useful for directional/forward actions.

Again, do not add API unless composition currently requires repeated local CSS.

---

# 30. Leading + Trailing

Test if normal content composition permits it.

Do not optimize Button specifically for this unless a real generic need exists.

---

# 31. Icon Ownership

Bootstrap Icons remain allowed.

Button should not map semantic strings to icons.

Consumer chooses icon.

---

# 32. Icon Size

Button should establish a coherent icon relationship.

Avoid consumers repeatedly hardcoding:

```text
font-size: 14px
font-size: 18px
margin-right: 6px
```

If repeated, determine whether Button CSS can style generic icon descendants safely.

---

# 33. IconButton Is Separate

Do not merge regular Button and IconButton.

Architecture:

```text
Button
→ label-driven action, optional icons

IconButton
→ icon-only action with accessible label
```

Keep both responsibilities clear.

---

# 34. Loading State — Audit

Determine whether Button needs a generic loading/busy state.

Potential behavior:

- disable repeated activation
- show loading indicator
- preserve width
- communicate busy state
- accessible `aria-busy`

But business async state remains consumer-owned.

---

# 35. Loading Acceptance Test

Create loading support only if repeated generic consumers need it.

Potential contexts:

- submit
- save
- delete
- retry
- async action

This likely satisfies the 2+ contexts rule, but verify repository evidence.

---

# 36. Loading Does Not Fetch

Button must NOT:

- call APIs
- own promises
- detect network state
- automatically reset itself

Consumer controls:

```text
loading = true/false
```

if a loading API is created.

---

# 37. Loading Visual

If loading is supported:

- keep button width stable where possible
- preserve label context if appropriate
- use existing Spinner/loading primitive if one exists
- do not add a new spinner framework inside Button

Audit existing loading indicator first.

---

# 38. Loading Accessibility

If loading:

- prevent accidental duplicate action where appropriate
- expose busy state
- ensure screen-reader meaning
- do not rely only on animation

Follow actual ORP accessibility conventions.

---

# 39. Disabled

Audit disabled visual treatment.

Disabled should remain identifiable without becoming unreadable.

Check:

- opacity
- text contrast
- cursor
- pointer events
- focus behavior

Do not use opacity so low that content disappears.

---

# 40. Active / Pressed

Distinguish:

```text
active interaction state
```

from:

```text
toggle button pressed state
```

Do not add `aria-pressed` to ordinary buttons.

If toggle buttons are not an existing ORP responsibility, defer them.

---

# 41. Hover

Hover must be subtle and meaningful.

Avoid:

```text
large translate
large shadow
dramatic saturation shift
```

Use actual ORP motion tokens.

---

# 42. Fine Pointer

Where practical, hover-specific decorative behavior should target devices that support hover/fine pointers.

Do not make mobile interaction depend on hover.

---

# 43. Focus

HIGH PRIORITY.

Audit focus across all variants.

Focus should be:

- visible
- accessible
- coherent
- ORP-branded
- not Bootstrap blue glow

Do not remove outlines without a replacement.

---

# 44. Focus Visible

Prefer `:focus-visible` where consistent with ORP browser support.

Do not hide keyboard focus.

---

# 45. Pressed Feedback

Buttons should have clear but restrained pressed feedback.

Possible mechanisms:

- color/surface change
- slight visual compression if existing motion direction supports it

Do not overanimate.

---

# 46. Radius

Button radius must align with Default Theme 2026.

Audit whether buttons are currently too Bootstrap-like or too pill-like.

---

# 47. Pill Buttons

Do NOT create a generic pill variant merely because it is fashionable.

If a specific composition needs a pill-shaped control, evaluate existing helpers/local composition.

Buttons should not all be pills.

---

# 48. Typography

Audit:

- font family
- weight
- size
- line-height
- letter spacing
- casing

Do not uppercase button labels globally.

Natural language casing is preferred.

---

# 49. Spanish Labels

Test:

```text
Guardar cambios
Ver información
Solicitar información
Continuar con el registro
Eliminar definitivamente
Volver a configuración
```

Do not optimize for one-word English labels.

---

# 50. White Space

Button internal spacing should be balanced across:

- label only
- icon + label
- trailing icon
- loading
- small
- medium
- large

---

# 51. Button Groups

Audit repeated groups of actions.

Do NOT automatically create `OrpButtonGroup`.

First determine whether:

```text
Cluster
```

already solves layout.

Only extract ButtonGroup if it provides more than spacing.

---

# 52. Adjacent Actions

Test:

```text
Primary + Ghost
Primary + Secondary
Danger + Ghost
Soft + Ghost
```

if Soft is approved.

Check visual hierarchy.

---

# 53. Multiple Filled Buttons

Flag compositions where several filled buttons compete.

The Button system should make action hierarchy easier, not harder.

---

# 54. Full Width Action Groups

On mobile, test whether:

```text
Primary block
Secondary block
```

creates too much visual weight.

Consider existing Stack/Cluster responsive composition rather than Button-specific behavior.

---

# 55. Anchor Buttons

Audit whether `.orp-btn` can be applied to:

```html
<a>
```

as well as:

```html
<button>
```

if that is current ORP architecture.

Ensure:

- semantic element remains consumer-owned
- disabled semantics are not faked incorrectly on anchors

---

# 56. Button Type

Vue Button wrappers, if they exist, should handle native `type` safely.

Audit accidental form submission behavior.

Do not change API unless necessary.

---

# 57. IconButton Consistency

Compare regular Button and IconButton:

- height
- radius
- focus
- hover
- primary
- ghost
- danger

They should share visual DNA.

Do not force identical APIs.

---

# 58. Soft + IconButton

If Soft is approved for regular Button, do NOT automatically add Soft to IconButton.

Audit separately.

Avoid variant multiplication.

---

# 59. Danger Hierarchy

Test destructive confirmation composition:

```text
Delete
Cancel
```

Danger should be clear.

Cancel should not visually compete.

---

# 60. Soft Hierarchy Test

If Soft is created, compare:

```text
Primary
Soft
Secondary
Ghost
```

side-by-side.

A user should be able to visually rank them.

If Soft and Secondary are nearly indistinguishable, one is unnecessary.

---

# 61. Outline Hierarchy Test

If Outline is created, compare it against Secondary.

If distinction depends only on tiny CSS differences:

reject Outline.

---

# 62. Link Hierarchy Test

If Link is created, compare against normal semantic links.

Ensure users can still understand navigation vs action through semantics/context.

---

# 63. Color Audit

Use Default Theme 2026 tokens.

Do not hardcode:

```text
#635bff
```

inside Button implementation.

Use the approved token.

---

# 64. Semantic Colors

Danger should use semantic danger tokens.

Do not create Success/Warning/Info merely because those tokens exist.

Tokens do not imply components need every semantic variant.

---

# 65. Borders

Avoid Bootstrap-like heavy outline treatment.

Borders should be quiet and intentional.

---

# 66. Shadows

Buttons generally should not require decorative shadows.

If current Primary uses shadow, evaluate whether it is actually needed.

---

# 67. Elevation

A button may communicate interaction through:

- surface
- border
- color
- pressed state

before shadow.

Follow:

```text
Flat
→ Border
→ Surface contrast
→ Shadow
```

---

# 68. Anti-Bootstrap Test

For each variant ask:

> If `.orp-btn` were renamed `.btn`, would this look like Bootstrap?

Score:

```text
0 = no meaningful resemblance
1 = minor generic similarity
2 = noticeable
3 = strong resemblance
```

Score before/after:

- Primary
- Secondary
- Ghost
- Danger
- Soft if added
- Outline if added
- Overall Button family

---

# 69. Variant Acceptance Rule

A new variant must answer:

```text
What action hierarchy does this express?
```

If the answer is:

```text
"It's another color/style option"
```

REJECT IT.

---

# 70. Variant Budget

Prefer approximately:

```text
4–6 meaningful variants
```

rather than 10+.

This is guidance, not a quota.

---

# 71. Playground Structure

Update the Buttons section of ORP Playground.

It should become a real Button system reference.

---

# 72. Playground — Variants

Show all approved variants together.

Use the same label where possible for comparison.

---

# 73. Playground — Sizes

Show:

```text
Small
Medium
Large
```

for a representative variant.

Avoid repeating every variant × every size unless useful.

---

# 74. Playground — Block

Show:

```text
Block Button
```

inside a realistic constrained container.

---

# 75. Playground — Icons

Show:

```text
Leading icon
Trailing icon
Icon + long label
```

using actual approved composition.

---

# 76. Playground — States

Show applicable:

```text
Default
Hover documentation
Focus
Active
Disabled
Loading
```

Do not fake hover through permanent demo styles if browser interaction can show it naturally.

---

# 77. Playground — Action Hierarchy

Required demo:

```text
Primary
Secondary/Soft
Ghost
```

in one realistic action group.

The hierarchy should be immediately visible.

---

# 78. Playground — Destructive

Required:

```text
Danger
Ghost cancel
```

or equivalent.

---

# 79. Playground — Long Spanish Labels

Required.

Use realistic text.

---

# 80. Playground — Mobile

Inspect the Button section at:

```text
320
375
390
430
```

especially:

- Block
- action groups
- long labels
- icons
- loading

---

# 81. Desktop QA

Also inspect:

```text
768
1200
1440
```

Buttons should not feel oversized or toy-like on desktop.

---

# 82. Touch Targets

Check WCAG/usability implications for Small.

Do not silently make Small unsuitable for touch without documenting intended usage.

---

# 83. Accessibility

Required audit:

- contrast
- focus
- disabled
- loading
- button type
- anchor semantics
- icon accessibility
- accessible names
- keyboard
- reduced motion

---

# 84. Icon Accessibility

Decorative icons inside labeled buttons should generally not duplicate the accessible name.

Follow existing icon conventions.

Icon-only actions belong to IconButton.

---

# 85. Loading Accessible Name

If loading changes visible label, ensure the action remains understandable.

Do not expose only:

```text
Loading...
```

without context if that harms meaning.

---

# 86. No Domain Props

Do not add:

```text
save
delete
checkout
whatsapp
contact
download
upload
login
```

variants/props.

---

# 87. No `.orp-btn--whatsapp`

WhatsApp remains application/domain branding.

Not ORP core.

---

# 88. No Icon Mapping

Do not implement:

```text
variant=download → download icon
variant=delete → trash icon
```

Consumer chooses icons.

---

# 89. No Utility Soup

Do not solve Button variants by stacking many helpers.

Button owns its own visual contract.

---

# 90. Token Compliance

Audit final Button styles for:

- color
- typography
- spacing
- radius
- border
- motion
- focus
- disabled
- shadow

Reuse tokens.

---

# 91. Hardcode Audit

Search Button styles after changes.

Document any remaining raw values.

Only retain values that are behavioral/structural and not reusable design decisions.

---

# 92. API Compatibility

Preserve current API wherever possible.

If CSS modifiers are the current public API, extend that convention.

If a Vue Button exists, follow its existing variant enum.

Do not create parallel Button APIs.

---

# 93. Breaking Changes

If current Secondary semantics must change substantially, document:

```text
CURRENT
TARGET
BREAKING IMPACT
CONSUMERS
MIGRATION
```

Do not silently redefine widely used behavior.

---

# 94. Read-Only Acerca

Do not migrate Acerca to new Button variants.

However, inspect it to identify future opportunities such as:

```text
Primary → main CTA
Soft → details
Ghost → cancel/back
Danger → destructive
```

Document only.

---

# 95. CatalogCard Pilot Relationship

The next/ongoing visual pilot is:

```text
CatalogCard Collection
```

Button refinement should support that pilot.

Do NOT redesign CatalogCard in this phase.

After Button audit is approved, CatalogCard can use the finalized action hierarchy during its visual pilot.

---

# 96. Tests

Run existing Button/IconButton tests.

Add meaningful tests for newly exposed public API:

- new variant
- loading
- disabled interaction
- accessibility attributes

Do not test CSS pixel values in unit tests.

---

# 97. Build

Run:

```bash
npm run build
```

Must pass.

---

# 98. Console QA

Inspect Playground.

No new:

- Vue warnings
- errors
- missing icons/assets

---

# 99. Required Report

Generate:

```text
.opencode/ORPUI/ORP-BUTTON-SYSTEM-AUDIT.md
```

---

# 100. Required Report Structure

```text
# ORP Button System Audit & Expansion

## Executive Summary

## Existing API

## Existing Variants

## Existing Sizes

## Existing States

## Consumer Audit

## Acerca Read-Only Evidence

## Capability Matrix

## Action Hierarchy

## Primary

## Secondary

## Ghost

## Danger

## Soft
Decision:
Reason:

## Outline
Decision:
Reason:

## Link
Decision:
Reason:

## Success
Decision:
Reason:

## Warning
Decision:
Reason:

## Info
Decision:
Reason:

## Sizes

## Block

## Leading Icon

## Trailing Icon

## IconButton Relationship

## Loading

## Disabled

## Hover

## Focus

## Active / Pressed

## Typography

## Radius

## Borders

## Elevation

## Color / Tokens

## Accessibility

## Mobile QA

## Desktop QA

## Bootstrap Resemblance Before / After

## Playground Coverage

## API Changes

## Breaking Changes

## Rejected Variants

## Deferred Findings

## Tests

## Build

## Console

## Files Created

## Files Modified

## Final Button Architecture

## Final Verdict

## Next Phase
```

---

# 101. Required Candidate Verdicts

For Soft:

```text
SOFT CREATED
SOFT ALREADY EXISTS
SOFT NOT JUSTIFIED
SOFT DEFERRED
```

For Outline:

```text
OUTLINE CREATED
OUTLINE ALREADY EXISTS
OUTLINE NOT JUSTIFIED
OUTLINE DEFERRED
```

For Link:

```text
LINK CREATED
LINK ALREADY EXISTS
LINK NOT JUSTIFIED
LINK DEFERRED
```

For Loading:

```text
LOADING SUPPORT CREATED
LOADING SUPPORT ALREADY EXISTS
LOADING SUPPORT NOT JUSTIFIED
LOADING SUPPORT DEFERRED
```

---

# 102. Semantic Variant Verdicts

Explicitly report:

```text
SUCCESS BUTTON:
CREATE / REJECT / DEFER

WARNING BUTTON:
CREATE / REJECT / DEFER

INFO BUTTON:
CREATE / REJECT / DEFER
```

Require evidence for CREATE.

---

# 103. Final Button Architecture

Report the real final API.

Example only:

```text
Button

Variants
├── Primary
├── Soft
├── Secondary
├── Ghost
└── Danger

Sizes
├── Small
├── Medium
└── Large

Layout
├── Auto
└── Block

Content
├── Label
├── Leading icon
└── Trailing icon

States
├── Default
├── Hover
├── Focus
├── Active
├── Disabled
└── Loading
```

Do not report variants that were rejected.

---

# 104. Final Verdict

End with exactly one:

```text
BUTTON SYSTEM READY FOR VISUAL PILOT
```

or:

```text
BUTTON SYSTEM NEEDS FOLLOW-UP
```

If follow-up is required, identify only blocking issues.

---

# 105. Next Phase

If ready:

```text
NEXT PHASE:
ORP VISUAL PILOT REDESIGN — CatalogCard Collection
```

Resume the existing CatalogCard pilot plan using the finalized Button system.

Do not automatically execute it.

---

# 106. STOP CONDITION

STOP after:

1. repository audit
2. consumer audit
3. capability matrix
4. action hierarchy analysis
5. Soft decision
6. Outline decision
7. Link decision
8. semantic color variant decisions
9. Loading decision
10. icon composition audit
11. sizes/block audit
12. states/accessibility audit
13. minimal justified implementation
14. Playground update
15. responsive QA
16. tests
17. build
18. report
19. final verdict
20. recommendation to resume CatalogCard visual pilot

Do not redesign CatalogCard.

Do not expand other Components.

---

# FINAL INSTRUCTION

Complete ORP's Button system without turning it into Bootstrap.

Buttons represent action hierarchy, not a color palette.

Audit:

```text
Primary
Secondary
Ghost
Danger
Soft
Outline
Link
```

but only create variants with a clear purpose.

Give `Soft` serious consideration because it can provide a modern intermediate hierarchy between loud Primary and quiet Ghost.

Treat `Outline` skeptically because it can duplicate Secondary and increase Bootstrap resemblance.

Treat `Success`, `Warning` and `Info` very skeptically.

Audit:

```text
Small
Medium
Large
Block
Leading icon
Trailing icon
Disabled
Loading
Hover
Focus
Active
```

Preserve semantics.

Preserve accessibility.

Use Default Theme 2026.

Keep primary usage intentional.

Avoid pills by default.

Avoid decorative shadows.

Avoid prop explosion.

Avoid utility soup.

Do not add domain variants.

Do not modify Acerca.

Do not redesign CatalogCard yet.

Generate the report.

Then STOP.

