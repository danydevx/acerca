<template>
  <div v-if="badge" class="catalog-badge" :class="[`is-${type || 'primary'}`]">{{ badge }}</div>
</template>

<script setup>
defineProps({
  badge: { type: String, default: '' },
  type: { type: String, default: 'primary' },
})
</script>

<style lang="scss" scoped>
.catalog-badge {
  position: absolute;
  top: 0.5rem;
  left: 0.5rem;
  padding: 0.25rem 0.5rem;
  border-radius: var(--bulma-radius-small);
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--bulma-scheme-main);

  &.is-primary { background: var(--bulma-primary); }
  &.is-info { background: var(--bulma-info); }
  &.is-success { background: var(--bulma-success); }
  &.is-warning { background: var(--bulma-warning); }
  &.is-danger { background: var(--bulma-danger); }
}
</style>
