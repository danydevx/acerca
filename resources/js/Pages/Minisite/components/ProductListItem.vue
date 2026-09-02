<template>
  <article
    class="product-list-item"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
    tabindex="0"
    :aria-label="`Ver detalles de ${item.name}`"
    role="button"
  >
    <div class="product-list-item__image">
      <img
        v-if="showImage && item.image"
        :src="item.image"
        :alt="item.name"
        loading="lazy"
      />
      <div v-else class="product-list-item__image-placeholder">
        <i class="bi bi-image"></i>
      </div>
      <div v-if="item.compare_at_price && showComparePrice" class="product-list-item__sale-badge orp-badge orp-badge--danger">
        -{{ discountPercent(item) }}%
      </div>
    </div>

    <div class="product-list-item__content">
      <span v-if="item.category_name" class="product-list-item__category">{{ item.category_name }}</span>
      <h3 class="product-list-item__name">{{ item.name }}</h3>
      <div class="product-list-item__meta">
        <span v-if="showStock && item.quantity !== null" class="product-list-item__stock" :class="item.quantity > 0 ? 'product-list-item__stock--available' : 'product-list-item__stock--out'">
          <i :class="item.quantity > 0 ? 'bi bi-check-circle' : 'bi bi-x-circle'"></i>
          {{ item.quantity > 0 ? 'En stock' : 'Agotado' }}
        </span>
      </div>
    </div>

    <div class="product-list-item__right">
      <div class="product-list-item__pricing">
        <div v-if="showPrice && item.price" class="product-list-item__price orp-price">
          <span class="orp-price__value">{{ formatCurrency(item.price) }}</span>
        </div>
        <div v-if="showComparePrice && item.compare_at_price" class="product-list-item__price-compare">
          {{ formatCurrency(item.compare_at_price) }}
        </div>
      </div>
      <div class="product-list-item__arrow">
        <i class="bi bi-chevron-right"></i>
      </div>
    </div>
  </article>
</template>

<script setup>
import { usePriceFormatter } from '@/Composables/usePriceFormatter'

defineProps({
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
</script>

<style lang="less">
.product-list-item {
  display: flex;
  align-items: center;
  gap: var(--orp-space-3);
  padding: var(--orp-space-3);
  background: var(--orp-surface);
  border-radius: var(--orp-radius-lg);
  cursor: pointer;
  transition: background var(--orp-duration-fast);

  &:active {
    background: var(--orp-surface-muted);
  }

  &:focus-visible {
    outline: 2px solid var(--orp-ring);
    outline-offset: 2px;
  }

  &__image {
    position: relative;
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    border-radius: var(--orp-radius-md);
    overflow: hidden;
    background: var(--orp-surface-muted);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 1.25rem;
  }

  &__sale-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    font-size: 0.6rem;
    padding: 1px 4px;
    line-height: 1.2;
  }

  &__content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  &__category {
    font-size: var(--orp-font-size-xs);
    font-weight: 600;
    color: var(--orp-primary);
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  &__name {
    font-size: var(--orp-font-size-base);
    font-weight: 600;
    margin: 0;
    color: var(--orp-surface-foreground);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: var(--orp-space-3);
  }

  &__stock {
    display: flex;
    align-items: center;
    gap: 3px;
    font-size: var(--orp-font-size-xs);
    line-height: 1;

    i {
      font-size: 0.7rem;
    }

    &--available {
      color: var(--orp-success);
      i { color: var(--orp-success); }
    }

    &--out {
      color: var(--orp-muted-foreground);
      i { color: var(--orp-muted-foreground); }
    }
  }

  &__right {
    display: flex;
    align-items: center;
    gap: var(--orp-space-2);
    flex-shrink: 0;
  }

  &__pricing {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1px;
  }

  &__price {
    .orp-price__value {
      font-size: var(--orp-font-size-base);
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

  &__arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    color: var(--orp-muted-foreground);
    font-size: 0.875rem;
  }
}
</style>
