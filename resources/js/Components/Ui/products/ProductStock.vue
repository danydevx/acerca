<template>
  <div class="product-stock" :class="stockClass">
    <i :class="iconClass"></i>
    <span class="product-stock__label">{{ label }}</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  quantity: {
    type: Number,
    default: null,
  },
  lowThreshold: {
    type: Number,
    default: 5,
  },
  showQuantity: {
    type: Boolean,
    default: true,
  },
})

const stockClass = computed(() => {
  if (props.quantity === null || props.quantity === undefined) return 'product-stock--unknown'
  if (props.quantity === 0) return 'product-stock--out'
  if (props.quantity <= props.lowThreshold) return 'product-stock--low'
  return 'product-stock--in'
})

const iconClass = computed(() => {
  if (props.quantity === null || props.quantity === undefined) return 'bi bi-question-circle'
  if (props.quantity === 0) return 'bi bi-x-circle'
  if (props.quantity <= props.lowThreshold) return 'bi bi-exclamation-circle'
  return 'bi bi-check-circle'
})

const label = computed(() => {
  if (props.quantity === null || props.quantity === undefined) return 'Stock no disponible'
  if (props.quantity === 0) return 'Agotado'
  if (props.quantity <= props.lowThreshold) {
    return props.showQuantity ? `¡Solo ${props.quantity} restantes!` : 'Poco stock'
  }
  return props.showQuantity ? `En stock (${props.quantity})` : 'En stock'
})
</script>

<style lang="scss" scoped>
.product-stock {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.8125rem;
  font-weight: 500;

  i {
    font-size: 1rem;
  }

  &--in {
    color: var(--bulma-success);
  }

  &--low {
    color: var(--bulma-warning);
  }

  &--out {
    color: var(--bulma-danger);
  }

  &--unknown {
    color: var(--bulma-text-weak);
  }
}
</style>
