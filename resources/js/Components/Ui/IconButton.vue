<template>
  <button
    class="ui-icon-btn dl-bulma-icon-btn is-inline-flex is-justify-content-center is-align-items-center"
    :class="[`dl-bulma-icon-btn--${variant}`, `dl-bulma-icon-btn--${size}`, { 'is-disabled': disabled }]"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
    <slot></slot>
  </button>
</template>

<script setup>
defineProps({
  variant: { type: String, default: 'primary' },
  size: { type: String, default: 'md' },
  disabled: { type: Boolean, default: false },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
.dl-bulma-icon-btn {
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.15s ease;
  font-family: inherit;

  &:focus {
    outline: none;
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  &--primary {
    background: var(--bulma-primary);
    color: var(--bulma-primary-invert);

    &:hover:not(.is-disabled) {
      background: color-mix(in oklch, var(--bulma-primary) 90%, black);
    }
  }

  &--secondary {
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text);

    &:hover:not(.is-disabled) {
      background: var(--bulma-border);
    }
  }

  &--success {
    background: var(--bulma-success);
    color: var(--bulma-success-invert);

    &:hover:not(.is-disabled) {
      background: color-mix(in oklch, var(--bulma-success) 90%, black);
    }
  }

  &--danger {
    background: var(--bulma-danger);
    color: var(--bulma-danger-invert);

    &:hover:not(.is-disabled) {
      background: color-mix(in oklch, var(--bulma-danger) 90%, black);
    }
  }

  &--warning {
    background: var(--bulma-warning);
    color: var(--bulma-warning-invert);

    &:hover:not(.is-disabled) {
      background: color-mix(in oklch, var(--bulma-warning) 90%, black);
    }
  }

  &--info {
    background: var(--bulma-info);
    color: var(--bulma-info-invert);

    &:hover:not(.is-disabled) {
      background: color-mix(in oklch, var(--bulma-info) 90%, black);
    }
  }

  &--ghost {
    background: transparent;
    color: var(--bulma-text);

    &:hover:not(.is-disabled) {
      background: var(--bulma-scheme-main-bis);
    }
  }

  &--outline {
    background: transparent;
    color: var(--bulma-link);
    border: 1px solid var(--bulma-link);

    &:hover:not(.is-disabled) {
      background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main));
    }
  }

  &--sm {
    width: 32px;
    height: 32px;
  }

  &--md {
    width: 40px;
    height: 40px;
  }

  &--lg {
    width: 48px;
    height: 48px;
  }

  &.is-disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
}
</style>
