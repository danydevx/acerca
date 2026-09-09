<template>
  <div
    class="alert"
    :class="[
      `alert--${type}`,
      `alert--${variant}`,
      { 'alert--dismissible': dismissible },
      { 'alert--bordered': bordered },
    ]"
    role="alert"
  >
    <div class="alert__icon">
      <i :class="iconClass"></i>
    </div>
    <div class="alert__content">
      <h4 v-if="title" class="alert__title">{{ title }}</h4>
      <div class="alert__message">
        <slot>{{ message }}</slot>
      </div>
    </div>
    <div v-if="dismissible || $slots.actions" class="alert__actions">
      <slot name="actions"></slot>
      <button
        v-if="dismissible"
        type="button"
        class="alert__close"
        aria-label="Cerrar"
        @click="handleDismiss"
      >
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
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
  bordered: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },
  icon: {
    type: String,
    default: '',
  },
  dismissible: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['dismiss'])

const icons = {
  info: 'bi bi-info-circle-fill',
  success: 'bi bi-check-circle-fill',
  warning: 'bi bi-exclamation-triangle-fill',
  error: 'bi bi-x-circle-fill',
  tip: 'bi bi-lightbulb-fill',
}

const iconClass = computed(() => props.icon || icons[props.type])

const handleDismiss = () => {
  emit('dismiss')
}
</script>

<style lang="scss" scoped>
.alert {
  display: flex;
  align-items: flex-start;
  gap: 0.875rem;
  padding: 1rem;
  border-radius: var(--bulma-radius);
  border: 1px solid transparent;
  position: relative;
  overflow: hidden;

  &__icon {
    font-size: 1.25rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    margin: 0 0 0.25rem;
    line-height: 1.4;
  }

  &__message {
    font-size: 0.875rem;
    line-height: 1.5;
  }

  &__actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
  }

  &__close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    padding: 0;
    border: none;
    background: transparent;
    cursor: pointer;
    opacity: 0.6;
    border-radius: var(--bulma-radius-small);
    transition: all 0.15s ease;

    &:hover {
      opacity: 1;
      background: oklch(0 0 0 / 0.1);
    }

    i {
      font-size: 0.875rem;
    }
  }

  &--left-accent {
    border-left: 4px solid currentColor;
    border-radius: 0 var(--bulma-radius) var(--bulma-radius) 0;
  }

  &--top-accent {
    border-top: 3px solid currentColor;
    border-radius: 0 0 var(--bulma-radius) var(--bulma-radius);
  }

  &--bordered {
    border-width: 1px;
  }

  &--soft {
    &.alert--info {
      background: color-mix(in oklch, var(--bulma-info) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-info) 25%, transparent);
      color: var(--bulma-info);
    }

    &.alert--success {
      background: color-mix(in oklch, var(--bulma-success) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-success) 25%, transparent);
      color: var(--bulma-success);
    }

    &.alert--warning {
      background: color-mix(in oklch, var(--bulma-warning) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-warning) 25%, transparent);
      color: var(--bulma-warning);
    }

    &.alert--error {
      background: color-mix(in oklch, var(--bulma-danger) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-danger) 25%, transparent);
      color: var(--bulma-danger);
    }

    &.alert--tip {
      background: color-mix(in oklch, var(--bulma-primary) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-primary) 25%, transparent);
      color: var(--bulma-primary);
    }

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }

  &--solid {
    &.alert--info {
      background: var(--bulma-info);
      border-color: var(--bulma-info);
      color: var(--bulma-info-invert);
    }

    &.alert--success {
      background: var(--bulma-success);
      border-color: var(--bulma-success);
      color: var(--bulma-success-invert);
    }

    &.alert--warning {
      background: var(--bulma-warning);
      border-color: var(--bulma-warning);
      color: var(--bulma-warning-invert);
    }

    &.alert--error {
      background: var(--bulma-danger);
      border-color: var(--bulma-danger);
      color: var(--bulma-danger-invert);
    }

    &.alert--tip {
      background: var(--bulma-primary);
      border-color: var(--bulma-primary);
      color: var(--bulma-primary-invert);
    }

    .alert__title,
    .alert__message {
      color: inherit;
    }

    .alert__close {
      color: inherit;
      opacity: 0.8;

      &:hover {
        opacity: 1;
        background: oklch(100% 0 0 / 0.2);
      }
    }
  }

  &--default {
    &.alert--info {
      background: color-mix(in oklch, var(--bulma-info) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-info) 30%, transparent);
      color: var(--bulma-info);
    }

    &.alert--success {
      background: color-mix(in oklch, var(--bulma-success) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-success) 30%, transparent);
      color: var(--bulma-success);
    }

    &.alert--warning {
      background: color-mix(in oklch, var(--bulma-warning) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-warning) 30%, transparent);
      color: var(--bulma-warning);
    }

    &.alert--error {
      background: color-mix(in oklch, var(--bulma-danger) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-danger) 30%, transparent);
      color: var(--bulma-danger);
    }

    &.alert--tip {
      background: color-mix(in oklch, var(--bulma-primary) 10%, transparent);
      border-color: color-mix(in oklch, var(--bulma-primary) 30%, transparent);
      color: var(--bulma-primary);
    }

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }
}
</style>
