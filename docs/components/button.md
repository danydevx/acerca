# Button

Buttons trigger actions or navigate.

## Basic Example

<DemoFrame>
  <button class="orp-btn">Default</button>
</DemoFrame>

```html
<button class="orp-btn">Default</button>
```

## Variants

<DemoFrame>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <button class="orp-btn orp-btn--primary">Primary</button>
    <button class="orp-btn orp-btn--secondary">Secondary</button>
    <button class="orp-btn orp-btn--ghost">Ghost</button>
    <button class="orp-btn orp-btn--danger">Danger</button>
  </div>
</DemoFrame>

```html
<button class="orp-btn orp-btn--primary">Primary</button>
<button class="orp-btn orp-btn--secondary">Secondary</button>
<button class="orp-btn orp-btn--ghost">Ghost</button>
<button class="orp-btn orp-btn--danger">Danger</button>
```

## Sizes

<DemoFrame>
  <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
    <button class="orp-btn orp-btn--primary orp-btn--sm">Small</button>
    <button class="orp-btn orp-btn--primary">Medium</button>
    <button class="orp-btn orp-btn--primary orp-btn--lg">Large</button>
  </div>
</DemoFrame>

```html
<button class="orp-btn orp-btn--primary orp-btn--sm">Small</button>
<button class="orp-btn orp-btn--primary">Medium</button>
<button class="orp-btn orp-btn--primary orp-btn--lg">Large</button>
```

## With Icons

<DemoFrame>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <button class="orp-btn orp-btn--primary">
      <i class="bi bi-plus orp-icon"></i>
      Add Item
    </button>
    <button class="orp-btn orp-btn--secondary">
      <i class="bi bi-download orp-icon"></i>
      Download
    </button>
  </div>
</DemoFrame>

```html
<button class="orp-btn orp-btn--primary">
  <i class="bi bi-plus orp-icon"></i>
  Add Item
</button>
```

## Disabled State

<DemoFrame>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <button class="orp-btn orp-btn--primary" disabled>Disabled</button>
    <button class="orp-btn orp-btn--secondary" disabled>Disabled</button>
  </div>
</DemoFrame>

```html
<button class="orp-btn orp-btn--primary" disabled>Disabled</button>
```

## Block Button

<DemoFrame>
  <div style="width: 100%;">
    <button class="orp-btn orp-btn--primary orp-btn--block">Full Width</button>
  </div>
</DemoFrame>

```html
<button class="orp-btn orp-btn--primary orp-btn--block">Full Width</button>
```

## CSS Classes Reference

| Class | Description |
|-------|-------------|
| `.orp-btn` | Base button |
| `.orp-btn--primary` | Primary variant |
| `.orp-btn--secondary` | Secondary variant |
| `.orp-btn--ghost` | Ghost variant |
| `.orp-btn--danger` | Danger variant |
| `.orp-btn--sm` | Small size |
| `.orp-btn--lg` | Large size |
| `.orp-btn--block` | Full width |
| `:disabled` | Disabled state |

## Accessibility

- Use `<button>` element for actions
- Provide `aria-label` for icon-only buttons
- Use `disabled` attribute, not `aria-disabled`
- Ensure sufficient color contrast (4.5:1 minimum)
