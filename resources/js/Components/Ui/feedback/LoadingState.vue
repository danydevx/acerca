<template>
  <div
    class="loading-state"
    :class="[
      `loading-state--${variant}`,
      { 'loading-state--inline': inline }
    ]"
  >
    <div v-if="variant === 'dots'" class="loading-state__dots">
      <div class="loading-state__dot"></div>
      <div class="loading-state__dot"></div>
      <div class="loading-state__dot"></div>
    </div>

    <div v-else-if="variant === 'spinner'" class="loading-state__spinner">
      <div class="loading-state__ring"></div>
    </div>

    <div v-else-if="variant === 'pulse'" class="loading-state__pulse">
      <div class="loading-state__pulse-ring"></div>
    </div>

    <div v-else-if="variant === 'bars'" class="loading-state__bars">
      <div class="loading-state__bar"></div>
      <div class="loading-state__bar"></div>
      <div class="loading-state__bar"></div>
      <div class="loading-state__bar"></div>
      <div class="loading-state__bar"></div>
    </div>

    <p v-if="message" class="loading-state__message">{{ message }}</p>
  </div>
</template>

<script setup>
defineProps({
  message: {
    type: String,
    default: 'Cargando...',
  },
  inline: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: 'dots',
    validator: (v) => ['dots', 'spinner', 'pulse', 'bars'].includes(v),
  },
})
</script>

<style lang="scss" scoped>
.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  padding: 2rem;
  text-align: center;

  &--inline {
    flex-direction: row;
    padding: 0.5rem;
    gap: 0.5rem;
  }

  &__dots,
  &__spinner,
  &__pulse,
  &__bars {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &__dot {
    width: 0.75rem;
    height: 0.75rem;
    background: var(--bulma-link);
    border-radius: 50%;
    animation: bounce 1.4s infinite ease-in-out both;

    &:nth-child(1) {
      animation-delay: -0.32s;
    }

    &:nth-child(2) {
      animation-delay: -0.16s;
    }

    &:nth-child(3) {
      animation-delay: 0s;
    }
  }

  &--inline &__dot {
    width: 0.5rem;
    height: 0.5rem;
  }

  &__ring {
    width: 2.5rem;
    height: 2.5rem;
    border: 3px solid var(--bulma-border);
    border-top-color: var(--bulma-link);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }

  &--inline &__ring {
    width: 1.25rem;
    height: 1.25rem;
    border-width: 2px;
  }

  &__pulse-ring {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--bulma-link);
    border-radius: 50%;
    animation: pulse-scale 1s ease-in-out infinite;
  }

  &--inline &__pulse-ring {
    width: 1.25rem;
    height: 1.25rem;
  }

  &__bars {
    gap: 0.25rem;
    height: 2.5rem;
  }

  &__bar {
    width: 0.375rem;
    height: 100%;
    background: var(--bulma-link);
    border-radius: 2px;
    animation: bar-stretch 1s ease-in-out infinite;

    &:nth-child(1) { animation-delay: -0.4s; }
    &:nth-child(2) { animation-delay: -0.3s; }
    &:nth-child(3) { animation-delay: -0.2s; }
    &:nth-child(4) { animation-delay: -0.1s; }
    &:nth-child(5) { animation-delay: 0s; }
  }

  &--inline &__bars {
    height: 1.25rem;
  }

  &--inline &__bar {
    width: 0.25rem;
  }

  &__message {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &--inline &__message {
    font-size: 0.875rem;
  }
}

@keyframes bounce {
  0%, 80%, 100% {
    transform: scale(0);
  }
  40% {
    transform: scale(1);
  }
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

@keyframes pulse-scale {
  0%, 100% {
    transform: scale(0.8);
    opacity: 0.5;
  }
  50% {
    transform: scale(1.2);
    opacity: 1;
  }
}

@keyframes bar-stretch {
  0%, 100% {
    transform: scaleY(0.4);
  }
  50% {
    transform: scaleY(1);
  }
}
</style>
