<template>
  <div class="hero-cover" :class="{ 'hero-cover--full': fullWidth }">
    <img
      v-if="src"
      :src="src"
      :alt="alt"
      class="hero-cover__image"
      :style="coverStyle"
    >
    <div v-else class="hero-cover__placeholder">
      <i class="bi bi-image"></i>
    </div>
    <slot></slot>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  src: {
    type: String,
    default: '',
  },
  alt: {
    type: String,
    default: '',
  },
  height: {
    type: String,
    default: 'medium',
    validator: (v) => ['auto', 'small', 'medium', 'large', 'full'].includes(v),
  },
  fullWidth: {
    type: Boolean,
    default: false,
  },
  fit: {
    type: String,
    default: 'cover',
    validator: (v) => ['cover', 'contain', 'fill'].includes(v),
  },
})

const heights = {
  auto: 'auto',
  small: '120px',
  medium: '200px',
  large: '300px',
  full: '100%',
}

const coverStyle = computed(() => ({
  objectFit: props.fit,
}))
</script>

<style lang="scss" scoped>
.hero-cover {
  position: relative;
  width: 100%;
  height: v-bind('heights[height]');
  background: var(--bulma-scheme-main-bis);
  overflow: hidden;

  &--full {
    width: 100vw;
    margin-left: calc(50% - 50vw);
  }

  &__image {
    width: 100%;
    height: 100%;
    object-position: center;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 3rem;
    }
  }
}
</style>
