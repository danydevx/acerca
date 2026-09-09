<template>
  <div
    class="inline-message"
    :class="`inline-message--${type}`"
    role="alert"
  >
    <i class="inline-message__icon" :class="iconClass"></i>
    <div class="inline-message__content">
      <span v-if="title" class="inline-message__title">{{ title }}</span>
      <span v-if="message" class="inline-message__message">{{ message }}</span>
    </div>
    <button
      v-if="dismissible"
      type="button"
      class="inline-message__dismiss"
      aria-label="Cerrar"
      @click="$emit('dismiss')"
    >
      <i class="bi bi-x"></i>
    </button>
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
  dismissible: {
    type: Boolean,
    default: false,
  },
  icon: {
    type: String,
    default: '',
  },
})

defineEmits(['dismiss'])

const iconMap = {
  info: 'bi bi-info-circle',
  success: 'bi bi-check-circle',
  warning: 'bi bi-exclamation-circle',
  error: 'bi bi-exclamation-triangle',
  tip: 'bi bi-lightbulb',
}

const iconClass = computed(() => props.icon || iconMap[props.type])
</script>

<style lang="scss" scoped>
.inline-message {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 0.875rem 1rem;
  border-radius: var(--bulma-radius);
  border: 1px solid;

  &__icon {
    font-size: 1.125rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
  }

  &__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__title {
    font-size: 0.875rem;
    font-weight: 600;
    line-height: 1.4;
  }

  &__message {
    font-size: 0.8125rem;
    line-height: 1.5;
  }

  &__dismiss {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
    padding: 0;
    border: none;
    background: transparent;
    opacity: 0.6;
    cursor: pointer;
    border-radius: var(--bulma-radius-small);
    transition: opacity 0.15s;

    &:hover {
      opacity: 1;
    }

    i {
      font-size: 0.875rem;
    }
  }

  &--info {
    background: color-mix(in oklch, var(--bulma-info) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-info) 30%, transparent);
    color: var(--bulma-info);

    .inline-message__title,
    .inline-message__message {
      color: var(--bulma-text);
    }
  }

  &--success {
    background: color-mix(in oklch, var(--bulma-success) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-success) 30%, transparent);
    color: var(--bulma-success);

    .inline-message__title,
    .inline-message__message {
      color: var(--bulma-text);
    }
  }

  &--warning {
    background: color-mix(in oklch, var(--bulma-warning) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-warning) 30%, transparent);
    color: var(--bulma-warning);

    .inline-message__title,
    .inline-message__message {
      color: var(--bulma-text);
    }
  }

  &--error {
    background: color-mix(in oklch, var(--bulma-danger) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-danger) 30%, transparent);
    color: var(--bulma-danger);

    .inline-message__title,
    .inline-message__message {
      color: var(--bulma-text);
    }
  }

  &--tip {
    background: color-mix(in oklch, var(--bulma-primary) 10%, transparent);
    border-color: color-mix(in oklch, var(--bulma-primary) 30%, transparent);
    color: var(--bulma-primary);

    .inline-message__title,
    .inline-message__message {
      color: var(--bulma-text);
    }
  }
}
</style>
