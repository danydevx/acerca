<template>
  <article
    class="product-list-item box p-3"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
    tabindex="0"
    :aria-label="`Ver detalles de ${item.name}`"
    role="button"
  >
    <div class="product-list-item__image">
      <figure class="image is-48x48">
        <img
          v-if="showImage && item.image"
          :src="item.image"
          :alt="item.name"
          loading="lazy"
          class="is-rounded"
        />
        <span v-else class="has-background-grey-light has-text-grey is-flex is-align-items-center is-justify-content-center is-rounded">
          <i class="bi bi-image"></i>
        </span>
        <span v-if="item.compare_at_price && showComparePrice" class="tag is-danger is-small product-list-item__sale-badge">
          -{{ discountPercent(item) }}%
        </span>
      </figure>
    </div>

    <div class="product-list-item__content">
      <span v-if="item.category_name" class="is-size-7 has-text-primary has-text-weight-bold is-uppercase">{{ item.category_name }}</span>
      <h3 class="title is-6 mb-1">{{ item.name }}</h3>
      <div class="is-size-7">
        <span v-if="showStock && item.quantity !== null" :class="item.quantity > 0 ? 'has-text-success' : 'has-text-grey'">
          <i :class="item.quantity > 0 ? 'bi bi-check-circle' : 'bi bi-x-circle'"></i>
          {{ item.quantity > 0 ? 'En stock' : 'Agotado' }}
        </span>
      </div>
    </div>

    <div class="product-list-item__right">
      <div class="has-text-right">
        <span v-if="showPrice && item.price" class="has-text-success has-text-weight-bold">
          {{ formatCurrency(item.price) }}
        </span>
        <span v-if="showComparePrice && item.compare_at_price" class="has-text-grey is-size-7 ml-2">
          <s>{{ formatCurrency(item.compare_at_price) }}</s>
        </span>
      </div>
      <i class="bi bi-chevron-right has-text-grey ml-2"></i>
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

<style lang="scss" scoped>
.product-list-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s;
  border-radius: var(--brand-card-radius, 12px);

  &:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  &:active {
    background: var(--brand-background-secondary, #f5f5f5);
  }

  &:focus-visible {
    outline: 2px solid var(--brand-primary);
    outline-offset: 2px;
  }

  &__image {
    position: relative;
    flex-shrink: 0;

    figure {
      margin-bottom: 0;
    }
  }

  &__sale-badge {
    position: absolute;
    bottom: -4px;
    right: -4px;
    font-size: 0.6rem;
    padding: 1px 4px;
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__right {
    display: flex;
    align-items: center;
    flex-shrink: 0;
  }
}
</style>
