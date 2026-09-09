<template>
  <div class="skeleton-group" :class="{ 'skeleton-group--card': variant === 'card' }">
    <slot>
      <template v-if="variant === 'card'">
        <Skeleton variant="image" />
        <div class="skeleton-group__content">
          <Skeleton variant="title" />
          <Skeleton variant="text" />
          <Skeleton variant="text" width="70%" />
        </div>
      </template>
      <template v-else-if="variant === 'list'">
        <div v-for="i in rows" :key="i" class="skeleton-group__list-item">
          <Skeleton variant="avatar-sm" />
          <div class="skeleton-group__list-text">
            <Skeleton variant="title" width="60%" />
            <Skeleton variant="text" width="90%" />
          </div>
        </div>
      </template>
      <template v-else-if="variant === 'product'">
        <Skeleton variant="image" />
        <div class="skeleton-group__product-content">
          <Skeleton variant="text" />
          <Skeleton variant="title" width="40%" />
          <Skeleton variant="badge" />
        </div>
      </template>
      <template v-else>
        <Skeleton v-for="i in rows" :key="i" :variant="variant" :width="width" />
      </template>
    </slot>
  </div>
</template>

<script setup>
import Skeleton from './Skeleton.vue'

defineProps({
  variant: {
    type: String,
    default: 'single',
    validator: (v) => ['single', 'card', 'list', 'product', 'text', 'avatar'].includes(v),
  },
  rows: {
    type: Number,
    default: 3,
  },
  width: {
    type: String,
    default: null,
  },
})
</script>

<style lang="scss" scoped>
.skeleton-group {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;

  &--card {
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-large);
    overflow: hidden;
  }

  &__content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__product-content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__list-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
  }

  &__list-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }
}
</style>
