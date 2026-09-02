<template>
  <section class="section-properties">
    <div class="section-properties__inner">
      <h2 v-if="title" class="section-properties__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-properties__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-properties__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay propiedades disponibles.
      </div>

      <div v-else-if="viewMode === 'carousel'" class="section-properties__carousel">
        <div
          v-for="item in displayedItems"
          :key="item.id"
          class="section-properties__card"
          @click="openPropertyModal(item)"
        >
          <div class="section-properties__card-image-wrapper">
            <img
              v-if="showImage && item.main_image"
              :src="item.main_image"
              :alt="item.title"
              class="section-properties__card-image"
              loading="lazy"
            />
            <div v-else class="section-properties__card-image-placeholder">
              <i class="bi bi-house"></i>
            </div>
            <span v-if="item.operation_label" class="section-properties__operation-badge">
              {{ item.operation_label }}
            </span>
          </div>
          <div class="section-properties__card-body">
            <h3 class="section-properties__card-title">{{ item.title }}</h3>
            <p v-if="showLocation && (item.city || item.state)" class="section-properties__card-location">
              <i class="bi bi-geo-alt"></i>{{ item.city }}{{ item.state ? ', ' + item.state : '' }}
            </p>
            <p v-if="showDescription && item.description" class="section-properties__card-desc">
              {{ truncateText(item.description, 80) }}
            </p>
            <div v-if="showPrice && item.formatted_price" class="section-properties__card-price">
              {{ item.formatted_price }}
            </div>
          </div>
        </div>
      </div>

      <div v-else-if="viewMode === 'grid'" class="section-properties__grid">
        <div
          v-for="item in displayedItems"
          :key="item.id"
          class="section-properties__grid-card"
          @click="openPropertyModal(item)"
        >
          <div class="section-properties__card-image-wrapper">
            <img
              v-if="showImage && item.main_image"
              :src="item.main_image"
              :alt="item.title"
              class="section-properties__card-image"
              loading="lazy"
            />
            <div v-else class="section-properties__card-image-placeholder">
              <i class="bi bi-house"></i>
            </div>
            <span v-if="item.operation_label" class="section-properties__operation-badge">
              {{ item.operation_label }}
            </span>
          </div>
          <div class="section-properties__card-body">
            <h3 class="section-properties__card-title">{{ item.title }}</h3>
            <p v-if="showLocation && (item.city || item.state)" class="section-properties__card-location">
              <i class="bi bi-geo-alt"></i>{{ item.city }}{{ item.state ? ', ' + item.state : '' }}
            </p>
            <p v-if="showDescription && item.description" class="section-properties__card-desc">
              {{ truncateText(item.description, 80) }}
            </p>
            <div v-if="showPrice && item.formatted_price" class="section-properties__card-price">
              {{ item.formatted_price }}
            </div>
          </div>
        </div>
      </div>

      <div v-else class="section-properties__list">
        <div
          v-for="item in displayedItems"
          :key="item.id"
          class="section-properties__list-item"
          @click="openPropertyModal(item)"
        >
          <div class="section-properties__list-image-wrapper">
            <img
              v-if="showImage && item.main_image"
              :src="item.main_image"
              :alt="item.title"
              class="section-properties__list-image"
              loading="lazy"
            />
            <div v-else class="section-properties__list-image-placeholder">
              <i class="bi bi-house"></i>
            </div>
          </div>
          <div class="section-properties__list-content">
            <span v-if="item.operation_label" class="section-properties__list-operation">
              {{ item.operation_label }}
            </span>
            <h3 class="section-properties__list-title">{{ item.title }}</h3>
            <p v-if="showLocation && (item.city || item.state)" class="section-properties__list-location">
              <i class="bi bi-geo-alt"></i>{{ item.city }}{{ item.state ? ', ' + item.state : '' }}
            </p>
            <p v-if="showDescription && item.description" class="section-properties__list-desc">
              {{ truncateText(item.description, 120) }}
            </p>
          </div>
          <div class="section-properties__list-price-wrapper">
            <div v-if="showPrice && item.formatted_price" class="section-properties__list-price">
              {{ item.formatted_price }}
            </div>
            <button class="section-properties__list-btn" @click.stop="openPropertyModal(item)">
              Ver detalles
            </button>
          </div>
        </div>
      </div>

      <div v-if="hasMoreItems && showAllButton" class="section-properties__show-all">
        <a :href="allPropertiesUrl" class="orp-btn orp-btn--ghost">
          Ver todas las propiedades ({{ items.length }})
        </a>
      </div>
    </div>

    <div v-if="selectedProperty" class="property-modal" @click="closePropertyModal">
      <div class="property-modal__content" @click.stop>
        <button class="property-modal__close" @click="closePropertyModal">
          <i class="bi bi-x-lg"></i>
        </button>
        <div v-if="selectedProperty.main_image" class="property-modal__image">
          <img :src="selectedProperty.main_image" :alt="selectedProperty.title" />
        </div>
        <div class="property-modal__info">
          <div class="property-modal__header">
            <span v-if="selectedProperty.operation_label" class="property-modal__operation">
              {{ selectedProperty.operation_label }}
            </span>
            <h2 class="property-modal__name">{{ selectedProperty.title }}</h2>
          </div>
          <p v-if="showLocation && (selectedProperty.city || selectedProperty.state)" class="property-modal__location">
            <i class="bi bi-geo-alt"></i>{{ selectedProperty.city }}{{ selectedProperty.state ? ', ' + selectedProperty.state : '' }}
          </p>
          <div v-if="showPrice && selectedProperty.formatted_price" class="property-modal__price">
            {{ selectedProperty.formatted_price }}
          </div>
          <p v-if="showDescription && selectedProperty.description" class="property-modal__description">
            {{ selectedProperty.description }}
          </p>

          <div v-if="selectedProperty.gallery && selectedProperty.gallery.length > 0" class="property-modal__gallery">
            <h4 class="property-modal__gallery-title">Galería</h4>
            <div class="property-modal__gallery-grid">
              <img
                v-for="img in selectedProperty.gallery"
                :key="img.id"
                :src="img.path"
                :alt="img.title || selectedProperty.title"
                class="property-modal__gallery-image"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  title: String,
  subtitle: String,
  description: String,
  items: {
    type: Array,
    default: () => [],
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  buttons: {
    type: Array,
    default: () => [],
  },
  businessSlug: {
    type: String,
    default: '',
  },
  showAllButton: {
    type: Boolean,
    default: true,
  },
})

const selectedProperty = ref(null)

const viewMode = computed(() => props.config?.view_mode || 'grid')
const showImage = computed(() => props.config?.show_image !== false)
const showPrice = computed(() => props.config?.show_price !== false)
const showLocation = computed(() => props.config?.show_location !== false)
const showDescription = computed(() => props.config?.show_description !== false)

const maxItems = computed(() => {
  if (props.config?.show_all) return props.items.length
  return props.config?.max_items || 12
})

const displayedItems = computed(() => {
  return props.items.slice(0, maxItems.value)
})

const hasMoreItems = computed(() => {
  return props.items.length > 0
})

const allPropertiesUrl = computed(() => {
  return `/m/${props.businessSlug}/propiedades`
})

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}

const openPropertyModal = (property) => {
  router.get(`/m/${props.businessSlug}/propiedades/${property.slug}`)
}

const closePropertyModal = () => {
  selectedProperty.value = null
}
</script>

<script>
import { defineComponent } from 'vue'
export default defineComponent({ name: 'SectionProperties' })
</script>

<style lang="less">
.section-properties {
  padding: var(--orp-space-6) var(--orp-space-2);
  background: var(--orp-surface);

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

    &::-webkit-scrollbar-track {
      background: var(--orp-border);
      border-radius: 2px;
    }

    &::-webkit-scrollbar-thumb {
      background: var(--orp-muted-foreground);
      border-radius: 2px;
    }
  }

  &__carousel &__card {
    flex: 0 0 280px;
    scroll-snap-align: start;
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--orp-space-4);
  }

  &__card {
    background: var(--orp-surface);
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
    box-shadow: var(--orp-shadow-sm);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;

    &:hover {
      transform: translateY(-4px);
      box-shadow: var(--orp-shadow-md);
    }

    &-image-wrapper {
      position: relative;
    }

    &-body {
      padding: var(--orp-space-3);
    }

    &-title {
      font-size: var(--orp-font-size-md);
      font-weight: 600;
      color: var(--orp-surface-foreground);
      margin: 0 0 var(--orp-space-2);
    }

    &-location {
      font-size: var(--orp-font-size-sm);
      color: var(--orp-muted-foreground);
      margin: 0 0 var(--orp-space-2);

      i {
        margin-right: var(--orp-space-1);
      }
    }

    &-desc {
      font-size: var(--orp-font-size-sm);
      color: var(--orp-muted-foreground);
      margin: 0 0 var(--orp-space-3);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    &-price {
      font-size: var(--orp-font-size-lg);
      font-weight: 700;
      color: var(--orp-success);
    }
  }

  &__grid-card {
    background: var(--orp-surface);
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
    box-shadow: var(--orp-shadow-sm);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;

    &:hover {
      transform: translateY(-4px);
      box-shadow: var(--orp-shadow-md);
    }

    .section-properties__card-image-wrapper {
      position: relative;
    }

    .section-properties__card-body {
      padding: var(--orp-space-3);
    }

    .section-properties__card-title {
      font-size: var(--orp-font-size-md);
      font-weight: 600;
      color: var(--orp-surface-foreground);
      margin: 0 0 var(--orp-space-2);
    }

    .section-properties__card-location {
      font-size: var(--orp-font-size-sm);
      color: var(--orp-muted-foreground);
      margin: 0 0 var(--orp-space-2);

      i {
        margin-right: var(--orp-space-1);
      }
    }

    .section-properties__card-desc {
      font-size: var(--orp-font-size-sm);
      color: var(--orp-muted-foreground);
      margin: 0 0 var(--orp-space-3);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .section-properties__card-price {
      font-size: var(--orp-font-size-lg);
      font-weight: 700;
      color: var(--orp-success);
    }
  }

  &__card-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  &__card-image-placeholder {
    width: 100%;
    height: 180px;
    background: var(--orp-surface-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 3rem;
  }

  &__operation-badge {
    position: absolute;
    top: var(--orp-space-2);
    left: var(--orp-space-2);
    background: var(--orp-primary);
    color: var(--orp-primary-foreground);
    padding: var(--orp-space-1) var(--orp-space-2);
    border-radius: var(--orp-radius-full, 20px);
    font-size: var(--orp-font-size-xs);
    font-weight: 600;
    text-transform: uppercase;
  }

  &__list {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-3);
  }

  &__list-item {
    display: flex;
    align-items: center;
    gap: var(--orp-space-3);
    padding: var(--orp-space-3);
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-lg);
    cursor: pointer;
    transition: background 0.2s;

    &:hover {
      background: var(--orp-border);
    }
  }

  &__list-image-wrapper {
    flex: 0 0 120px;
    width: 120px;
    height: 90px;
    border-radius: var(--orp-radius-md);
    overflow: hidden;
  }

  &__list-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &__list-image-placeholder {
    width: 100%;
    height: 100%;
    background: var(--orp-border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 2rem;
  }

  &__list-content {
    flex: 1;
    min-width: 0;
  }

  &__list-operation {
    display: inline-block;
    background: color-mix(in srgb, var(--orp-primary) 15%, transparent);
    color: var(--orp-primary);
    padding: 2px var(--orp-space-2);
    border-radius: var(--orp-radius-sm);
    font-size: var(--orp-font-size-xs);
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: var(--orp-space-1);
  }

  &__list-title {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    color: var(--orp-surface-foreground);
    margin: 0 0 var(--orp-space-1);
  }

  &__list-location {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-2);

    i {
      margin-right: var(--orp-space-1);
    }
  }

  &__list-desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__list-price-wrapper {
    flex: 0 0 auto;
    text-align: right;
  }

  &__list-price {
    font-size: var(--orp-font-size-lg);
    font-weight: 700;
    color: var(--orp-success);
    margin-bottom: var(--orp-space-2);
  }

  &__list-btn {
    padding: var(--orp-space-2) var(--orp-space-3);
    background: var(--orp-primary);
    color: var(--orp-primary-foreground);
    border: none;
    border-radius: var(--orp-radius-md);
    font-size: var(--orp-font-size-sm);
    cursor: pointer;
    transition: background 0.2s;

    &:hover {
      background: color-mix(in srgb, var(--orp-primary) 85%, black);
    }
  }

  &__show-all {
    display: flex;
    justify-content: center;
    margin-top: var(--orp-space-4);
  }
}

.property-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--orp-space-2);
  overflow-y: auto;

  &__content {
    background: var(--orp-surface);
    border-radius: var(--orp-radius-xl);
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
  }

  &__close {
    position: absolute;
    top: var(--orp-space-2);
    right: var(--orp-space-2);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    color: var(--orp-muted-foreground);

    &:hover {
      background: var(--orp-surface);
      color: var(--orp-danger);
    }
  }

  &__image {
    width: 100%;
    height: 300px;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__info {
    padding: var(--orp-space-4);
  }

  &__header {
    margin-bottom: var(--orp-space-3);
  }

  &__operation {
    display: inline-block;
    background: color-mix(in srgb, var(--orp-primary) 15%, transparent);
    color: var(--orp-primary);
    padding: var(--orp-space-1) var(--orp-space-2);
    border-radius: var(--orp-radius-sm);
    font-size: var(--orp-font-size-sm);
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: var(--orp-space-2);
  }

  &__name {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    margin: 0;
    color: var(--orp-surface-foreground);
  }

  &__location {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-3);

    i {
      margin-right: var(--orp-space-1);
    }
  }

  &__price {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    color: var(--orp-success);
    margin-bottom: var(--orp-space-3);
  }

  &__description {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    line-height: 1.6;
    margin: 0 0 var(--orp-space-4);
  }

  &__gallery {
    border-top: 1px solid var(--orp-border);
    padding-top: var(--orp-space-3);
  }

  &__gallery-title {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    color: var(--orp-surface-foreground);
    margin: 0 0 var(--orp-space-2);
  }

  &__gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: var(--orp-space-2);
  }

  &__gallery-image {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: var(--orp-radius-md);
    cursor: pointer;
    transition: opacity 0.2s;

    &:hover {
      opacity: 0.8;
    }
  }
}
</style>
