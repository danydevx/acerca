<template>
  <div v-if="durationMinutes" class="service-duration" :class="{ 'service-duration--inline': inline }">
    <i class="bi bi-clock"></i>
    <span>{{ durationMinutes }} min</span>
  </div>
</template>

<script setup>
defineProps({
  durationMinutes: {
    type: Number,
    default: null,
  },
  inline: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.service-duration {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.75rem;
  color: var(--bulma-text-weak);

  &--inline {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  &:not(&--inline) {
    position: absolute;
    bottom: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: oklch(0 0 0 / 0.6);
    color: var(--bulma-scheme-main);
    border-radius: var(--bulma-radius-small);
  }
}
</style>
