<template>
  <Teleport to="body">
    <Transition name="dialog">
      <div
        v-if="modelValue"
        class="ui-dialog dl-bulma-dialog"
        role="dialog"
        aria-modal="true"
        @click.self="closeOnBackdrop && close()"
        @keydown.esc="handleEscape"
      >
        <div class="dl-bulma-dialog__backdrop" @click="closeOnBackdrop && close()"></div>
        <div
          class="dl-bulma-dialog__panel"
          :class="`dl-bulma-dialog__panel--${size}`"
        >
          <div v-if="hasHeader" class="dl-bulma-dialog__header">
            <div class="dl-bulma-dialog__header-content">
              <div v-if="icon || tone !== 'neutral'" class="dl-bulma-dialog__icon" :class="`dl-bulma-dialog__icon--${tone}`">
                <i :class="['bi', iconClass]" aria-hidden="true"></i>
              </div>
              <div class="dl-bulma-dialog__header-text">
                <h2 v-if="title" class="dl-bulma-dialog__title">{{ title }}</h2>
                <p v-if="description" class="dl-bulma-dialog__description">{{ description }}</p>
              </div>
            </div>
            <button
              v-if="showClose && dismissible"
              class="dl-bulma-dialog__close"
              aria-label="Close"
              @click="close"
            >
              <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
          </div>

          <div class="dl-bulma-dialog__body">
            <slot></slot>
          </div>

          <div
            v-if="$slots.actions"
            class="dl-bulma-dialog__actions"
            :class="{ 'dl-bulma-dialog__actions--vertical': verticalActions }"
          >
            <slot name="actions"></slot>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed } from 'vue'

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
  tone: {
    type: String,
    default: 'neutral',
    validator: (v) => ['neutral', 'info', 'success', 'warning', 'danger'].includes(v)
  },
  icon: {
    type: String,
    default: ''
  },
  size: {
    type: String,
    default: 'sm',
    validator: (v) => ['sm', 'md', 'lg'].includes(v)
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  },
  dismissible: {
    type: Boolean,
    default: true
  },
  verticalActions: {
    type: Boolean,
    default: false
  },
  showClose: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue', 'close', 'confirm', 'cancel'])

const close = () => {
  if (!props.dismissible) return
  emit('update:modelValue', false)
  emit('close')
}

const handleEscape = () => {
  if (props.closeOnBackdrop && props.dismissible) {
    close()
  }
}

const iconMap = {
  neutral: 'bi-info-circle',
  info: 'bi-info-circle',
  success: 'bi-check-circle',
  warning: 'bi-exclamation-triangle',
  danger: 'bi-x-circle'
}

const iconClass = computed(() => {
  if (props.icon) return props.icon
  return iconMap[props.tone] || iconMap.neutral
})

const hasHeader = computed(() => props.title || props.description || (props.showClose && props.dismissible))
</script>

<style lang="scss" scoped>
.dl-bulma-dialog {
  position: fixed;
  inset: 0;
  z-index: 100;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;

  &__backdrop {
    position: absolute;
    inset: 0;
    background: oklch(0 0 0 / 0.5);
  }

  &__panel {
    position: relative;
    background: var(--bulma-scheme-main);
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px oklch(0 0 0 / 0.25);
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;

    &--sm {
      width: 100%;
      max-width: 400px;
    }

    &--md {
      width: 100%;
      max-width: 500px;
    }

    &--lg {
      width: 100%;
      max-width: 800px;
    }
  }

  &__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1.25rem 1.25rem 0;
    gap: 1rem;
  }

  &__header-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    flex: 1;
  }

  &__icon {
    font-size: 1.5rem;
    flex-shrink: 0;

    &--neutral { color: var(--bulma-text-weak); }
    &--info { color: var(--bulma-info); }
    &--success { color: var(--bulma-success); }
    &--warning { color: var(--bulma-warning); }
    &--danger { color: var(--bulma-danger); }
  }

  &__header-text {
    flex: 1;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0.25rem 0 0;
  }

  &__close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.25rem;
    border-radius: 4px;
    flex-shrink: 0;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);
    }
  }

  &__body {
    padding: 1.25rem;
    overflow-y: auto;
    flex: 1;
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    padding: 0 1.25rem 1.25rem;

    &--vertical {
      flex-direction: column;
    }
  }
}

.dialog-enter-active,
.dialog-leave-active {
  transition: opacity 0.2s ease;

  .dl-bulma-dialog__panel {
    transition: transform 0.2s ease;
  }
}

.dialog-enter-from,
.dialog-leave-to {
  opacity: 0;

  .dl-bulma-dialog__panel {
    transform: scale(0.95);
  }
}
</style>
