# ORP UI — BUTTON SYSTEM AUDIT

## Objective

Audit the current ORP Button system before broader visual rollout.

Current known baseline:

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

Candidates to audit:

```text
Soft
Outline
Link
Loading
Leading icon
Trailing icon
```

Do NOT add candidates automatically.

---

# Core Principle

Button variants represent ACTION HIERARCHY, not a color palette.

Do not recreate Bootstrap:

```text
primary
secondary
success
warning
danger
info
light
dark
outline-*
```

---

# Audit

Inspect:

```text
Button / .orp-btn
IconButton
Default Theme 2026
Typography
Visual Helpers
Playground
Patterns
Forms
Modal
Alert
Empty
```

Read Acerca only as usage evidence.

---

# Required Decisions

For each:

```text
Primary
Secondary
Ghost
Danger
Soft
Outline
Link
Loading
```

use:

```text
KEEP
REFINE
CREATE
REJECT
DEFER
```

---

# Hierarchy Hypothesis

Audit:

```text
Primary
→ strongest normal action

Soft
→ emphasized but quieter than Primary

Secondary
→ visible neutral action

Ghost
→ tertiary action

Danger
→ destructive action
```

Validate actual need.

---

# Soft

Strong candidate.

Potential role:

```text
soft primary-tinted surface
primary text/icon
lower weight than Primary
```

Reject if it duplicates Secondary.

---

# Outline

High scrutiny.

If Secondary already covers a visible neutral action:

```text
OUTLINE NOT JUSTIFIED
```

is preferable.

---

# Link

Only for action semantics rendered quietly.

Do not replace semantic anchors.

---

# Semantic Color Buttons

Explicitly audit:

```text
Success
Warning
Info
```

Default recommendation: reject unless strong cross-context evidence exists.

---

# Sizes

Audit Small / Medium / Large for:

- height
- padding
- typography
- icon size
- radius
- touch usability

---

# Block

Verify:

```text
width: 100%
```

or equivalent existing behavior.

Test long Spanish labels and mobile.

---

# Icons

Test:

```text
[icon] Label
Label [icon]
```

Avoid leftIcon/rightIcon prop explosion unless repeated CSS/API problems prove it is necessary.

---

# Loading

Audit generic busy state:

- aria-busy
- duplicate activation prevention
- stable width
- existing Spinner reuse

Button must not own async/business logic.

---

# States

Audit:

```text
Default
Hover
Focus
Active
Disabled
Loading
```

---

# Anti-Bootstrap

Score 0–3 for:

```text
Primary
Secondary
Ghost
Danger
Overall
```

Explain visual signals.

---

# Playground

Show:

```text
Variants
Sizes
Block
Leading icon
Trailing icon
Long Spanish labels
Disabled
Loading if justified
Primary + quieter secondary action
Danger + cancel
```

---

# QA

Test:

```text
320
375
390
430
768
1200
1440
```

Run tests, build, browser console.

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-BUTTON-SYSTEM-AUDIT.md
```

Final verdict:

```text
BUTTON SYSTEM READY
```

or:

```text
BUTTON SYSTEM NEEDS FOLLOW-UP
```

STOP.
