<template>
  <section class="section-reviews">
    <div class="section-reviews__inner">
      <h2 v-if="title" class="section-reviews__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-reviews__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-reviews__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay reseñas disponibles.
      </div>

      <div v-else-if="viewMode === 'carousel'" class="section-reviews__carousel">
        <article
          v-for="review in displayedItems"
          :key="review.id"
          class="section-reviews__card orp-card"
        >
          <div class="orp-rating">
            <div class="orp-rating__icons">
              <i
                v-for="star in 5"
                :key="star"
                class="bi"
                :class="star <= review.rating ? 'bi-star-fill' : 'bi-star'"
              ></i>
            </div>
          </div>

          <p v-if="showComment && review.comment" class="section-reviews__comment">
            "{{ review.comment }}"
          </p>

          <div class="section-reviews__author">
            <strong v-if="showClientName">{{ review.client_name }}</strong>
            <span v-if="review.company"> - {{ review.company }}</span>
          </div>

          <a
            v-if="review.google_link"
            :href="review.google_link"
            target="_blank"
            class="orp-btn orp-btn--ghost orp-btn--sm"
          >
            <i class="bi bi-google"></i> Ver en Google
          </a>
        </article>
      </div>

      <div v-else-if="viewMode === 'list'" class="section-reviews__list">
        <article
          v-for="review in displayedItems"
          :key="review.id"
          class="section-reviews__list-item orp-card"
        >
          <div class="orp-rating">
            <div class="orp-rating__icons">
              <i
                v-for="star in 5"
                :key="star"
                class="bi"
                :class="star <= review.rating ? 'bi-star-fill' : 'bi-star'"
              ></i>
            </div>
          </div>

          <p v-if="showComment && review.comment" class="section-reviews__comment">
            "{{ review.comment }}"
          </p>

          <div class="section-reviews__author">
            <strong v-if="showClientName">{{ review.client_name }}</strong>
            <span v-if="review.company"> - {{ review.company }}</span>
          </div>

          <a
            v-if="review.google_link"
            :href="review.google_link"
            target="_blank"
            class="orp-btn orp-btn--ghost orp-btn--sm"
          >
            <i class="bi bi-google"></i> Ver en Google
          </a>
        </article>
      </div>

      <div v-else class="section-reviews__grid">
        <article
          v-for="review in displayedItems"
          :key="review.id"
          class="section-reviews__card orp-card"
        >
          <div class="orp-rating">
            <div class="orp-rating__icons">
              <i
                v-for="star in 5"
                :key="star"
                class="bi"
                :class="star <= review.rating ? 'bi-star-fill' : 'bi-star'"
              ></i>
            </div>
          </div>

          <p v-if="showComment && review.comment" class="section-reviews__comment">
            "{{ review.comment }}"
          </p>

          <div class="section-reviews__author">
            <strong v-if="showClientName">{{ review.client_name }}</strong>
            <span v-if="review.company"> - {{ review.company }}</span>
          </div>

          <a
            v-if="review.google_link"
            :href="review.google_link"
            target="_blank"
            class="orp-btn orp-btn--ghost orp-btn--sm"
          >
            <i class="bi bi-google"></i> Ver en Google
          </a>
        </article>
      </div>

      <div v-if="hasMoreItems" class="section-reviews__show-all">
        <a :href="allReviewsUrl" class="orp-btn orp-btn--ghost">
          Ver todas las reseñas ({{ items.length }})
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: String,
  subtitle: String,
  items: {
    type: Array,
    default: () => [],
  },
  config: Object,
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
})

const viewMode = computed(() => props.config?.view_mode || 'grid')

const maxItems = computed(() => {
  if (props.config?.show_all) return props.items.length
  return props.config?.max_items || 12
})

const displayedItems = computed(() => {
  return props.items.slice(0, maxItems.value)
})

const hasMoreItems = computed(() => {
  return !props.config?.show_all && props.items.length > maxItems.value
})

const allReviewsUrl = computed(() => {
  return '#reviews'
})

const showComment = computed(() => {
  return props.config?.show_comment !== false
})

const showClientName = computed(() => {
  return props.config?.show_client_name !== false
})
</script>

<script>
import { computed } from 'vue'
export default {
  name: 'SectionReviews'
}
</script>

<style lang="less">
.section-reviews {
  padding: var(--orp-space-6) var(--orp-space-2);
  background: var(--orp-background);

  &__inner {
    max-width: 1024px;
    margin: 0 auto;
  }

  &__title {
    font-weight: 700;
    margin: 0 0 var(--orp-space-1);
    text-align: center;
    color: var(--orp-foreground);
  }

  &__subtitle {
    font-weight: 600;
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__description-text {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--orp-space-4);
  }

  &__carousel {
    display: flex;
    gap: var(--orp-space-3);
    overflow-x: auto;
    padding-bottom: var(--orp-space-3);
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;

    &::-webkit-scrollbar {
      height: 4px;
    }

    &::-webkit-scrollbar-track {
      background: var(--orp-surface-muted);
      border-radius: 2px;
    }

    &::-webkit-scrollbar-thumb {
      background: var(--orp-border);
      border-radius: 2px;
    }
  }

  &__carousel &__card {
    flex: 0 0 280px;
    scroll-snap-align: start;
  }

  &__list {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-3);
  }

  &__list-item {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-2);
  }

  &__card {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-3);
  }

  &__comment {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    line-height: 1.6;
    margin: 0;
    font-style: italic;
  }

  &__author {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-foreground);

    strong {
      color: var(--orp-foreground);
    }
  }

  &__show-all {
    display: flex;
    justify-content: center;
    margin-top: var(--orp-space-4);
  }
}
</style>
