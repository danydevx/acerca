<template>
  <article
    class="product-card card is-clickable"
    :class="{ 'product-card--carousel': carousel }"
    @click="$emit('details', item)"
    @keydown.enter="$emit('details', item)"
    @keydown.space.prevent="$emit('details', item)"
    tabindex="0"
    :aria-label="`Ver detalles de ${item.name}`"
    role="button"
  >
    <div class="card-image">
      <figure class="image is-4by3">
        <img
          v-if="showImage && item.image"
          :src="item.image"
          :alt="item.name"
          loading="lazy"
        />
        <div v-else class="product-card__placeholder has-background-grey-light">
          <i class="bi bi-image has-text-grey"></i>
        </div>
      </figure>
      <div v-if="showBadges" class="product-card__badges">
        <span
          v-if="item.compare_at_price && showComparePrice"
          class="tag is-danger is-light"
        >
          -{{ discountPercent(item) }}%
        </span>
        <span
          v-if="showStock && item.quantity !== null && item.quantity === 0"
          class="tag is-light"
        >
          Agotado
        </span>
      </div>
    </div>

    <div class="card-content">
      <h3 class="title is-6 mb-2">{{ item.name }}</h3>

      <p
        v-if="showDescription && item.description"
        class="has-text-grey is-size-7 mb-3"
      >
        {{ truncateText(item.description, 48) }}
      </p>

      <div v-if="showPrice && item.price" class="product-card__price">
        <span class="has-text-success has-text-weight-bold is-size-5">
          {{ formatCurrency(item.price) }}
        </span>
        <span
          v-if="showComparePrice && item.compare_at_price"
          class="has-text-grey ml-2 is-size-7"
        >
          <s>{{ formatCurrency(item.compare_at_price) }}</s>
        </span>
      </div>
    </div>
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
  showBadges: {
    type: Boolean,
    default: true,
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

<style lang="scss" scoped>
.product-card {
  border-radius: var(--brand-card-radius, 12px);
  overflow: hidden;
  transition: transform 0.15s, box-shadow 0.15s;
  height: 100%;

  &:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  &:active {
    transform: scale(0.98);
  }

  .card-image {
    position: relative;
    overflow: hidden;

    .image {
      img {
        transition: transform 0.15s;
      }
    }
  }

  &__placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    min-height: 160px;

    i {
      font-size: 2rem;
    }
  }

  &__badges {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    align-items: flex-end;
  }

  .card-content {
    padding: 1rem;
  }

  &__price {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 0.25rem;
  }

  &--carousel {
    flex: 0 0 clamp(240px, 65vw, 300px);
    scroll-snap-align: start;
    margin-right: 1rem;

    &:last-child {
      margin-right: 0;
    }
  }
}
</style>
