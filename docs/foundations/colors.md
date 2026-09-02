# Colors

ORP UI provides a comprehensive color system with semantic tokens.

## Semantic Colors

### Primary

<DemoFrame>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-primary); border-radius: 8px;"></div>
      <small>Primary</small>
    </div>
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-primary-foreground); border-radius: 8px;"></div>
      <small>On Primary</small>
    </div>
  </div>
</DemoFrame>

### Neutral

<DemoFrame>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-surface); border: 1px solid var(--orp-border); border-radius: 8px;"></div>
      <small>Surface</small>
    </div>
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-surface-muted); border-radius: 8px;"></div>
      <small>Surface Muted</small>
    </div>
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-surface-foreground); border-radius: 8px;"></div>
      <small>Foreground</small>
    </div>
  </div>
</DemoFrame>

### Status Colors

<DemoFrame>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-success); border-radius: 8px;"></div>
      <small>Success</small>
    </div>
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-warning); border-radius: 8px;"></div>
      <small>Warning</small>
    </div>
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-danger); border-radius: 8px;"></div>
      <small>Danger</small>
    </div>
    <div style="width: 80px; text-align: center;">
      <div style="width: 100%; height: 60px; background: var(--orp-info); border-radius: 8px;"></div>
      <small>Info</small>
    </div>
  </div>
</DemoFrame>

## Token Reference

| Token | Default | Purpose |
|-------|---------|---------|
| `--orp-primary` | #3B82F6 | Primary actions |
| `--orp-primary-foreground` | white | Text on primary |
| `--orp-secondary` | #64748B | Secondary actions |
| `--orp-secondary-foreground` | white | Text on secondary |
| `--orp-success` | #22C55E | Success states |
| `--orp-warning` | #F59E0B | Warning states |
| `--orp-danger` | #EF4444 | Error/danger states |
| `--orp-info` | #06B6D4 | Information |
| `--orp-muted` | #F4F4F5 | Subtle backgrounds |
| `--orp-muted-foreground` | #71717A | Secondary text |
| `--orp-border` | #E4E4E7 | Borders |
| `--orp-input` | #A1A1AA | Input borders |
| `--orp-ring` | #3B82F6 | Focus rings |

## Usage

```css
.my-component {
  background: var(--orp-primary);
  color: var(--orp-primary-foreground);
  border: 1px solid var(--orp-border);
}
```

## Dark Theme

In dark mode, all tokens automatically adjust. See the [Theming Guide](/guide/theming) for customization.
