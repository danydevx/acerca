<template>
  <article
    class="product-card orp-card orp-card--interactive"
    :class="{ 'product-card--carousel': carousel }"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
    tabindex="0"
    :aria-label="`Ver detalles de ${item.name}`"
    role="button"
  >
    <div class="product-card__media orp-card__media">
      <img
        v-if="showImage && item.image"
        :src="item.image"
        :alt="item.name"
        class="product-card__image"
        loading="lazy"
      />
      <div v-else class="product-card__image-placeholder">
        <i class="bi bi-image"></i>
      </div>
      <div class="product-card__badges">
        <span v-if="item.compare_at_price && showComparePrice" class="product-card__badge product-card__badge--sale orp-badge orp-badge--danger">
          -{{ discountPercent(item) }}%
        </span>
        <span v-if="showStock && item.quantity !== null && item.quantity === 0" class="product-card__badge orp-badge orp-badge--secondary">
          Agotado
        </span>
      </div>
    </div>

    <div class="product-card__body orp-card__body">
      <h3 class="product-card__title">{{ item.name }}</h3>
      <p v-if="showDescription && item.description" class="product-card__desc">
        {{ truncateText(item.description, 48) }}
      </p>
    </div>

    <footer class="product-card__footer orp-card__footer">
      <div class="product-card__pricing">
        <div v-if="showPrice && item.price" class="product-card__price orp-price">
          <span class="orp-price__value">{{ formatCurrency(item.price) }}</span>
        </div>
        <div v-if="showComparePrice && item.compare_at_price" class="product-card__price-compare">
          {{ formatCurrency(item.compare_at_price) }}
        </div>
      </div>
      <div class="product-card__action">
        <i class="bi bi-chevron-right"></i>
      </div>
    </footer>
  </article>
</template>

<script setup>
import { usePriceFormatter } from '@/Composables/usePriceFormatter'

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  showImage: {
    type: Boolean,
    default: true,
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
  showComparePrice: {
    type: Boolean,
    default: true,
  },
  showDescription: {
    type: Boolean,
    default: false,
  },
  showStock: {
    type: Boolean,
    default: false,
  },
  carousel: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['details'])

const { formatPrice } = usePriceFormatter({
  locale: 'es-MX',
  currency: '$',
  decimals: 2,
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return formatPrice(value) || ''
}

const discountPercent = (item) => {
  if (!item.compare_at_price || !item.price) return 0
  return Math.round((1 - item.price / item.compare_at_price) * 100)
}

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}
</script>

<style lang="less">
.product-card {
  &__media {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
  }

  &__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--orp-duration-fast);
  }

  &__image-placeholder {
    width: 100%;
    height: 100%;
    background: var(--orp-surface-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 2.5rem;
  }

  &__badges {
    position: absolute;
    top: var(--orp-space-2);
    right: var(--orp-space-2);
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: flex-end;
  }

  &__badge {
    font-size: 0.7rem;
    padding: 2px 6px;
    opacity: 0.95;
  }

  &__body {
    padding: var(--orp-space-3) var(--orp-space-3) var(--orp-space-2);
  }

  &__title {
    font-size: var(--orp-font-size-base);
    font-weight: 600;
    margin: 0 0 var(--orp-space-1);
    color: var(--orp-surface-foreground);
    line-height: 1.3;
  }

  &__desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--orp-space-2) var(--orp-space-3) var(--orp-space-3);
    border-top: none;
  }

  &__pricing {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  &__price {
    .orp-price__value {
      font-size: var(--orp-font-size-lg);
      font-weight: 700;
      color: var(--orp-surface-foreground);
    }
  }

  &__price-compare {
    font-size: var(--orp-font-size-xs);
    color: var(--orp-muted-foreground);
    text-decoration: line-through;
    line-height: 1;
  }

  &__action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: var(--orp-radius-full);
    background: var(--orp-surface-muted);
    color: var(--orp-muted-foreground);
    transition: background var(--orp-duration-fast), color var(--orp-duration-fast);
  }

  &--carousel {
    flex: 0 0 clamp(240px, 65vw, 300px);
    scroll-snap-align: start;
    margin-right: var(--orp-space-3);

    &:last-child {
      margin-right: 0;
    }
  }

  &--interactive {
    cursor: pointer;

    &:active {
      .product-card__image {
        transform: scale(0.98);
      }
      .product-card__action {
        background: var(--orp-border);
        color: var(--orp-surface-foreground);
      }
    }

    &:focus-visible {
      outline: 2px solid var(--orp-ring);
      outline-offset: 2px;
    }
  }
}
</style>
