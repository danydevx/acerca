# ORP UI — AVATAR PRIMITIVE AUDIT

## Objective

Audit Avatar as a generic identity/media primitive.

Evaluate whether current API and visual treatment are sufficient for ProfileCard and generic identity use.

---

# Responsibility

Avatar owns:

- avatar shape
- image/fallback containment
- size
- image fit
- generic fallback presentation

Avatar does NOT own:

- profile business data
- social links
- presence system
- user fetching
- upload behavior
- crop editor

---

# Audit

Inspect:

```text
Avatar implementation
ProfileCard
ContactCard
Comments/reviews if present
Navigation/user menu if present
Playground
```

---

# Required Questions

1. Are sizes sufficient?
2. Is fallback behavior generic?
3. Are initials supported/needed?
4. Is icon fallback supported/needed?
5. Is image fit correct?
6. Is radius hardcoded?
7. Are decorative rings/borders overused?
8. Does Avatar need status/presence overlay?
9. Would status overlay duplicate Badge?
10. Are loading/error states application-owned?

---

# Sizes

Audit actual size scale.

Do not create:

```text
xs sm md lg xl 2xl 3xl
```

without evidence.

Prefer a small meaningful scale.

---

# Shape

Determine whether Avatar is:

```text
circle by default
```

or supports another generic shape.

Do not add arbitrary shape matrices.

---

# Fallback

Audit:

```text
image
initials
generic icon
```

Only implement missing fallback paths if 2+ generic contexts need them.

---

# Status Overlay

High threshold.

Do not add presence/status dot merely because many design systems have one.

Require clear generic evidence and compatibility with Badge/Status decision.

---

# Accessibility

Audit:

- alt handling
- decorative avatar cases
- fallback text
- contrast
- image failure

Consumer remains responsible for meaningful alt text where applicable.

---

# Playground

Show:

```text
image
initials
fallback
sizes
long initials/name context
inside ProfileCard
```

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-AVATAR-AUDIT.md
```

Final verdict:

```text
AVATAR ALREADY ADEQUATE
AVATAR REFINED
AVATAR NEEDS FOLLOW-UP
```

STOP.
