# ORP UI — NAVIGATION DISCOVERY AUDIT

## Context

ORP foundation, primitives, components and Patterns are mature, but navigation has not yet received a dedicated architectural review.

This is a DISCOVERY audit.

Do NOT automatically create Navigation components.

---

# Objective

Determine which navigation capabilities ORP genuinely lacks and where they belong.

Candidates are hypotheses:

```text
Nav
NavItem
Tabs
Breadcrumb
Pagination
AppBar / Navbar
Sidebar
Menu
Bottom Navigation
```

Do NOT assume they all belong in ORP.

---

# Core Classification

Possible layers:

```text
Primitive
Component
Pattern
Application / Domain
```

Navigation must be classified by responsibility.

---

# Initial Hypothesis

```text
Nav structure
→ may be Primitive or simple semantic CSS

Tabs
→ Component
   state + keyboard + ARIA

Breadcrumb
→ Component or semantic composition

Pagination
→ Component

Navbar / AppBar
→ Component or Pattern

Sidebar
→ Component / Pattern

Bottom Navigation
→ Component / Pattern
```

Validate against repository evidence.

---

# Mandatory Audit

Search ORP and Playground for:

```text
nav
navigation
menu
tabs
tablist
breadcrumb
pagination
sidebar
navbar
appbar
bottom-nav
aria-current
aria-selected
role=tab
role=navigation
```

Inspect Acerca READ-ONLY:

```text
NavigationMenu
minisite navigation
admin navigation if relevant
tabs
pagination
breadcrumbs
mobile nav
```

Do not migrate anything.

---

# Required Discovery Matrix

| Candidate | Existing solution | Generic contexts | Behavior/state | Likely layer | Decision | Reason |
|---|---|---:|---|---|---|---|
| Nav | ? | ? | ? | ? | ? | ? |
| NavItem | ? | ? | ? | ? | ? | ? |
| Tabs | ? | ? | ? | ? | ? | ? |
| Breadcrumb | ? | ? | ? | ? | ? | ? |
| Pagination | ? | ? | ? | ? | ? | ? |
| Navbar/AppBar | ? | ? | ? | ? | ? | ? |
| Sidebar | ? | ? | ? | ? | ? | ? |
| Bottom Navigation | ? | ? | ? | ? | ? | ? |

Use:

```text
REUSE
CREATE PRIMITIVE
CREATE COMPONENT
CREATE PATTERN
KEEP APPLICATION-LEVEL
DEFER
REJECT
```

---

# Nav Primitive

Audit whether simple semantic navigation can be solved with:

```html
<nav>
  <a>
  <a aria-current="page">
</nav>
```

plus a small `.orp-nav` primitive.

If yes, do not over-componentize.

---

# NavItem

Do NOT create `OrpNavItem` unless it adds real semantics/behavior beyond an anchor/button.

---

# Tabs

Tabs require strong accessibility behavior:

- active state
- tablist/tab semantics
- keyboard arrows
- Home/End if appropriate
- panel association
- focus management

If ORP needs Tabs, it belongs in Component layer.

Do not implement during discovery unless explicitly requested in a later phase.

---

# Breadcrumb

Audit semantic:

```html
<nav aria-label="Breadcrumb">
  <ol>
```

Determine whether CSS + markup guidance is enough or a Component is justified.

Avoid prop-heavy route-specific APIs.

---

# Pagination

Audit:

- page navigation
- current page
- previous/next
- disabled
- ellipsis
- accessible labels
- links vs buttons

Likely Component, but validate evidence.

---

# Navbar / AppBar

Do not confuse:

```text
navigation primitive
```

with:

```text
full application shell
```

A Navbar/AppBar may be too composition-specific for Primitive layer.

---

# Sidebar

Same rule.

Sidebar can involve:

- layout
- collapse
- navigation
- mobile drawer behavior

Do not create a giant Sidebar component during this audit.

---

# Bottom Navigation

Audit mobile-specific generic need.

High threshold.

Do not add simply because mobile apps use it.

---

# Menu / Dropdown

Check whether a menu/popover system already exists or is missing.

If missing, document separately.

Do not silently build one as Navigation.

---

# Navigation Visual Direction

Audit against Default Theme 2026:

- restrained active state
- clear focus
- no Bootstrap navbar appearance
- no excessive pills
- semantic color restraint
- mobile ergonomics

---

# Accessibility

This audit must pay special attention to:

```text
nav landmarks
aria-current
keyboard
focus
tab semantics
link vs button
mobile menu control
```

---

# No Domain Leakage

Do not create props like:

```text
dashboard
services
products
profile
logout
home
```

---

# Playground Recommendation

If no implementation occurs, add only discovery documentation.

If a tiny existing Nav primitive is merely extended, Playground may show:

```text
basic nav
active item
vertical nav
mobile width
```

Do not build Tabs/Pagination demos without approved components.

---

# Required Report

Generate:

```text
.opencode/ORPUI/ORP-NAVIGATION-DISCOVERY-AUDIT.md
```

Report:

```text
Executive Summary
Existing Navigation Inventory
Acerca Read-Only Evidence
Discovery Matrix
Nav
NavItem
Tabs
Breadcrumb
Pagination
Navbar/AppBar
Sidebar
Bottom Navigation
Menu/Dropdown Dependencies
Accessibility
Visual Direction
Layer Classification
Recommended Implementation Order
Rejected Candidates
Deferred Candidates
Final Verdict
Next Phase
```

---

# Final Verdict

Use one:

```text
NAVIGATION FOUNDATION ALREADY ADEQUATE
NAVIGATION HAS FOCUSED GAPS
NAVIGATION NEEDS DEDICATED COMPONENT PHASE
```

If gaps exist, recommend ONE next navigation capability only.

Do not implement the entire navigation family.

STOP.
