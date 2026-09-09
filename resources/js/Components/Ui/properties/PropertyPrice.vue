<template>
  <div class="property-price" :class="{ 'property-price--rent': isRent }">
    <span class="property-price__value">{{ formattedPrice }}</span>
    <span v-if="priceType === 'rent' && showPeriod" class="property-price__period">/ {{ period }}</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  price: {
    type: [String, Number],
    required: true,
  },
  priceType: {
    type: String,
    default: 'sale',
    validator: (v) => ['sale', 'rent', 'both'].includes(v),
  },
  period: {
    type: String,
    default: 'mes',
  },
  showPeriod: {
    type: Boolean,
    default: true,
  },
  currency: {
    type: String,
    default: 'MXN',
  },
  locale: {
    type: String,
    default: 'es-MX',
  },
})

const isRent = computed(() => props.priceType === 'rent')

const formattedPrice = computed(() => {
  const num = typeof props.price === 'string' ? parseFloat(props.price.replace(/[^0-9.-]/g, '')) : props.price
  if (isNaN(num)) return props.price

  return new Intl.NumberFormat(props.locale, {
    style: 'currency',
    currency: props.currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(num)
})
</script>

<style lang="scss" scoped>
.property-price {
  display: flex;
  align-items: baseline;
  gap: 0.125rem;

  &__value {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--bulma-text);
  }

  &__period {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &--rent {
    .property-price__value {
      color: var(--bulma-success);
    }
  }
}
</style>
