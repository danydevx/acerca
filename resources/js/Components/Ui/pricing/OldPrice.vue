<template>
  <span class="old-price">
    <s>{{ formattedPrice }}</s>
    <span v-if="label" class="old-price__label">{{ label }}</span>
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
  label: {
    type: String,
    default: '',
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
.old-price {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.875rem;
  color: var(--bulma-text-weak);

  s {
    text-decoration: line-through;
  }

  &__label {
    font-size: 0.75rem;
    text-transform: uppercase;
  }
}
</style>
