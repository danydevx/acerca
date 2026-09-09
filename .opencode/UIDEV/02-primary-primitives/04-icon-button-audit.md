# ORP UI — ICON BUTTON AUDIT

## Objective

Audit IconButton as a distinct action primitive/component.

Known API from current ORP history:

```text
variant:
- primary
- ghost
- danger

size:
- sm
- md
- lg

disabled
ariaLabel
```

Verify repository source of truth.

---

# Responsibility

IconButton is:

```text
icon-only action
```

It is NOT:

- normal Button without text
- Badge
- toggle system
- menu system
- floating action button by default

---

# Audit

Inspect:

```text
OrpIconButton
.orp-icon-btn
Button
Bootstrap Icons usage
Modal
Drawer
Cards
Media overlays
Maps
Playground
```

---

# Required Questions

1. Are variants sufficient?
2. Does IconButton need Secondary or Soft?
3. Are sizes coherent with Button?
4. Is ariaLabel required/enforced?
5. Are hit targets accessible?
6. Does anchor icon-link styling need to remain CSS-only?
7. Are hover/focus/active states coherent?
8. Does it visually resemble Bootstrap square buttons?
9. Is icon optical sizing consistent?
10. Are circular/pill shapes overused?

---

# Variant Rule

Do not automatically mirror every Button variant.

A Button variant does NOT imply an IconButton variant.

Audit:

```text
Primary
Ghost
Danger
Secondary?
Soft?
```

Create only if 2+ generic contexts prove need.

---

# Anchor Icon Links

If `.orp-icon-btn` is used on `<a>`:

preserve semantic distinction.

Do not force Vue IconButton to render links unless API already supports it cleanly.

---

# Accessibility

Required:

- accessible name
- keyboard
- focus-visible
- hit target
- disabled semantics
- decorative icon handling
- no color-only destructive meaning

---

# Shape

Audit:

- square-ish rounded
- circular
- pill-like

Do not default everything to circles unless ORP visual direction justifies it.

---

# Size

Compare:

```text
sm
md
lg
```

to normal Button control heights.

Icon size and hit area are separate concerns.

---

# Playground

Show:

```text
Primary
Ghost
Danger
Sizes
Disabled
Inside Card
Media overlay
Modal header
Anchor icon link if supported
Long accessible label in inspector/docs
```

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-ICON-BUTTON-AUDIT.md
```

Final verdict:

```text
ICON BUTTON ALREADY ADEQUATE
ICON BUTTON REFINED
ICON BUTTON NEEDS FOLLOW-UP
```

STOP.
