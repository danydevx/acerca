# ORP UI — PLAYGROUND DOCUMENTATION SHELL REDESIGN

## Objective

Redesign the ORP Playground so it behaves and feels like the documentation site of a real modern Vue/React UI framework.

The current Playground has grown organically and presents too much content in one long column. This makes navigation difficult, comparisons harder, and the framework feel like a demo page instead of a coherent UI library.

The new Playground must use a documentation-shell architecture inspired by mature UI frameworks such as Vuestic, Vuetify, Quasar, PrimeVue, Chakra, Mantine, etc., WITHOUT copying their visual design or architecture literally.

The reference idea is:

```text
┌─────────────────────────────────────────────────────────────────────┐
│ Topbar: Brand / Search / utility links / version                   │
├───────────────────┬─────────────────────────────────────────────────┤
│                   │                                                 │
│ Sidebar           │ Documentation Content                           │
│                   │                                                 │
│ Foundation        │ Page title                                      │
│ Primitives        │ Description                                     │
│ Components        │ Examples                                        │
│ Patterns          │ API / usage                                     │
│ Content           │                                                 │
│                   │                                                 │
└───────────────────┴─────────────────────────────────────────────────┘
```

This phase is about DOCUMENTATION INFORMATION ARCHITECTURE and SHELL LAYOUT.

It is NOT a redesign of every ORP component.

---

# 1. Critical Scope Rule

Do NOT use this task to redesign:

- Card
- Button
- Badge
- Avatar
- Media
- CatalogCard
- PricingCard
- ProfileCard
- ContentCard
- StatCard
- ContactCard
- Modal
- Drawer
- Accordion
- Progress
- Meter
- Skeleton
- Map

Their current demos may be moved/reorganized, but their component implementation should remain unchanged.

The goal is:

```text
REORGANIZE
→ NAVIGATE
→ DOCUMENT
→ PRESENT
```

not:

```text
RESTYLE EVERY COMPONENT
```

---

# 2. Repository Audit First

Before editing, inspect the actual Playground implementation.

Identify:

- route/controller/view used by `/orp-playground`
- Vue entry
- Playground page/component structure
- current sections
- current navigation
- current CSS/LESS
- current ORP imports
- how demos are organized
- whether Vue Router is available/used
- whether Inertia is involved
- whether Playground currently has anchors or local state
- existing search if any
- existing Drawer
- existing Container
- existing Stack
- existing Grid
- existing Button/IconButton
- existing typography/content primitives

Do NOT assume routing architecture.

Use the simplest architecture compatible with the existing application.

---

# 3. Desired Information Architecture

Organize ORP documentation into clear top-level categories.

Recommended initial taxonomy:

```text
Getting Started

Foundation
├── Colors
├── Typography
├── Spacing
├── Radius
├── Elevation / Shadows
├── Motion
└── Visual Helpers

Primitives
├── Container
├── Section
├── Stack
├── Cluster
├── Grid
├── Surface
├── Divider
├── Card
├── Media
├── Avatar
├── Badge
├── Price
├── List
├── Button
└── IconButton

Components
├── Modal
├── Drawer
├── Accordion
├── Skeleton
├── Progress
├── Meter
└── Map

Patterns
├── CatalogCard
├── PricingCard
├── ProfileCard
├── ContentCard
├── StatCard
└── ContactCard

Content
├── Links
├── Lists
├── Blockquote
├── Code
├── Tables
├── Figure
└── Prose
```

IMPORTANT:

Use the REAL repository inventory.

If an item does not exist, do not invent its documentation page merely because it appears above.

If existing ORP elements are missing from this proposed taxonomy, include them in the correct category.

---

# 4. Navigation Architecture

The documentation shell should have three potential navigation levels:

```text
Topbar
Sidebar
Page-local navigation
```

But do not overbuild.

Required:

```text
Topbar
Sidebar
Main content
```

Optional if justified:

```text
"On this page" navigation
```

---

# 5. Desktop Layout

Target architecture:

```text
┌────────────────────────────────────────────────────────────────────────┐
│ ORP UI       Search...                         GitHub?       Version?  │
├────────────────────┬───────────────────────────────────────────────────┤
│                    │                                                   │
│ Sidebar            │ Main documentation content                        │
│                    │                                                   │
│ Getting Started    │                                                   │
│                    │                                                   │
│ Foundation         │                                                   │
│   Colors           │                                                   │
│   Typography       │                                                   │
│                    │                                                   │
│ Primitives         │                                                   │
│   Card             │                                                   │
│   Button           │                                                   │
│   Badge            │                                                   │
│                    │                                                   │
│ Components         │                                                   │
│                    │                                                   │
│ Patterns           │                                                   │
│                    │                                                   │
└────────────────────┴───────────────────────────────────────────────────┘
```

The sidebar should remain available while reading long documentation.

Use sticky/fixed behavior carefully.

Avoid nested page scrolling unless necessary.

---

# 6. Topbar

Create a clean ORP documentation topbar.

Potential content:

```text
ORP UI brand/name
Search trigger/input
Playground/Home
GitHub if a real repository link already exists/configured
Version if available from a reliable existing source
Theme control only if ORP already supports it
```

Do NOT invent:

- fake version numbers
- fake GitHub URLs
- fake documentation links

If data is unavailable, omit it.

---

# 7. Topbar Visual Direction

Follow Default Theme 2026.

Target:

- white/neutral surface
- quiet bottom boundary if needed
- Electric Indigo used sparingly
- Manrope/approved typography
- restrained height
- no heavy shadow
- no Bootstrap navbar appearance
- no giant rounded search field unless justified

---

# 8. Sidebar

The Sidebar is the primary framework navigation.

It must support grouped navigation.

Example:

```text
FOUNDATION
  Colors
  Typography
  Spacing

PRIMITIVES
  Container
  Grid
  Card
  Button
  Badge

COMPONENTS
  Modal
  Drawer
  Accordion

PATTERNS
  CatalogCard
  PricingCard
```

---

# 9. Sidebar Group Behavior

Evaluate whether groups should:

```text
always remain expanded
```

or:

```text
collapse/expand
```

Do not add accordion behavior just because Vuestic uses it.

For the current size of ORP, always-expanded groups may be simpler and easier to scan.

If collapsible groups are implemented, use existing ORP Accordion or accessible native behavior where appropriate.

---

# 10. Active Navigation

The current documentation page/item must be obvious.

Prefer restrained indicators such as:

- primary text
- subtle primary-soft background
- slim indicator
- stronger font weight

Avoid:

```text
large filled blue pill
```

for every active item.

---

# 11. Sidebar Visual Hierarchy

Category labels and items must have distinct hierarchy.

Example:

```text
PRIMITIVES      ← quiet category label

Card
Media
Avatar
Button
```

Do not make category labels louder than page links.

---

# 12. Sidebar Width

Choose a comfortable documentation-navigation width.

Do not copy Vuestic's exact width.

It must:

- fit common ORP component names
- preserve main-content width
- work at laptop sizes
- avoid excessive empty sidebar space

Use ORP tokens/custom properties where appropriate.

---

# 13. Main Content

Each selected documentation item should display as a focused documentation page.

Example:

```text
Buttons

Short description.

Variants
[examples]

Sizes
[examples]

Block
[example]

States
[examples]

Usage
[text]

API / CSS
[reference]
```

Do not display every ORP component one after another in the same giant document.

---

# 14. One Concept Per Documentation View

The user should be able to select:

```text
Card
```

and primarily see Card documentation.

Then select:

```text
Button
```

and see Button documentation.

This is the key architectural change.

---

# 15. Routing / Navigation Strategy

Audit the current stack and choose the simplest robust solution.

Possible strategies:

```text
real routes
query parameter
hash route
local documentation registry + selected state
```

Do NOT introduce Vue Router merely because documentation sites commonly use it if the project does not already need/use it.

Prefer existing Laravel/Inertia/Vue conventions.

---

# 16. Deep Linking

Strongly prefer documentation items to be directly linkable.

Examples conceptually:

```text
/orp-playground/button
/orp-playground/primitives/button
/orp-playground#button
```

Exact strategy depends on current architecture.

The browser back/forward behavior should remain reasonable.

---

# 17. Documentation Registry

Evaluate creating a central navigation/document registry rather than hardcoding sidebar links in multiple places.

Conceptually:

```js
[
  {
    group: 'Primitives',
    items: [
      { id: 'card', label: 'Card', ... },
      { id: 'button', label: 'Button', ... }
    ]
  }
]
```

Only implement if it simplifies the existing architecture.

Do not overengineer a documentation CMS.

---

# 18. Existing Demo Preservation

Preserve all useful existing Playground examples.

Move them into their corresponding documentation pages.

Do not delete examples simply because the page architecture changes.

Audit duplicates and obsolete demos before removing anything.

---

# 19. Documentation Page Anatomy

Establish a consistent page structure.

Recommended:

```text
Page title

Short description

Primary demo / overview

Capabilities / variants

Usage examples

States / edge cases

Guidance

API / class reference if useful
```

Not every page needs every section.

---

# 20. Documentation Section Component

Evaluate whether a tiny internal Playground-only documentation component is useful for repeated structure, for example:

```text
PlaygroundSection
DemoBlock
CodeExample
```

IMPORTANT:

These are DOCUMENTATION INTERNALS.

They are NOT ORP public framework components.

Keep them outside the ORP public export/API.

---

# 21. Demo Block

A consistent demo block may contain:

```text
Title
Description
Preview
Optional code
```

Avoid surrounding every example with heavy Card chrome.

Remember:

```text
Spacing
→ Typography
→ Divider
→ Surface
→ Card
```

Use simple grouping first.

---

# 22. Code Examples

If existing Playground already shows code, preserve/improve it.

If it does not, do NOT build a syntax-highlighting system during this phase.

Simple semantic:

```html
<pre><code>
```

using ORP content styles is enough.

---

# 23. Search

The reference screenshot includes search.

Search is valuable, but it must remain proportional to this phase.

First audit whether Playground already has search.

If not, implement only a lightweight client-side documentation search IF it can be done cleanly without introducing a search library.

Potential search scope:

```text
component names
primitive names
pattern names
foundation topics
```

Do not implement full-text indexing.

---

# 24. Search Behavior

If implemented:

typing:

```text
but
```

could return:

```text
Button
IconButton
```

Selecting a result navigates to its documentation view.

Keyboard support is desirable.

---

# 25. Search Shortcut

Do NOT add keyboard shortcuts such as:

```text
Ctrl + K
Cmd + K
```

unless the implementation remains simple, accessible and justified.

It is optional, not required.

---

# 26. Mobile Architecture

At mobile widths, the permanent sidebar disappears.

Target:

```text
┌───────────────────────────────┐
│ ☰  ORP UI          Search    │
├───────────────────────────────┤
│                               │
│ Documentation content         │
│                               │
└───────────────────────────────┘
```

The navigation opens through an existing ORP Drawer if suitable.

This is an excellent dogfooding opportunity.

---

# 27. Dogfood ORP Drawer

If ORP Drawer is stable and appropriate:

use it for mobile documentation navigation.

Do not create a second custom mobile sidebar system.

---

# 28. Mobile Drawer Content

The Drawer should contain the same navigation taxonomy as desktop.

Do not maintain two separate hardcoded menus.

Reuse the documentation registry/navigation source.

---

# 29. Mobile Topbar

Keep it compact.

Potential structure:

```text
Menu
ORP UI
Search
```

Do not squeeze desktop utility links into mobile.

---

# 30. Responsive Breakpoint

Use existing ORP/project breakpoint conventions.

Do not invent a Bootstrap-compatible breakpoint table.

---

# 31. Main Content Width

Documentation should not span the entire 1440px viewport.

Use Container/readable measure appropriately.

However, component demos such as Grid or CatalogCard may need wider preview regions.

Allow documentation text and demo width to differ when necessary.

---

# 32. Reading Measure

Long explanatory text should have a comfortable readable width.

Do not globally constrain all demos to prose width.

---

# 33. Optional "On This Page"

After the main shell works, evaluate a third-column/local navigation for long documentation pages.

Example:

```text
On this page
  Variants
  Sizes
  Block
  States
  Accessibility
```

This is OPTIONAL.

Only implement if:

- pages are long enough
- desktop width supports it
- it does not complicate responsive behavior

---

# 34. If "On This Page" Exists

Architecture:

```text
Sidebar
Main Content
Local TOC
```

At narrower desktop/tablet sizes, hide the local TOC before hiding the main Sidebar.

Do not squeeze all three columns.

---

# 35. Scroll Behavior

When selecting a documentation page:

start at the page beginning.

When selecting an in-page section:

scroll predictably.

Respect:

```text
prefers-reduced-motion
```

if smooth scrolling is used.

---

# 36. Sticky Elements

Potential sticky elements:

```text
Topbar
Sidebar navigation
On-this-page TOC
```

Avoid stacking sticky offsets incorrectly.

Audit at multiple viewport heights.

---

# 37. Avoid Double Scrollbars

The documentation site should preferably use the browser/page scroll.

Do not create:

```text
body scroll
+ sidebar scroll
+ content scroll
```

unless necessary.

A long Sidebar may have its own overflow area, but implement carefully.

---

# 38. Visual Direction

The documentation shell itself should demonstrate ORP 2026.

Use:

- approved Default Theme 2026 tokens
- approved typography
- neutral surfaces
- restrained primary color
- subtle borders
- minimal elevation
- consistent spacing
- consistent radius

---

# 39. Do Not Copy Vuestic Visually

The provided Vuestic screenshot is a STRUCTURAL reference.

Do NOT copy:

- logo
- exact sidebar
- exact colors
- exact widths
- exact search
- exact typography
- exact spacing
- exact navigation behavior

ORP must have its own identity.

---

# 40. Anti-Bootstrap

The shell must not look like:

```text
Bootstrap admin dashboard
```

Avoid:

- `.navbar` visual language
- boxed sidebar cards
- gray admin background everywhere
- blue active pills
- generic form-control search
- excessive borders
- shadows around every panel

---

# 41. Surface Hierarchy

Prefer:

```text
Page canvas
Topbar boundary
Sidebar boundary
Main content
```

without wrapping each region in Card.

---

# 42. Topbar Elevation

Prefer flat + border/surface distinction.

Use shadow only if sticky overlap genuinely needs elevation.

---

# 43. Sidebar Elevation

Sidebar normally does not need shadow.

A quiet border or surface contrast is preferable.

---

# 44. Main Canvas

Main documentation area should feel spacious and focused.

Do not use a dark/gray admin canvas unless Default Theme 2026 explicitly calls for it.

---

# 45. Typography

Use approved typography hierarchy.

Documentation should clearly distinguish:

```text
Page title
Section heading
Subsection heading
Body
Supporting text
Code
Meta
Navigation labels
```

---

# 46. Navigation Typography

Sidebar links should remain highly readable.

Avoid tiny text simply to fit more navigation.

---

# 47. Icons

Use the existing approved icon family.

Bootstrap Icons are allowed in ORP.

Do not introduce another icon library.

Use icons sparingly in documentation navigation.

Text labels should do most of the work.

---

# 48. Category Icons

Do not put a colored icon beside every category unless it materially improves navigation.

Avoid SaaS-dashboard visual clichés.

---

# 49. Search Icon

If search exists, a simple search icon is appropriate.

Do not overdecorate.

---

# 50. Active Indicator

Prefer one strong active signal rather than:

```text
bold
+ colored background
+ border
+ icon
+ left bar
```

all simultaneously.

---

# 51. Spacing

Use existing ORP spacing tokens.

The shell should itself demonstrate:

```text
related
group
section
page
```

spacing hierarchy.

---

# 52. One Axis, One Owner

Avoid:

```text
layout padding
+ Container padding
+ page padding
```

stacking accidentally.

Audit horizontal gutter ownership.

---

# 53. Documentation Data

Do not mix documentation content deeply into shell layout code if avoidable.

Prefer clear separation:

```text
Shell
Navigation data
Documentation views
Demo components
```

without building an overengineered documentation engine.

---

# 54. Suggested Internal Structure

Adapt to the repository.

Conceptually something like:

```text
Playground/
├── PlaygroundShell.vue
├── PlaygroundTopbar.vue
├── PlaygroundSidebar.vue
├── PlaygroundNavigation.vue
├── PlaygroundSearch.vue        # only if implemented
├── PlaygroundPage.vue
├── PlaygroundSection.vue
├── DemoBlock.vue
├── navigation.js
└── pages/
    ├── foundation/
    ├── primitives/
    ├── components/
    ├── patterns/
    └── content/
```

DO NOT follow this structure blindly.

First inspect existing code.

Reuse existing components/files when practical.

---

# 55. Public ORP Boundary

Playground-specific components must NOT be exported from:

```text
orp-ui.js
```

unless they are already legitimate ORP public components.

The documentation shell is application tooling, not framework API.

---

# 56. Dogfooding

Use ORP primitives/components inside Playground where appropriate:

```text
Container
Stack
Cluster
Grid
Drawer
Button
IconButton
Divider
Surface
Typography
```

But do not force ORP components where semantic HTML/CSS is simpler.

---

# 57. Avoid Helper Soup

Do not build the shell from dozens of helper classes.

Use semantic Playground BEM/classes plus ORP layout primitives.

---

# 58. Playground BEM

Playground-specific layout styling may use clear BEM naming, for example:

```text
.orp-playground
.orp-playground__topbar
.orp-playground__sidebar
.orp-playground__main
.orp-playground__content
```

Follow existing project naming conventions.

---

# 59. Shell CSS Must Use Tokens

No arbitrary design-system hardcodes where tokens exist.

Use:

- colors
- spacing
- radius
- borders
- typography
- elevation
- motion

from ORP.

Structural widths may use dedicated local custom properties if justified.

---

# 60. Search Hardcodes

If Search is implemented, do not hardcode component names separately from navigation data.

Search should derive from the same registry.

---

# 61. Active State Source

Desktop Sidebar and mobile Drawer must derive active state from the same navigation state/routing source.

---

# 62. Accessibility — Shell

Audit:

- `<header>`
- `<nav>`
- `<main>`
- headings
- accessible menu button
- Drawer focus
- active navigation
- search label
- keyboard
- focus-visible
- skip link if useful

---

# 63. Skip Link

Strongly evaluate:

```text
Skip to content
```

for keyboard users.

If implemented, keep it visually hidden until focused.

Use existing visually-hidden helper if appropriate.

---

# 64. Navigation Landmark

Use semantic:

```html
<nav aria-label="ORP UI documentation">
```

or equivalent appropriate label.

---

# 65. Current Page

Use:

```text
aria-current="page"
```

where navigation semantics support it.

---

# 66. Mobile Menu Button

Must have:

- accessible label
- expanded state if appropriate
- focus
- proper Drawer behavior

Prefer existing IconButton.

---

# 67. Search Accessibility

If search exists:

- real label/accessibility name
- keyboard accessible results
- clear focus
- no placeholder-only semantics

---

# 68. Responsive QA

Required:

```text
320
375
390
430
768
1024
1200
1440
```

---

# 69. 320px

Check:

- topbar fit
- menu button
- brand
- search
- no horizontal overflow
- content gutter
- demos
- mobile Drawer

---

# 70. 390px

Primary mobile reference.

Capture screenshot if browser tooling exists.

---

# 71. 768px

Decide whether Sidebar is visible or Drawer-based based on actual available width.

Do not force desktop sidebar too early.

---

# 72. 1024px

Important documentation/laptop width.

Verify:

- Sidebar width
- content width
- optional local TOC
- demo widths

---

# 73. 1440px

Verify the page does not become excessively wide/empty.

---

# 74. Viewport Height

Also test shorter laptop heights where possible.

Sticky navigation and Sidebar scrolling often fail vertically even when width looks correct.

---

# 75. Browser Back/Forward

If documentation selection changes URL/history:

verify browser back and forward.

---

# 76. Refresh / Deep Link

If deep linking is implemented:

refreshing a documentation page should preserve the selected documentation item.

---

# 77. Search + Navigation Sync

If search selects Button:

Sidebar should also reflect Button as active.

---

# 78. No Fake Pages

Do not create empty documentation pages for planned components.

Only expose real ORP capabilities.

Future components can be added later.

---

# 79. Navigation Discovery Relationship

A separate ORP Navigation Discovery Audit exists/planned.

Do NOT confuse Playground navigation implementation with public ORP Navigation API.

The Playground may use semantic/custom application navigation while ORP's public Navigation architecture remains under audit.

This is important.

---

# 80. Do Not Create OrpNav Just for Playground

If ORP currently lacks a public Nav primitive:

do not create it merely because the Playground needs a Sidebar.

Build Playground navigation at the application/documentation layer.

The later Navigation Discovery Audit will determine what belongs in ORP core.

---

# 81. Existing Drawer Exception

Using existing public `OrpDrawer` for mobile navigation is encouraged because Drawer is already stable.

That is dogfooding, not architecture growth.

---

# 82. Documentation Home

Create or preserve a simple Playground landing view.

It may show:

```text
ORP UI
Short description
Framework categories
Quick links
```

Do not turn it into a marketing landing page.

---

# 83. Kitchen Sink

If a current all-components view is useful for visual regression:

do not delete it.

Move it to a dedicated internal page such as conceptually:

```text
Overview
Kitchen Sink
Visual Test
```

Use the actual naming convention.

This can remain useful for visual audits.

---

# 84. Pattern Comparison

Preserve any existing Pattern comparison board.

Give it a dedicated documentation/visual-test location instead of mixing it into unrelated pages.

---

# 85. Component Comparison

Same for component comparison boards.

These are valuable for visual QA.

---

# 86. Documentation vs Visual QA

Distinguish:

```text
Documentation pages
```

from:

```text
Visual regression / comparison pages
```

Do not force every test case into the public-looking docs flow.

---

# 87. Migration Strategy

Do not rewrite the entire Playground in one blind pass.

Recommended:

```text
1. Audit current sections
2. Create navigation taxonomy
3. Create shell
4. Move a small representative set
5. Validate navigation
6. Migrate remaining existing demos
7. Remove obsolete old one-column rendering
8. QA
```

---

# 88. Representative Migration

Use a few pages first, for example actual existing:

```text
Typography
Card
Button
Modal
CatalogCard
```

Then migrate remaining documentation after shell behavior is proven.

This is implementation sequencing inside the same task, not a request to stop halfway.

---

# 89. Preserve Git Diff Clarity

Avoid mixing unrelated component visual changes into this shell refactor.

The diff should clearly communicate:

```text
Playground documentation architecture
```

---

# 90. No Business Logic

Do not touch:

- Laravel domain modules
- minisites
- vCards
- appointments
- products
- services
- database
- API
- authentication

unless routing for the Playground itself genuinely requires a minimal route adjustment.

---

# 91. No Acerca Minisite Changes

Explicitly do not modify:

```text
resources/js/Pages/Minisite/
```

for this task.

---

# 92. Build

Run:

```bash
npm run build
```

Must pass.

---

# 93. Tests

Run relevant existing tests.

If shell/navigation logic is significant and test infrastructure supports it, add focused tests.

Do not create excessive snapshot tests.

---

# 94. Console

Check:

- Vue warnings
- runtime errors
- missing assets
- navigation errors
- Drawer errors
- search errors

---

# 95. Browser QA

Browser inspection is mandatory if tooling is available.

Inspect at least:

```text
390
768
1024
1440
```

---

# 96. Screenshots

If browser screenshot tooling exists, capture at least:

```text
390px — mobile docs
1440px — desktop docs
```

Prefer one documentation page such as Button for comparison.

---

# 97. Required Report

Generate:

```text
.opencode/ORPUI/ORP-PLAYGROUND-DOCUMENTATION-SHELL-REPORT.md
```

---

# 98. Report Structure

```text
# ORP Playground Documentation Shell Redesign

## Executive Summary

## Previous Architecture

## Problems Found

## Repository Audit

## Existing Playground Inventory

## Final Documentation Taxonomy

## Routing / Selection Strategy

## Deep Linking Strategy

## Shell Architecture

## Topbar

## Sidebar

## Main Content

## Mobile Navigation

## Drawer Dogfooding

## Search
Implemented / Deferred / Rejected

## On This Page Navigation
Implemented / Deferred / Rejected

## Documentation Registry

## Internal Playground Components

## Public ORP Boundary

## Existing Demos Migrated

## Existing Demos Preserved

## Removed / Consolidated Demos

## Kitchen Sink / Visual QA Strategy

## Accessibility

## Mobile QA

## Tablet QA

## Desktop QA

## Screenshots

## Files Created

## Files Modified

## Tests

## Build

## Console

## Known Limitations

## Final Verdict

## Recommended Next Phase
```

---

# 99. Final Verdict

End with one:

```text
PLAYGROUND DOCUMENTATION SHELL READY
```

or:

```text
PLAYGROUND DOCUMENTATION SHELL NEEDS FOLLOW-UP
```

---

# 100. Next Phase

If ready, recommend returning to the focused Primitive audits:

```text
NEXT PHASE:
ORP CARD PRIMITIVE AUDIT
```

because Card is the first planned focused audit.

Do NOT execute Card audit automatically.

---

# 101. STOP CONDITION

STOP after:

1. auditing current Playground
2. inventorying real ORP documentation items
3. defining taxonomy
4. implementing desktop shell
5. implementing Sidebar
6. implementing Topbar
7. implementing focused documentation views
8. implementing mobile navigation
9. dogfooding Drawer if appropriate
10. preserving/migrating existing demos
11. implementing lightweight search only if justified
12. implementing local TOC only if justified
13. responsive QA
14. accessibility QA
15. tests
16. build
17. console QA
18. screenshots if available
19. report
20. one next-phase recommendation

Do not redesign Card, Button or other ORP components.

---

# FINAL INSTRUCTION

Transform ORP Playground from:

```text
one long component demo page
```

into:

```text
a navigable UI framework documentation environment
```

Use the structural idea common to mature Vue/React UI frameworks:

```text
Topbar
+ Sidebar
+ Focused documentation content
+ Mobile Drawer navigation
```

but preserve ORP's own 2026 visual identity.

The provided Vuestic screenshot is a structural reference only.

Do not copy Vuestic visually.

Do not create public ORP navigation components just to build the docs shell.

Do not redesign existing ORP components during this phase.

Use the real repository inventory.

Preserve useful demos.

Use Default Theme 2026.

Dogfood existing ORP primitives/components where appropriate.

Make each ORP concept easy to find, open, inspect and compare.

Then generate the report and STOP.
