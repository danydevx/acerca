<template>
  <div
    class="media-container"
    :class="[`media-container--${aspect}`, { 'media-container--rounded': rounded }]"
  >
    <img
      v-if="src"
      :src="src"
      :alt="alt"
      class="media-container__content"
    >
    <div v-else-if="$slots.placeholder" class="media-container__placeholder">
      <slot name="placeholder"></slot>
    </div>
    <div v-if="$slots.overlay" class="media-container__overlay">
      <slot name="overlay"></slot>
    </div>
  </div>
</template>

<script setup>
defineProps({
  src: { type: String, default: '' },
  alt: { type: String, default: '' },
  aspect: {
    type: String,
    default: 'square',
    validator: (v) => ['square', 'portrait', 'landscape', 'wide'].includes(v),
  },
  rounded: { type: Boolean, default: false },
})
</script>

<style lang="scss" scoped>
.media-container {
  position: relative;
  overflow: hidden;
  background: var(--bulma-scheme-main-bis);

  &--square { aspect-ratio: 1 / 1; }
  &--portrait { aspect-ratio: 3 / 4; }
  &--landscape { aspect-ratio: 4 / 3; }
  &--wide { aspect-ratio: 16 / 9; }

  &--rounded { border-radius: var(--bulma-radius-medium); }

  &__content {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &__placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);
  }

  &__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: flex-end;
    padding: 1rem;
  }
}
</style>
