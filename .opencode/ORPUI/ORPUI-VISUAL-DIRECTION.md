# ORP UI — Visual Direction

## Purpose

This document establishes the visual language and design principles for ORP UI, ensuring consistency across all components, primitives, and patterns.

---

## 1. Design Principles

### 1.1 Core Philosophy
- **Composable**: Build from primitives up, not from scratch
- **Token-driven**: All visual decisions flow from design tokens
- **Semantic**: Colors and styles communicate meaning, not just aesthetics
- **Accessible**: All visual choices meet WCAG 2.1 AA contrast requirements
- **Mobile-first**: Design for small screens first, enhance for larger

### 1.2 Visual Hierarchy
1. **Surface & Background**: Establish depth and context
2. **Primary Actions**: Draw attention through color and size
3. **Content**: Typography creates natural hierarchy
4. **Supporting**: Metadata and secondary info recede

---

## 2. Color System

### 2.1 Semantic Token Usage

**Correct Usage:**
```css
background: var(--orp-surface);
color: var(--orp-surface-foreground);
border-color: var(--orp-border);
```

**Never hardcode:**
```css
/* WRONG */
color: #17191d;
background: #ffffff;
border: 1px solid #e1e5ea;

/* CORRECT */
color: var(--orp-surface-foreground);
background: var(--orp-surface);
border: 1px solid var(--orp-border);
```

### 2.2 Color Application Rules

| Token | Usage | Never Use For |
|-------|-------|---------------|
| `--orp-surface` | Card backgrounds, modals | Text |
| `--orp-surface-foreground` | Primary text | Secondary elements |
| `--orp-muted-foreground` | Secondary text, metadata | Primary content |
| `--orp-primary` | Primary buttons, links | Backgrounds of large areas |
| `--orp-border` | Borders, dividers | Text emphasis |
| `--orp-success` | Positive states only | Decorative elements |
| `--orp-danger` | Error states, destructive actions | Warnings |
| `--orp-warning` | Caution states | Success states |

### 2.3 Dark Theme
- All semantic tokens have dark theme equivalents
- Always use tokens, never assume light theme values
- Test components in both themes

---

## 3. Typography

### 3.1 Font Family
```css
font-family: var(--orp-font-family);
```
**Value**: `Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif`

### 3.2 Type Scale

| Token | Size | Usage |
|-------|------|-------|
| `--orp-font-size-xs` | 0.75rem | Metadata, timestamps |
| `--orp-font-size-sm` | 0.875rem | Secondary text, labels |
| `--orp-font-size-md` | 1rem | Body text, descriptions |
| `--orp-font-size-lg` | 1.125rem | Card titles, section headers |
| `--orp-font-size-xl` | 1.5rem | Page titles, hero text |

### 3.3 Typography Rules
- **Always** use `var(--orp-font-family)` for font
- **Always** use tokens for font sizes
- **Never** hardcode `font-size: 14px` — use `var(--orp-font-size-sm)`
- Line height is unified: `var(--orp-line-height)` = 1.5

---

## 4. Spacing System

### 4.1 Spacing Scale

| Token | Value | Usage |
|-------|-------|-------|
| `--orp-space-1` | 4px | Tight gaps, icon padding |
| `--orp-space-2` | 8px | Default gaps in components |
| `--orp-space-3` | 12px | Padding within cards |
| `--orp-space-4` | 16px | Section padding, larger gaps |
| `--orp-space-5` | 24px | Between sections |
| `--orp-space-6` | 32px | Page-level spacing |
| `--orp-space-7` | 40px | Large section breaks |
| `--orp-space-8` | 48px | Hero spacing |

### 4.2 Spacing Rules
- **Stack** (vertical rhythm): Use `--orp-space-*` for `gap`
- **Cluster** (horizontal wrapping): Use `--orp-space-*` for `gap`
- **Grid** (collections): Use `--orp-space-*` for `gap`
- **Never** hardcode `gap: 8px` — use `gap: var(--orp-space-2)`

---

## 5. Border Radius

### 5.1 Radius Scale

| Token | Value | Usage |
|-------|-------|-------|
| `--orp-radius-sm` | 8px | Inputs, badges, small elements |
| `--orp-radius-md` | 12px | Buttons, cards, dropdowns |
| `--orp-radius-lg` | 18px | Modals, large cards |
| `--orp-radius-xl` | 24px | Featured cards |
| `--orp-radius-pill` | 999px | Pills, avatars (circular) |

### 5.2 Radius Usage Rules
- **Cards**: `var(--orp-radius-lg)` for standard, `var(--orp-radius-xl)` for emphasis
- **Buttons**: `var(--orp-radius-md)` always
- **Inputs**: `var(--orp-radius-sm)` to `var(--orp-radius-md)`
- **Avatars**: `var(--orp-radius-pill)` for circular (with `aspect-ratio: 1/1`)
- **Never** use `border-radius: 50%` — use `var(--orp-radius-pill)` + `aspect-ratio: 1/1`

---

## 6. Shadows

### 6.1 Shadow Scale

| Token | Usage |
|-------|-------|
| `--orp-shadow-sm` | Subtle lift, hover states |
| `--orp-shadow-md` | Dropdowns, popovers |
| `--orp-shadow-lg` | Modals, sheets |
| `--orp-shadow-dropdown` | Dropdown menus |
| `--orp-shadow-popover` | Popovers, tooltips |

### 6.2 Shadow Rules
- **Cards**: Use `--orp-shadow-sm` for resting, `--orp-shadow-md` on hover
- **Interactive elements**: Elevate on hover with shadow
- **Overlays** (modals, drawers): Use `--orp-shadow-lg`
- **Never** hardcode `box-shadow: 0 4px 6px...` — use tokens

---

## 7. Motion & Animation

### 7.1 Duration Tokens

| Token | Value | Usage |
|-------|-------|-------|
| `--orp-duration-fast` | 150ms | Micro-interactions, hover |
| `--orp-duration-normal` | 200ms | Standard transitions |
| `--orp-duration-slow` | 300ms | Page transitions |
| `--orp-duration-spinner` | 800ms | Loading indicators |
| `--orp-duration-shimmer` | 1500ms | Skeleton loading |

### 7.2 Easing
```css
var(--orp-ease-standard) /* cubic-bezier(.2, .8, .2, 1) */
```

### 7.3 Motion Rules
- **Micro-interactions**: 150ms (hover, focus)
- **State changes**: 200ms (collapse, expand)
- **Page transitions**: 300ms (modal open, drawer)
- **Always** respect `prefers-reduced-motion`
- **Never** animate layout shifts

---

## 8. Focus States

### 8.1 Focus Ring
```css
&:focus-visible {
    outline: 2px solid var(--orp-ring);
    outline-offset: 2px;
}
```

### 8.2 Focus Rules
- **Never** use `outline: none` without `:focus-visible` replacement
- Focus must be visible for keyboard navigation
- Use `var(--orp-ring)` for focus ring color
- Offset by 2px for visibility

---

## 9. Z-Index Scale

| Token | Value | Usage |
|-------|-------|-------|
| `--orp-z-base` | 0 | Default stacking |
| `--orp-z-sticky` | 100 | Sticky headers |
| `--orp-z-fixed` | 200 | Fixed elements |
| `--orp-z-dropdown` | 500 | Dropdown menus |
| `--orp-z-popover` | 600 | Popovers, tooltips |
| `--orp-z-backdrop` | 900 | Modal backdrops |
| `--orp-z-modal` | 1000 | Modals |
| `--orp-z-sheet` | 1100 | Sheets, sidebars |
| `--orp-z-toast` | 1200 | Toast notifications |
| `--orp-z-notification` | 1250 | Notification stack |

### Z-Index Rules
- **Never** use `z-index: 9999` or similar
- **Always** use semantic z-index tokens
- Modal backdrops must use `--orp-z-backdrop`

---

## 10. Component Visual Rules

### 10.1 Cards
```css
background: var(--orp-surface);
border-radius: var(--orp-radius-lg);
border: 1px solid var(--orp-border);
```
- Interactive cards: lift with `--orp-shadow-sm` on hover
- Never use `box-shadow` on resting cards

### 10.2 Buttons
- Primary: `background: var(--orp-primary)`
- Secondary: `background: var(--orp-secondary)`
- Ghost: transparent with border
- Danger: `background: var(--orp-danger)`
- Always use `var(--orp-radius-md)`

### 10.3 Forms
- Inputs: `border-radius: var(--orp-radius-sm)`
- Error states: use `var(--orp-danger)` for border
- Labels: `var(--orp-font-size-sm)`, `var(--orp-muted-foreground)`
- Helper text: `var(--orp-font-size-xs)`, `var(--orp-muted-foreground)`

---

## 11. Responsive Breakpoints

| Token | Value | Device |
|-------|-------|--------|
| `--orp-breakpoint-sm` | 576px | Large phones |
| `--orp-breakpoint-md` | 768px | Tablets |
| `--orp-breakpoint-lg` | 992px | Laptops |
| `--orp-breakpoint-xl` | 1200px | Desktops |

### Responsive Rules
- **Mobile-first**: Base styles target 320px+
- **Enhance progressively**: Add media queries for larger screens
- **Never** use desktop as default with mobile overrides

---

## 12. CSS Custom Properties vs Hardcoded Values

### 12.1 When to Use Tokens

**Always use tokens for:**
- Colors (`background`, `color`, `border-color`)
- Spacing (`padding`, `margin`, `gap`)
- Typography (`font-size`, `line-height`)
- Borders (`border-radius`)
- Shadows (`box-shadow`)
- Z-index
- Durations

**Acceptable hardcoded values:**
- Third-party integrations (video.js, GLightbox)
- Complex gradient definitions that can't be tokenized
- Canvas/WebGL contexts

### 12.2 Never Hardcode
```css
/* WRONG */
color: #fff;
background: #000;
padding: 16px;
font-size: 14px;
border-radius: 8px;
z-index: 999;

/* CORRECT */
color: var(--orp-primary-foreground);
background: var(--orp-surface);
padding: var(--orp-space-4);
font-size: var(--orp-font-size-sm);
border-radius: var(--orp-radius-md);
z-index: var(--orp-z-modal);
```

---

## 13. Dark Theme Rules

### 13.1 Token Override Pattern
```less
.dark-theme {
    --orp-surface: #181b21;
    --orp-surface-foreground: #f4f5f7;
    --orp-border: #303640;
    // ... all semantic tokens
}
```

### 13.2 Dark Theme Requirements
- All components must work in both themes
- Never assume light theme colors
- Test in both themes during development
- Use `color-mix()` for semantic variations when needed

---

## 14. Iconography

### 14.1 Icon System
- **Primary**: Bootstrap Icons (included via `_bootstrap-icons.less`)
- **Sizing**: Use `font-size` tokens (`--orp-font-size-sm`, etc.)
- **Color**: Inherit from parent `color`

### 14.2 Icon Rules
- **Never** use emoji as icons
- **Always** provide `aria-hidden="true"` for decorative icons
- Icon-only buttons **must** have `aria-label`
- Use `bi-*` classes from Bootstrap Icons

---

## 15. Accessibility Visual Requirements

### 15.1 Color Contrast
- Text on background: minimum 4.5:1 (AA)
- Large text: minimum 3:1
- UI components: minimum 3:1

### 15.2 Touch Targets
- Minimum 44x44px for touch
- Minimum 32x32px for mouse/trackpad

### 15.3 Motion
- Always respect `prefers-reduced-motion`
- Provide non-motion alternatives

---

## 16. Anti-Patterns

### 16.1 Visual Anti-Patterns to Avoid

```css
/* WRONG: Hardcoded color */
color: #dc3545;

/* WRONG: px instead of rem for font */
font-size: 14px;

/* WRONG: Magic number spacing */
padding: 19px;

/* WRONG: Border-radius 50% for circles */
border-radius: 50%;

/* WRONG: z-index without token */
z-index: 1000;

/* WRONG: Hardcoded shadow */
box-shadow: 0 2px 4px rgba(0,0,0,0.1);

/* WRONG: outline: none without focus-visible */
&:focus {
    outline: none;
}
```

### 16.2 Correct Patterns

```css
/* CORRECT: Token-based color */
color: var(--orp-danger);

/* CORRECT: rem for font sizing */
font-size: var(--orp-font-size-sm);

/* CORRECT: Token-based spacing */
padding: var(--orp-space-4);

/* CORRECT: Token + aspect-ratio for circles */
border-radius: var(--orp-radius-pill);
aspect-ratio: 1/1;

/* CORRECT: Token z-index */
z-index: var(--orp-z-modal);

/* CORRECT: Token shadow */
box-shadow: var(--orp-shadow-md);

/* CORRECT: outline: none with :focus-visible */
&:focus-visible {
    outline: 2px solid var(--orp-ring);
    outline-offset: 2px;
}
```

---

## 17. Implementation Checklist

Before committing any ORP UI code, verify:

- [ ] All colors use semantic tokens (no `#hex`, `rgb()`, `hsl()`)
- [ ] All spacing uses `--orp-space-*` tokens
- [ ] All font sizes use `--orp-font-size-*` tokens
- [ ] All border radii use `--orp-radius-*` tokens
- [ ] All shadows use `--orp-shadow-*` tokens
- [ ] All z-index uses `--orp-z-*` tokens
- [ ] All durations use `--orp-duration-*` tokens
- [ ] Focus states use `var(--orp-ring)` for outline
- [ ] No `outline: none` without `:focus-visible` replacement
- [ ] Works in both light and dark themes
- [ ] Respects `prefers-reduced-motion`
- [ ] Touch targets are minimum 44x44px

---

## 18. Related Documents

- `GLOBAL-ARCHITECTURE-AUDIT.md` — Technical inventory and architecture
- `GENERIC-COMPOSITIONS-PATTERNS.md` — Composition patterns guide
- `ORP-CONTENT-CARD.md` — Content card specification
- `ORP-STAT-CARD.md` — Stat card specification
- `ORP-MAPS.md` — Map component specification

---

**Last Updated:** September 2026
**Status:** ACTIVE
