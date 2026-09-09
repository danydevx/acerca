<template>
  <Teleport to="body">
    <Transition name="sheet">
      <div
        v-if="modelValue"
        class="ui-sheet dl-bulma-sheet"
        @click.self="closeOnBackdrop && close()"
      >
        <div class="dl-bulma-sheet__backdrop" @click="closeOnBackdrop && close()"></div>
        <section
          class="dl-bulma-sheet__panel"
          :class="`dl-bulma-sheet__panel--${height}`"
          role="dialog"
          aria-modal="true"
        >
          <div v-if="showHandle" class="dl-bulma-sheet__handle"></div>
          <header class="dl-bulma-sheet__header">
            <h2 v-if="title" class="dl-bulma-sheet__title">{{ title }}</h2>
            <button class="dl-bulma-sheet__close" aria-label="Close" @click="close">
              <i class="bi bi-x-lg"></i>
            </button>
          </header>
          <p v-if="description" class="dl-bulma-sheet__description">{{ description }}</p>
          <div class="dl-bulma-sheet__body">
            <slot></slot>
          </div>
          <footer v-if="$slots.footer" class="dl-bulma-sheet__footer">
            <slot name="footer"></slot>
          </footer>
        </section>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: ''
  },
  description: {
    type: String,
    default: ''
  },
  showHandle: {
    type: Boolean,
    default: true
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  },
  height: {
    type: String,
    default: 'auto',
    validator: (v) => ['auto', 'half', 'large'].includes(v)
  }
})

const emit = defineEmits(['update:modelValue', 'open', 'close'])

const close = () => {
  emit('update:modelValue', false)
  emit('close')
}
</script>

<style lang="scss" scoped>
.dl-bulma-sheet {
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
    display: flex;
    flex-direction: column;
    box-shadow: 0 -4px 20px oklch(0 0 0 / 0.15);
    max-height: 90vh;
    overflow: hidden;

    &--auto {
      height: auto;
    }

    &--half {
      height: 50vh;
    }

    &--large {
      height: 90vh;
    }
  }

  &__handle {
    width: 36px;
    height: 4px;
    background: var(--bulma-border);
    border-radius: 2px;
    margin: 0.75rem auto;
    flex-shrink: 0;
  }

  &__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem 0;
    flex-shrink: 0;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
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

  &__description {
    padding: 0.5rem 1rem 0;
    color: var(--bulma-text-weak);
    font-size: 0.875rem;
    margin: 0;
  }

  &__body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
  }

  &__footer {
    padding: 0 1rem 1rem;
    flex-shrink: 0;
  }
}

.sheet-enter-active,
.sheet-leave-active {
  transition: opacity 0.3s ease;

  .dl-bulma-sheet__panel {
    transition: transform 0.3s ease;
  }
}

.sheet-enter-from,
.sheet-leave-to {
  opacity: 0;

  .dl-bulma-sheet__panel {
    transform: translateY(100%);
  }
}
</style>
