<template>
  <section class="section-gallery">
    <div class="section-gallery__inner">
      <h2 v-if="title" class="section-gallery__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-gallery__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-gallery__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="section-gallery__empty orp-text-muted orp-text-center orp-p-4">
        No hay imágenes en la galería.
      </div>

      <div v-else-if="viewMode === 'carousel'" class="section-gallery__carousel">
        <a
          v-for="item in items"
          :key="item.id"
          :href="item.path"
          class="orp-gallery__item orp-gallery__item--square glightbox"
          data-gallery="gallery"
          :data-title="item.title || 'Imagen'"
        >
          <img :src="item.path" :alt="item.title || 'Imagen'" loading="lazy" />
          <div v-if="showCaptions && item.title" class="orp-gallery__overlay">
            <span>{{ item.title }}</span>
          </div>
        </a>
      </div>

      <div v-else class="orp-gallery orp-gallery--cols-3 orp-gallery--gap-sm">
        <a
          v-for="item in items"
          :key="item.id"
          :href="item.path"
          class="orp-gallery__item orp-gallery__item--square glightbox"
          data-gallery="gallery"
          :data-title="item.title || 'Imagen'"
        >
          <img :src="item.path" :alt="item.title || 'Imagen'" loading="lazy" />
          <div v-if="showCaptions && item.title" class="orp-gallery__overlay">
            <span>{{ item.title }}</span>
          </div>
        </a>
      </div>

      <div v-if="buttons && buttons.length" class="section-gallery__buttons orp-mt-4">
        <a
          v-for="(btn, idx) in buttons"
          :key="idx"
          :href="btn.url || '#'"
          class="orp-btn orp-btn--primary"
          :target="btn.open_in_new_tab ? '_blank' : '_self'"
        >
          {{ btn.text }}
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, nextTick } from 'vue'
import GLightbox from 'glightbox'
import 'glightbox/dist/css/glightbox.min.css'

const props = defineProps({
  title: String,
  subtitle: String,
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
  items: {
    type: Array,
    default: () => [],
  },
  config: {
    type: Object,
    default: () => ({}),
  },
})

const viewMode = computed(() => props.config?.gallery_view_mode || 'grid')
const showCaptions = computed(() => props.config?.show_captions !== false)

onMounted(() => {
  nextTick(() => {
    const lightbox = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
      selector: '.section-gallery .glightbox',
    })
  })
})
</script>

<style lang="less">
.section-gallery {
  padding: var(--orp-space-6) var(--orp-space-2);
  background: var(--orp-background);

  &__inner {
    max-width: 1024px;
    margin: 0 auto;
  }

  &__title {
    font-weight: 700;
    margin: 0 0 var(--orp-space-1);
    text-align: center;
    color: var(--orp-foreground);
  }

  &__subtitle {
    font-weight: 600;
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__description-text {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__buttons {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: var(--orp-space-2);
  }

  &__empty {
    color: var(--orp-muted-foreground);
  }

  &__carousel {
    display: flex;
    gap: var(--orp-space-3);
    overflow-x: auto;
    padding-bottom: var(--orp-space-3);
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;

    &::-webkit-scrollbar {
      height: 4px;
    }

    &::-webkit-scrollbar-thumb {
      background: var(--orp-border);
      border-radius: 2px;
    }
  }
}
</style>
