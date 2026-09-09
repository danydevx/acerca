# ORP UI — BADGE / STATUS CAPABILITY AUDIT

## Context

ORP currently has Badge variants such as:

```text
primary
secondary
success
warning
danger
outline
```

A previous Component Gap Review concluded the Status question must be resolved against Badge.

This audit verifies the final visual/API richness of Badge without re-opening component proliferation.

---

# Objective

Audit:

```text
Badge
├── visual variants
├── semantic variants
├── size/density
├── icon composition
├── status representation
└── placement patterns
```

---

# Critical Rule

Do NOT create `OrpStatus` unless previous architecture explicitly approved it.

If Badge already covers state representation:

```text
BADGE ALREADY COVERS STATUS
```

must remain respected.

---

# Audit

Inspect:

```text
Badge implementation
StatCard
ProfileCard
CatalogCard
PricingCard
ContentCard
ContactCard
Alert
Forms
Tables
Playground
```

Read Acerca only as evidence.

---

# Questions

- Are badges too pill-like?
- Are semantic colors too saturated?
- Is outline useful?
- Is primary being overused?
- Is there a neutral/default badge?
- Are icon + label combinations clean?
- Are status dots being reinvented locally?
- Does Badge look like a mini Button?
- Are sizes needed?
- Is text truncation appropriate?

---

# Semantic vs Visual Intent

Do not conflate:

```text
primary/secondary visual emphasis
```

with:

```text
success/warning/danger semantic state
```

Document both roles.

---

# Status Representation

If state uses Badge:

ensure color is not the only signal.

Text/icon/shape must preserve meaning.

Do not add automatic aria-live.

---

# Sizes

Audit whether multiple Badge sizes are actually needed.

Avoid API growth if one compact size works in most contexts.

---

# Icon

Audit generic:

```text
[icon] Label
```

without semantic icon mapping.

---

# Playground

Show:

```text
neutral/default
primary
secondary
success
warning
danger
outline if justified
icon + label
long label
status examples
Badge vs Button comparison
```

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-BADGE-STATUS-AUDIT.md
```

Required conclusion:

```text
BADGE ALREADY ADEQUATE
BADGE REFINED
BADGE SHOULD BE EXTENDED
```

And explicitly:

```text
STATUS:
BADGE ALREADY COVERS STATUS
or
STATUS NEEDS FOCUSED FOLLOW-UP
```

STOP.
