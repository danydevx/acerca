<template>
  <div class="page-content" :class="[`page-content--${variant}`, `page-content--padding-${padding}`]">
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  variant: { type: String, default: 'default', validator: (v) => ['', 'default', 'contained', 'fluid'].includes(v) },
  padding: { type: String, default: 'md', validator: (v) => ['none', 'sm', 'md', 'lg'].includes(v) },
})
</script>

<style lang="scss" scoped>
.page-content {
  width: 100%;

  &--default {
    padding: 1.5rem;
  }

  &--contained {
    max-width: 960px;
    margin: 0 auto;
    padding: 1.5rem;
  }

  &--fluid {
    padding: 0;
  }

  &--padding-none { padding: 0; }
  &--padding-sm { padding: 0.75rem; }
  &--padding-md { padding: 1.5rem; }
  &--padding-lg { padding: 3rem; }
}
</style>
