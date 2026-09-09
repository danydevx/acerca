<template>
  <div
    class="callout"
    :class="[
      `callout--${type}`,
      `callout--${variant}`,
      { 'callout--dismissible': dismissible },
      { 'callout--bordered': bordered },
    ]"
  >
    <div class="callout__icon">
      <i :class="iconName"></i>
    </div>
    <div class="callout__content">
      <div v-if="title" class="callout__title">{{ title }}</div>
      <div class="callout__body">
        <slot>{{ message }}</slot>
      </div>
    </div>
    <button v-if="dismissible" class="callout__close" aria-label="Dismiss" @click="$emit('dismiss')">
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
    validator: (v) => ['info', 'success', 'warning', 'danger', 'tip'].includes(v),
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
  title: { type: String, default: '' },
  message: { type: String, default: '' },
  icon: { type: String, default: '' },
  dismissible: { type: Boolean, default: false },
})

defineEmits(['dismiss'])

const iconName = computed(() => {
  if (props.icon) return props.icon

  const icons = {
    info: 'bi bi-info-circle-fill',
    success: 'bi bi-check-circle-fill',
    warning: 'bi bi-exclamation-triangle-fill',
    danger: 'bi bi-x-circle-fill',
    tip: 'bi bi-lightbulb-fill',
  }
  return icons[props.type] || icons.info
})
</script>

<style lang="scss" scoped>
.callout {
  display: flex;
  align-items: flex-start;
  gap: 0.875rem;
  padding: 1rem;
  border-radius: var(--bulma-radius);
  border: 1px solid transparent;
  position: relative;
  overflow: hidden;

  &__icon {
    flex-shrink: 0;
    font-size: 1.25rem;
    margin-top: 0.125rem;
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    line-height: 1.4;
  }

  &__body {
    font-size: 0.875rem;
    line-height: 1.5;
  }

  &__close {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.25rem;
    border-radius: var(--bulma-radius-small);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    transition: all 0.15s ease;

    &:hover {
      background: oklch(0 0 0 / 0.1);
      color: var(--bulma-text);
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

  &--soft,
  &--default {
    &.callout--info {
      background: color-mix(in oklch, var(--bulma-info) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-info) 25%, transparent);
      color: var(--bulma-info);

      .callout__icon { color: var(--bulma-info); }
    }

    &.callout--success {
      background: color-mix(in oklch, var(--bulma-success) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-success) 25%, transparent);
      color: var(--bulma-success);

      .callout__icon { color: var(--bulma-success); }
    }

    &.callout--warning {
      background: color-mix(in oklch, var(--bulma-warning) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-warning) 25%, transparent);
      color: var(--bulma-warning);

      .callout__icon { color: var(--bulma-warning); }
    }

    &.callout--danger {
      background: color-mix(in oklch, var(--bulma-danger) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-danger) 25%, transparent);
      color: var(--bulma-danger);

      .callout__icon { color: var(--bulma-danger); }
    }

    &.callout--tip {
      background: color-mix(in oklch, var(--bulma-primary) 12%, transparent);
      border-color: color-mix(in oklch, var(--bulma-primary) 25%, transparent);
      color: var(--bulma-primary);

      .callout__icon { color: var(--bulma-primary); }
    }
  }

  &--solid {
    &.callout--info {
      background: var(--bulma-info);
      border-color: var(--bulma-info);
      color: var(--bulma-info-invert);

      .callout__icon { color: var(--bulma-info-invert); }
      .callout__close { color: var(--bulma-info-invert); }
    }

    &.callout--success {
      background: var(--bulma-success);
      border-color: var(--bulma-success);
      color: var(--bulma-success-invert);

      .callout__icon { color: var(--bulma-success-invert); }
      .callout__close { color: var(--bulma-success-invert); }
    }

    &.callout--warning {
      background: var(--bulma-warning);
      border-color: var(--bulma-warning);
      color: var(--bulma-warning-invert);

      .callout__icon { color: var(--bulma-warning-invert); }
      .callout__close { color: var(--bulma-warning-invert); }
    }

    &.callout--danger {
      background: var(--bulma-danger);
      border-color: var(--bulma-danger);
      color: var(--bulma-danger-invert);

      .callout__icon { color: var(--bulma-danger-invert); }
      .callout__close { color: var(--bulma-danger-invert); }
    }

    &.callout--tip {
      background: var(--bulma-primary);
      border-color: var(--bulma-primary);
      color: var(--bulma-primary-invert);

      .callout__icon { color: var(--bulma-primary-invert); }
      .callout__close { color: var(--bulma-primary-invert); }
    }
  }

  &--dismissible {
    padding-right: 3rem;
  }
}
</style>
