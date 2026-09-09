<template>
  <div
    class="product-image"
    :class="{
      'product-image--square': ratio === 'square',
      'product-image--portrait': ratio === 'portrait',
      'product-image--zoomable': zoomable,
    }"
    @click="handleClick"
  >
    <img
      v-if="src && !error"
      :src="src"
      :alt="alt"
      loading="lazy"
      @error="error = true"
    >
    <div v-else class="product-image__placeholder">
      <i class="bi bi-image"></i>
    </div>
    <div v-if="badge" class="product-image__badge">{{ badge }}</div>
    <slot name="overlay"></slot>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  src: {
    type: String,
    default: '',
  },
  alt: {
    type: String,
    default: 'Product image',
  },
  badge: {
    type: String,
    default: '',
  },
  ratio: {
    type: String,
    default: 'landscape',
    validator: (v) => ['landscape', 'square', 'portrait'].includes(v),
  },
  zoomable: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['click'])
const error = ref(false)

const handleClick = () => {
  emit('click')
}
</script>

<style lang="scss" scoped>
.product-image {
  position: relative;
  aspect-ratio: 4 / 3;
  overflow: hidden;
  border-radius: var(--bulma-radius);
  background: var(--bulma-scheme-main-bis);
  cursor: pointer;

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 2rem;
    }
  }

  &__badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-small);
  }

  &--square {
    aspect-ratio: 1;
  }

  &--portrait {
    aspect-ratio: 3 / 4;
  }

  &--zoomable:hover img {
    transform: scale(1.05);
  }
}
</style>
