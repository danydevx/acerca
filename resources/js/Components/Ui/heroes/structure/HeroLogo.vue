<template>
  <div class="hero-logo" :class="`hero-logo--${size}`">
    <img v-if="src && !error" :src="src" :alt="name || 'Logo'" class="hero-logo__image" @error="error = true">
    <div v-else class="hero-logo__placeholder">
      <i class="bi bi-building"></i>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  src: {
    type: String,
    default: '',
  },
  name: {
    type: String,
    default: '',
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg', 'xl'].includes(v),
  },
})

const error = ref(false)
</script>

<style lang="scss" scoped>
.hero-logo {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius);
  overflow: hidden;
  box-shadow: 0 2px 8px oklch(0 0 0 / 0.1);

  &--sm {
    width: 2.5rem;
    height: 2.5rem;
  }

  &--md {
    width: 3.5rem;
    height: 3.5rem;
  }

  &--lg {
    width: 5rem;
    height: 5rem;
  }

  &--xl {
    width: 7rem;
    height: 7rem;
  }

  &__image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 0.25rem;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 1.5rem;
    }
  }
}
</style>
