<template>
  <span
    class="menu-badge"
    :class="[
      `menu-badge--${variant}`,
      `menu-badge--${size}`,
      { 'menu-badge--rounded': rounded }
    ]"
  >
    <i v-if="icon" class="menu-badge__icon" :class="icon"></i>
    <slot>{{ text }}</slot>
  </span>
</template>

<script setup>
defineProps({
  text: {
    type: String,
    default: '',
  },
  icon: {
    type: String,
    default: '',
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => [
      'default',
      'primary',
      'secondary',
      'success',
      'warning',
      'danger',
      'info',
      'new',
      'popular',
      'spicy',
      'vegetarian',
      'vegan',
    ].includes(v),
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  rounded: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.menu-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  font-weight: 600;
  white-space: nowrap;

  &--sm {
    font-size: 0.5625rem;
    padding: 0.0625rem 0.25rem;
  }

  &--md {
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
  }

  &--lg {
    font-size: 0.6875rem;
    padding: 0.25rem 0.5rem;
  }

  &--rounded {
    border-radius: var(--bulma-radius-rounded);
  }

  &--default {
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text);
  }

  &--primary {
    background: var(--bulma-primary);
    color: var(--bulma-primary-invert);
  }

  &--secondary {
    background: var(--bulma-scheme-main-ter);
    color: var(--bulma-text);
  }

  &--success {
    background: var(--bulma-success);
    color: white;
  }

  &--warning {
    background: var(--bulma-warning);
    color: var(--bulma-warning-invert);
  }

  &--danger {
    background: var(--bulma-danger);
    color: var(--bulma-danger-invert);
  }

  &--info {
    background: var(--bulma-info);
    color: var(--bulma-info-invert);
  }

  &--new {
    background: linear-gradient(135deg, var(--bulma-primary) 0%, var(--bulma-link) 100%);
    color: white;
  }

  &--popular {
    background: var(--bulma-warning);
    color: var(--bulma-warning-invert);
  }

  &--spicy {
    background: oklch(65% 0.18 25);
    color: white;
  }

  &--vegetarian {
    background: oklch(60% 0.15 140);
    color: oklch(25% 0.15 140);
  }

  &--vegan {
    background: oklch(60% 0.15 130);
    color: oklch(25% 0.15 130);
  }

  &__icon {
    font-size: 0.875em;
  }
}
</style>
