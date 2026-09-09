<template>
  <Teleport to="body">
    <Transition name="action-sheet">
      <div v-if="modelValue" class="ui-action-sheet dl-bulma-action-sheet">
        <div class="dl-bulma-action-sheet__backdrop" @click="$emit('update:modelValue', false)"></div>
        <div class="dl-bulma-action-sheet__panel">
          <div v-if="title" class="dl-bulma-action-sheet__header is-flex is-justify-content-space-between is-align-items-center p-4">
            <h3 class="dl-bulma-action-sheet__title is-size-6 has-text-weight-semibold">{{ title }}</h3>
            <button class="dl-bulma-action-sheet__close" @click="$emit('update:modelValue', false)">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <div class="dl-bulma-action-sheet__content">
            <slot></slot>
          </div>
          <div v-if="$slots.footer" class="dl-bulma-action-sheet__footer pt-3 px-4 pb-4">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  modelValue: { type: Boolean, default: false },
  title: { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>

<style lang="scss" scoped>
.dl-bulma-action-sheet {
  position: fixed;
  inset: 0;
  z-index: 100;

  &__backdrop {
    position: absolute;
    inset: 0;
    background: oklch(0 0 0 / 0.5);
  }

  &__panel {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--bulma-scheme-main);
    border-radius: 16px 16px 0 0;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 -4px 20px oklch(0 0 0 / 0.15);
  }

  &__header {
    border-bottom: 1px solid var(--bulma-border);
  }

  &__title {
    margin: 0;
    color: var(--bulma-text);
  }

  &__close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.5rem;
    border-radius: 4px;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);
    }
  }

  &__content {
    flex: 1;
    overflow-y: auto;
    padding: 0.5rem 0;
  }

  &__footer {
    border-top: 1px solid var(--bulma-border);
  }
}

.action-sheet-enter-active,
.action-sheet-leave-active {
  transition: opacity 0.3s ease;

  .dl-bulma-action-sheet__panel {
    transition: transform 0.3s ease;
  }
}

.action-sheet-enter-from,
.action-sheet-leave-to {
  opacity: 0;

  .dl-bulma-action-sheet__panel {
    transform: translateY(100%);
  }
}
</style>
