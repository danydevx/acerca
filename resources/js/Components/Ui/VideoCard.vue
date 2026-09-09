<template>
  <div class="video-card" :class="{ 'video-card--horizontal': horizontal }">
    <div class="video-card__thumbnail" @click="$emit('click')">
      <img v-if="thumbnail" :src="thumbnail" :alt="title">
      <div v-else class="video-card__placeholder">
        <i class="bi bi-play-circle"></i>
      </div>
      <span v-if="duration" class="video-card__duration">{{ formatDuration(duration) }}</span>
      <div v-if="$slots.badges" class="video-card__badges">
        <slot name="badges"></slot>
      </div>
    </div>
    <div class="video-card__content">
      <h3 v-if="title" class="video-card__title" @click="$emit('click')">{{ title }}</h3>
      <div v-if="meta.length" class="video-card__meta">
        <template v-for="(item, index) in meta" :key="index">
          <span>{{ item }}</span>
          <span v-if="index < meta.length - 1" class="video-card__separator">•</span>
        </template>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: '' },
  thumbnail: { type: String, default: '' },
  duration: { type: Number, default: 0 },
  meta: { type: Array, default: () => [] },
  horizontal: { type: Boolean, default: false },
})

defineEmits(['click'])

const formatDuration = (seconds) => {
  if (!seconds || isNaN(seconds)) return '0:00'
  const hrs = Math.floor(seconds / 3600)
  const mins = Math.floor((seconds % 3600) / 60)
  const secs = Math.floor(seconds % 60)
  if (hrs > 0) {
    return `${hrs}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`
  }
  return `${mins}:${secs.toString().padStart(2, '0')}`
}
</script>

<style lang="scss" scoped>
.video-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  border: 1px solid var(--bulma-border);
  transition: box-shadow 150ms;

  &:hover {
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
  }

  &--horizontal {
    flex-direction: row;

    .video-card__thumbnail {
      width: 200px;
      flex-shrink: 0;
      aspect-ratio: 16 / 9;
    }

    .video-card__content {
      flex: 1;
      padding: 0.75rem;
    }
  }

  &__thumbnail {
    position: relative;
    aspect-ratio: 16 / 9;
    background: var(--bulma-scheme-main-bis);
    cursor: pointer;
    overflow: hidden;

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
      font-size: 3rem;
    }
  }

  &__duration {
    position: absolute;
    bottom: 0.5rem;
    right: 0.5rem;
    padding: 0.125rem 0.375rem;
    background: oklch(0 0 0 / 0.8);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: var(--bulma-radius-small);
  }

  &__badges {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    display: flex;
    gap: 0.25rem;
  }

  &__content {
    padding: 0.75rem;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
    cursor: pointer;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;

    &:hover {
      color: var(--bulma-link);
    }
  }

  &__meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &__separator {
    margin: 0 0.125rem;
  }
}
</style>
