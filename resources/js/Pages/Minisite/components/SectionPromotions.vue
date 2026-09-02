<template>
  <section class="section-promotions">
    <div class="section-promotions__inner">
      <h2 v-if="title" class="section-promotions__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-promotions__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-promotions__description-text">{{ description }}</p>

      <div v-if="buttons && buttons.length" class="section-promotions__buttons">
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

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay promociones disponibles.
      </div>

      <div v-else-if="viewMode === 'carousel'" class="section-promotions__carousel">
        <div
          v-for="item in itemsWithDiscount"
          :key="item.id"
          class="section-promotions__carousel-item"
          @click="goToPromotion(item.slug)"
        >
          <div v-if="showImage && item.image" class="section-promotions__item-image">
            <img :src="item.image" :alt="item.name" />
          </div>
          <div class="section-promotions__item-content">
            <div class="section-promotions__item-header">
              <h3 class="section-promotions__item-title">{{ item.name }}</h3>
              <span v-if="item.discountPercent" class="section-promotions__item-discount">
                -{{ item.discountPercent }}%
              </span>
            </div>
            <p v-if="showDescription && item.description" class="section-promotions__item-desc">
              {{ truncateText(item.description, 80) }}
            </p>
            <div v-if="showPrice" class="section-promotions__item-prices">
              <span v-if="item.regular_price" class="section-promotions__price-original">
                ${{ item.regular_price }}
              </span>
              <span v-if="item.promotion_price" class="section-promotions__price-promotion">
                ${{ item.promotion_price }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="section-promotions__list">
        <div
          v-for="item in itemsWithDiscount"
          :key="item.id"
          class="section-promotions__list-item"
          @click="openPromotionModal(item)"
        >
          <div v-if="showImage && item.image" class="section-promotions__list-image-wrapper">
            <img :src="item.image" :alt="item.name" class="section-promotions__list-image" />
          </div>
          <div v-else class="section-promotions__list-image-placeholder">
            <i class="bi bi-tag"></i>
          </div>
          <div class="section-promotions__list-content">
            <div class="section-promotions__list-header">
              <h3 class="section-promotions__list-title">{{ item.name }}</h3>
              <span v-if="item.discountPercent" class="section-promotions__list-discount">
                -{{ item.discountPercent }}%
              </span>
            </div>
            <p v-if="showDescription && item.description" class="section-promotions__list-desc">
              {{ truncateText(item.description, 80) }}
            </p>
            <div class="section-promotions__list-meta">
              <span v-if="showPrice && item.promotion_price" class="section-promotions__list-price">
                {{ formatCurrency(item.promotion_price) }}
              </span>
              <span v-if="item.regular_price && item.promotion_price" class="section-promotions__list-price-original">
                {{ formatCurrency(item.regular_price) }}
              </span>
              <span v-if="item.expires_at" class="section-promotions__list-valid">
                <i class="bi bi-calendar3"></i>
                Valido hasta: {{ formatDate(item.expires_at) }}
              </span>
              <span v-if="item.coupon_code" class="section-promotions__list-coupon">
                <i class="bi bi-ticket"></i>
                {{ item.coupon_code }}
              </span>
            </div>
          </div>
          <div class="section-promotions__list-actions">
            <button class="section-promotions__action-btn" @click.stop="openPromotionModal(item)">
              <i class="bi bi-arrow-right-circle"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="selectedPromotion" class="promotion-modal" @click="closePromotionModal">
      <div class="promotion-modal__content" @click.stop>
        <button class="promotion-modal__close" @click="closePromotionModal">
          <i class="bi bi-x-lg"></i>
        </button>
        <div class="promotion-modal__image">
          <img v-if="selectedPromotion.image" :src="selectedPromotion.image" :alt="selectedPromotion.name" />
          <span v-if="selectedPromotion.discountPercent" class="promotion-modal__discount">
            -{{ selectedPromotion.discountPercent }}% OFF
          </span>
        </div>
        <div class="promotion-modal__info">
          <h2 class="promotion-modal__name">{{ selectedPromotion.name }}</h2>
          <div class="promotion-modal__prices">
            <span v-if="selectedPromotion.regular_price" class="promotion-modal__price-original">
              {{ formatCurrency(selectedPromotion.regular_price) }}
            </span>
            <span v-if="selectedPromotion.promotion_price" class="promotion-modal__price-promotion">
              {{ formatCurrency(selectedPromotion.promotion_price) }}
            </span>
          </div>
          <div class="promotion-modal__meta">
            <div v-if="selectedPromotion.expires_at" class="promotion-modal__meta-item">
              <i class="bi bi-calendar3"></i>
              <span>Valido hasta: <strong>{{ formatDate(selectedPromotion.expires_at) }}</strong></span>
            </div>
            <div v-if="selectedPromotion.coupon_code" class="promotion-modal__meta-item promotion-modal__meta-item--coupon">
              <i class="bi bi-ticket"></i>
              <span>Codigo: <strong>{{ selectedPromotion.coupon_code }}</strong></span>
            </div>
          </div>
          <p v-if="selectedPromotion.description" class="promotion-modal__description">
            {{ selectedPromotion.description }}
          </p>
          <div class="promotion-modal__actions">
            <button class="orp-btn orp-btn--ghost" @click="closePromotionModal">
              <i class="bi bi-x"></i>Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { usePriceFormatter } from '@/Composables/usePriceFormatter'

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
  businessSlug: {
    type: String,
    default: '',
  },
})

const selectedPromotion = ref(null)

const { formatPrice } = usePriceFormatter({
  locale: 'es-MX',
  currency: '$',
  decimals: 2,
})

const viewMode = computed(() => props.config?.view_mode || 'list')
const showImage = computed(() => props.config?.show_image !== false)
const showPrice = computed(() => props.config?.show_price !== false)
const showDescription = computed(() => props.config?.show_description !== true)

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  })
}

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return formatPrice(value) || ''
}

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}

const itemsWithDiscount = computed(() => {
  return props.items.map(item => {
    let discountPercent = null
    if (item.regular_price && item.promotion_price && item.regular_price > item.promotion_price) {
      discountPercent = Math.round((1 - item.promotion_price / item.regular_price) * 100)
    }
    return { ...item, discountPercent }
  })
})

const goToPromotion = (slug) => {
  window.location.href = `/m/${props.businessSlug}/promociones/${slug}`
}

const openPromotionModal = (item) => {
  selectedPromotion.value = item
  document.body.style.overflow = 'hidden'
}

const closePromotionModal = () => {
  selectedPromotion.value = null
  document.body.style.overflow = ''
}
</script>

<style lang="less">
.section-promotions {
  padding: var(--orp-space-6) var(--orp-space-2);
  background: var(--orp-surface-muted);

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
    margin-bottom: var(--orp-space-4);
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

  &__carousel-item {
    flex: 0 0 280px;
    scroll-snap-align: start;
    background: var(--orp-surface);
    border-radius: var(--orp-radius-md);
    overflow: hidden;
    box-shadow: var(--orp-shadow-sm);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;

    &:hover {
      transform: translateY(-4px);
      box-shadow: var(--orp-shadow-md);
    }
  }

  &__item-image {
    width: 100%;
    height: 160px;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__item-content {
    padding: var(--orp-space-3);
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
    background: var(--orp-surface);
    border-radius: var(--orp-radius-lg);
    box-shadow: var(--orp-shadow-sm);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;

    &:hover {
      transform: translateX(4px);
      box-shadow: var(--orp-shadow-md);
    }
  }

  &__list-image-wrapper {
    flex-shrink: 0;
  }

  &__list-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--orp-radius-md);
  }

  &__list-image-placeholder {
    width: 80px;
    height: 80px;
    background: var(--orp-surface-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 1.75rem;
    border-radius: var(--orp-radius-md);
  }

  &__list-content {
    flex: 1;
    min-width: 0;
  }

  &__list-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: var(--orp-space-2);
    margin-bottom: var(--orp-space-1);
  }

  &__list-title {
    font-size: var(--orp-font-size-lg);
    font-weight: 600;
    margin: 0;
    color: var(--orp-surface-foreground);
  }

  &__list-discount {
    background: var(--orp-danger);
    color: var(--orp-on-color, #fff);
    font-size: var(--orp-font-size-xs);
    font-weight: 700;
    padding: var(--orp-space-1) var(--orp-space-2);
    border-radius: var(--orp-radius-sm);
    white-space: nowrap;
    flex-shrink: 0;
  }

  &__list-desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-2);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__list-meta {
    display: flex;
    gap: var(--orp-space-3);
    flex-wrap: wrap;
    align-items: center;
  }

  &__list-price {
    font-size: var(--orp-font-size-lg);
    font-weight: 700;
    color: var(--orp-danger);
    white-space: nowrap;
  }

  &__list-price-original {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    text-decoration: line-through;
    white-space: nowrap;
  }

  &__list-valid {
    display: flex;
    align-items: center;
    gap: var(--orp-space-1);
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);

    i {
      color: var(--orp-muted-foreground);
    }
  }

  &__list-coupon {
    display: flex;
    align-items: center;
    gap: var(--orp-space-1);
    font-size: var(--orp-font-size-sm);
    color: var(--orp-primary);
    font-weight: 600;

    i {
      color: var(--orp-muted-foreground);
    }
  }

  &__list-actions {
    display: flex;
    align-items: center;
    flex-shrink: 0;
  }

  &__action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--orp-surface-muted);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--orp-muted-foreground);
    transition: all 0.2s;

    i {
      font-size: 1.25rem;
    }

    &:hover {
      background: var(--orp-primary);
      color: var(--orp-primary-foreground);
    }
  }
}

.promotion-modal {
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
  padding: var(--orp-space-3);
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
    transition: all 0.2s;

    &:hover {
      background: var(--orp-surface);
      color: var(--orp-danger);
    }
  }

  &__image {
    width: 100%;
    height: 240px;
    overflow: hidden;
    position: relative;
    background: var(--orp-surface-muted);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__discount {
    position: absolute;
    top: var(--orp-space-3);
    right: var(--orp-space-3);
    background: var(--orp-danger);
    color: var(--orp-on-color, #fff);
    font-size: var(--orp-font-size-md);
    font-weight: 700;
    padding: var(--orp-space-2) var(--orp-space-3);
    border-radius: var(--orp-radius-md);
  }

  &__info {
    padding: var(--orp-space-4);
  }

  &__name {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    margin: 0 0 var(--orp-space-3);
    color: var(--orp-surface-foreground);
  }

  &__prices {
    display: flex;
    gap: var(--orp-space-3);
    align-items: center;
    margin-bottom: var(--orp-space-3);
  }

  &__price-original {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    text-decoration: line-through;
  }

  &__price-promotion {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    color: var(--orp-danger);
  }

  &__meta {
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-md);
    padding: var(--orp-space-3);
    margin-bottom: var(--orp-space-4);
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: var(--orp-space-2);
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    margin-bottom: var(--orp-space-2);

    &:last-child {
      margin-bottom: 0;
    }

    i {
      color: var(--orp-muted-foreground);
      font-size: 1rem;
    }

    strong {
      color: var(--orp-surface-foreground);
    }

    &--coupon {
      i {
        color: var(--orp-primary);
      }
      strong {
        color: var(--orp-primary);
        font-size: var(--orp-font-size-lg);
      }
    }
  }

  &__description {
    font-size: var(--orp-font-size-md);
    color: var(--orp-surface-foreground);
    line-height: 1.6;
    margin-bottom: var(--orp-space-4);
  }

  &__actions {
    display: flex;
    gap: var(--orp-space-2);

    .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--orp-space-3) var(--orp-space-4);
      font-size: var(--orp-font-size-md);
      font-weight: 600;
    }
  }
}
</style>
