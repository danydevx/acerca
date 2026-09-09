# ORP UI — MEDIA PRIMITIVE VISUAL AUDIT

## Context

Media capability has already been audited and declared stable.

Do NOT reopen architecture unless a blocking issue is found.

This is a focused API/visual consistency audit.

---

# Objective

Verify the stable Media primitive exposes enough generic visual capability for ORP 2026.

Audit:

```text
aspect ratio
cover / contain
responsive sizing
overlay
caption relationship
radius ownership
overflow
video/picture support if already present
```

---

# Critical Rule

Do NOT create a second media system.

Do NOT create Gallery, Carousel, Lightbox, VideoPlayer or domain media components.

---

# Audit

Inspect:

```text
Media implementation
Card
CatalogCard
ContentCard
ProfileCard
Typography figure/figcaption
GLightbox integration boundaries
Playground
```

---

# Questions

- Are available ratios sufficient?
- Is there a custom-property escape hatch?
- Are cover/contain clear?
- Is object-position needed or already solved?
- Is overlay generic?
- Is radius owned correctly?
- Does Media add decorative chrome by default?
- Can Media be edge-to-edge inside Card?
- Are responsive images semantically consumer-owned?
- Are captions duplicated with Typography primitives?

---

# Ratios

Avoid large ratio catalogs.

Keep a small reusable set plus existing generic escape hatch if justified.

---

# Object Fit

Audit:

```text
cover
contain
```

Only add others if evidence exists.

---

# Radius

Media should not independently force large radius if parent composition owns clipping.

Avoid:

```text
rounded card
+
rounded image inside
```

by default.

---

# Overlay

Overlay must remain generic.

No product/service-specific actions.

---

# Caption

Prefer semantic:

```html
<figure>
<figcaption>
```

from Typography/Content when appropriate.

Do not duplicate caption systems.

---

# Playground

Show:

```text
responsive media
ratios
cover vs contain
edge-to-edge Card media
overlay
figure/caption integration
portrait and landscape sources
```

---

# Report

Generate:

```text
.opencode/ORPUI/ORP-MEDIA-VISUAL-AUDIT.md
```

Final verdict:

```text
MEDIA REMAINS ADEQUATE
MEDIA VISUAL REFINEMENT COMPLETE
MEDIA NEEDS FOCUSED FOLLOW-UP
```

STOP.
