<template>
  <div class="service-price-display" :class="{ 'service-price-display--compact': compact }">
    <span v-if="priceFrom" class="service-price-display__label">Desde</span>
    <span class="service-price-display__price">{{ formattedPrice }}</span>
    <span v-if="originalPrice" class="service-price-display__original">
      {{ formattedOriginalPrice }}
    </span>
    <span v-if="showDiscount && discountPercent > 0" class="service-price-display__discount">
      -{{ discountPercent }}%
    </span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  price: {
    type: [String, Number],
    default: null,
  },
  originalPrice: {
    type: [String, Number],
    default: null,
  },
  priceFrom: {
    type: Boolean,
    default: false,
  },
  currency: {
    type: String,
    default: 'MXN',
  },
  locale: {
    type: String,
    default: 'es-MX',
  },
  compact: {
    type: Boolean,
    default: false,
  },
  showDiscount: {
    type: Boolean,
    default: true,
  },
})

const discountPercent = computed(() => {
  if (!props.originalPrice || !props.price) return 0
  return Math.round((1 - props.price / props.originalPrice) * 100)
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat(props.locale, {
    style: 'currency',
    currency: props.currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  }).format(value)
}

const formattedPrice = computed(() => formatCurrency(props.price))
const formattedOriginalPrice = computed(() => formatCurrency(props.originalPrice))
</script>

<style lang="scss" scoped>
.service-price-display {
  display: flex;
  align-items: baseline;
  gap: 0.375rem;
  flex-wrap: wrap;

  &__label {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
  }

  &__price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-success);
  }

  &__original {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
  }

  &__discount {
    display: inline-flex;
    align-items: center;
    padding: 0.125rem 0.375rem;
    font-size: 0.6875rem;
    font-weight: 600;
    background: var(--bulma-danger);
    color: var(--bulma-danger-invert);
    border-radius: var(--bulma-radius-small);
  }

  &--compact {
    .service-price-display__price {
      font-size: 0.875rem;
    }

    .service-price-display__label {
      font-size: 0.625rem;
    }

    .service-price-display__original {
      font-size: 0.75rem;
    }
  }
}
</style>
