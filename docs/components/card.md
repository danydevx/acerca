# Card

Cards contain related content and actions.

## Basic Card

<DemoFrame>
  <div class="orp-card" style="max-width: 320px;">
    <div class="orp-card__body">
      <h3 class="orp-card__title">Card Title</h3>
      <p class="orp-card__description">This is some description text that provides more information about the card content.</p>
    </div>
  </div>
</DemoFrame>

```html
<div class="orp-card">
  <div class="orp-card__body">
    <h3 class="orp-card__title">Card Title</h3>
    <p class="orp-card__description">Content</p>
  </div>
</div>
```

## Card with Header

<DemoFrame>
  <div class="orp-card" style="max-width: 320px;">
    <div class="orp-card__header">
      <h3 class="orp-card__title">Featured</h3>
    </div>
    <div class="orp-card__body">
      <p>Card body content goes here.</p>
    </div>
    <div class="orp-card__footer">
      <button class="orp-btn orp-btn--primary orp-btn--sm">Action</button>
    </div>
  </div>
</DemoFrame>

## Outlined Variant

<DemoFrame>
  <div class="orp-card orp-card--outlined" style="max-width: 320px;">
    <div class="orp-card__body">
      <h3 class="orp-card__title">Outlined Card</h3>
      <p class="orp-card__description">A card with only border, no shadow.</p>
    </div>
  </div>
</DemoFrame>

```html
<div class="orp-card orp-card--outlined">
  <div class="orp-card__body">
    <h3 class="orp-card__title">Title</h3>
    <p class="orp-card__description">Content</p>
  </div>
</div>
```

## Elevated Variant

<DemoFrame>
  <div class="orp-card orp-card--elevated" style="max-width: 320px;">
    <div class="orp-card__body">
      <h3 class="orp-card__title">Elevated Card</h3>
      <p class="orp-card__description">A card with shadow for emphasis.</p>
    </div>
  </div>
</DemoFrame>

```html
<div class="orp-card orp-card--elevated">
  <div class="orp-card__body">
    <h3 class="orp-card__title">Title</h3>
    <p class="orp-card__description">Content</p>
  </div>
</div>
```

## CSS Classes Reference

| Class | Description |
|-------|-------------|
| `.orp-card` | Base card |
| `.orp-card--outlined` | Bordered card |
| `.orp-card--elevated` | Shadowed card |
| `.orp-card__header` | Card header |
| `.orp-card__body` | Card body |
| `.orp-card__footer` | Card footer |
| `.orp-card__title` | Card title |
| `.orp-card__description` | Card description |

## Composition

Cards are CSS primitives. Compose them as needed:

```html
<div class="orp-card">
  <div class="orp-card__header">
    <span class="orp-badge orp-badge--success">New</span>
    <h3>Title</h3>
  </div>
  <div class="orp-card__body">
    <img src="..." class="orp-card__image" alt="...">
    <p>Description</p>
  </div>
  <div class="orp-card__footer">
    <button class="orp-btn orp-btn--primary">Action</button>
  </div>
</div>
```
