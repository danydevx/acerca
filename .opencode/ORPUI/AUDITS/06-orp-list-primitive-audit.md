# ORP UI — LIST PRIMITIVE AUDIT

## Context

ORP has `.orp-list`, but Typography & Content also introduced/proposed semantic prose lists.

This audit must protect the distinction between:

```text
UI List
```

and:

```text
Prose ul/ol
```

---

# Objective

Audit the existing UI List primitive for generic application use.

Potential capabilities to evaluate:

```text
default
divided
interactive
dense
leading content
trailing content
selected state
```

Do NOT add these automatically.

---

# Responsibility

UI List is for structured repeated interface rows.

Examples:

- settings
- contacts
- options
- navigation-like rows
- metadata rows
- result lists

It is NOT the styling system for article/prose `<ul>` and `<ol>`.

---

# Audit

Inspect:

```text
.orp-list
Typography prose lists
Divider
Stack
Cluster
Card
Navigation candidates
Playground
Acerca read-only list usages
```

---

# Required Questions

- Is `.orp-list` merely Stack with borders?
- Is a dedicated List primitive justified?
- Is divided behavior duplicated?
- Are row paddings consistent?
- Is interactive state generic?
- Is selected state needed?
- Is dense mode needed?
- Are leading/trailing areas repeated?
- Does List overlap Navigation too much?
- Does it resemble Bootstrap list-group?

---

# Anti-Bootstrap

Explicitly compare with Bootstrap `list-group`.

Avoid:

```text
bordered boxed group
every row as mini card
active blue row
```

unless semantics require similar behavior.

---

# Divided

Prefer Divider/border logic that remains subtle.

Do not box every row.

---

# Interactive

Interactive list rows need:

- focus
- hover
- keyboard semantics appropriate to consumer element

Do not make `<div>` clickable by default.

---

# Selected

Selected state must remain distinct from hover and focus.

Only create if multiple generic consumers require it.

---

# Dense

Do not create dense mode unless real application contexts justify it.

Mobile usability must remain acceptable.

---

# Playground

Show:

```text
basic UI list
divided if justified
interactive if justified
selected if justified
leading/trailing content
long Spanish content
UI List vs Prose List comparison
```

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-LIST-PRIMITIVE-AUDIT.md
```

Final verdict:

```text
LIST ALREADY ADEQUATE
LIST REFINED
LIST NEEDS FOLLOW-UP
```

STOP.
