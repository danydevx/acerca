<template>
  <Transition name="selection-bar">
    <div v-if="visible" class="selection-bar">
      <div class="selection-bar__content">
        <div class="selection-bar__info">
          <span class="selection-bar__count">{{ selectedCount }}</span>
          <span class="selection-bar__label">{{ label }}</span>
        </div>

        <div class="selection-bar__actions">
          <slot></slot>
        </div>

        <button class="selection-bar__close" @click="$emit('close')">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
  </Transition>
</template>

<script setup>
defineProps({
  visible: { type: Boolean, default: false },
  selectedCount: { type: Number, default: 0 },
  label: { type: String, default: 'selected' },
})

defineEmits(['close'])
</script>

<style lang="scss" scoped>
.selection-bar {
  position: fixed;
  bottom: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 50;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  box-shadow: 0 4px 20px oklch(0 0 0 / 0.15);
  padding: 0.75rem 1rem;

  &__content {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  &__info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__count {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 1.75rem;
    height: 1.75rem;
    background: var(--bulma-primary);
    color: var(--bulma-primary-invert);
    border-radius: 50%;
    font-size: 0.875rem;
    font-weight: 600;
  }

  &__label {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
  }

  &__close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background: none;
    border: none;
    border-radius: var(--bulma-radius);
    color: var(--bulma-text-weak);
    cursor: pointer;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);
    }
  }
}

.selection-bar-enter-active,
.selection-bar-leave-active {
  transition: all 0.3s ease;
}

.selection-bar-enter-from,
.selection-bar-leave-to {
  opacity: 0;
  transform: translateX(-50%) translateY(20px);
}
</style>
