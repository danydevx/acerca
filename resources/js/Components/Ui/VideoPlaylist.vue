<template>
  <div class="video-playlist" :class="{ 'video-playlist--horizontal': horizontal }">
    <div v-if="$slots.header || title" class="video-playlist__header">
      <slot name="header">
        <h3 v-if="title" class="video-playlist__title">{{ title }}</h3>
      </slot>
    </div>
    <div class="video-playlist__items">
      <div
        v-for="(item, index) in items"
        :key="index"
        class="video-playlist__item"
        :class="{ 'is-active': activeIndex === index }"
        @click="$emit('item-click', item, index)"
      >
        <div class="video-playlist__thumbnail">
          <img v-if="item.thumbnail" :src="item.thumbnail" :alt="item.title">
          <div v-else class="video-playlist__placeholder">
            <i class="bi bi-play-circle"></i>
          </div>
          <span v-if="item.duration" class="video-playlist__duration">{{ formatDuration(item.duration) }}</span>
          <div v-if="activeIndex === index" class="video-playlist__playing">
            <i class="bi bi-play-fill"></i>
          </div>
        </div>
        <div class="video-playlist__info">
          <span class="video-playlist__name">{{ item.title }}</span>
          <span v-if="item.meta" class="video-playlist__meta">{{ item.meta }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: '' },
  items: { type: Array, default: () => [] },
  activeIndex: { type: Number, default: -1 },
  horizontal: { type: Boolean, default: false },
})

defineEmits(['item-click'])

const formatDuration = (seconds) => {
  if (!seconds || isNaN(seconds)) return '0:00'
  const mins = Math.floor(seconds / 60)
  const secs = Math.floor(seconds % 60)
  return `${mins}:${secs.toString().padStart(2, '0')}`
}
</script>

<style lang="scss" scoped>
.video-playlist {
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &--horizontal {
    .video-playlist__items {
      display: flex;
      overflow-x: auto;
    }

    .video-playlist__item {
      flex-shrink: 0;
      width: 180px;
    }
  }

  &__header {
    padding: 0.75rem 1rem;
    background: var(--bulma-scheme-main-bis);
    border-bottom: 1px solid var(--bulma-border);
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__items {
    max-height: 400px;
    overflow-y: auto;
  }

  &__item {
    display: flex;
    gap: 0.75rem;
    padding: 0.75rem;
    cursor: pointer;
    transition: background 150ms;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &.is-active {
      background: color-mix(in oklch, var(--bulma-primary) 10%, var(--bulma-scheme-main));
      border-left: 3px solid var(--bulma-primary);
    }
  }

  &__thumbnail {
    position: relative;
    width: 100px;
    aspect-ratio: 16 / 9;
    flex-shrink: 0;
    border-radius: var(--bulma-radius-small);
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 1.5rem;
    }
  }

  &__duration {
    position: absolute;
    bottom: 0.25rem;
    right: 0.25rem;
    padding: 0.0625rem 0.25rem;
    background: oklch(0 0 0 / 0.8);
    color: #fff;
    font-size: 0.6875rem;
    font-weight: 500;
    border-radius: 2px;
  }

  &__playing {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: oklch(0 0 0 / 0.4);
    color: #fff;

    i {
      font-size: 1.5rem;
    }
  }

  &__info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
  }

  &__name {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__meta {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;
  }
}
</style>
