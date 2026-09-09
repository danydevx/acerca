<template>
  <component
    :is="tag"
    class="fab"
    :class="[
      variantClass,
      { 'is-fixed': fixed || fixedPosition },
      `is-${size}`,
    ]"
    v-bind="$attrs"
  >
    <span v-if="$slots.icon" class="fab__icon">
      <slot name="icon"></slot>
    </span>
    <span v-if="$slots.default" class="fab__label">
      <slot></slot>
    </span>
  </component>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  tag: { type: String, default: 'button' },
  variant: { type: String, default: 'primary' },
  size: { type: String, default: 'normal' },
  fixed: { type: Boolean, default: false },
  fixedPosition: { type: String, default: null },
})

const variantClass = computed(() => {
  if (props.variant === 'primary') return 'is-primary'
  if (props.variant === 'secondary') return 'is-secondary'
  return `is-${props.variant}`
})
</script>

<style lang="scss" scoped>
.fab {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  min-width: 3.5rem;
  height: 3.5rem;
  padding: 0;
  background: var(--bulma-primary);
  color: var(--bulma-primary-invert);
  border: none;
  border-radius: var(--bulma-radius-large);
  box-shadow: var(--bulma-shadow-large);
  cursor: pointer;
  transition: transform 150ms, box-shadow 150ms;
  font-family: var(--bulma-family-sans-serif);

  &:hover {
    transform: scale(1.05);
    box-shadow: var(--bulma-shadow-large);
  }

  &:active {
    transform: scale(0.98);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  &.is-secondary {
    background: var(--bulma-secondary);
    color: var(--bulma-secondary-invert);
  }

  &.is-fixed,
  &.is-bottom-end {
    position: fixed;
    z-index: 99;
    bottom: calc(3rem + env(safe-area-inset-bottom, 0px));
    right: 1rem;
  }

  &.is-extended {
    min-width: auto;
    padding: 0 1rem;
    border-radius: 9999px;
  }

  &.is-small {
    min-width: 2.5rem;
    height: 2.5rem;
    border-radius: var(--bulma-radius);
  }

  &.is-medium {
    min-width: 3rem;
    height: 3rem;
  }

  &.is-large {
    min-width: 4rem;
    height: 4rem;
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    line-height: 1;
  }

  &__label {
    font-size: var(--bulma-size-medium);
    font-weight: 500;
    white-space: nowrap;
  }
}
</style>
