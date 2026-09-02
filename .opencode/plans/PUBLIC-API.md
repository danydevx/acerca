# ORP UI Public API - v0.1.0

This document defines the public API surface for ORP UI v0.1.0.

## Version

**Status:** Pre-release  
**Target:** v0.1.0

---

## CSS Entry Point

### Main Bundle

```javascript
import 'orp-ui/dist/orp-ui.css'
```

### Individual Modules

CSS modules are bundled together in the main distribution. Individual component LESS files are considered internal.

---

## LESS Entry Points (Advanced)

::: warning
LESS source files are for advanced users who need build-time customization.
:::

```javascript
import 'orp-ui/less/orp-ui.less'           // Full bundle
import 'orp-ui/less/_variables.less'       // Variables only
import 'orp-ui/less/components/*.less'      // Component CSS
```

---

## Vue Components

### Framework Components

| Component | Import | Notes |
|-----------|--------|-------|
| `OrpTabs` | `import { OrpTabs } from 'orp-ui'` | |
| `OrpModal` | `import { OrpModal } from 'orp-ui'` | |
| `OrpSheet` | `import { OrpSheet } from 'orp-ui'` | |
| `OrpSwitch` | `import { OrpSwitch } from 'orp-ui'` | |
| `OrpToast` | `import { OrpToast } from 'orp-ui'` | |
| `OrpAccordion` | `import { OrpAccordion } from 'orp-ui'` | |
| `OrpDropdown` | `import { OrpDropdown } from 'orp-ui'` | |
| `OrpPopover` | `import { OrpPopover } from 'orp-ui'` | |
| `OrpDrawer` | `import { OrpDrawer } from 'orp-ui'` | |
| `OrpIconButton` | `import { OrpIconButton } from 'orp-ui'` | |
| `OrpSegmented` | `import { OrpSegmented } from 'orp-ui'` | |
| `OrpSearchInput` | `import { OrpSearchInput } from 'orp-ui'` | |
| `OrpFileInput` | `import { OrpFileInput } from 'orp-ui'` | |
| `OrpActionSheet` | `import { OrpActionSheet } from 'orp-ui'` | |
| `OrpDropzone` | `import { OrpDropzone } from 'orp-ui'` | |
| `OrpCommandMenu` | `import { OrpCommandMenu } from 'orp-ui'` | |
| `OrpContextMenu` | `import { OrpContextMenu } from 'orp-ui'` | |
| `OrpDataTable` | `import { OrpDataTable } from 'orp-ui'` | |
| `OrpVideoPlayer` | `import { OrpVideoPlayer } from 'orp-ui'` | |
| `OrpAudioPlayer` | `import { OrpAudioPlayer } from 'orp-ui'` | |
| `OrpDialog` | `import { OrpDialog } from 'orp-ui'` | |
| `OrpDialogHost` | `import { OrpDialogHost } from 'orp-ui'` | |
| `OrpNotification` | `import { OrpNotification } from 'orp-ui'` | |
| `OrpNotificationHost` | `import { OrpNotificationHost } from 'orp-ui'` | |
| `OrpCombobox` | `import { OrpCombobox } from 'orp-ui'` | |
| `OrpMultiSelect` | `import { OrpMultiSelect } from 'orp-ui'` | |
| `OrpTagInput` | `import { OrpTagInput } from 'orp-ui'` | |
| `OrpNumberStepper` | `import { OrpNumberStepper } from 'orp-ui'` | |
| `OrpOtpInput` | `import { OrpOtpInput } from 'orp-ui'` | |
| `OrpPasswordInput` | `import { OrpPasswordInput } from 'orp-ui'` | |

### Host Components

| Component | Purpose |
|-----------|---------|
| `OrpDialogHost` | Renders dialog stack via Teleport |
| `OrpNotificationHost` | Renders notification stack via Teleport |

---

## Composables

### Dialog

```javascript
import { useOrpDialog } from 'orp-ui'

const dialog = useOrpDialog()

// Alert
await dialog.alert({
  title: 'Warning',
  message: 'This action cannot be undone',
  tone: 'danger'
})

// Confirm
const confirmed = await dialog.confirm({
  title: 'Delete Item',
  message: 'Are you sure?'
})

// Prompt
const name = await dialog.prompt({
  title: 'Enter Name',
  label: 'Your name'
})
```

### Notifications

```javascript
import { useOrpNotifications } from 'orp-ui'

const { show, success, danger, clear } = useOrpNotifications()

// Show notification
const item = show({
  title: 'Saved',
  message: 'Your changes have been saved',
  tone: 'success'
})

// Close programmatically
item.close()

// Shorthand methods
success({ title: 'Success', message: 'Done!' })
danger({ title: 'Error', message: 'Failed!' })
```

### Theme

```javascript
import { useOrpTheme } from 'orp-ui'

const { theme, toggleTheme, setTheme } = useOrpTheme()

setTheme('dark')
toggleTheme()
```

---

## CSS Classes (Public API)

### Layout

| Class | Description |
|-------|-------------|
| `.orp-container` | Page container |
| `.orp-page` | Page wrapper |
| `.orp-section` | Section with header/body |
| `.orp-stack` | Vertical stack layout |
| `.orp-cluster` | Cluster/gap layout |

### Actions

| Class | Description |
|-------|-------------|
| `.orp-btn` | Button base |
| `.orp-btn--primary` | Primary variant |
| `.orp-btn--secondary` | Secondary variant |
| `.orp-btn--ghost` | Ghost variant |
| `.orp-btn--danger` | Danger variant |
| `.orp-btn--sm` | Small size |
| `.orp-btn--lg` | Large size |
| `.orp-btn--block` | Full width |
| `.orp-icon-btn` | Icon button |
| `.orp-icon-btn--sm` | Small icon button |

### Overlays

| Class | Description |
|-------|-------------|
| `.orp-modal` | Modal overlay |
| `.orp-modal__content` | Modal content |
| `.orp-sheet` | Bottom sheet |
| `.orp-drawer` | Side drawer |
| `.orp-popover` | Popover tooltip |
| `.orp-dropdown` | Dropdown menu |

### Feedback

| Class | Description |
|-------|-------------|
| `.orp-alert` | Alert box |
| `.orp-alert--info` | Info variant |
| `.orp-alert--success` | Success variant |
| `.orp-alert--warning` | Warning variant |
| `.orp-alert--danger` | Danger variant |
| `.orp-toast` | Toast notification |
| `.orp-spinner` | Loading spinner |
| `.orp-progress` | Progress bar |
| `.orp-skeleton` | Loading skeleton |
| `.orp-empty-state` | Empty state |

### Forms

| Class | Description |
|-------|-------------|
| `.orp-field` | Form field wrapper |
| `.orp-input` | Text input |
| `.orp-textarea` | Textarea |
| `.orp-select` | Select dropdown |
| `.orp-checkbox` | Checkbox |
| `.orp-radio` | Radio button |
| `.orp-switch` | Toggle switch |
| `.orp-segmented` | Segmented control |

### Data Display

| Class | Description |
|-------|-------------|
| `.orp-avatar` | Avatar |
| `.orp-avatar-group` | Avatar group |
| `.orp-badge` | Badge/Chip |
| `.orp-list` | List |
| `.orp-list--divided` | Divided list |
| `.orp-meta` | Metadata text |
| `.orp-rating` | Star rating |
| `.orp-divider` | Horizontal divider |
| `.orp-price` | Price display |

### Navigation

| Class | Description |
|-------|-------------|
| `.orp-app-bar` | Top app bar |
| `.orp-bottom-nav` | Bottom navigation |
| `.orp-tabs` | Tab navigation |
| `.orp-tabs--pill` | Pill variant |
| `.orp-breadcrumb` | Breadcrumb trail |
| `.orp-pagination` | Pagination |

### Media

| Class | Description |
|-------|-------------|
| `.orp-media` | Media container |
| `.orp-media-card` | Media card |
| `.orp-gallery` | Image gallery |
| `.orp-hero` | Hero section |

### Utilities

| Class | Description |
|-------|-------------|
| `.orp-d-flex` | Flex display |
| `.orp-d-grid` | Grid display |
| `.orp-gap-1` to `.orp-gap-5` | Gap utilities |
| `.orp-p-1` to `.orp-p-5` | Padding |
| `.orp-m-1` to `.orp-m-5` | Margin |
| `.orp-sr-only` | Screen reader only |

---

## CSS Custom Properties (Public Tokens)

### Colors

```css
:root {
  --orp-primary: #3B82F6;
  --orp-primary-foreground: white;
  --orp-secondary: #64748B;
  --orp-secondary-foreground: white;
  --orp-success: #22C55E;
  --orp-warning: #F59E0B;
  --orp-danger: #EF4444;
  --orp-info: #06B6D4;
  --orp-muted: #F4F4F5;
  --orp-muted-foreground: #71717A;
  --orp-border: #E4E4E7;
  --orp-input: #A1A1AA;
  --orp-ring: #3B82F6;
}
```

### Surface

```css
:root {
  --orp-background: white;
  --orp-foreground: #09090B;
  --orp-surface: white;
  --orp-surface-foreground: #09090B;
  --orp-surface-muted: #F4F4F5;
  --orp-muted-foreground: #71717A;
}
```

### Typography

```css
:root {
  --orp-font-family: system-ui, sans-serif;
  --orp-font-size-xs: 0.75rem;
  --orp-font-size-sm: 0.875rem;
  --orp-font-size-md: 1rem;
  --orp-font-size-lg: 1.125rem;
  --orp-font-size-xl: 1.25rem;
  --orp-font-size-2xl: 1.5rem;
}
```

### Spacing

```css
:root {
  --orp-space-1: 0.25rem;
  --orp-space-2: 0.5rem;
  --orp-space-3: 0.75rem;
  --orp-space-4: 1rem;
  --orp-space-5: 1.5rem;
  --orp-space-6: 2rem;
  --orp-space-8: 3rem;
}
```

### Border Radius

```css
:root {
  --orp-radius-sm: 0.25rem;
  --orp-radius-md: 0.5rem;
  --orp-radius-lg: 0.75rem;
  --orp-radius-pill: 999px;
}
```

---

## NOT Public API (Internal)

The following are internal and should not be used directly:

- All LESS files in `less/internal/`
- LESS mixins (consider them private)
- Vue composables starting with `use` that are not documented
- CSS classes prefixed with internal naming
- JavaScript utilities in internal folders

---

## Stability Classification

### Stable
- CSS class names documented here
- CSS custom properties documented here
- Vue component props documented here
- Vue component events documented here

### Experimental
May change before v1.0:
- Some advanced composables
- Some specialized components

### Internal
Will not be documented and may change without notice:
- LESS mixins and internal utilities
- Vue component internal structure
- CSS class names not documented

---

## Changelog

### v0.1.0 (Unreleased)

#### Added
- Initial public API surface
- 30 Vue components
- 75+ CSS components
- 3 composables (useOrpDialog, useOrpNotifications, useOrpTheme)
- Full theming system with light/dark themes
- Comprehensive documentation

---

*Last updated: 2026-09-02*
