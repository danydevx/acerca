<template>
  <div class="menu-grid" :class="`menu-grid--${columns}`">
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  columns: {
    type: String,
    default: '3',
    validator: (v) => ['2', '3', '4'].includes(v),
  },
})
</script>

<style lang="scss" scoped>
.menu-grid {
  display: grid;
  gap: 1rem;

  &--2 {
    grid-template-columns: repeat(2, 1fr);

    @media (max-width: 480px) {
      grid-template-columns: 1fr;
    }
  }

  &--3 {
    grid-template-columns: repeat(3, 1fr);

    @media (max-width: 768px) {
      grid-template-columns: repeat(2, 1fr);
    }

    @media (max-width: 480px) {
      grid-template-columns: 1fr;
    }
  }

  &--4 {
    grid-template-columns: repeat(4, 1fr);

    @media (max-width: 1024px) {
      grid-template-columns: repeat(3, 1fr);
    }

    @media (max-width: 768px) {
      grid-template-columns: repeat(2, 1fr);
    }

    @media (max-width: 480px) {
      grid-template-columns: 1fr;
    }
  }
}
</style>
