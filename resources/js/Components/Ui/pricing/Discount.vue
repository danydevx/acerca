<template>
  <span
    class="discount"
    :class="{
      'discount--prominent': prominent,
    }"
  >
    <i v-if="icon" class="bi" :class="icon"></i>
    <span class="discount__value">{{ formattedDiscount }}</span>
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: [String, Number],
    required: true,
  },
  type: {
    type: String,
    default: 'percent',
    validator: (v) => ['percent', 'amount'].includes(v),
  },
  currency: {
    type: String,
    default: 'MXN',
  },
  locale: {
    type: String,
    default: 'es-MX',
  },
  icon: {
    type: String,
    default: 'bi-tag',
  },
  prominent: {
    type: Boolean,
    default: false,
  },
})

const formattedDiscount = computed(() => {
  if (props.type === 'percent') {
    return `-${props.value}%`
  }

  const num = typeof props.value === 'string' ? parseFloat(props.value) : props.value
  if (isNaN(num)) return `-${props.value}`

  return `-${new Intl.NumberFormat(props.locale, {
    style: 'currency',
    currency: props.currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  }).format(num)}`
})
</script>

<style lang="scss" scoped>
.discount {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.5rem;
  background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
  color: var(--bulma-danger);
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: var(--bulma-radius-small);

  i {
    font-size: 0.6875rem;
  }

  &--prominent {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;

    i {
      font-size: 0.75rem;
    }
  }
}
</style>
