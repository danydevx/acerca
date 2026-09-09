<template>
  <div class="product-meta" :class="{ 'product-meta--compact': compact }">
    <span v-if="sku" class="product-meta__item">
      <span class="product-meta__label">{{ skuLabel }}:</span>
      <span class="product-meta__value">{{ sku }}</span>
    </span>
    <span v-if="category" class="product-meta__item">
      <span class="product-meta__label">{{ categoryLabel }}:</span>
      <span class="product-meta__value">{{ category }}</span>
    </span>
    <span v-if="brand" class="product-meta__item">
      <span class="product-meta__label">{{ brandLabel }}:</span>
      <span class="product-meta__value">{{ brand }}</span>
    </span>
    <div v-if="tags && tags.length" class="product-meta__tags">
      <span
        v-for="(tag, index) in tags"
        :key="index"
        class="product-meta__tag"
      >
        {{ tag }}
      </span>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  sku: {
    type: String,
    default: '',
  },
  category: {
    type: String,
    default: '',
  },
  brand: {
    type: String,
    default: '',
  },
  tags: {
    type: Array,
    default: () => [],
  },
  skuLabel: {
    type: String,
    default: 'SKU',
  },
  categoryLabel: {
    type: String,
    default: 'Categoría',
  },
  brandLabel: {
    type: String,
    default: 'Marca',
  },
  compact: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.product-meta {
  display: flex;
  flex-direction: column;
  gap: 0.375rem;
  font-size: 0.8125rem;

  &--compact {
    gap: 0.25rem;
    font-size: 0.75rem;
  }

  &__item {
    display: flex;
    gap: 0.375rem;
  }

  &__label {
    color: var(--bulma-text-weak);
  }

  &__value {
    color: var(--bulma-text);
    font-weight: 500;
  }

  &__tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.375rem;
    margin-top: 0.25rem;
  }

  &__tag {
    padding: 0.125rem 0.5rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius-small);
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
  }
}
</style>
