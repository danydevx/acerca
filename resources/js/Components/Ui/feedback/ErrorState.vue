<template>
  <div class="error-state" :class="{ 'error-state--compact': compact }">
    <div class="error-state__icon">
      <i class="bi bi-exclamation-triangle"></i>
    </div>
    <div class="error-state__content">
      <h4 v-if="title" class="error-state__title">{{ title }}</h4>
      <p v-if="message" class="error-state__message">{{ message }}</p>
      <div v-if="showRetry && retryLabel" class="error-state__actions">
        <button type="button" class="error-state__retry" @click="$emit('retry')">
          <i class="bi bi-arrow-clockwise"></i>
          {{ retryLabel }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'Algo salió mal',
  },
  message: {
    type: String,
    default: 'No pudimos completar la solicitud. Por favor intenta de nuevo.',
  },
  retryLabel: {
    type: String,
    default: 'Reintentar',
  },
  showRetry: {
    type: Boolean,
    default: true,
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['retry'])
</script>

<style lang="scss" scoped>
.error-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 1rem;
  padding: 2rem;
  background: color-mix(in oklch, var(--bulma-danger) 8%, transparent);
  border: 1px solid color-mix(in oklch, var(--bulma-danger) 20%, transparent);
  border-radius: var(--bulma-radius-large);

  &--compact {
    flex-direction: row;
    padding: 1rem;
    text-align: left;

    .error-state__icon {
      width: 2.5rem;
      height: 2.5rem;
      font-size: 1.25rem;
    }

    .error-state__content {
      flex: 1;
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 4rem;
    height: 4rem;
    background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
    border-radius: 50%;
    color: var(--bulma-danger);

    i {
      font-size: 2rem;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-width: 400px;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__message {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    line-height: 1.5;
    margin: 0;
  }

  &__actions {
    margin-top: 0.5rem;
  }

  &__retry {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: var(--bulma-danger);
    color: var(--bulma-danger-invert);
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.15s, transform 0.15s;

    &:hover {
      background: color-mix(in oklch, var(--bulma-danger) 85%, black);
      transform: translateY(-1px);
    }

    &:active {
      transform: translateY(0);
    }

    i {
      font-size: 1rem;
    }
  }
}
</style>
