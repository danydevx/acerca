<template>
  <div
    class="media-card"
    :class="[
      variantClass,
      { 'media-card--interactive': interactive }
    ]"
  >
    <div v-if="$slots.media || src" class="media-card__media">
      <img v-if="src" :src="src" :alt="title">
      <slot name="media"></slot>
    </div>

    <div class="media-card__body">
      <div v-if="eyebrow" class="media-card__eyebrow">{{ eyebrow }}</div>
      <h3 v-if="title" class="media-card__title" :class="{ 'media-card__title--clamp': clampTitle }">{{ title }}</h3>
      <p v-if="description" class="media-card__description" :class="{ 'media-card__description--clamp': clampDescription }">{{ description }}</p>

      <div v-if="meta.length" class="media-card__meta">
        <span v-for="(item, index) in meta" :key="index" class="media-card__meta-item">
          <i v-if="item.icon" :class="item.icon"></i>
          {{ item.text }}
        </span>
      </div>

      <slot></slot>
    </div>

    <div v-if="$slots.footer" class="media-card__footer">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  src: { type: String, default: '' },
  title: { type: String, default: '' },
  eyebrow: { type: String, default: '' },
  description: { type: String, default: '' },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'compact', 'horizontal', 'featured'].includes(v),
  },
  interactive: { type: Boolean, default: false },
  clampTitle: { type: Boolean, default: false },
  clampDescription: { type: Boolean, default: false },
  meta: { type: Array, default: () => [] },
})

const variantClass = computed(() => `media-card--${props.variant}`)
</script>

<style lang="scss" scoped>
.media-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &__media {
    position: relative;
    width: 100%;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__body {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.75rem;
  }

  &__eyebrow {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--bulma-primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;

    &--clamp {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.5;

    &--clamp {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.25rem;
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
    padding: 0.75rem;
    padding-top: 0;
  }

  &--compact {
    .media-card__body {
      padding: 0.5rem;
      gap: 0.25rem;
    }

    .media-card__title {
      font-size: 0.875rem;
    }
  }

  &--horizontal {
    flex-direction: row;

    .media-card__media {
      width: 120px;
      flex-shrink: 0;
    }

    .media-card__body {
      flex: 1;
      justify-content: center;
    }

    @media (max-width: 360px) {
      flex-direction: column;

      .media-card__media {
        width: 100%;
      }
    }
  }

  &--featured {
    .media-card__media {
      aspect-ratio: 16 / 9;
    }

    .media-card__body {
      padding: 1rem;
      gap: 0.75rem;
    }

    .media-card__title {
      font-size: 1.25rem;
    }
  }

  &--interactive {
    cursor: pointer;
    transition: transform 150ms, box-shadow 150ms;

    &:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
    }

    &:active {
      transform: translateY(0);
    }
  }
}
</style>
