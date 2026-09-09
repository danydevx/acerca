<template>
  <div
    class="interactive-card"
    :class="{ 'is-interactive': interactive, 'is-disabled': disabled }"
    tabindex="0"
    @click="interactive && $emit('click')"
    @keydown.enter="interactive && $emit('click')"
  >
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  interactive: { type: Boolean, default: true },
  disabled: { type: Boolean, default: false },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
.interactive-card {
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  padding: 1.5rem;
  transition: all 150ms;

  &.is-interactive {
    cursor: pointer;

    &:hover {
      box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
      transform: translateY(-2px);
    }

    &:focus {
      outline: none;
      box-shadow: 0 0 0 3px color-mix(in oklch, var(--bulma-link) 30%, transparent);
    }

    &:active {
      transform: translateY(0);
    }
  }

  &.is-disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
  }
}
</style>
