# Installation

## Requirements

- Vue 3.5+
- Modern browser (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)

## Package Installation

```bash
npm install orp-ui
```

Or with yarn:

```bash
yarn add orp-ui
```

Or with pnpm:

```bash
pnpm add orp-ui
```

## CSS Setup

### Full CSS Bundle

```javascript
import 'orp-ui/dist/orp-ui.css'
```

### LESS Source (Advanced)

```javascript
import 'orp-ui/less/orp-ui.less'
```

## Vue Components

### Individual Import

```javascript
import { OrpButton } from 'orp-ui'
import { OrpModal } from 'orp-ui'
import { OrpCard } from 'orp-ui'
```

### Tree Shaking

All components support tree shaking when using a bundler like Vite or webpack.

```javascript
import { 
  OrpButton,
  OrpCard,
  OrpModal,
  OrpTabs,
  OrpToast 
} from 'orp-ui'
```

## Optional Integrations

### Bootstrap Icons

```bash
npm install bootstrap-icons
```

```html
<link rel="stylesheet" href="bootstrap-icons/font/bootstrap-icons.css">
```

### Swiper (for Carousels)

```bash
npm install swiper
```

### GLightbox (for Lightboxes)

```bash
npm install glightbox
```

## Verifying Installation

Create a simple test:

```html
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="orp-ui/dist/orp-ui.css">
</head>
<body>
  <button class="orp-btn orp-btn--primary">Hello ORP</button>
</body>
</html>
```

## CDN Usage (Development Only)

```html
<link rel="stylesheet" href="https://unpkg.com/orp-ui/dist/orp-ui.css">
```
