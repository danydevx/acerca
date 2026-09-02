# Theming

ORP UI uses CSS custom properties (variables) for theming at runtime.

## Architecture

### LESS Variables (Build-time)

```less
@orp-primary: #3B82F6;
@orp-radius-md: 8px;
```

### CSS Custom Properties (Runtime)

```css
:root {
  --orp-primary: #3B82F6;
  --orp-radius-md: 8px;
}
```

## Theme Hierarchy

1. **CSS Reset** - Base styles
2. **Foundation** - Tokens and variables
3. **Components** - Component-specific styles
4. **Custom Theme** - User overrides

## Built-in Themes

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
  --orp-secondary: #ff7043;
  --orp-background: #fff3e0;
}
```

## Semantic Tokens

### Colors

| Token | Light | Dark | Purpose |
|-------|-------|------|---------|
| `--orp-primary` | #3B82F6 | #60A5FA | Primary actions |
| `--orp-success` | #22C55E | #4ADE80 | Success states |
| `--orp-warning` | #F59E0B | #FBBF24 | Warnings |
| `--orp-danger` | #EF4444 | #F87171 | Errors |
| `--orp-info` | #06B6D4 | #22D3EE | Information |

### Surface Tokens

| Token | Purpose |
|-------|---------|
| `--orp-surface` | Main background |
| `--orp-surface-foreground` | Main text |
| `--orp-surface-muted` | Subtle backgrounds |
| `--orp-muted-foreground` | Secondary text |

### Border Tokens

| Token | Purpose |
|-------|---------|
| `--orp-border` | Default borders |
| `--orp-input` | Input borders |

## Creating a Custom Theme

```css
[data-orp-theme="ocean"] {
  /* Primary colors */
  --orp-primary: #0EA5E9;
  --orp-primary-foreground: white;
  
  /* Surface colors */
  --orp-surface: #F0F9FF;
  --orp-surface-foreground: #0C4A6E;
  
  /* Border colors */
  --orp-border: #BAE6FD;
  
  /* Shadows */
  --orp-shadow-sm: 0 1px 2px rgba(14, 165, 233, 0.1);
  --orp-shadow-md: 0 4px 6px rgba(14, 165, 233, 0.15);
}
```

## Theme Toggle

Use the `data-orp-theme` attribute on the `<html>` element:

```javascript
const toggleTheme = (theme) => {
  document.documentElement.setAttribute('data-orp-theme', theme)
}
```

## System Theme Detection

```javascript
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)')

const applySystemTheme = () => {
  document.documentElement.setAttribute(
    'data-orp-theme',
    prefersDark.matches ? 'dark' : 'light'
  )
}

prefersDark.addEventListener('change', applySystemTheme)
```
