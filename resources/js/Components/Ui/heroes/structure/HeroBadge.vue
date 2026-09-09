<template>
  <span
    class="hero-badge"
    :class="[
      `hero-badge--${variant}`,
      `hero-badge--${size}`,
      { 'hero-badge--rounded': rounded }
    ]"
  >
    <i v-if="icon" class="hero-badge__icon" :class="icon"></i>
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
.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  font-weight: 500;
  white-space: nowrap;

  &--sm {
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
  }

  &--md {
    font-size: 0.6875rem;
    padding: 0.25rem 0.5rem;
  }

  &--lg {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
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

  &__icon {
    font-size: 0.875em;
  }
}
</style>
