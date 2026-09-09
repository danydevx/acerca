<template>
  <div class="quick-actions" :class="[`quick-actions--${variant}`]">
    <button
      v-for="(action, index) in actions"
      :key="index"
      class="quick-actions__item"
      @click="$emit('select', action, index)"
    >
      <span v-if="action.icon" class="quick-actions__icon">
        <i :class="action.icon"></i>
      </span>
      <span class="quick-actions__label">{{ action.label }}</span>
      <kbd v-if="action.shortcut" class="quick-actions__shortcut">{{ action.shortcut }}</kbd>
    </button>
  </div>
</template>

<script setup>
defineProps({
  actions: {
    type: Array,
    default: () => [],
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'compact'].includes(v),
  },
})

defineEmits(['select'])
</script>

<style lang="scss" scoped>
.quick-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;

  &--compact {
    gap: 0.25rem;
  }

  &__item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    cursor: pointer;
    transition: all 150ms;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      border-color: var(--bulma-border-hover);
    }

    &:active {
      transform: scale(0.98);
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 1rem;
    }
  }

  &__label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__shortcut {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 1.5rem;
    height: 1.5rem;
    padding: 0 0.375rem;
    background: var(--bulma-scheme-main-bis);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-small);
    font-family: var(--bulma-family-sans-serif);
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--bulma-text-weak);
    margin-left: 0.5rem;
  }

  &--compact {
    .quick-actions__item {
      padding: 0.375rem 0.5rem;
    }

    .quick-actions__label {
      font-size: 0.8125rem;
    }
  }
}
</style>
