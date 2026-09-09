<template>
  <div class="keyboard-shortcut" :class="[`keyboard-shortcut--${size}`]">
    <kbd class="keyboard-shortcut__key">{{ key }}</kbd>
    <span v-if="label" class="keyboard-shortcut__label">{{ label }}</span>
  </div>
</template>

<script setup>
defineProps({
  key: { type: String, required: true },
  label: { type: String, default: '' },
  size: {
    type: String,
    default: 'default',
    validator: (v) => ['small', 'default', 'large'].includes(v),
  },
})
</script>

<style lang="scss" scoped>
.keyboard-shortcut {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;

  &__key {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2rem;
    height: 2rem;
    padding: 0 0.5rem;
    background: var(--bulma-scheme-main-bis) !important;
    border: 1px solid var(--bulma-border) !important;
    border-radius: var(--bulma-radius) !important;
    font-family: var(--bulma-family-sans-serif) !important;
    font-size: 0.875rem !important;
    font-weight: 500 !important;
    color: var(--bulma-text) !important;
    box-shadow: 0 1px 2px oklch(0 0 0 / 0.05) !important;
    white-space: nowrap;
  }

  &__label {
    font-size: 0.875rem;
    color: var(--bulma-text-light);
  }

  &--small {
    .keyboard-shortcut__key {
      min-width: 1.5rem;
      height: 1.5rem;
      font-size: 0.75rem;
      padding: 0 0.375rem;
    }

    .keyboard-shortcut__label {
      font-size: 0.75rem;
    }
  }

  &--large {
    .keyboard-shortcut__key {
      min-width: 2.5rem;
      height: 2.5rem;
      font-size: 1rem;
      padding: 0 0.75rem;
    }

    .keyboard-shortcut__label {
      font-size: 1rem;
    }
  }
}
</style>
