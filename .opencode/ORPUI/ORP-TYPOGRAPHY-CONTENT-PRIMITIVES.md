
# ORP UI — TYPOGRAPHY & CONTENT PRIMITIVES
# Audit, complete and standardize the typography/content foundation
# Run after ORP Default Theme 2026 and before the Visual Direction Audit

## Context

ORP UI already has:

- Foundation/tokens
- layout primitives
- generic UI components
- generic Patterns
- ORP Playground

The default visual theme is being modernized separately.

Before continuing with the ORP Visual Direction Audit, we need to inspect and strengthen a different part of the framework:

TYPOGRAPHY + CONTENT PRIMITIVES.

The objective is NOT to copy Vuestic, Bootstrap, Tailwind Typography or another framework.

The objective is to ensure ORP has a coherent, reusable and token-driven way to render common textual and rich-content structures without every consumer inventing local CSS.

Examples include:

- headings
- body copy
- supporting text
- links
- ordered lists
- unordered lists
- nested lists
- blockquotes
- inline code
- code blocks
- keyboard input
- highlighted text
- horizontal separators
- rich CMS content
- truncation
- line clamping
- accessible hidden text
- tables if justified

This phase must follow:

DISCOVER → CLASSIFY → REUSE → COMPLETE → VERIFY

Do not blindly create everything listed in this prompt.

---

# 1. Primary Objective

Create a complete and coherent ORP typography/content foundation so consumers do not need local rules such as:

```css
.service-description ul {}
.about-content blockquote {}
.product-description a {}
.content-body h2 {}
.article-content p {}
```

when those styles represent generic content behavior.

The framework should provide reusable solutions instead.

---

# 2. Architectural Placement

Use this conceptual architecture:

```text
ORP UI
├── Foundation
│   ├── Tokens
│   ├── Typography
│   └── Content styles
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
│
└── Patterns
```

Typography/content styles generally belong in:

FOUNDATION

or:

PRIMITIVES / PRIMARY

depending on their responsibility.

Do not automatically create Vue components.

---

# 3. Critical Rule: Audit Existing ORP First

Before creating anything, inspect the real repository.

Search for existing:

- typography tokens
- heading classes
- text classes
- `.orp-list`
- List component
- Divider
- link styles
- blockquote styles
- code styles
- table styles
- truncation helpers
- line-clamp helpers
- screen-reader helpers
- rich-content/prose styles
- text alignment helpers
- typography-related Pattern CSS

Also inspect:

- ORP Playground
- ORP public exports
- ORP LESS entry files
- documentation
- tests

Do not create a second implementation of something ORP already solves.

---

# 4. Existing `.orp-list` Is a Known Candidate

Previous ORP work indicates `.orp-list` may already exist.

VERIFY IT.

Determine:

- what responsibility it currently has
- whether it means semantic HTML list styling
- whether it means application/list-row layout
- whether nested lists are supported
- whether ordered/unordered variants exist
- whether changing it would break existing consumers

Do NOT redefine `.orp-list` until this is understood.

If `.orp-list` currently represents application UI lists rather than prose lists, keep those responsibilities separate.

---

# 5. Avoid Naming Collisions

If ORP already uses `.orp-list` for component/layout behavior, do not overload it with rich-text list semantics.

Possible conceptual alternatives include:

```text
.orp-prose ul
.orp-prose ol
.orp-content-list
```

These are examples only.

Choose naming based on the actual architecture.

---

# 6. Typography Inventory

Audit all typography-related values currently used across ORP.

Inventory:

- font family
- font sizes
- font weights
- line heights
- letter spacing
- text colors
- heading margins
- paragraph margins
- label styles
- metadata styles

Record repeated hardcoded values.

---

# 7. Typography Roles

Determine whether ORP needs a small semantic typography hierarchy.

Conceptual roles:

```text
Display
Heading
Title
Body
Supporting
Label
Meta
```

These are conceptual roles, NOT mandatory class/component names.

Do not create unnecessary abstractions.

---

# 8. Typography API Decision

For each typography role decide whether it belongs as:

- token only
- CSS class
- semantic element styling
- Vue component
- no abstraction

Prefer the smallest sufficient solution.

A Vue component requires a stronger justification than a CSS class/token.

---

# 9. Do Not Build a Typography Component Zoo

Do NOT automatically create:

```text
OrpHeading
OrpText
OrpParagraph
OrpLabel
OrpMeta
OrpStrong
OrpLink
```

unless repository evidence shows a Vue abstraction provides real value.

Typography is primarily visual/content foundation.

---

# 10. Semantic HTML First

Prefer correct HTML:

```html
<h1>
<h2>
<h3>
<p>
<a>
<ul>
<ol>
<li>
<blockquote>
<strong>
<em>
<code>
<pre>
<kbd>
<mark>
<table>
```

before inventing component wrappers.

ORP should style semantic content, not replace HTML unnecessarily.

---

# 11. Heading System

Audit:

```html
<h1>
<h2>
<h3>
<h4>
<h5>
<h6>
```

Determine:

- visual hierarchy
- line height
- font weight
- spacing
- responsive behavior
- compatibility with the new ORP Default Theme 2026

Do not make every heading dramatically different.

---

# 12. Heading Semantics vs Appearance

HTML heading level and visual size are different concepts.

Do not encourage incorrect document hierarchy just to obtain a visual size.

If ORP needs visual heading roles independent from semantic level, define them carefully.

Do not create a large utility matrix unless necessary.

---

# 13. Body Copy

Define/verify coherent body typography:

- readable default size
- line height
- text color
- paragraph rhythm
- long-form readability

Avoid arbitrary paragraph margins inside components.

---

# 14. Supporting Text

Audit how ORP currently represents supporting copy.

Avoid repeatedly hardcoding:

```css
font-size: 0.875rem;
color: var(--...muted);
```

inside every component.

If a generic role is justified, centralize it.

---

# 15. Metadata

Audit compact metadata across:

- CatalogCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard
- other components

Determine whether metadata needs:

- typography token
- class
- existing Info/Meta abstraction
- nothing new

Do not reopen the previous Information Component Discovery unless evidence requires it.

---

# 16. Labels

Audit form labels and UI labels.

Ensure:

- consistent font weight
- consistent size
- readable contrast
- relationship to controls

Do not confuse form labels with decorative uppercase kickers.

---

# 17. Text Case

ORP should prefer natural casing.

Do not introduce broad helpers for:

```text
uppercase
lowercase
capitalize
```

unless real framework evidence requires them.

Avoid recreating Bootstrap text utilities.

---

# 18. Links

Audit existing anchor/link styling.

ORP needs a clear default link treatment.

Evaluate:

- default link
- secondary/subtle link if justified
- hover
- focus
- visited behavior where appropriate
- disabled behavior only if semantics permit
- links inside prose
- links inside components

---

# 19. Link Affordance

Links must remain recognizable.

Do not make links indistinguishable from body text merely to create a cleaner interface.

Use:

- color
- underline
- weight
- interaction states

appropriately.

---

# 20. Link Variants

Do NOT create a large link variant system.

Potential generic distinction:

```text
default
secondary
```

only if repository evidence supports it.

No domain variants.

---

# 21. Unordered Lists

Support proper unordered content lists.

Test:

```html
<ul>
  <li>Item</li>
  <li>Item</li>
</ul>
```

and nested lists.

Spacing must preserve grouping.

---

# 22. Ordered Lists

Support ordered lists:

```html
<ol>
  <li>First</li>
  <li>Second</li>
</ol>
```

including nested levels.

Do not assume every ordered list must use the same marker style.

Start with semantic browser numbering refined by ORP.

---

# 23. Nested Lists

Explicitly test:

```text
1. Coffee
2. Tea
   1. Black tea
      1. Brooke Bond
      2. Lipton
   2. Green tea
      1. Greenfield
      2. Tess
3. Milk
```

and equivalent unordered nesting.

Verify:

- indentation
- marker visibility
- spacing
- wrapping
- mobile behavior

---

# 24. Lists Inside Rich Content

Lists inside rich content should work without consumers manually attaching classes to every nested element.

This is one of the main reasons to evaluate an ORP prose/content scope.

---

# 25. Rich Content / Prose

Strongly evaluate whether ORP needs a generic content scope conceptually like:

```html
<div class="orp-prose">
  <h2>Heading</h2>

  <p>Paragraph...</p>

  <ul>
    <li>...</li>
  </ul>

  <blockquote>...</blockquote>

  <p>
    Visit <a href="#">this resource</a>.
  </p>
</div>
```

The final name must follow ORP conventions.

---

# 26. Purpose of Prose

A prose/content scope is useful for:

- CMS HTML
- descriptions
- About content
- articles
- rich service descriptions
- rich product descriptions
- property descriptions
- restaurant content
- vCard biography
- documentation-like content

It should style semantic descendants coherently.

---

# 27. Prose Is Not a Blog Theme

Do not turn `.orp-prose` into a highly opinionated editorial theme.

It should provide:

- typography rhythm
- lists
- links
- blockquotes
- code
- tables where appropriate
- media spacing if justified

while inheriting ORP tokens.

---

# 28. Prose Width

Do not automatically impose a narrow max-width on every prose container.

Long-form editorial content may benefit from readable measure.

Product descriptions and embedded CMS content may need to fill their parent.

If measure control is needed, separate it from content styling.

---

# 29. Prose Heading Rhythm

Within rich content:

- headings need clear hierarchy
- headings should visually belong to following content
- avoid excessive margins
- nested content must remain readable

Use ORP spacing tokens.

---

# 30. Prose Paragraph Rhythm

Paragraphs should have predictable vertical rhythm.

Avoid:

```css
p { margin-bottom: random-value; }
```

scattered across components.

---

# 31. Blockquote

Support semantic:

```html
<blockquote>
  <p>...</p>
  <cite>...</cite>
</blockquote>
```

or equivalent valid markup.

Target visual direction:

- restrained
- readable
- clearly differentiated
- not decorative

---

# 32. Blockquote Styling

Avoid defaulting to:

- giant quote icons
- gradients
- heavy shadows
- huge colored panels

Possible tools:

- spacing
- typography
- subtle rule
- quiet surface

Choose based on ORP Visual Direction.

---

# 33. Blockquote Citation

If `<cite>` is present:

ensure clear relationship to the quote.

Do not force a specific author data structure.

---

# 34. Inline Code

Audit/support:

```html
<code>npm run build</code>
```

Requirements:

- visually distinguishable
- readable
- token-driven
- not excessively boxed
- works inside paragraphs

---

# 35. Code Blocks

Audit/support:

```html
<pre><code>...</code></pre>
```

Requirements:

- overflow handling
- mobile horizontal scrolling where necessary
- readable typography
- sufficient contrast
- restrained surface
- no syntax-highlighting dependency required

---

# 36. No Syntax Highlighter Dependency

Do not add:

- Prism
- Highlight.js
- Shiki

just for this phase.

Code block foundation must work without them.

Consumers may integrate highlighting separately.

---

# 37. Keyboard Input

Evaluate semantic:

```html
<kbd>Ctrl</kbd> + <kbd>K</kbd>
```

This is useful in documentation/product UI.

Implement only if it fits ORP content foundation cleanly.

---

# 38. Highlighted Text

Evaluate semantic:

```html
<mark>highlighted text</mark>
```

Use a restrained accessible treatment.

Do not confuse `<mark>` with selected state or Badge.

---

# 39. Strong and Emphasis

Ensure:

```html
<strong>
<em>
```

work naturally with the new typography.

Do not over-style them.

---

# 40. Horizontal Rule

Audit:

```html
<hr>
```

and existing ORP Divider.

Determine whether:

- `<hr>` gets semantic content styling
- `Divider` remains a layout/UI primitive
- both can coexist

Do not duplicate responsibilities.

---

# 41. Divider vs HR

Conceptually:

`<hr>`
→ thematic break in content

Divider primitive
→ visual separation in UI composition

Preserve semantic distinction where useful.

---

# 42. Tables

Audit whether ORP currently has table styling or a Table component.

Do not assume a Vue DataTable is needed.

Start by evaluating semantic content tables:

```html
<table>
  <thead>...</thead>
  <tbody>...</tbody>
</table>
```

---

# 43. Basic Table Requirements

If generic table styling is justified:

support:

- header hierarchy
- row readability
- cell spacing
- borders only where useful
- long content
- numeric content
- mobile overflow strategy

---

# 44. Responsive Tables

Do not destroy table semantics by automatically converting rows into Cards.

For wide tables, horizontal scrolling may be the correct generic behavior.

If a wrapper is needed, determine whether it belongs to:

- CSS primitive
- prose
- component

based on evidence.

---

# 45. Striped Tables

Do NOT add striped rows automatically.

Only add a variant if:

- dense data benefits
- actual consumers need it

Quiet alternating fills may be useful for long lookup tables.

---

# 46. Dense Tables

Do not add `dense` unless ORP has a real operational use case.

Avoid speculative APIs.

---

# 47. Truncation

Audit whether ORP already has single-line truncation.

If missing and repeated across the framework, a small helper may be justified.

Conceptually:

```css
.orp-truncate
```

Expected behavior:

- single line
- overflow hidden
- ellipsis
- nowrap

Final naming must follow ORP conventions.

---

# 48. Line Clamp

Audit repeated multiline truncation.

If justified, consider a SMALL set such as:

```text
2 lines
3 lines
```

Do not create:

```text
line-clamp-1 through line-clamp-12
```

without evidence.

---

# 49. Truncation Accessibility

Never use truncation as a substitute for providing access to important content.

Ensure consumers can still expose full content where required.

---

# 50. Text Alignment Helpers

Audit actual need for:

```text
left
center
right
justify
```

Do NOT automatically copy Vuestic/Bootstrap helpers.

ORP Visual Direction already prefers left alignment by default.

Create alignment helpers only if cross-framework evidence shows they provide real value.

---

# 51. Justified Text

Do not encourage `text-align: justify` as a general design-system default.

It can harm readability and spacing.

Only support if a real use case exists.

---

# 52. Screen Reader Text

Audit whether ORP already has an accessible visually-hidden helper.

If missing, this is a strong candidate for a generic helper.

Conceptually:

```css
.orp-sr-only
```

or naming consistent with ORP.

It must use a proven accessible visually-hidden pattern.

---

# 53. Accessibility Helper Priority

A visually hidden helper is more valuable than cosmetic helpers such as uppercase or center-text.

Prioritize functional helpers.

---

# 54. Content Images

Evaluate images inside prose.

Do not globally impose decorative radius on all content images.

Respect:

- media role
- captions
- width
- aspect ratio
- existing ORP Media primitive

---

# 55. Figure and Figcaption

Audit/support if appropriate:

```html
<figure>
  <img ...>
  <figcaption>...</figcaption>
</figure>
```

Ensure caption remains visually connected to media.

Do not put a divider between figure and caption.

---

# 56. Content Spacing

All generic content spacing must use ORP spacing tokens.

No random hardcoded margins.

---

# 57. Typography Tokens

Audit whether ORP has tokens for:

- font family
- size
- weight
- line height
- letter spacing

Only add missing tokens with actual reusable value.

Do not create a huge design-token taxonomy for theoretical completeness.

---

# 58. New Default Theme Integration

This phase runs after ORP Default Theme 2026.

Typography/content primitives must consume the final approved:

- font family
- text colors
- neutral surfaces
- borders
- radius
- spacing
- focus
- primary color

Do not create a parallel typography palette.

---

# 59. Manrope

If the Default Theme phase selected Manrope:

use it through the existing ORP font token.

Do not hardcode:

```css
font-family: "Manrope";
```

inside each content style.

---

# 60. Link Color

Links should consume semantic ORP tokens.

Do not hardcode Electric Indigo directly into link CSS.

---

# 61. Blockquote Color

Do not hardcode brand colors into Blockquote.

Use shared tokens.

Blockquote should remain compatible with theme overrides.

---

# 62. Code Surfaces

Code backgrounds/borders should use neutral/surface tokens.

No arbitrary gray hex values.

---

# 63. Helpers Philosophy

ORP may have a small helper layer.

But:

ORP IS NOT BOOTSTRAP UTILITIES.

A helper is justified when it solves a tiny, repeated, generic behavior better than a component.

Good candidates may include:

- truncate
- line clamp
- visually hidden

Questionable candidates:

- uppercase
- lowercase
- capitalize
- margin utilities
- padding utilities
- arbitrary text colors
- dozens of alignment classes

---

# 64. Helper Acceptance Test

Before creating a helper ask:

1. Is it generic?
2. Is it repeated?
3. Is its behavior stable?
4. Is a component unnecessary?
5. Does it avoid domain meaning?
6. Does it reduce local CSS?
7. Does it avoid utility-framework creep?

If not:

DO NOT BUILD.

---

# 65. Content Primitive Acceptance Test

Before creating a primitive/style abstraction ask:

1. Does semantic HTML already solve most of it?
2. Does ORP only need styling?
3. Is there an existing ORP primitive?
4. Is this needed in at least two contexts?
5. Is the responsibility stable?
6. Can it be token-driven?

---

# 66. Domain Leak Guard

Do not introduce content primitives named around:

- Product
- Service
- Property
- Restaurant
- vCard
- Listing
- Course
- Appointment
- Business
- Office

Typography/content foundation must remain generic.

---

# 67. Acerca Evidence

You MAY inspect Acerca read-only to find repeated content needs.

Examples:

- About
- Services descriptions
- Product descriptions
- Properties
- Restaurant menu descriptions
- vCard biography
- FAQ answers

Do NOT modify Acerca.

---

# 68. Rich HTML Safety Boundary

ORP styling does not sanitize HTML.

If `.orp-prose` or equivalent is used with CMS HTML:

sanitization remains the application's responsibility.

Document this.

Do not add sanitizer dependencies in this phase.

---

# 69. Playground

Create or expand a dedicated Playground section:

TYPOGRAPHY & CONTENT

Use realistic examples.

---

# 70. Playground — Typography

Demonstrate:

- display if supported
- headings
- body
- supporting text
- labels
- metadata

Show hierarchy together, not only isolated snippets.

---

# 71. Playground — Links

Demonstrate:

- normal link
- long link
- link inside paragraph
- secondary link if implemented
- keyboard focus

---

# 72. Playground — Lists

Demonstrate:

- unordered
- ordered
- nested unordered
- nested ordered
- long wrapping items
- lists inside prose

---

# 73. Playground — Blockquote

Demonstrate:

- short quote
- long quote
- citation
- mobile wrapping

---

# 74. Playground — Code

Demonstrate:

- inline code
- code block
- long line overflow
- `<kbd>` if implemented
- `<mark>` if implemented

---

# 75. Playground — Rich Content

Create one realistic rich-content example combining:

```text
Heading
Paragraph
Link
Subheading
Unordered list
Ordered list
Blockquote
Code
Figure/caption if supported
Table if supported
```

This is critical.

It proves the system works as a composition.

---

# 76. Playground — Table

If table styling is implemented, demonstrate:

- basic table
- long text
- numeric values
- mobile overflow

Do not create a fake DataTable API.

---

# 77. Playground — Helpers

Only demonstrate helpers that were actually justified.

Do not create helpers merely to make this Playground section larger.

---

# 78. Visual Direction

Typography/content primitives must follow ORP Visual Direction:

- calm
- restrained
- left-aligned by default
- spacing-driven hierarchy
- minimal decoration
- no Bootstrap visual DNA
- accessible contrast
- consistent tokens

---

# 79. Avoid Bootstrap Typography Clone

Do NOT recreate:

```text
.display-1 through display-6
.lead
.text-muted
.text-primary
.text-secondary
.text-center
.text-end
.text-uppercase
.fw-bold
.small
```

as a one-to-one ORP equivalent.

Only build what ORP genuinely needs.

---

# 80. Avoid Vuestic Clone

The Vuestic typography examples are inspiration for coverage, not API design.

Do not copy:

- naming
- helper matrix
- class structure
- exact spacing
- exact typography scale

ORP must follow its own architecture.

---

# 81. CSS Scope

Be careful with global element selectors.

Do not accidentally restyle every:

```html
ul
ol
blockquote
table
```

inside third-party components.

Prefer intentional ORP scope where appropriate.

---

# 82. Third-Party Safety

Do not let generic content styles leak into:

- Leaflet controls
- GLightbox
- external widgets
- embedded content

Scope styles carefully.

---

# 83. Reset Interaction

Audit existing CSS reset/base rules.

Avoid fighting browser/reset styles with duplicated declarations.

---

# 84. BEM / Naming

Follow actual ORP naming conventions.

Do not introduce a second naming philosophy.

If prose uses descendants, keep selectors understandable and bounded.

---

# 85. Specificity

Keep specificity low.

Avoid:

```css
.orp-prose .some-wrapper ul li a span {}
```

Prefer simple semantic descendant rules.

---

# 86. No `!important`

Do not use `!important` to force the typography system unless the repository already has a documented exceptional pattern.

If specificity conflicts occur:

fix architecture/scope.

---

# 87. Tests

Add/update tests where behavior/API exists.

Pure CSS visual rules may not need meaningless unit tests.

Test what is testable:

- component exports if any
- class behavior if existing test infrastructure supports it
- no regression of existing List/Divider components

---

# 88. Browser Verification

Visual browser verification is REQUIRED if tooling exists.

Inspect actual rendered Playground.

Do not claim visual verification from LESS inspection.

---

# 89. Responsive QA

Test:

320
375
390
430
768
1200
1440

Pay special attention to:

- nested list indentation
- long links
- blockquotes
- code overflow
- tables
- prose spacing
- headings
- long Spanish text

---

# 90. Accessibility QA

Verify:

- link recognition
- link focus
- heading hierarchy in demo markup
- readable text contrast
- blockquote semantics
- table semantics
- `<kbd>` readability
- `<mark>` contrast
- screen-reader helper if implemented

---

# 91. Build

Run:

```bash
npm run build
```

Must pass.

---

# 92. Console

Playground must have:

- no Vue warnings
- no CSS loading errors
- no missing font assets
- no horizontal PAGE overflow

Code/table containers may scroll internally where appropriate.

---

# 93. Hardcode Audit

After implementation search new typography/content files for:

- raw colors
- arbitrary font sizes
- arbitrary spacing
- arbitrary radii
- arbitrary shadows
- hardcoded font families

Classify every remaining literal value.

Use tokens whenever shared system values exist.

---

# 94. Required Discovery Matrix

Before implementation produce an internal inventory like:

| Concept | Existing solution | Files | Repeated contexts | Layer | Decision | Reason |
|---|---|---|---:|---|---|---|
| Links | ? | ? | ? | Foundation | REUSE/CREATE | ... |
| Lists | `.orp-list`? | ? | ? | ? | ... | ... |
| Blockquote | ? | ? | ? | Foundation | ... | ... |
| Prose | ? | ? | ? | Foundation | ... | ... |
| Inline code | ? | ? | ? | Foundation | ... | ... |
| Code block | ? | ? | ? | Foundation | ... | ... |
| Table | ? | ? | ? | Foundation/Component | ... | ... |
| Truncate | ? | ? | ? | Helper | ... | ... |
| Line clamp | ? | ? | ? | Helper | ... | ... |
| SR only | ? | ? | ? | Helper | ... | ... |

Do not implement before this inventory exists.

---

# 95. Decision Values

Use:

REUSE
EXTEND
CREATE
KEEP LOCAL
REJECT
DEFER

---

# 96. Success Can Mean "Do Not Create"

If an item is already solved adequately:

REUSE.

If semantic browser behavior + existing tokens are sufficient:

do not create an abstraction.

Completeness does not mean maximum number of classes.

---

# 97. Documentation

Document the final supported typography/content API.

Include:

- when to use semantic HTML
- when to use prose scope
- list guidance
- link guidance
- blockquote
- code
- table if supported
- helpers
- accessibility notes
- theming behavior

---

# 98. Required Report

Generate:

```text
ORP-TYPOGRAPHY-CONTENT-PRIMITIVES-REPORT.md
```

following the project's actual docs/plans convention.

---

# 99. Report Structure

```text
# ORP Typography & Content Primitives Report

## Executive Summary

## Existing Typography Inventory

## Existing Content Primitive Inventory

## Discovery Matrix

## Existing `.orp-list` Analysis

## Typography Roles

## Links

## Lists

## Rich Content / Prose

## Blockquote

## Inline Code / Code Blocks

## Kbd / Mark / Strong / Emphasis

## HR vs Divider

## Tables

## Helpers

## Accessibility

## Token Usage

## Hardcoded Values

## Playground Coverage

## Responsive QA

## Tests

## Build

## Rejected Abstractions

## Deferred Candidates

## Public API Added

## Files Created

## Files Modified

## Final Architecture

## Readiness for Visual Direction Audit
```

---

# 100. Final Architecture Report

Show where every new abstraction lives.

Example only:

```text
ORP UI
├── Foundation
│   ├── Typography
│   └── Prose
├── Primitives
│   └── Divider
└── Helpers
    ├── Truncate
    └── Visually Hidden
```

Do not force this exact result.

Report the architecture actually justified by the audit.

---

# 101. Rejected Abstractions

Explicitly list things deliberately NOT created.

Examples might include:

```text
OrpHeading
OrpParagraph
OrpLink
text-uppercase
text-lowercase
text-capitalize
20 line-clamp utilities
12-column text alignment utilities
```

Explain why.

This prevents future agents from recreating rejected ideas without evidence.

---

# 102. Readiness Status

End with one:

```text
READY FOR VISUAL DIRECTION AUDIT
```

or:

```text
TYPOGRAPHY FOUNDATION NEEDS FOLLOW-UP
```

If follow-up is required, recommend ONE next action.

---

# 103. Scope Restrictions

DO NOT:

- redesign Acerca
- migrate Minisite sections
- create new Card Patterns
- resurrect ActionCard
- expand Map Phase 2
- create a DataTable framework
- add syntax-highlighting dependencies
- build Bootstrap-style utility classes
- copy Vuestic's API
- start the Visual Direction Audit automatically
- start the Global Architecture Audit automatically

---

# 104. STOP CONDITION

STOP after:

1. repository audit
2. discovery matrix
3. justified typography/content implementation
4. Playground coverage
5. tests
6. responsive/accessibility QA
7. build
8. report
9. readiness verdict

Do not continue into the next phase.

---

# FINAL INSTRUCTION

Strengthen ORP's typography and content foundation.

1. Audit the real repository first.
2. Verify the existing `.orp-list` responsibility before touching list styles.
3. Do not duplicate existing ORP abstractions.
4. Prefer semantic HTML.
5. Prefer CSS/tokens over Vue components for typography.
6. Evaluate a scoped rich-content/prose solution.
7. Support ordered, unordered and nested lists where justified.
8. Provide coherent link behavior.
9. Provide restrained Blockquote styling.
10. Support inline code and code blocks where justified.
11. Evaluate `<kbd>`, `<mark>`, `<figure>` and `<figcaption>`.
12. Audit semantic tables before considering any Table component.
13. Evaluate truncate, line clamp and visually-hidden helpers based on evidence.
14. Do not recreate Bootstrap Utilities.
15. Do not copy Vuestic's API.
16. Use ORP tokens.
17. Respect the approved Default Theme 2026 typography and palette.
18. Keep styles scoped away from Leaflet, GLightbox and third-party UI.
19. Add realistic Playground examples.
20. Test nested content and long Spanish text on mobile.
21. Verify accessibility.
22. Run existing tests.
23. Run `npm run build`.
24. Generate `ORP-TYPOGRAPHY-CONTENT-PRIMITIVES-REPORT.md`.
25. End with a readiness verdict.
26. STOP.
