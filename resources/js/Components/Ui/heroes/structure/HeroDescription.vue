<template>
  <p class="hero-description" :class="{ 'hero-description--centered': centered }">
    {{ text }}
  </p>
</template>

<script setup>
defineProps({
  text: {
    type: String,
    default: '',
  },
  centered: {
    type: Boolean,
    default: false,
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
})
</script>

<style lang="scss" scoped>
.hero-description {
  margin: 0;
  color: var(--bulma-text-weak);
  line-height: 1.5;

  &--centered {
    text-align: center;
  }
}
</style>
