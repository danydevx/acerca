# Input

Text input fields for user data entry.

## Basic Input

<DemoFrame>
  <div style="max-width: 320px;">
    <input type="text" class="orp-input" placeholder="Enter text...">
  </div>
</DemoFrame>

```html
<input type="text" class="orp-input" placeholder="Enter text...">
```

## With Label

<DemoFrame>
  <div style="max-width: 320px;">
    <label class="orp-field">
      <span class="orp-field__label">Email</span>
      <input type="email" class="orp-input" placeholder="you@example.com">
    </label>
  </div>
</DemoFrame>

```html
<label class="orp-field">
  <span class="orp-field__label">Email</span>
  <input type="email" class="orp-input" placeholder="you@example.com">
</label>
```

## With Help Text

<DemoFrame>
  <div style="max-width: 320px;">
    <label class="orp-field">
      <span class="orp-field__label">Password</span>
      <input type="password" class="orp-input" placeholder="Enter password">
      <span class="orp-field__help">Must be at least 8 characters</span>
    </label>
  </div>
</DemoFrame>

## Invalid State

<DemoFrame>
  <div style="max-width: 320px;">
    <label class="orp-field orp-field--invalid">
      <span class="orp-field__label">Email</span>
      <input type="email" class="orp-input" value="invalid-email">
      <span class="orp-field__error">Please enter a valid email</span>
    </label>
  </div>
</DemoFrame>

## Disabled State

<DemoFrame>
  <div style="max-width: 320px;">
    <input type="text" class="orp-input" placeholder="Disabled" disabled>
  </div>
</DemoFrame>

## Sizes

<DemoFrame>
  <div style="display: flex; flex-direction: column; gap: 1rem; max-width: 320px;">
    <input type="text" class="orp-input orp-input--sm" placeholder="Small">
    <input type="text" class="orp-input" placeholder="Medium">
    <input type="text" class="orp-input orp-input--lg" placeholder="Large">
  </div>
</DemoFrame>

## CSS Classes Reference

| Class | Description |
|-------|-------------|
| `.orp-input` | Base input |
| `.orp-input--sm` | Small input |
| `.orp-input--lg` | Large input |
| `.orp-input--error` | Error state |
| `.orp-field` | Field wrapper |
| `.orp-field__label` | Field label |
| `.orp-field__help` | Help text |
| `.orp-field__error` | Error message |
| `.orp-field--invalid` | Invalid state |
