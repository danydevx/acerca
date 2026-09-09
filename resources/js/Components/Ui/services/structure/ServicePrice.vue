<template>
  <div class="service-price">
    <span class="service-price__current" :class="{ 'has-text-danger': discountPercent > 0 }">
      {{ formattedPrice }}
    </span>
    <span
      v-if="showComparePrice && compareAtPrice"
      class="service-price__original"
    >
      <s>{{ formattedCompareAtPrice }}</s>
    </span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  price: {
    type: [String, Number],
    default: '',
  },
  compareAtPrice: {
    type: [String, Number],
    default: null,
  },
  showComparePrice: {
    type: Boolean,
    default: true,
  },
})

const discountPercent = computed(() => {
  if (!props.compareAtPrice || !props.price) return 0
  return Math.round((1 - props.price / props.compareAtPrice) * 100)
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  }).format(value)
}

const formattedPrice = computed(() => formatCurrency(props.price))
const formattedCompareAtPrice = computed(() => formatCurrency(props.compareAtPrice))
</script>

<style lang="scss" scoped>
.service-price {
  display: flex;
  align-items: baseline;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-top: auto;
}

.service-price__current {
  font-size: 1.125rem;
  font-weight: 700;
  color: var(--bulma-text);
}

.service-price__original {
  font-size: 0.8125rem;
  color: var(--bulma-text-weak);
}
</style>
