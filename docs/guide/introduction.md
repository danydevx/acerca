# Introduction

ORP UI is a mobile-first UI framework for Vue 3 applications.

## Design Principles

- **Mobile First** - Designed for touch interfaces with responsive layouts
- **CSS First** - Use as pure CSS primitives or enhanced with Vue components
- **Semantic HTML** - Accessible markup that works without JavaScript
- **Vue When Needed** - JavaScript components only when behavior requires it
- **Composition Over Duplication** - Reuse primitives to build complex patterns
- **Runtime CSS Variables** - Theming via CSS custom properties
- **Icon Agnostic** - Works with any icon library
- **Accessible** - WCAG 2.2 AA compliant

## What ORP UI Is

ORP UI owns:
- Presentation
- Interaction
- Accessibility

## What ORP UI Is Not

ORP UI does not own:
- Routing
- API calls
- Permissions
- Business logic
- Persistence

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Framework Boundaries

ORP UI is:
- Vue 3 focused but CSS-agnostic
- A UI layer, not an application framework
- Installable as a standalone package

## Quick Example

```html
<link rel="stylesheet" href="orp-ui.css">
<script type="module">
import { OrpButton } from 'orp-ui'
</script>

<orp-button variant="primary">Click me</orp-button>
```

Or use CSS-only:

```html
<button class="orp-btn orp-btn--primary">Click me</button>
```
