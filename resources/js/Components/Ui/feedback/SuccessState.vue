<template>
  <div class="success-state" :class="{ 'success-state--compact': compact }">
    <div class="success-state__icon">
      <i class="bi bi-check-lg"></i>
    </div>
    <div class="success-state__content">
      <h4 v-if="title" class="success-state__title">{{ title }}</h4>
      <p v-if="message" class="success-state__message">{{ message }}</p>
      <div v-if="$slots.action" class="success-state__actions">
        <slot name="action"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: '¡Listo!',
  },
  message: {
    type: String,
    default: 'La operación se completó exitosamente.',
  },
  compact: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.success-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 1rem;
  padding: 2rem;
  background: color-mix(in oklch, var(--bulma-success) 8%, transparent);
  border: 1px solid color-mix(in oklch, var(--bulma-success) 20%, transparent);
  border-radius: var(--bulma-radius-large);

  &--compact {
    flex-direction: row;
    padding: 1rem;
    text-align: left;

    .success-state__icon {
      width: 2.5rem;
      height: 2.5rem;
      font-size: 1.25rem;
    }

    .success-state__content {
      flex: 1;
    }
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 4rem;
    height: 4rem;
    background: var(--bulma-success);
    border-radius: 50%;
    color: var(--bulma-success-invert);
    animation: successPop 0.4s ease;

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
}

@keyframes successPop {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>
