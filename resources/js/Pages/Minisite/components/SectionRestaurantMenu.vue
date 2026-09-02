<template>
  <section class="section-restaurant-menu">
    <div class="section-restaurant-menu__inner">
      <h2 v-if="title" class="section-restaurant-menu__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-restaurant-menu__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-restaurant-menu__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay opciones disponibles en el menú.
      </div>

      <div v-else>
        <div v-if="hasCategories && items.length > 1" class="section-restaurant-menu__tabs">
          <button
            v-for="category in items"
            :key="category.id"
            class="section-restaurant-menu__tab"
            :class="{ 'active': activeCategory === category.id }"
            @click="activeCategory = category.id"
          >
            {{ category.title }}
          </button>
        </div>

        <div class="section-restaurant-menu__category-content">
          <template v-for="category in items" :key="category.id">
            <div
              v-show="!hasCategories || activeCategory === category.id || items.length === 1"
              class="section-restaurant-menu__category"
            >
              <div v-if="category.title && items.length > 1" class="section-restaurant-menu__category-header">
                <h3 class="section-restaurant-menu__category-title">{{ category.title }}</h3>
                <p v-if="category.description" class="section-restaurant-menu__category-desc">
                  {{ category.description }}
                </p>
              </div>

              <template v-if="viewMode === 'full'">
                <div class="section-restaurant-menu__full-section">
                  <h4 class="section-restaurant-menu__full-title">
                    <i class="bi bi-collection"></i>Carrusel
                  </h4>
                  <div class="section-restaurant-menu__carousel">
                    <div
                      v-for="product in getDisplayedProducts(category)"
                      :key="'carousel-' + product.id"
                      class="section-restaurant-menu__carousel-card"
                      @click="openProductModal(product)"
                    >
                      <template v-if="showImages">
                        <div v-if="product.image" class="section-restaurant-menu__card-image">
                          <img :src="product.image" :alt="product.title" loading="lazy" />
                        </div>
                        <div v-else class="section-restaurant-menu__card-image-placeholder">
                          <i class="bi bi-basket"></i>
                        </div>
                      </template>
                      <div class="section-restaurant-menu__card-body">
                        <h4 class="section-restaurant-menu__product-name">{{ product.title }}</h4>
                        <p v-if="product.description" class="section-restaurant-menu__product-desc">
                          {{ truncateText(product.description, 60) }}
                        </p>
                        <div v-if="showPrices && product.price !== null && product.price !== undefined" class="section-restaurant-menu__product-price">
                          {{ formatCurrency(product.price) }}
                        </div>
                        <div v-if="product.has_variants" class="section-restaurant-menu__product-variants">
                          <span class="orp-badge orp-badge--secondary">
                            <i class="bi bi-list-ul me-1"></i>Con variantes
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="section-restaurant-menu__full-section">
                  <h4 class="section-restaurant-menu__full-title">
                    <i class="bi bi-grid-3x3-gap"></i>Cuadrícula
                  </h4>
                  <div class="section-restaurant-menu__grid">
                    <div
                      v-for="product in getDisplayedProducts(category)"
                      :key="'grid-' + product.id"
                      class="section-restaurant-menu__grid-card"
                      @click="openProductModal(product)"
                    >
                      <template v-if="showImages">
                        <div v-if="product.image" class="section-restaurant-menu__card-image">
                          <img :src="product.image" :alt="product.title" loading="lazy" />
                        </div>
                        <div v-else class="section-restaurant-menu__card-image-placeholder">
                          <i class="bi bi-basket"></i>
                        </div>
                      </template>
                      <div class="section-restaurant-menu__card-body">
                        <h4 class="section-restaurant-menu__product-name">{{ product.title }}</h4>
                        <p v-if="product.description" class="section-restaurant-menu__product-desc">
                          {{ truncateText(product.description, 60) }}
                        </p>
                        <div v-if="showPrices && product.price !== null && product.price !== undefined" class="section-restaurant-menu__product-price">
                          {{ formatCurrency(product.price) }}
                        </div>
                        <div v-if="product.has_variants" class="section-restaurant-menu__product-variants">
                          <span class="orp-badge orp-badge--secondary">
                            <i class="bi bi-list-ul me-1"></i>Con variantes
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="section-restaurant-menu__full-section">
                  <h4 class="section-restaurant-menu__full-title">
                    <i class="bi bi-list-ul me-2"></i>Lista
                  </h4>
                  <div class="section-restaurant-menu__list">
                    <div
                      v-for="product in getDisplayedProducts(category)"
                      :key="'list-' + product.id"
                      class="section-restaurant-menu__product"
                      @click="openProductModal(product)"
                    >
                      <div v-if="showImages && product.image" class="section-restaurant-menu__product-image">
                        <img :src="product.image" :alt="product.title" loading="lazy" />
                      </div>
                      <div class="section-restaurant-menu__product-info">
                        <h4 class="section-restaurant-menu__product-name">{{ product.title }}</h4>
                        <p v-if="product.description" class="section-restaurant-menu__product-desc">
                          {{ truncateText(product.description, 80) }}
                        </p>
                        <div v-if="showPrices && product.price !== null && product.price !== undefined" class="section-restaurant-menu__product-price">
                          {{ formatCurrency(product.price) }}
                        </div>
                        <div v-if="product.has_variants" class="section-restaurant-menu__product-variants">
                          <span class="orp-badge orp-badge--secondary">
                            <i class="bi bi-list-ul me-1"></i>Con variantes
                          </span>
                        </div>
                      </div>
                      <button class="section-restaurant-menu__product-btn">
                        <i class="bi bi-plus-lg"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </template>

              <template v-else>
                <div v-if="viewMode === 'carousel'" class="section-restaurant-menu__carousel">
                  <div
                    v-for="product in getDisplayedProducts(category)"
                    :key="product.id"
                    class="section-restaurant-menu__carousel-card"
                    @click="openProductModal(product)"
                  >
                    <template v-if="showImages">
                      <div v-if="product.image" class="section-restaurant-menu__card-image">
                        <img :src="product.image" :alt="product.title" loading="lazy" />
                      </div>
                      <div v-else class="section-restaurant-menu__card-image-placeholder">
                        <i class="bi bi-basket"></i>
                      </div>
                    </template>
                    <div class="section-restaurant-menu__card-body">
                      <h4 class="section-restaurant-menu__product-name">{{ product.title }}</h4>
                      <p v-if="product.description" class="section-restaurant-menu__product-desc">
                        {{ truncateText(product.description, 60) }}
                      </p>
                      <div v-if="showPrices && product.price !== null && product.price !== undefined" class="section-restaurant-menu__product-price">
                        {{ formatCurrency(product.price) }}
                      </div>
                      <div v-if="product.has_variants" class="section-restaurant-menu__product-variants">
                        <span class="orp-badge orp-badge--secondary">
                          <i class="bi bi-list-ul me-1"></i>Con variantes
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-else-if="viewMode === 'grid'" class="section-restaurant-menu__grid">
                  <div
                    v-for="product in getDisplayedProducts(category)"
                    :key="product.id"
                    class="section-restaurant-menu__grid-card"
                    @click="openProductModal(product)"
                  >
                    <template v-if="showImages">
                      <div v-if="product.image" class="section-restaurant-menu__card-image">
                        <img :src="product.image" :alt="product.title" loading="lazy" />
                      </div>
                      <div v-else class="section-restaurant-menu__card-image-placeholder">
                        <i class="bi bi-basket"></i>
                      </div>
                    </template>
                    <div class="section-restaurant-menu__card-body">
                      <h4 class="section-restaurant-menu__product-name">{{ product.title }}</h4>
                      <p v-if="product.description" class="section-restaurant-menu__product-desc">
                        {{ truncateText(product.description, 60) }}
                      </p>
                      <div v-if="showPrices && product.price !== null && product.price !== undefined" class="section-restaurant-menu__product-price">
                        {{ formatCurrency(product.price) }}
                      </div>
                      <div v-if="product.has_variants" class="section-restaurant-menu__product-variants">
                        <span class="orp-badge orp-badge--secondary">
                          <i class="bi bi-list-ul me-1"></i>Con variantes
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-else class="section-restaurant-menu__list">
                  <div
                    v-for="product in getDisplayedProducts(category)"
                    :key="product.id"
                    class="section-restaurant-menu__product"
                    @click="openProductModal(product)"
                  >
                    <div v-if="showImages && product.image" class="section-restaurant-menu__product-image">
                      <img :src="product.image" :alt="product.title" loading="lazy" />
                    </div>
                    <div class="section-restaurant-menu__product-info">
                      <h4 class="section-restaurant-menu__product-name">{{ product.title }}</h4>
                      <p v-if="product.description" class="section-restaurant-menu__product-desc">
                        {{ truncateText(product.description, 80) }}
                      </p>
                      <div v-if="showPrices && product.price !== null && product.price !== undefined" class="section-restaurant-menu__product-price">
                        {{ formatCurrency(product.price) }}
                      </div>
                      <div v-if="product.has_variants" class="section-restaurant-menu__product-variants">
                        <span class="orp-badge orp-badge--secondary">
                          <i class="bi bi-list-ul me-1"></i>Con variantes
                        </span>
                      </div>
                    </div>
                    <button class="section-restaurant-menu__product-btn">
                      <i class="bi bi-plus-lg"></i>
                    </button>
                  </div>
                </div>
              </template>

              <div v-if="hasMoreItems(category) && viewMode !== 'full'" class="section-restaurant-menu__show-all">
                <button class="orp-btn orp-btn--ghost" @click="showAllCategory(category.id)">
                  Ver todos ({{ category.products.length }})
                </button>
              </div>
            </div>
          </template>
        </div>
      </div>

      <div class="section-restaurant-menu__buttons">
        <a
          v-if="buttons && buttons.length"
          v-for="(btn, index) in buttons"
          :key="index"
          :href="btn.url"
          class="orp-btn"
          :class="'orp-btn--' + (btn.style || 'primary')"
        >
          {{ btn.text }}
        </a>
        <a
          v-if="businessSlug"
          :href="`/m/${businessSlug}/menu`"
          class="orp-btn orp-btn--ghost"
        >
          <i class="bi bi-cup-hot me-2"></i>Ver menú completo
        </a>
      </div>
    </div>

    <div v-if="selectedProduct" class="product-modal" @click="closeProductModal">
      <div class="product-modal__content" @click.stop>
        <button class="product-modal__close" @click="closeProductModal">
          <i class="bi bi-x-lg"></i>
        </button>
        <div v-if="selectedProduct.image" class="product-modal__image">
          <img :src="selectedProduct.image" :alt="selectedProduct.title" />
        </div>
        <div class="product-modal__info">
          <h2 class="product-modal__name">{{ selectedProduct.title }}</h2>
          <div v-if="selectedProduct.price && !selectedProduct.has_variants" class="product-modal__price">
            {{ formatCurrency(selectedProduct.price) }}
          </div>
          <p v-if="selectedProduct.description" class="product-modal__description">
            {{ selectedProduct.description }}
          </p>

          <div v-if="selectedProduct.has_variants && selectedProduct.variants" class="product-modal__variants">
            <h4 class="product-modal__variants-title">Opciones:</h4>
            <div
              v-for="variant in selectedProduct.variants"
              :key="variant.id"
              class="product-modal__variant"
            >
              <div class="product-modal__variant-info">
                <span class="product-modal__variant-name">{{ variant.title }}</span>
                <span v-if="variant.description" class="product-modal__variant-desc">
                  {{ variant.description }}
                </span>
              </div>
              <span class="product-modal__variant-price">{{ formatCurrency(variant.price) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  title: String,
  subtitle: String,
  items: {
    type: Array,
    default: () => [],
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
  businessSlug: {
    type: String,
    default: '',
  },
})

const selectedProduct = ref(null)
const expandedCategories = ref(new Set())

const viewMode = computed(() => props.config?.view_mode || 'list')
const showImages = computed(() => props.config?.show_images !== false)
const showPrices = computed(() => props.config?.show_prices !== false)
const maxItems = computed(() => props.config?.max_items || 12)
const showAll = computed(() => props.config?.show_all === true)

const hasCategories = computed(() => {
  return props.items.some(cat => cat.products && cat.products.length > 0)
})

const activeCategory = ref(null)

const getDisplayedProducts = (category) => {
  const products = category.products || []
  if (showAll.value || expandedCategories.value.has(category.id)) {
    return products
  }
  return products.slice(0, maxItems.value)
}

const hasMoreItems = (category) => {
  const products = category.products || []
  return !showAll.value && !expandedCategories.value.has(category.id) && products.length > maxItems.value
}

const showAllCategory = (categoryId) => {
  expandedCategories.value.add(categoryId)
}

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}

const openProductModal = (product) => {
  selectedProduct.value = product
}

const closeProductModal = () => {
  selectedProduct.value = null
}
</script>

<script>
import { defineComponent } from 'vue'
export default defineComponent({ name: 'SectionRestaurantMenu' })
</script>

<style lang="less">
.section-restaurant-menu {
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

  &__tabs {
    display: flex;
    flex-wrap: wrap;
    gap: var(--orp-space-2);
    justify-content: center;
    margin-bottom: var(--orp-space-4);
    padding-bottom: var(--orp-space-3);
    border-bottom: 1px solid var(--orp-border);
  }

  &__tab {
    padding: var(--orp-space-2) var(--orp-space-3);
    border: 1px solid var(--orp-border);
    border-radius: var(--orp-radius-full, 20px);
    background: var(--orp-surface);
    color: var(--orp-muted-foreground);
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--orp-surface-muted);
      border-color: var(--orp-muted-foreground);
    }

    &.active {
      background: var(--orp-primary);
      border-color: var(--orp-primary);
      color: var(--orp-primary-foreground);
    }
  }

  &__category-content {
    margin-bottom: var(--orp-space-4);
  }

  &__category {
    margin-bottom: var(--orp-space-5);

    &:last-child {
      margin-bottom: 0;
    }
  }

  &__category-header {
    margin-bottom: var(--orp-space-3);
  }

  &__category-title {
    font-size: var(--orp-font-size-lg);
    font-weight: 600;
    color: var(--orp-foreground);
    margin: 0 0 var(--orp-space-1);
  }

  &__category-desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0;
  }

  &__list {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-2);
  }

  &__product {
    display: flex;
    align-items: center;
    gap: var(--orp-space-3);
    padding: var(--orp-space-3);
    border-radius: var(--orp-radius-md);
    background: var(--orp-surface-muted);
    cursor: pointer;
    transition: background 0.2s;

    &:hover {
      background: var(--orp-border);
    }
  }

  &__product-image {
    flex: 0 0 64px;
    width: 64px;
    height: 64px;
    border-radius: var(--orp-radius-md);
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__product-image-placeholder {
    width: 64px;
    height: 64px;
    border-radius: var(--orp-radius-md);
    background: var(--orp-border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 1.5rem;
  }

  &__product-info {
    flex: 1;
    min-width: 0;
  }

  &__product-name {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    color: var(--orp-surface-foreground);
    margin: 0 0 var(--orp-space-1);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__product-desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-1);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__product-price {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    color: var(--orp-success);
  }

  &__product-variants {
    margin-top: var(--orp-space-1);
  }

  &__product-btn {
    flex: 0 0 32px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--orp-primary);
    color: var(--orp-primary-foreground);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;

    &:hover {
      background: color-mix(in srgb, var(--orp-primary) 85%, black);
    }
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--orp-space-3);
  }

  &__grid-card {
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;

    &:hover {
      transform: translateY(-4px);
      box-shadow: var(--orp-shadow-md);
    }

    .section-restaurant-menu__card-image {
      width: 100%;
      height: 140px;
      overflow: hidden;

      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }

    .section-restaurant-menu__card-image-placeholder {
      width: 100%;
      height: 140px;
      background: var(--orp-border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--orp-muted-foreground);
      font-size: 2.5rem;
    }

    .section-restaurant-menu__card-body {
      padding: var(--orp-space-3);
    }

    .section-restaurant-menu__product-name {
      font-size: var(--orp-font-size-md);
      font-weight: 600;
      color: var(--orp-surface-foreground);
      margin: 0 0 var(--orp-space-2);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .section-restaurant-menu__product-desc {
      font-size: var(--orp-font-size-sm);
      color: var(--orp-muted-foreground);
      margin: 0 0 var(--orp-space-2);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .section-restaurant-menu__product-price {
      font-size: var(--orp-font-size-md);
      font-weight: 600;
      color: var(--orp-success);
    }
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

  &__carousel-card {
    flex: 0 0 220px;
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
    scroll-snap-align: start;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;

    &:hover {
      transform: translateY(-4px);
      box-shadow: var(--orp-shadow-md);
    }

    .section-restaurant-menu__card-image {
      width: 100%;
      height: 140px;
      overflow: hidden;

      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }

    .section-restaurant-menu__card-image-placeholder {
      width: 100%;
      height: 140px;
      background: var(--orp-border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--orp-muted-foreground);
      font-size: 2.5rem;
    }

    .section-restaurant-menu__card-body {
      padding: var(--orp-space-3);
    }

    .section-restaurant-menu__product-name {
      font-size: var(--orp-font-size-md);
      font-weight: 600;
      color: var(--orp-surface-foreground);
      margin: 0 0 var(--orp-space-2);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .section-restaurant-menu__product-desc {
      font-size: var(--orp-font-size-sm);
      color: var(--orp-muted-foreground);
      margin: 0 0 var(--orp-space-2);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .section-restaurant-menu__product-price {
      font-size: var(--orp-font-size-md);
      font-weight: 600;
      color: var(--orp-success);
    }
  }

  &__show-all {
    display: flex;
    justify-content: center;
    margin-top: var(--orp-space-3);
  }

  &__full-section {
    margin-bottom: var(--orp-space-5);
    padding-bottom: var(--orp-space-4);
    border-bottom: 1px dashed var(--orp-border);

    &:last-of-type {
      border-bottom: none;
      margin-bottom: 0;
    }
  }

  &__full-title {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-3);
    display: flex;
    align-items: center;

    i {
      color: var(--orp-primary);
    }
  }

  &__buttons {
    display: flex;
    justify-content: center;
    gap: var(--orp-space-2);
    margin-top: var(--orp-space-4);
  }
}

.product-modal {
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

  &__content {
    background: var(--orp-surface);
    border-radius: var(--orp-radius-xl);
    max-width: 500px;
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
    height: 250px;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__info {
    padding: var(--orp-space-6);
  }

  &__name {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    margin: 0 0 var(--orp-space-2);
    color: var(--orp-surface-foreground);
  }

  &__price {
    font-size: var(--orp-font-size-lg);
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

  &__variants {
    border-top: 1px solid var(--orp-border);
    padding-top: var(--orp-space-3);
  }

  &__variants-title {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    color: var(--orp-surface-foreground);
    margin: 0 0 var(--orp-space-2);
  }

  &__variant {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--orp-space-2);
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-md);
    margin-bottom: var(--orp-space-2);

    &:last-child {
      margin-bottom: 0;
    }
  }

  &__variant-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  &__variant-name {
    font-weight: 500;
    color: var(--orp-surface-foreground);
  }

  &__variant-desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
  }

  &__variant-price {
    font-weight: 600;
    color: var(--orp-success);
  }
}
</style>
