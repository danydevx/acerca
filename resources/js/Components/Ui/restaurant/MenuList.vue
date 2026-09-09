<template>
  <div class="menu-list" :class="{ 'menu-list--compact': compact }">
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  compact: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.menu-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;

  &--compact {
    gap: 0.5rem;
  }
}
</style>
