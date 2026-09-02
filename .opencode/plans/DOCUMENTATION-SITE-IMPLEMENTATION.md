# ORP UI Documentation Site - VitePress Implementation

## Tooling Decision
- **Solution:** VitePress
- **Reason:** Lightweight, Vue-native, Markdown-based, Vite-compatible, static build
- **Dependencies added:** `vitepress` as dev dependency
- **Build impact:** Separate docs build, doesn't affect main app

## Documentation Structure

```
docs/
├── .vitepress/
│   ├── config.mts          # Main config: nav, sidebar, theme
│   ├── theme/
│   │   ├── index.ts       # Theme entry
│   │   ├── Layout.vue     # Custom layout with ORP shell
│   │   └── style.css      # Theme styles
│   └── utils/
│       └── components.ts   # Shared demo components
├── index.md               # Landing page
├── public/
│   └── orp-ui-logo.svg   # Logo
├── guide/
│   ├── introduction.md
│   ├── getting-started.md
│   ├── installation.md
│   └── theming.md
├── foundations/
│   ├── colors.md
│   ├── typography.md
│   ├── spacing.md
│   ├── tokens.md
│   └── motion.md
├── components/
│   ├── index.md
│   ├── button.md
│   ├── card.md
│   ├── modal.md
│   ├── sheet.md
│   ├── drawer.md
│   ├── tabs.md
│   ├── dropdown.md
│   ├── popover.md
│   ├── alert.md
│   ├── toast.md
│   ├── notification.md
│   ├── input.md
│   ├── textarea.md
│   ├── select.md
│   ├── checkbox.md
│   ├── radio.md
│   ├── switch.md
│   ├── list.md
│   ├── avatar.md
│   ├── badge.md
│   ├── table.md
│   └── ... (all components)
├── utilities/
│   ├── display.md
│   ├── flex.md
│   ├── spacing.md
│   └── text.md
├── integrations/
│   ├── bootstrap-icons.md
│   ├── swiper.md
│   └── glightbox.md
└── accessibility/
    └── overview.md
```

## Installation

```bash
npm install -D vitepress
```

## package.json Scripts

```json
{
  "scripts": {
    "docs:dev": "vitepress dev docs",
    "docs:build": "vitepress build docs",
    "docs:preview": "vitepress preview docs"
  }
}
```

## Key Features

1. **Navigation:** Guide, Foundations, Components, Utilities, Integrations, Accessibility
2. **Sidebar:** Categorized by component type (Actions, Layout, Navigation, Overlays, Feedback, Forms, Data Display, Media, Files, Rich UI)
3. **Search:** Local search with MiniSearch
4. **Theme:** Uses ORP UI for shell, dark/light toggle
5. **Demo Frame:** Isolated preview with ORP styles loaded

## Component Page Template

```markdown
# Component Name

## Summary
Brief description of the component.

## Basic Example
<DemoFrame>
  <OrpComponent />
</DemoFrame>

```html
<OrpComponent />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| variant | string | 'default' | Visual variant |

## Slots

| Slot | Props | Description |
|------|-------|-------------|
| default | - | Main content |

## Accessibility
- Keyboard: Tab to focus, Enter to activate
- ARIA: role="button"
```

## Demo Component Implementation

```vue
<script setup>
import '../../../resources/js/orp-ui.js'
import '../../../resources/less/orp-ui/orp-ui.less'
</script>

<template>
  <div class="demo-frame">
    <slot />
  </div>
</template>

<style scoped>
.demo-frame {
  padding: 2rem;
  background: var(--orp-surface);
  border-radius: var(--orp-radius-lg);
}
</style>
```

## Bootstrap Leakage Prevention

Docs must use ORP classes, not Bootstrap:
- ❌ `btn`, `card`, `modal`, `alert`
- ✅ `orp-btn`, `orp-card`, `orp-modal`, `orp-alert`

## Next Steps
1. Create VitePress config and theme
2. Create documentation pages for each component
3. Add demo components with live previews
4. Test in development mode
