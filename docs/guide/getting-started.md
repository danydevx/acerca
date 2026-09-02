# Getting Started

## Installation

### Via Package

```bash
npm install orp-ui
```

### CSS Import

```javascript
import 'orp-ui/dist/orp-ui.css'
```

### Vue Components Import

```javascript
import { 
  OrpButton, 
  OrpCard, 
  OrpModal 
} from 'orp-ui'
```

## Usage

### CSS-Only (No Vue)

```html
<button class="orp-btn orp-btn--primary">Primary</button>
<button class="orp-btn orp-btn--secondary">Secondary</button>
<button class="orp-btn orp-btn--ghost">Ghost</button>
```

### With Vue

```vue
<script setup>
import { OrpButton } from 'orp-ui'
</script>

<template>
  <OrpButton variant="primary" @click="handleClick">
    Click me
  </OrpButton>
</template>
```

## Theming

### Light Theme (Default)

```html
<html>
```

### Dark Theme

```html
<html data-orp-theme="dark">
```

### Custom Theme

```css
[data-orp-theme="brand"] {
  --orp-primary: #ff5722;
  --orp-primary-foreground: white;
}
```

## Available Components

- **Actions**: Button, Icon Button
- **Layout**: Card, Section, Stack, Cluster, Grid
- **Navigation**: App Bar, Bottom Nav, Tabs, Breadcrumb, Pagination
- **Forms**: Input, Textarea, Select, Checkbox, Radio, Switch, Segmented
- **Overlays**: Modal, Sheet, Drawer, Popover, Dropdown
- **Feedback**: Alert, Toast, Spinner, Progress, Skeleton, Empty State
- **Data Display**: Avatar, Badge, List, Meta, Rating, Divider
- **Media**: Media, Gallery, Video Player, Audio Player
- **Files**: File Input, Dropzone

## No Plugin Required

ORP UI does not require `app.use()` - use direct imports instead.

```javascript
// No this:
app.use(OrpUI)

// Do this:
import { OrpButton } from 'orp-ui'
```
