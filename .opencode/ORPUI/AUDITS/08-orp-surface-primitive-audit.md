# ORP UI — SURFACE PRIMITIVE AUDIT

## Context

Surface was introduced/audited to reduce misuse of Card for generic grouping.

This phase verifies whether Surface's API and visual role are now clear.

---

# Definition

```text
Surface
→ This region has a visual plane.

Card
→ This is a discrete content object/entity.

Section
→ This is a page chapter/region.
```

---

# Objective

Audit:

- default Surface
- subtle/muted variants if they exist
- padding ownership
- radius
- border
- elevation
- nesting
- Card distinction
- Section composition

---

# Critical Rule

Surface must NOT become:

```text
Card Lite
```

or:

```text
bg-light rounded shadow-sm
```

---

# Audit

Inspect:

```text
Surface
Card
Section
Container
Forms
Map
Playground
Patterns
Acerca read-only grouping regions
```

---

# Required Questions

- Does Surface have a distinct visual purpose?
- Are variants minimal?
- Does Surface own padding?
- Does it own radius?
- Is border default?
- Is shadow ever default?
- Is Surface overused?
- Are nested Surfaces appearing?
- Does it meaningfully reduce Card usage?

---

# Variants

Only keep variants that correspond to actual theme surface tokens.

Potential:

```text
default
subtle
muted
```

Do not add color variants.

---

# Padding

Make ownership explicit.

Surface should not accidentally duplicate Section or Card spacing.

---

# Elevation

Surface should generally be flat.

Raised Surface requires strong evidence.

---

# Playground

Required comparison:

```text
Plain
Surface
Card
```

Also:

```text
Section + Surface
Surface + Grid
Surface + Form
Surface + Map
```

only where existing architecture supports them.

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-SURFACE-PRIMITIVE-AUDIT.md
```

Final verdict:

```text
SURFACE ALREADY ADEQUATE
SURFACE REFINED
SURFACE ROLE NEEDS FOLLOW-UP
```

STOP.
