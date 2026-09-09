# ORP UI — DIVIDER PRIMITIVE AUDIT

## Objective

Audit Divider as a minimal structural primitive.

Divider should remain intentionally small.

---

# Responsibility

Divider:

```text
separates adjacent content regions
```

It does NOT own:

- margins
- section spacing
- card borders
- decorative lines
- business semantics

---

# Audit

Inspect:

```text
Divider implementation
Typography hr
List
Stack
Card
Surface
Accordion
Navigation candidates
Playground
```

---

# Required Questions

- Is horizontal Divider sufficient?
- Is vertical Divider genuinely needed?
- Are styles/colors/thickness variants unnecessary?
- Does Divider duplicate border helpers?
- Is spacing owned by parent Stack/Section?
- Is semantic `<hr>` guidance clear?
- Is Divider too visible?

---

# Vertical Divider

Create/keep only with at least 2 generic contexts.

Do not add merely for completeness.

---

# Border Helper vs Divider

```text
Border helper
→ modifies an existing box edge

Divider
→ is an intentional separator element
```

Keep distinction documented.

---

# Semantic HR

When content represents a thematic break:

prefer semantic `<hr>` styled appropriately.

Do not replace semantics with decorative `<div>`.

---

# Playground

Show:

```text
between Stack groups
inside List if appropriate
inside Surface
semantic hr comparison
vertical only if justified
```

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-DIVIDER-PRIMITIVE-AUDIT.md
```

Final verdict:

```text
DIVIDER ALREADY ADEQUATE
DIVIDER REFINED
DIVIDER NEEDS FOLLOW-UP
```

STOP.
