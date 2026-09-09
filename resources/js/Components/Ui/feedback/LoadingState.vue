<template>
  <div class="loading-state" :class="{ 'loading-state--inline': inline }">
    <div class="loading-state__spinner">
      <div class="loading-state__dot"></div>
      <div class="loading-state__dot"></div>
      <div class="loading-state__dot"></div>
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

    .loading-state__spinner {
      width: 1.25rem;
      height: 1.25rem;
    }

    .loading-state__dot {
      width: 0.5rem;
      height: 0.5rem;
    }

    .loading-state__message {
      font-size: 0.875rem;
      margin: 0;
    }
  }

  &__spinner {
    display: flex;
    gap: 0.375rem;
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
  }

  &__message {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    margin: 0;
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
</style>
