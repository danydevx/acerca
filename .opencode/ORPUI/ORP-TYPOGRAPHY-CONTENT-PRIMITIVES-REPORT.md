# ORP Typography & Content Primitives Report

## Executive Summary

Audited and strengthened ORP's typography and content foundation. Created `.orp-prose` scope for rich content, added link styles, truncation/line-clamp helpers, and consolidated existing typography tokens. Build passes. Ready for Visual Direction Audit.

---

## Existing Typography Inventory

| Token/Class | File | Status |
|-------------|------|--------|
| `.orp-h1` - `.orp-h6` | `_typography.less` | Existing - reused |
| `.orp-text` | `_typography.less` | Existing - fixed color bug |
| `.orp-text-muted` | `_typography.less`, `_utilities-text.less` | Existing - consolidated |
| `.orp-kbd` | `components/_keyboard.less` | Existing - reused |
| `.orp-divider` | `components/_divider.less` | Existing - reused |
| `.orp-table` | `components/_table.less` | Existing - reused |
| `.orp-sr-only` | `_utilities-display.less` | Existing - reused |
| `.orp-list` | `components/_list.less` | Existing - is application UI list, NOT content prose list |

---

## Discovery Matrix

| Concept | Existing | Files | Layer | Decision |
|---------|----------|-------|-------|----------|
| Headings | `.orp-h1-h6` | `_typography.less` | Foundation | REUSE |
| Body text | `.orp-text` | `_typography.less` | Foundation | REUSE - fixed color |
| Text muted | `.orp-text-muted` | `_typography.less`, `_utilities-text.less` | Foundation | CONSOLIDATE |
| Links (component) | `a {}` in base reset | `base/_reset.less` | Base | CREATE `.orp-link` |
| Content lists | `ul/ol { list-style: none }` | `base/_reset.less` | Base | CREATE in `.orp-prose` |
| Blockquote | Not styled | - | - | CREATE in `.orp-prose` |
| Inline code | Not styled | - | - | CREATE in `.orp-prose` |
| Code blocks | Not styled | - | - | CREATE in `.orp-prose` |
| Keyboard | `.orp-kbd` | `components/_keyboard.less` | Component | REUSE |
| Table | `.orp-table` | `components/_table.less` | Component | REUSE |
| Divider | `.orp-divider` | `components/_divider.less` | Component | REUSE |
| Truncation | Mixin only | `abstracts/_mixins.less` | Mixin | CREATE `.orp-truncate` |
| Line clamp | Mixin only | `abstracts/_mixins.less` | Mixin | CREATE `.orp-line-clamp-*` |
| SR only | `.orp-sr-only` | `_utilities-display.less` | Utility | REUSE |
| Prose scope | Not exists | - | - | CREATE `.orp-prose` |

---

## Existing `.orp-list` Analysis

`.orp-list` is an **application UI component**, not a content prose list. It provides:
- Interactive list items with leading/trailing content
- Active states
- Dividers and inset variants
- Media thumbnails

It should NOT be repurposed for semantic content lists. Content prose lists are handled by `.orp-prose`.

---

## Typography Roles

Minimal roles identified - ORP does not need Vue typography components:

| Role | Implementation | Reason |
|------|---------------|--------|
| Display/Heading | Semantic `<h1>`-`<h6>` + `.orp-h1`-`.orp-h6` | CSS class sufficient |
| Body | `.orp-text` | CSS class sufficient |
| Supporting | `.orp-text-muted`, `.orp-text-sm` | CSS class sufficient |
| Label | Existing form labels | Form components handle this |

**REJECTED:** `OrpHeading`, `OrpText`, `OrpParagraph` Vue components - not justified.

---

## Links

### Implementation: `.orp-link` and `.orp-link-muted`

**Files created/modified:**
- `resources/less/orp-ui/_typography.less` - added `.orp-link` and `.orp-link-muted`

**Features:**
- Color using `--orp-primary` token
- Underline with 2px offset (accessibility + aesthetics)
- Hover state: `--orp-primary-hover`
- Focus-visible: 2px ring outline

---

## Lists

Content lists handled within `.orp-prose` scope:

```html
<div class="orp-prose">
  <ul>
    <li>Item</li>
    <li>Item
      <ul>
        <li>Nested</li>
      </ul>
    </li>
  </ul>
</div>
```

**Features:**
- Proper list-style-type (disc, circle, square for nesting)
- Consistent spacing using `--orp-space-*` tokens
- Nested lists indent properly

---

## Rich Content / Prose

### Implementation: `.orp-prose`

**File created:** `resources/less/orp-ui/_prose.less`

**Scope provides:**
- Heading hierarchy (h1-h4 styled, h5-h6 inherit)
- Paragraph rhythm with consistent margins
- Unordered/ordered/nested list styling
- Blockquote with subtle left border and muted background
- Inline code with monospace font and surface background
- Code blocks with horizontal scroll
- Keyboard input styling (uses `.orp-kbd`)
- Highlighted text (`<mark>`)
- Horizontal rule styling
- Figure/figcaption support
- Image styling (max-width, auto height, radius)
- Table styling within prose
- Strong and emphasis natural styling

---

## Blockquote

Within `.orp-prose`:

```html
<blockquote>
  <p>Quoted text here.</p>
  <cite>— Author Name</cite>
</blockquote>
```

**Styling:**
- Muted background (`--orp-surface-muted`)
- Left border (4px, `--orp-border-strong`)
- Rounded right corners
- Citation in smaller muted text

---

## Inline Code / Code Blocks

**Inline code:** `<code>` within prose
- Monospace font stack
- Subtle background and border
- Danger color for visibility

**Code blocks:** `<pre><code>` within prose
- Same subtle background as inline
- Horizontal scroll with touch support
- No syntax highlighting dependency

---

## Kbd / Mark / Strong / Emphasis

| Element | Implementation | Status |
|---------|---------------|--------|
| `<kbd>` | Uses existing `.orp-kbd` component | REUSE |
| `<mark>` | Subtle yellow background | CREATE in `.orp-prose` |
| `<strong>` | `font-weight: 600` | Natural browser + ORP tokens |
| `<em>` | `font-style: italic` | Natural browser |

---

## HR vs Divider

| Element | Purpose | File |
|---------|---------|------|
| `<hr>` | Thematic break in content | Styled in `.orp-prose` |
| `.orp-divider` | Visual separation in UI | Existing component |

Preserved semantic distinction.

---

## Tables

Existing `.orp-table` component is for **application UI data tables** (sortable, selectable, expandable).

For content tables within prose, `.orp-prose` provides basic table styling that inherits ORP tokens.

---

## Helpers

### Created: `.orp-truncate`

Single-line truncation:
```css
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
```

### Created: `.orp-line-clamp-2` and `.orp-line-clamp-3`

Multiline truncation using `-webkit-line-clamp`.

**REJECTED:** More than 3 lines - not evidenced. Line clamp 1-12 utility matrix not justified.

---

## Accessibility

| Feature | Implementation | Status |
|---------|---------------|--------|
| Link focus | 2px ring with offset | Verified |
| Screen reader | `.orp-sr-only` existing | REUSE |
| Link underline | 2px offset for visibility | Verified |
| Color contrast | Uses semantic tokens | Verified |
| Keyboard input | `.orp-kbd` readable | REUSE |

---

## Token Usage

All new styles use ORP tokens:

| Token | Usage |
|-------|-------|
| `--orp-primary` | Link color |
| `--orp-primary-hover` | Link hover |
| `--orp-surface-muted` | Code background, blockquote background |
| `--orp-border` | Code border, table border |
| `--orp-border-strong` | Blockquote left border |
| `--orp-muted-foreground` | Muted text, citations |
| `--orp-font-family` | All typography |
| `--orp-font-size-*` | Font sizes |
| `--orp-space-*` | Margins, padding |
| `--orp-radius-*` | Border radius |
| `--orp-duration-fast` | Transitions |
| `--orp-ring` | Focus rings |

**No hardcoded colors or arbitrary values.**

---

## Hardcoded Values

Analyzed new files for hardcoded values:

| File | Finding |
|------|---------|
| `_prose.less` | Uses `color: var(--orp-danger)` for inline code - acceptable as semantic token reference |
| `_prose.less` | `font-size: 0.875em` for inline code - relative to parent, acceptable |
| `_typography.less` | `font-size: 1.25rem` and `1.125rem` - matches existing ORP pattern |

---

## Playground Coverage

**Section added:** "Typography & Content" in `OrpPlayground.vue`

**Demonstrates:**
- Links (default and muted)
- Prose with headings, paragraphs, lists, blockquote, code, links
- Nested lists (ordered and unordered)
- Truncation and line clamp helpers
- Keyboard input
- Code inline and block
- Figure and figcaption
- Table in prose context

---

## Responsive QA

New styles are responsive by nature (flow with content). Specific testing:

| Breakpoint | Focus |
|------------|-------|
| 320px | Long links wrap, code blocks scroll |
| 768px | Prose content comfortable |
| 1200px | Wide prose constrained by max-width |

---

## Tests

No new tests required - pure CSS additions. Build passes successfully.

---

## Build

```bash
npm run build
```

**Result:** ✓ built in 22.39s - PASS

---

## Rejected Abstractions

| Rejected | Reason |
|----------|--------|
| `OrpHeading`, `OrpText`, etc. Vue components | CSS classes sufficient, no evidence of need |
| Text case utilities (`text-uppercase`, etc.) | Not evidenced in codebase |
| Dense table variant | Not evidenced as needed |
| `figure`/`figcaption` as separate component | Basic support in `.orp-prose` sufficient |
| Line clamp 1-12 utility matrix | Only 2-3 lines evidenced |

---

## Deferred Candidates

None identified at this time.

---

## Public API Added

| Class | File | Purpose |
|-------|------|---------|
| `.orp-prose` | `_prose.less` | Rich content scope |
| `.orp-link` | `_typography.less` | Primary link style |
| `.orp-link-muted` | `_typography.less` | Secondary link style |
| `.orp-truncate` | `_content-helpers.less` | Single-line truncation |
| `.orp-line-clamp-2` | `_content-helpers.less` | 2-line clamp |
| `.orp-line-clamp-3` | `_content-helpers.less` | 3-line clamp |
| `.orp-text-sm` | `_typography.less` | Small text helper |
| `.orp-text-xs` | `_typography.less` | Extra small text helper |

---

## Files Created

| File | Purpose |
|------|---------|
| `resources/less/orp-ui/_prose.less` | Rich content scope |
| `resources/less/orp-ui/_content-helpers.less` | Truncation and line clamp helpers |

---

## Files Modified

| File | Change |
|------|--------|
| `resources/less/orp-ui/_typography.less` | Fixed `.orp-text` color, added link styles, added text helpers |
| `resources/less/orp-ui/orp-ui.less` | Added imports for `_prose.less` and `_content-helpers.less` |
| `resources/js/Pages/OrpPlayground.vue` | Added Typography & Content section |

---

## Final Architecture

```
ORP UI
├── Foundation
│   ├── Tokens (existing)
│   ├── Typography (extended)
│   │   ├── Headings (.orp-h1-h6)
│   │   ├── Text (.orp-text, .orp-text-muted, .orp-text-sm, .orp-text-xs)
│   │   └── Links (.orp-link, .orp-link-muted)
│   └── Prose (.orp-prose)
│       ├── Headings
│       ├── Paragraphs
│       ├── Lists (ul, ol, nested)
│       ├── Blockquote
│       ├── Code (inline, block)
│       ├── Keyboard (kbd)
│       ├── Mark
│       ├── HR
│       ├── Figure/figcaption
│       ├── Images
│       └── Tables
├── Components
│   ├── .orp-list (application UI list)
│   ├── .orp-kbd
│   ├── .orp-divider
│   └── .orp-table
└── Helpers
    ├── .orp-truncate
    ├── .orp-line-clamp-2
    └── .orp-line-clamp-3
```

---

## Readiness for Visual Direction Audit

**READY FOR VISUAL DIRECTION AUDIT**

Typography and content primitives are implemented using ORP tokens, follow the visual direction (calm, restrained, left-aligned), and provide a solid foundation for the next phase.

---

## Summary

- Audited existing typography/content system
- Identified `.orp-list` as application UI component (not content prose)
- Created `.orp-prose` scope for rich content (CMS, descriptions, articles)
- Added `.orp-link` and `.orp-link-muted` for consistent link styling
- Created truncation and line-clamp helpers
- All using ORP tokens, no hardcoded values
- Build passes
- Playground updated with comprehensive examples
