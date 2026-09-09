<template>
  <article class="review-card">
    <header class="review-card__header">
      <div class="review-card__author">
        <div v-if="authorImage" class="review-card__avatar">
          <img :src="authorImage" :alt="author" loading="lazy">
        </div>
        <div v-else class="review-card__avatar review-card__avatar--placeholder">
          <i class="bi bi-person"></i>
        </div>
        <div class="review-card__author-info">
          <span class="review-card__author-name">{{ author }}</span>
          <span v-if="date" class="review-card__date">{{ formattedDate }}</span>
        </div>
      </div>
      <Rating
        v-if="rating"
        :value="rating"
        :show-value="false"
        :show-count="false"
        :inline="true"
      />
    </header>

    <div v-if="title" class="review-card__title">{{ title }}</div>

    <p v-if="text" class="review-card__text">{{ text }}</p>

    <div v-if="source" class="review-card__source">
      <i :class="sourceIcon"></i>
      <span>{{ source }}</span>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'
import Rating from './Rating.vue'

const props = defineProps({
  author: {
    type: String,
    required: true,
  },
  authorImage: {
    type: String,
    default: '',
  },
  rating: {
    type: Number,
    default: null,
  },
  title: {
    type: String,
    default: '',
  },
  text: {
    type: String,
    default: '',
  },
  date: {
    type: [Date, String],
    default: null,
  },
  source: {
    type: String,
    default: '',
  },
})

const sourceIcons = {
  google: 'bi bi-google',
  facebook: 'bi bi-facebook',
  yelp: 'bi bi-yelp',
  tripadvisor: 'bi bi-tripadvisor',
  Booking: 'bi bi-booking',
  Expedia: 'bi bi-expedia',
}

const sourceIcon = computed(() => sourceIcons[props.source] || 'bi bi-star')

const formattedDate = computed(() => {
  if (!props.date) return ''
  const d = props.date instanceof Date ? props.date : new Date(props.date)
  return d.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
})
</script>

<style lang="scss" scoped>
.review-card {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  padding: 1rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 0.5rem;
  }

  &__author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &--placeholder {
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text-weak);

      i {
        font-size: 1.25rem;
      }
    }
  }

  &__author-info {
    display: flex;
    flex-direction: column;
  }

  &__author-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__date {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__text {
    font-size: 0.875rem;
    color: var(--bulma-text);
    line-height: 1.5;
    margin: 0;
  }

  &__source {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }
}
</style>
