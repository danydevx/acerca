<template>
  <div class="catalog-pricing">
    <span v-if="value" class="catalog-pricing__price" :class="{ 'catalog-pricing__price--discount': discount }">
      <span v-if="discount" class="catalog-pricing__original">${{ originalValue }}</span>
      <span class="catalog-pricing__current">${{ value }}</span>
    </span>
    <span v-if="unit" class="catalog-pricing__unit">{{ unit }}</span>
  </div>
</template>

<script setup>
defineProps({
  value: { type: [String, Number], default: '' },
  originalValue: { type: [String, Number], default: '' },
  discount: { type: Number, default: 0 },
  unit: { type: String, default: '' },
})
</script>

<style lang="scss" scoped>
.catalog-pricing {
  display: flex;
  align-items: baseline;
  gap: 0.25rem;
  margin-top: auto;
}

.catalog-pricing__price {
  display: flex;
  align-items: baseline;
  gap: 0.5rem;

  &-original {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
  }

  &-current {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-text);
  }

  &--discount &-current {
    color: var(--bulma-danger);
  }
}

.catalog-pricing__unit {
  font-size: 0.75rem;
  color: var(--bulma-text-weak);
}
</style>
