<template>
  <article
    class="content-card"
    :class="[
      `content-card--${variant}`,
      {
        'content-card--horizontal': horizontal,
        'content-card--interactive': interactive,
        'content-card--minimal': minimal,
      }
    ]"
    @click="interactive && $emit('click')"
  >
    <div v-if="$slots.media || src" class="content-card__media">
      <slot name="media">
        <img v-if="src" :src="src" :alt="title">
        <div v-else class="content-card__placeholder"><i class="bi bi-image"></i></div>
      </slot>
      <div v-if="badge && !minimal" class="content-card__badge" :class="[`is-${badgeType || 'primary'}`]">{{ badge }}</div>
    </div>
    <div class="content-card__body">
      <div v-if="eyebrow && !minimal" class="content-card__eyebrow">{{ eyebrow }}</div>
      <h3 v-if="title" class="content-card__title">{{ title }}</h3>
      <p v-if="description && !minimal" class="content-card__description">{{ description }}</p>
      <div v-if="!minimal" class="content-card__footer">
        <div v-if="$slots.meta || (author || readTime)" class="content-card__meta">
          <slot name="meta">
            <span v-if="author" class="content-card__author">
              <UiAvatar v-if="authorAvatar" :src="authorAvatar" :size="24" />
              <span v-else-if="authorInitials" class="content-card__author-initials">{{ authorInitials }}</span>
              {{ author }}
            </span>
            <span v-if="readTime" class="content-card__read-time">{{ readTime }}</span>
          </slot>
        </div>
        <slot name="footer"></slot>
      </div>
    </div>
  </article>
</template>

<script setup>
defineProps({
  variant: { type: String, default: 'default' },
  src: { type: String, default: '' },
  eyebrow: { type: String, default: '' },
  title: { type: String, default: '' },
  description: { type: String, default: '' },
  badge: { type: String, default: '' },
  badgeType: { type: String, default: 'primary' },
  author: { type: String, default: '' },
  authorAvatar: { type: String, default: '' },
  authorInitials: { type: String, default: '' },
  readTime: { type: String, default: '' },
  horizontal: { type: Boolean, default: false },
  interactive: { type: Boolean, default: false },
  minimal: { type: Boolean, default: false },
})

defineEmits(['click'])
</script>

<style lang="scss" scoped>
.content-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  transition: all 150ms;

  &--interactive {
    cursor: pointer;

    &:hover {
      box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
      transform: translateY(-2px);
    }

    &:active {
      transform: translateY(0);
    }
  }

  &--horizontal {
    flex-direction: row;

    .content-card__media {
      width: 280px;
      flex-shrink: 0;
      aspect-ratio: auto;
    }

    .content-card__body {
      flex: 1;
      padding: 1.25rem;
    }
  }

  &--minimal {
    flex-direction: row;
    border: none;
    background: transparent;
    border-radius: var(--bulma-radius);

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    .content-card__media {
      width: 64px;
      height: 64px;
      border-radius: var(--bulma-radius);
      aspect-ratio: 1;
      flex-shrink: 0;
    }

    .content-card__body {
      flex: 1;
      padding: 0.5rem 0.75rem;
      gap: 0.25rem;
    }

    .content-card__title {
      font-size: 0.9375rem;
      -webkit-line-clamp: 1;
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 16 / 9;
    background: var(--bulma-scheme-main-bis);
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
    font-size: 2.5rem;
  }

  &__badge {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: var(--bulma-radius-rounded);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-scheme-main);

    &.is-primary { background: var(--bulma-primary); }
    &.is-info { background: var(--bulma-info); }
    &.is-success { background: var(--bulma-success); }
    &.is-warning { background: var(--bulma-warning); }
    &.is-danger { background: var(--bulma-danger); }
    &.is-link { background: var(--bulma-link); }
  }

  &__body {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
  }

  &__eyebrow {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-link);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.75rem;
  }

  &__meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &__author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__author-initials {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--bulma-primary);
    color: var(--bulma-primary-invert);
    font-size: 0.625rem;
    font-weight: 600;
  }

  &__read-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;

    &::before {
      content: '·';
    }
  }
}
</style>
