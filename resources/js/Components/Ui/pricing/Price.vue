<template>
  <span class="price" :class="{ 'price--large': size === 'lg', 'price--small': size === 'sm' }">
    {{ formattedPrice }}
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: [String, Number],
    required: true,
  },
  currency: {
    type: String,
    default: 'MXN',
  },
  locale: {
    type: String,
    default: 'es-MX',
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
})

const formattedPrice = computed(() => {
  const num = typeof props.value === 'string' ? parseFloat(props.value) : props.value
  if (isNaN(num)) return props.value

  return new Intl.NumberFormat(props.locale, {
    style: 'currency',
    currency: props.currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  }).format(num)
})
</script>

<style lang="scss" scoped>
.price {
  font-weight: 700;
  color: var(--bulma-text);

  &--sm {
    font-size: 0.875rem;
  }

  &--lg {
    font-size: 1.5rem;
  }
}
</style>
