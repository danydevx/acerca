<template>
  <Teleport to="body">
    <TransitionGroup name="toast" tag="div" class="ui-toast-container" :class="`ui-toast-container--${position}`">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        class="ui-toast dl-bulma-toast"
        :class="[`dl-bulma-toast--${toast.tone}`]"
      >
        <div v-if="toast.icon" class="dl-bulma-toast__icon">
          <i :class="toast.icon"></i>
        </div>
        <div class="dl-bulma-toast__content">
          <div v-if="toast.title" class="dl-bulma-toast__title">{{ toast.title }}</div>
          <div v-if="toast.message" class="dl-bulma-toast__message">{{ toast.message }}</div>
        </div>
        <button class="dl-bulma-toast__close" @click="removeToast(toast.id)">
          <i class="bi bi-x"></i>
        </button>
      </div>
    </TransitionGroup>
  </Teleport>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  position: { type: String, default: 'bottom-end' }
})

const toasts = ref([])
let toastId = 0

const addToast = ({ title = '', message = '', tone = 'neutral', duration = 5000, icon = '' }) => {
  const id = ++toastId
  const toast = { id, title, message, tone, icon: icon || getIconForTone(tone) }
  toasts.value.push(toast)

  if (duration > 0) {
    setTimeout(() => removeToast(id), duration)
  }

  return id
}

const removeToast = (id) => {
  const index = toasts.value.findIndex((t) => t.id === id)
  if (index > -1) toasts.value.splice(index, 1)
}

const getIconForTone = (tone) => {
  const icons = { neutral: 'bi bi-bell', info: 'bi bi-info-circle', success: 'bi bi-check-circle', warning: 'bi bi-exclamation-triangle', danger: 'bi bi-x-circle' }
  return icons[tone] || icons.neutral
}

const success = (opts) => addToast({ ...opts, tone: 'success' })
const error = (opts) => addToast({ ...opts, tone: 'danger' })
const warning = (opts) => addToast({ ...opts, tone: 'warning' })
const info = (opts) => addToast({ ...opts, tone: 'info' })
const show = (opts) => addToast({ ...opts })

defineExpose({ addToast, removeToast, success, error, warning, info, show })
</script>

<style lang="scss" scoped>
.ui-toast-container {
  position: fixed;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 1rem;
  max-width: 400px;

  &--bottom-end {
    bottom: 0;
    right: 0;
  }

  &--bottom-start {
    bottom: 0;
    left: 0;
  }

  &--top-end {
    top: 0;
    right: 0;
  }

  &--top-start {
    top: 0;
    left: 0;
  }
}

.ui-toast {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1rem;
  border-radius: 8px;
  background: var(--bulma-scheme-main);
  box-shadow: 0 10px 15px -3px oklch(0 0 0 / 0.1), 0 4px 6px -2px oklch(0 0 0 / 0.05);
  border: 1px solid var(--bulma-border);

  &--info {
    border-left: 4px solid var(--bulma-info);

    .dl-bulma-toast__icon { color: var(--bulma-info); }
  }

  &--success {
    border-left: 4px solid var(--bulma-success);

    .dl-bulma-toast__icon { color: var(--bulma-success); }
  }

  &--warning {
    border-left: 4px solid var(--bulma-warning);

    .dl-bulma-toast__icon { color: var(--bulma-warning); }
  }

  &--danger {
    border-left: 4px solid var(--bulma-danger);

    .dl-bulma-toast__icon { color: var(--bulma-danger); }
  }

  &--neutral {
    border-left: 4px solid var(--bulma-text-weak);

    .dl-bulma-toast__icon { color: var(--bulma-text-weak); }
  }
}

.dl-bulma-toast {
  &__icon {
    font-size: 1.25rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__title {
    font-weight: 600;
    color: var(--bulma-text);
    font-size: 0.9375rem;
  }

  &__message {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;
  }

  &__close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.125rem;
    border-radius: 4px;
    flex-shrink: 0;

    &:hover {
      color: var(--bulma-text);
    }
  }
}

.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100%);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.toast-move {
  transition: transform 0.3s ease;
}
</style>
