<template>
  <section class="section-products">
    <div class="section-products__inner">
      <header v-if="title || subtitle || description" class="section-products__header">
        <h2 v-if="title" class="section-products__title">{{ title }}</h2>
        <p v-if="subtitle" class="section-products__subtitle">{{ subtitle }}</p>
        <p v-if="description" class="section-products__description">{{ description }}</p>
      </header>

      <div v-if="items.length === 0" class="section-products__empty orp-empty">
        <div class="orp-empty__media">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        </div>
        <h3 class="orp-empty__title">Sin productos</h3>
        <p class="orp-empty__description">No hay productos disponibles en este momento.</p>
      </div>

      <template v-else>
        <div v-if="viewMode === 'grid'" class="section-products__grid">
          <ProductCard
            v-for="item in displayedItems"
            :key="item.id"
            :item="item"
            :show-image="showImage"
            :show-price="showPrice"
            :show-compare-price="showComparePrice"
            :show-description="showDescription"
            :show-stock="showStock"
            @details="openProductModal"
          />
        </div>

        <div v-else-if="viewMode === 'carousel'" class="section-products__carousel-wrapper">
          <div class="section-products__carousel">
            <ProductCard
              v-for="item in displayedItems"
              :key="item.id"
              :item="item"
              :show-image="showImage"
              :show-price="showPrice"
              :show-compare-price="showComparePrice"
              :show-description="showDescription"
              :show-stock="showStock"
              carousel
              @details="openProductModal"
            />
          </div>
        </div>

        <div v-else class="section-products__list">
          <ProductListItem
            v-for="item in displayedItems"
            :key="item.id"
            :item="item"
            :show-image="showImage"
            :show-price="showPrice"
            :show-compare-price="showComparePrice"
            :show-description="showDescription"
            :show-stock="showStock"
            @details="openProductModal"
          />
        </div>

        <div v-if="hasMoreItems" class="section-products__show-all">
          <a :href="showAllUrl" class="section-products__show-all-link">
            Ver todos los productos
            <span class="section-products__show-all-count">({{ items.length }})</span>
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>

        <div v-if="buttons && buttons.length" class="section-products__buttons orp-stack orp-stack--3">
          <a
            v-for="(btn, idx) in buttons"
            :key="idx"
            :href="btn.url || '#'"
            class="orp-btn orp-btn--primary orp-btn--lg orp-btn--block"
            :target="btn.open_in_new_tab ? '_blank' : '_self'"
          >
            {{ btn.text }}
          </a>
        </div>
      </template>
    </div>

    <ProductDetailModal
      v-model="showProductModal"
      :product="selectedProduct"
      :business-slug="businessSlug"
      :order-settings="orderSettings"
      :show-stock="showStock"
    />
  </section>
</template>

<script setup>
import { ref, computed, defineOptions } from 'vue'
import ProductCard from './ProductCard.vue'
import ProductListItem from './ProductListItem.vue'
import ProductDetailModal from './ProductDetailModal.vue'

defineOptions({ name: 'SectionProducts' })

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
  orderSettings: {
    type: Object,
    default: null,
  },
})

const selectedProduct = ref(null)
const showProductModal = computed({
  get: () => selectedProduct.value !== null,
  set: (val) => { if (!val) selectedProduct.value = null }
})

const viewMode = computed(() => props.config?.view_mode || 'grid')
const showImage = computed(() => props.config?.show_image !== false)
const showPrice = computed(() => props.config?.show_price !== false)
const showComparePrice = computed(() => props.config?.show_compare_price !== false)
const showStock = computed(() => props.config?.show_stock !== false)
const showDescription = computed(() => props.config?.show_description !== true)
const maxItems = computed(() => props.config?.max_items || 12)
const displayedItems = computed(() => {
  const max = maxItems.value
  const items = props.items || []
  if (items.length <= max) return items
  return items.slice(0, max)
})
const hasMoreItems = computed(() => (props.items || []).length > maxItems.value)
const showAllUrl = computed(() => `/m/${props.businessSlug}/productos`)

const openProductModal = (item) => {
  selectedProduct.value = item
}
</script>

<style lang="less">
.section-products {
  padding: var(--orp-space-6) 0;

  &__inner {
    max-width: 1024px;
    margin: 0 auto;
    padding: 0 var(--orp-space-4);
  }

  &__header {
    margin-bottom: var(--orp-space-5);
    text-align: center;
  }

  &__title {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    margin: 0 0 var(--orp-space-2);
    color: var(--orp-surface-foreground);
    line-height: 1.2;
  }

  &__subtitle {
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-2);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__description {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    margin: 0;
    max-width: 480px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.5;
  }

  &__empty {
    padding: var(--orp-space-8) var(--orp-space-4);

    .orp-empty__media svg {
      width: 48px;
      height: 48px;
    }
  }

  &__carousel-wrapper {
    margin-left: calc(-1 * var(--orp-space-4));
    margin-right: calc(-1 * var(--orp-space-4));
    padding-left: var(--orp-space-4);
    overflow: hidden;
  }

  &__carousel {
    display: flex;
    gap: var(--orp-space-3);
    overflow-x: auto;
    padding-bottom: var(--orp-space-4);
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding-right: var(--orp-space-6);

    &::-webkit-scrollbar {
      display: none;
    }
  }

  &__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--orp-space-3);

    @media (min-width: 480px) {
      grid-template-columns: repeat(2, 1fr);
    }

    @media (min-width: 768px) {
      grid-template-columns: repeat(3, 1fr);
      gap: var(--orp-space-4);
    }
  }

  &__list {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-2);
  }

  &__show-all {
    display: flex;
    justify-content: center;
    margin-top: var(--orp-space-5);
    padding-top: var(--orp-space-4);
    border-top: 1px solid var(--orp-border);
  }

  &__show-all-link {
    display: inline-flex;
    align-items: center;
    gap: var(--orp-space-2);
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-muted-foreground);
    text-decoration: none;
    padding: var(--orp-space-2) var(--orp-space-3);
    border-radius: var(--orp-radius-md);
    transition: color var(--orp-duration-fast), background var(--orp-duration-fast);

    &:hover {
      color: var(--orp-surface-foreground);
      background: var(--orp-surface-muted);
    }

    i {
      font-size: 0.75rem;
      transition: transform var(--orp-duration-fast);
    }

    &:hover i {
      transform: translateX(2px);
    }
  }

  &__show-all-count {
    color: var(--orp-muted-foreground);
    font-weight: 400;
  }

  &__buttons {
    margin-top: var(--orp-space-5);
    padding-top: var(--orp-space-4);
    border-top: 1px solid var(--orp-border);
  }
}
</style>
