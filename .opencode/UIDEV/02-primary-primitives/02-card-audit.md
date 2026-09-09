# ORP UI — CARD PRIMITIVE AUDIT

## Context

ORP UI already has a stable Card primitive and several higher-level Patterns that depend on it:

```text
CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard
```

Before continuing the CatalogCard visual pilot, audit Card itself as a foundational visual primitive.

This is NOT a request to redesign all Patterns.

The purpose is to verify that Card's API, variants and visual behavior support Default Theme 2026 without carrying Bootstrap-like assumptions.

---

# Objective

Audit:

```text
Card
├── Default
├── Interactive
├── Outlined
├── Raised
├── Header
├── Body
├── Footer
└── Media relationship
```

Determine:

- which variants are justified
- which variants overlap
- which variants create Bootstrap resemblance
- whether Card is too visually heavy by default
- whether Patterns are forced to undo Card styling
- whether interactive behavior is coherent
- whether Card anatomy is still useful
- whether Card and Surface are sufficiently distinct

---

# Critical Rule

Do NOT create new Card variants unless evidence requires them.

Do NOT create:

```text
CardSoft
CardFlat
CardGlass
CardModern
CardFeature
CardProduct
CardService
```

Avoid variant multiplication.

Valid conclusions include:

```text
CARD ALREADY ADEQUATE
CARD NEEDS VISUAL REFINEMENT
CARD VARIANT CONSOLIDATION REQUIRED
```

---

# Mandatory Audit

Inspect actual implementation and consumers:

```text
.orp-card
.orp-card--interactive
.orp-card--outlined
.orp-card--raised

.orp-card__header
.orp-card__body
.orp-card__footer
.orp-card__media
```

Also inspect:

```text
Surface
Media
Divider
Stack
Grid
CatalogCard
PricingCard
ProfileCard
ContentCard
StatCard
ContactCard
Playground
```

---

# Required Matrix

| Capability | Exists | Used by | Visual purpose | Overlap | Decision |
|---|---|---|---|---|---|
| Default Card | ? | ? | ? | ? | ? |
| Interactive | ? | ? | ? | ? | ? |
| Outlined | ? | ? | ? | ? | ? |
| Raised | ? | ? | ? | ? | ? |
| Header | ? | ? | ? | ? | ? |
| Body | ? | ? | ? | ? | ? |
| Footer | ? | ? | ? | ? | ? |
| Media | ? | ? | ? | ? | ? |

Use:

```text
KEEP
REFINE
MERGE
DEPRECATE
REJECT
```

---

# Default Card

Audit whether default Card should visually be:

```text
flat
quietly bordered
subtle surface
```

rather than automatically elevated.

Use ORP visual direction:

```text
Flat
→ Border
→ Surface contrast
→ Shadow
```

---

# Interactive Card

Audit:

- hover
- focus
- cursor
- pressed feedback
- keyboard semantics
- nested interactive controls
- elevation changes
- border/surface changes

Interactive Card should not mean:

```text
shadow + translate + scale
```

by default.

---

# Outlined

Ask:

> Does Outlined express a stable visual hierarchy distinct from Default?

If Default already uses a quiet border, Outlined may be redundant.

Do not keep variants only because Bootstrap-style systems often have them.

---

# Raised

Raised must communicate real elevation.

Audit use cases such as:

- floating layer
- selected/prominent object
- draggable/floating behavior

If it is used merely as "prettier Card", flag it.

---

# Header / Body / Footer

Audit whether these remain useful structural regions.

Check:

- padding ownership
- divider assumptions
- empty region behavior
- nested Stack usage
- responsive behavior

Do not force all Cards to use all regions.

---

# Card vs Surface

Required comparison:

```text
Plain region
Surface
Card
```

Definitions:

```text
Surface
→ a visual plane/grouping region

Card
→ a discrete content/entity container
```

If they are visually indistinguishable, document the problem.

---

# Card vs Section

Card must not own page rhythm or chapter spacing.

Section owns page structure.

---

# Card vs Pattern

Patterns should compose Card rather than duplicate Card chrome.

Audit whether higher-level Patterns currently override:

- border
- radius
- shadow
- background
- padding

If every Pattern has to undo the same Card defaults, Card is wrong.

---

# Radius

Audit Card radius against Default Theme 2026.

Avoid giant generic SaaS-card radius.

Use approved tokens.

---

# Border

Audit:

- visibility
- color
- contrast
- interaction changes

Borders should remain quiet.

---

# Shadow

Inventory every Card shadow.

For each ask:

> What elevation does this communicate?

If there is no answer, remove/recommend removal.

---

# Media Relationship

Check:

```text
Card
└── Media
```

Card owns composition.

Media owns ratio/object behavior.

Avoid duplicate radius and overflow systems.

---

# Padding

Audit whether Card padding is:

- token-driven
- consistent
- too generous on mobile
- duplicated by children

One axis, one owner.

---

# Mobile QA

Test:

```text
320
375
390
430
```

Check:

- nested padding
- radius
- media
- actions
- long content
- interactive target behavior

---

# Desktop QA

Test:

```text
768
1200
1440
```

Check:

- giant Cards
- too much empty space
- repetitive grids
- weak hierarchy

---

# Bootstrap Resemblance

Score before/after:

```text
0 = none
1 = minor
2 = noticeable
3 = strong
```

Evaluate:

```text
Default
Interactive
Outlined
Raised
Overall Card
```

Explain each score.

---

# Playground

Create/update a Card audit section showing:

```text
Plain content
Default Card
Interactive Card
Outlined Card if justified
Raised Card if justified
Card with Media
Card with Header/Body/Footer
Card with long Spanish content
Surface vs Card comparison
```

Do not create fake variants only for demo.

---

# Scope Restrictions

Do NOT:

- redesign Patterns
- modify Acerca
- add domain variants
- create new components
- add utility systems
- change backend/business logic

---

# Tests

Run relevant Card tests.

Run:

```bash
npm run build
```

Check browser console.

---

# Required Report

Generate:

```text
.opencode/ORPUI/ORP-CARD-PRIMITIVE-AUDIT.md
```

Include:

```text
Executive Summary
Existing API
Consumer Inventory
Variant Matrix
Default
Interactive
Outlined
Raised
Header/Body/Footer
Card vs Surface
Card vs Pattern
Media Relationship
Radius
Border
Elevation
Padding
Mobile
Desktop
Bootstrap Resemblance
Playground
Files Modified
Tests
Build
Console
Final Verdict
Next Phase
```

---

# Final Verdict

Use exactly one:

```text
CARD ALREADY ADEQUATE
CARD VISUAL REFINEMENT COMPLETE
CARD NEEDS FOCUSED FOLLOW-UP
```

STOP after report.
