<template>
  <div class="service-gallery">
    <div v-if="mainImage" class="service-gallery__main-image">
      <img :src="mainImage" :alt="name">
    </div>
    <div v-if="images && images.length > 1" class="service-gallery__thumbs">
      <a
        v-for="img in images"
        :key="img.id"
        :href="img.path"
        class="service-gallery__thumb glightbox"
        data-gallery="service-gallery"
        :data-title="name"
      >
        <img :src="img.path" :alt="img.title || name">
      </a>
    </div>
  </div>
</template>

<script setup>
import { watch, nextTick, onBeforeUnmount } from 'vue'
import GLightbox from 'glightbox'
import 'glightbox/dist/css/glightbox.min.css'

const props = defineProps({
  images: {
    type: Array,
    default: () => [],
  },
  name: {
    type: String,
    default: '',
  },
  mainImage: {
    type: String,
    default: '',
  },
})

let lightboxInstance = null

const initLightbox = () => {
  nextTick(() => {
    if (lightboxInstance) {
      lightboxInstance.destroy()
    }
    lightboxInstance = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: false,
      selector: '.service-gallery .glightbox',
    })
  })
}

watch(() => props.images, (val) => {
  if (val && val.length > 0) {
    initLightbox()
  }
}, { immediate: true })

onBeforeUnmount(() => {
  if (lightboxInstance) {
    lightboxInstance.destroy()
    lightboxInstance = null
  }
})
</script>

<style lang="scss" scoped>
.service-gallery {
  flex-shrink: 0;

  @media (min-width: 768px) {
    width: 45%;
  }
}

.service-gallery__main-image {
  width: 100%;
  aspect-ratio: 4 / 3;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  background: var(--bulma-scheme-main-bis);
  margin-bottom: 0.75rem;

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}

.service-gallery__thumbs {
  display: flex;
  gap: 0.5rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;

  &::-webkit-scrollbar {
    height: 4px;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--bulma-border);
    border-radius: var(--bulma-radius-small);
  }
}

.service-gallery__thumb {
  flex: 0 0 64px;
  height: 64px;
  border-radius: var(--bulma-radius);
  overflow: hidden;
  display: block;
  scroll-snap-align: start;

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &:hover {
    opacity: 0.85;
  }
}
</style>
