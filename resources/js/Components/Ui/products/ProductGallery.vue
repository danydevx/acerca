<template>
  <div class="product-gallery" :class="{ 'product-gallery--thumbs-bottom': thumbsPosition === 'bottom' }">
    <div class="product-gallery__main" @click="$emit('preview', currentIndex)">
      <ProductImage
        v-if="images.length > 0"
        :src="images[currentIndex]?.url || images[currentIndex]"
        :alt="images[currentIndex]?.alt || `Product image ${currentIndex + 1}`"
        :badge="currentBadge"
        :zoomable="true"
      />
      <div v-else class="product-gallery__placeholder">
        <i class="bi bi-image"></i>
      </div>
      <button
        v-if="images.length > 1"
        type="button"
        class="product-gallery__nav product-gallery__nav--prev"
        aria-label="Imagen anterior"
        @click.stop="prev"
      >
        <i class="bi bi-chevron-left"></i>
      </button>
      <button
        v-if="images.length > 1"
        type="button"
        class="product-gallery__nav product-gallery__nav--next"
        aria-label="Siguiente imagen"
        @click.stop="next"
      >
        <i class="bi bi-chevron-right"></i>
      </button>
      <div v-if="images.length > 1" class="product-gallery__counter">
        {{ currentIndex + 1 }} / {{ images.length }}
      </div>
    </div>

    <div v-if="images.length > 1 && showThumbs" class="product-gallery__thumbs">
      <button
        v-for="(image, index) in images"
        :key="index"
        type="button"
        class="product-gallery__thumb"
        :class="{ 'product-gallery__thumb--active': index === currentIndex }"
        :aria-label="`Ver imagen ${index + 1}`"
        @click="currentIndex = index"
      >
        <img
          :src="typeof image === 'string' ? image : image.url"
          :alt="`Thumbnail ${index + 1}`"
          loading="lazy"
        >
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import ProductImage from './ProductImage.vue'

const props = defineProps({
  images: {
    type: Array,
    default: () => [],
  },
  showThumbs: {
    type: Boolean,
    default: true,
  },
  thumbsPosition: {
    type: String,
    default: 'bottom',
    validator: (v) => ['bottom', 'left'].includes(v),
  },
  badge: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['change', 'preview'])

const currentIndex = ref(0)

const currentBadge = computed(() => {
  if (props.badge) return props.badge
  if (props.images[currentIndex.value]?.badge) return props.images[currentIndex.value].badge
  return ''
})

const prev = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--
    emit('change', currentIndex.value)
  }
}

const next = () => {
  if (currentIndex.value < props.images.length - 1) {
    currentIndex.value++
    emit('change', currentIndex.value)
  }
}
</script>

<style lang="scss" scoped>
.product-gallery {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;

  &--thumbs-bottom {
    flex-direction: column;
  }

  &__main {
    position: relative;
    border-radius: var(--bulma-radius-large);
    overflow: hidden;
  }

  &__placeholder {
    aspect-ratio: 4 / 3;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    border-radius: var(--bulma-radius-large);

    i {
      font-size: 3rem;
    }
  }

  &__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s, transform 0.15s;
    box-shadow: 0 2px 8px oklch(0 0 0 / 0.15);

    &:hover {
      transform: translateY(-50%) scale(1.05);
    }

    i {
      font-size: 1.25rem;
      color: var(--bulma-text);
    }

    &--prev {
      left: 0.75rem;
    }

    &--next {
      right: 0.75rem;
    }
  }

  &:hover &__nav {
    opacity: 1;
  }

  &__counter {
    position: absolute;
    bottom: 0.75rem;
    right: 0.75rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-scheme-main);
    border-radius: var(--bulma-radius-small);
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--bulma-text);
    box-shadow: 0 2px 8px oklch(0 0 0 / 0.15);
  }

  &__thumbs {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding: 0.25rem;

    &::-webkit-scrollbar {
      height: 0.25rem;
    }

    &::-webkit-scrollbar-track {
      background: var(--bulma-scheme-main-bis);
      border-radius: 0.125rem;
    }

    &::-webkit-scrollbar-thumb {
      background: var(--bulma-border);
      border-radius: 0.125rem;
    }
  }

  &__thumb {
    flex-shrink: 0;
    width: 4rem;
    height: 4rem;
    padding: 0;
    border: 2px solid transparent;
    border-radius: var(--bulma-radius);
    overflow: hidden;
    cursor: pointer;
    transition: border-color 0.15s, opacity 0.15s;
    opacity: 0.6;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &:hover {
      opacity: 0.9;
    }

    &--active {
      border-color: var(--bulma-link);
      opacity: 1;
    }
  }
}
</style>
