<template>
  <div
    class="gallery"
    :class="[
      `gallery--cols-${columns}`,
      `gallery--gap-${gapSize}`,
    ]"
  >
    <div
      v-for="(item, index) in items"
      :key="index"
      class="gallery__item"
      :class="[`gallery__item--${item.aspect || 'square'}`, { 'gallery__item--selectable': selectable }]"
      @click="$emit('item-click', item, index)"
    >
      <img :src="item.src" :alt="item.alt || item.caption || ''">

      <div v-if="item.caption || $slots.overlay" class="gallery__overlay">
        <slot name="overlay" :item="item" :index="index">
          <button v-if="selectable" class="gallery__action" @click.stop="$emit('select', item, index)">
            <i class="bi bi-check2"></i>
          </button>
          <button v-if="removable" class="gallery__action" @click.stop="$emit('remove', item, index)">
            <i class="bi bi-trash"></i>
          </button>
        </slot>
      </div>

      <div v-if="item.caption" class="gallery__caption">
        {{ item.caption }}
      </div>

      <div v-if="selected && selected.includes(index)" class="gallery__selected-badge">
        <i class="bi bi-check"></i>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    default: () => [],
  },
  columns: {
    type: Number,
    default: 2,
    validator: (v) => [1, 2, 3, 4].includes(v),
  },
  gapSize: {
    type: String,
    default: 'md',
    validator: (v) => ['none', 'sm', 'md', 'lg'].includes(v),
  },
  selectable: { type: Boolean, default: false },
  removable: { type: Boolean, default: false },
  selected: { type: Array, default: () => [] },
})

defineEmits(['item-click', 'select', 'remove'])
</script>

<style lang="scss" scoped>
.gallery {
  display: grid;

  &--cols-1 { grid-template-columns: repeat(1, 1fr); }
  &--cols-2 { grid-template-columns: repeat(2, 1fr); }
  &--cols-3 { grid-template-columns: repeat(3, 1fr); }
  &--cols-4 { grid-template-columns: repeat(4, 1fr); }

  &--gap-none { gap: 0; }
  &--gap-sm { gap: 0.5rem; }
  &--gap-md { gap: 0.75rem; }
  &--gap-lg { gap: 1rem; }

  &__item {
    position: relative;
    overflow: hidden;
    border-radius: var(--bulma-radius-medium);
    background: var(--bulma-scheme-main-bis);

    &--selectable {
      cursor: pointer;
    }

    &:hover .gallery__overlay {
      opacity: 1;
    }

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    &--square { aspect-ratio: 1 / 1; }
    &--portrait { aspect-ratio: 3 / 4; }
    &--landscape { aspect-ratio: 4 / 3; }
    &--wide { aspect-ratio: 16 / 9; }
  }

  &__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: oklch(0 0 0 / 0.5);
    opacity: 0;
    transition: opacity 150ms;
  }

  &__action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    background: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 150ms;

    &:hover {
      transform: scale(1.1);
    }

    i {
      font-size: 1.25rem;
      color: var(--bulma-text);
    }
  }

  &__caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0.75rem;
    background: linear-gradient(transparent, oklch(0 0 0 / 0.7));
    color: white;
    font-size: 0.875rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  &__selected-badge {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 1.5rem;
    height: 1.5rem;
    background: var(--bulma-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
  }
}
</style>
