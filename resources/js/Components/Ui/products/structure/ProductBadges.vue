<template>
  <div class="product-badges">
    <span
      v-if="discountPercent > 0"
      class="product-badges__badge product-badges__badge--discount"
    >
      -{{ discountPercent }}%
    </span>
    <span
      v-if="showStock && quantity === 0"
      class="product-badges__badge product-badges__badge--out"
    >
      Agotado
    </span>
  </div>
</template>

<script setup>
defineProps({
  discountPercent: {
    type: Number,
    default: 0,
  },
  showStock: {
    type: Boolean,
    default: false,
  },
  quantity: {
    type: Number,
    default: null,
  },
})
</script>

<style lang="scss" scoped>
.product-badges {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  align-items: flex-end;
}

.product-badges__badge {
  padding: 0.25rem 0.5rem;
  border-radius: var(--bulma-radius-small);
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--bulma-scheme-main);

  &--discount {
    background: var(--bulma-danger);
  }

  &--out {
    background: var(--bulma-grey-light);
    color: var(--bulma-grey-darker);
  }
}
</style>
