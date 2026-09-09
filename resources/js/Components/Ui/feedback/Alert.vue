<template>
  <div
    class="alert"
    :class="[`alert--${type}`, { 'alert--dismissible': dismissible }]"
    role="alert"
  >
    <div class="alert__icon">
      <i :class="iconClass"></i>
    </div>
    <div class="alert__content">
      <h4 v-if="title" class="alert__title">{{ title }}</h4>
      <div class="alert__message">
        <slot>{{ message }}</slot>
      </div>
    </div>
    <div v-if="dismissible || $slots.actions" class="alert__actions">
      <slot name="actions"></slot>
      <button
        v-if="dismissible"
        type="button"
        class="alert__close"
        aria-label="Cerrar"
        @click="handleDismiss"
      >
        <i class="bi bi-x"></i>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'info',
    validator: (v) => ['info', 'success', 'warning', 'error', 'tip'].includes(v),
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },
  icon: {
    type: String,
    default: '',
  },
  dismissible: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['dismiss'])

const icons = {
  info: 'bi bi-info-circle-fill',
  success: 'bi bi-check-circle-fill',
  warning: 'bi bi-exclamation-triangle-fill',
  error: 'bi bi-x-circle-fill',
  tip: 'bi bi-lightbulb-fill',
}

const iconClass = computed(() => props.icon || icons[props.type])

const handleDismiss = () => {
  emit('dismiss')
}
</script>

<style lang="scss" scoped>
.alert {
  display: flex;
  align-items: flex-start;
  gap: 0.875rem;
  padding: 1rem;
  border-radius: var(--bulma-radius);
  border: 1px solid;

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
    font-size: 0.9375rem;
    font-weight: 600;
    margin: 0 0 0.25rem;
    line-height: 1.4;
  }

  &__message {
    font-size: 0.875rem;
    line-height: 1.5;
  }

  &__actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
  }

  &__close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    padding: 0;
    border: none;
    background: transparent;
    cursor: pointer;
    opacity: 0.6;
    border-radius: var(--bulma-radius-small);
    transition: opacity 0.15s;

    &:hover {
      opacity: 1;
    }

    i {
      font-size: 1rem;
    }
  }

  &--info {
    background: color-mix(in oklch, var(--bulma-info) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-info) 30%, transparent);
    color: var(--bulma-info);

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }

  &--success {
    background: color-mix(in oklch, var(--bulma-success) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-success) 30%, transparent);
    color: var(--bulma-success);

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }

  &--warning {
    background: color-mix(in oklch, var(--bulma-warning) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-warning) 30%, transparent);
    color: var(--bulma-warning);

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }

  &--error {
    background: color-mix(in oklch, var(--bulma-danger) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-danger) 30%, transparent);
    color: var(--bulma-danger);

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }

  &--tip {
    background: color-mix(in oklch, var(--bulma-primary) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-primary) 30%, transparent);
    color: var(--bulma-primary);

    .alert__title,
    .alert__message {
      color: var(--bulma-text);
    }
  }
}
</style>
