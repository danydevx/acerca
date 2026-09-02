# Modal

Modals overlay the screen to focus user attention.

## Basic Modal

<DemoFrame>
  <div class="orp-modal" style="position: relative; max-width: 400px;">
    <div class="orp-modal__content">
      <div class="orp-modal__header">
        <h3 class="orp-modal__title">Modal Title</h3>
        <button class="orp-modal__close" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <div class="orp-modal__body">
        <p>This is the modal body content. It can contain any HTML.</p>
      </div>
      <div class="orp-modal__footer">
        <button class="orp-btn orp-btn--ghost">Cancel</button>
        <button class="orp-btn orp-btn--primary">Confirm</button>
      </div>
    </div>
  </div>
</DemoFrame>

## Alert Dialog

<DemoFrame>
  <div class="orp-modal" style="position: relative; max-width: 400px;">
    <div class="orp-modal__content">
      <div class="orp-modal__header">
        <h3 class="orp-modal__title">Alert</h3>
        <button class="orp-modal__close" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
      <div class="orp-modal__body">
        <div class="orp-alert orp-alert--danger">
          <div class="orp-alert__icon"><i class="bi bi-exclamation-triangle"></i></div>
          <div class="orp-alert__content">
            <div class="orp-alert__title">Warning</div>
            <div class="orp-alert__message">This action cannot be undone.</div>
          </div>
        </div>
      </div>
      <div class="orp-modal__footer">
        <button class="orp-btn orp-btn--danger">Delete</button>
      </div>
    </div>
  </div>
</DemoFrame>

## CSS Classes Reference

| Class | Description |
|-------|-------------|
| `.orp-modal` | Base modal overlay |
| `.orp-modal__content` | Modal content container |
| `.orp-modal__header` | Modal header |
| `.orp-modal__title` | Modal title |
| `.orp-modal__close` | Close button |
| `.orp-modal__body` | Modal body |
| `.orp-modal__footer` | Modal footer |

## Vue Component Props

When using `OrpModal.vue`:

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | Boolean | false | Show/hide modal |
| `title` | String | '' | Modal title |
| `size` | String | 'md' | sm, md, lg |
| `closable` | Boolean | true | Show close button |
| `closeOnBackdrop` | Boolean | true | Close when clicking outside |

## Events

| Event | Payload | Description |
|-------|---------|-------------|
| `update:modelValue` | Boolean | Sync visibility |
| `close` | - | Modal closed |

## Accessibility

- Focus trap inside modal
- Escape key closes modal
- Click outside closes modal
- Focus returns to trigger element on close
