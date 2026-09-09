<template>
  <div class="menu-price" :class="{ 'menu-price--inline': inline }">
    <span v-if="originalPrice && showDiscount" class="menu-price__original">
      {{ formatPrice(originalPrice) }}
    </span>
    <span class="menu-price__current" :class="`menu-price__current--${size}`">
      {{ formatPrice(price) }}
    </span>
    <span v-if="unit" class="menu-price__unit">{{ unit }}</span>
    <span v-if="showDiscount && discountPercent" class="menu-price__discount">
      -{{ discountPercent }}%
    </span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  price: {
    type: Number,
    required: true,
  },
  originalPrice: {
    type: Number,
    default: null,
  },
  unit: {
    type: String,
    default: '',
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  showDiscount: {
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

const discountPercent = computed(() => {
  if (!props.originalPrice || !props.price) return null
  const discount = Math.round((1 - props.price / props.originalPrice) * 100)
  return discount > 0 ? discount : null
})

const formatPrice = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat(props.locale, {
    style: 'currency',
    currency: props.currency,
  }).format(value)
}
</script>

<style lang="scss" scoped>
.menu-price {
  display: flex;
  align-items: baseline;
  gap: 0.5rem;
  flex-wrap: wrap;

  &--inline {
    display: inline-flex;
  }

  &__original {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
  }

  &__current {
    font-weight: 700;
    color: var(--bulma-success);

    &--sm {
      font-size: 0.9375rem;
    }

    &--md {
      font-size: 1.125rem;
    }

    &--lg {
      font-size: 1.5rem;
    }
  }

  &__unit {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    font-weight: 400;
  }

  &__discount {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.125rem 0.375rem;
    background: var(--bulma-danger);
    color: white;
    border-radius: var(--bulma-radius-small);
  }
}
</style>
