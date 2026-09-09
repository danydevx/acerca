<template>
  <div class="panel-block-wrapper">
    <div
      class="panel-block is-clickable"
      :class="{ 'is-active': isOpen }"
      @click="toggle"
    >
      <span v-if="icon" class="panel-icon">
        <i :class="icon"></i>
      </span>
      <span class="panel-block-label">{{ label }}</span>
      <span v-if="badge" class="panel-block-badge" :class="[`is-${badgeType}`]">
        {{ badge }}
      </span>
      <span class="panel-block-chevron" :class="{ 'is-open': isOpen }">
        <i class="bi bi-chevron-right"></i>
      </span>
    </div>

    <Transition name="panel-expand">
      <div v-if="isOpen" class="panel-block-content">
        <slot></slot>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  label: { type: String, required: true },
  icon: { type: String, default: '' },
  badge: { type: [String, Number], default: null },
  badgeType: {
    type: String,
    default: 'info',
    validator: (v) => ['info', 'success', 'warning', 'danger', 'primary'].includes(v),
  },
  defaultOpen: { type: Boolean, default: false },
})

const isOpen = ref(props.defaultOpen)

const toggle = () => {
  isOpen.value = !isOpen.value
}
</script>

<style lang="scss" scoped>
.panel-block-wrapper {
  border-bottom: 1px solid var(--bulma-border);

  &:last-child {
    border-bottom: none;
  }
}

.panel-block {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  background: var(--bulma-scheme-main);
  cursor: pointer;
  transition: background 150ms;

  &:hover {
    background: var(--bulma-scheme-main-bis);
  }

  &.is-active {
    background: var(--bulma-scheme-main-bis);
    border-left: 3px solid var(--bulma-link);
  }

  &-label {
    flex: 1;
    color: var(--bulma-text);
  }

  &-badge {
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;

    &.is-info {
      background: color-mix(in oklch, var(--bulma-info) 20%, transparent);
      color: var(--bulma-info);
    }

    &.is-success {
      background: color-mix(in oklch, var(--bulma-success) 20%, transparent);
      color: var(--bulma-success);
    }

    &.is-warning {
      background: color-mix(in oklch, var(--bulma-warning) 20%, transparent);
      color: var(--bulma-warning);
    }

    &.is-danger {
      background: color-mix(in oklch, var(--bulma-danger) 20%, transparent);
      color: var(--bulma-danger);
    }

    &.is-primary {
      background: color-mix(in oklch, var(--bulma-primary) 20%, transparent);
      color: var(--bulma-primary);
    }
  }

  &-chevron {
    color: var(--bulma-text-weak);
    transition: transform 200ms;

    &.is-open {
      transform: rotate(90deg);
    }
  }
}

.panel-icon {
  color: var(--bulma-text-weak);
}

.panel-block-content {
  padding: 1rem;
  background: var(--bulma-scheme-main-bis);
  border-top: 1px solid var(--bulma-border);
}

.panel-expand-enter-active,
.panel-expand-leave-active {
  transition: all 0.2s ease;
  overflow: hidden;
}

.panel-expand-enter-from,
.panel-expand-leave-to {
  opacity: 0;
  max-height: 0;
  padding-top: 0;
  padding-bottom: 0;
}

.panel-expand-enter-to,
.panel-expand-leave-from {
  opacity: 1;
  max-height: 500px;
}
</style>
