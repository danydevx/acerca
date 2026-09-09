<template>
  <div
    class="inline-message"
    :class="[
      `inline-message--${type}`,
      `inline-message--${variant}`,
      { 'inline-message--dismissible': dismissible },
      { 'inline-message--with-title': title },
    ]"
    role="alert"
  >
    <i class="inline-message__icon" :class="iconClass"></i>
    <div class="inline-message__content">
      <span v-if="title" class="inline-message__title">{{ title }}</span>
      <span v-if="message" class="inline-message__message">{{ message }}</span>
    </div>
    <button
      v-if="dismissible"
      type="button"
      class="inline-message__dismiss"
      aria-label="Cerrar"
      @click="$emit('dismiss')"
    >
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'info',
    validator: (v) => ['info', 'success', 'warning', 'error', 'tip'].includes(v),
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'soft', 'solid', 'left-accent', 'top-accent'].includes(v),
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },
  dismissible: {
    type: Boolean,
    default: false,
  },
  icon: {
    type: String,
    default: '',
  },
})

defineEmits(['dismiss'])

const iconMap = {
  info: 'bi bi-info-circle',
  success: 'bi bi-check-circle',
  warning: 'bi bi-exclamation-circle',
  error: 'bi bi-exclamation-triangle',
  tip: 'bi bi-lightbulb',
}

const iconClass = computed(() => props.icon || iconMap[props.type])
</script>

<style lang="scss" scoped>
.inline-message {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  border-radius: var(--bulma-radius);
  border: 1px solid transparent;
  position: relative;

  &__icon {
    font-size: 1rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
  }

  &__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &--with-title &__content {
    gap: 0.25rem;
  }

  &__title {
    font-size: 0.875rem;
    font-weight: 600;
    line-height: 1.4;
  }

  &__message {
    font-size: 0.8125rem;
    line-height: 1.5;
    color: var(--bulma-text);
  }

  &__dismiss {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    padding: 0;
    border: none;
    background: transparent;
    opacity: 0.5;
    cursor: pointer;
    border-radius: var(--bulma-radius-small);
    transition: all 0.15s ease;
    margin: -0.125rem -0.25rem 0 0;

    &:hover {
      opacity: 1;
      background: oklch(0 0 0 / 0.1);
    }

    i {
      font-size: 0.75rem;
    }
  }

  &--left-accent {
    border-left: 3px solid currentColor;
    border-radius: 0 var(--bulma-radius) var(--bulma-radius) 0;
    padding-left: 1rem;
  }

  &--top-accent {
    border-top: 2px solid currentColor;
    border-radius: 0 0 var(--bulma-radius) var(--bulma-radius);
  }

  &--soft {
    &.inline-message--info {
      background: color-mix(in oklch, var(--bulma-info) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-info) 20%, transparent);
      color: var(--bulma-info);
    }

    &.inline-message--success {
      background: color-mix(in oklch, var(--bulma-success) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-success) 20%, transparent);
      color: var(--bulma-success);
    }

    &.inline-message--warning {
      background: color-mix(in oklch, var(--bulma-warning) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-warning) 20%, transparent);
      color: var(--bulma-warning);
    }

    &.inline-message--error {
      background: color-mix(in oklch, var(--bulma-danger) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-danger) 20%, transparent);
      color: var(--bulma-danger);
    }

    &.inline-message--tip {
      background: color-mix(in oklch, var(--bulma-primary) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-primary) 20%, transparent);
      color: var(--bulma-primary);
    }
  }

  &--solid {
    &.inline-message--info {
      background: var(--bulma-info);
      color: var(--bulma-info-invert);
    }

    &.inline-message--success {
      background: var(--bulma-success);
      color: var(--bulma-success-invert);
    }

    &.inline-message--warning {
      background: var(--bulma-warning);
      color: var(--bulma-warning-invert);
    }

    &.inline-message--error {
      background: var(--bulma-danger);
      color: var(--bulma-danger-invert);
    }

    &.inline-message--tip {
      background: var(--bulma-primary);
      color: var(--bulma-primary-invert);
    }

    .inline-message__title,
    .inline-message__message {
      color: inherit;
    }

    .inline-message__dismiss {
      color: inherit;
      opacity: 0.7;

      &:hover {
        opacity: 1;
        background: oklch(100% 0 0 / 0.2);
      }
    }
  }

  &--default {
    &.inline-message--info {
      background: color-mix(in oklch, var(--bulma-info) 8%, transparent);
      border-color: color-mix(in oklch, var(--bulma-info) 25%, transparent);
      color: var(--bulma-info);
    }

    &.inline-message--success {
      background: color-mix(in oklch, var(--bulma-success) 8%, transparent);
      border-color: color-mix(in oklch, var(--bulma-success) 25%, transparent);
      color: var(--bulma-success);
    }

    &.inline-message--warning {
      background: color-mix(in oklch, var(--bulma-warning) 8%, transparent);
      border-color: color-mix(in oklch, var(--bulma-warning) 25%, transparent);
      color: var(--bulma-warning);
    }

    &.inline-message--error {
      background: color-mix(in oklch, var(--bulma-danger) 8%, transparent);
      border-color: color-mix(in oklch, var(--bulma-danger) 25%, transparent);
      color: var(--bulma-danger);
    }

    &.inline-message--tip {
      background: color-mix(in oklch, var(--bulma-primary) 8%, transparent);
      border-color: color-mix(in oklch, var(--bulma-primary) 25%, transparent);
      color: var(--bulma-primary);
    }
  }
}
</style>
