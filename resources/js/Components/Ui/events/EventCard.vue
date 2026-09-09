<template>
  <article class="event-card" :class="{ 'event-card--horizontal': horizontal }">
    <div v-if="image" class="event-card__media">
      <img :src="image" :alt="title" loading="lazy">
      <div v-if="price" class="event-card__price">{{ price }}</div>
    </div>

    <div class="event-card__content">
      <div class="event-card__header">
        <EventDate v-if="date" :date="date" :compact="true" />
        <div class="event-card__info">
          <h3 class="event-card__title">{{ title }}</h3>
          <p v-if="subtitle" class="event-card__subtitle">{{ subtitle }}</p>
        </div>
      </div>

      <div v-if="showMeta && (time || location)" class="event-card__meta">
        <EventTime v-if="time" :start="time.start" :end="time.end" :compact="true" />
        <EventLocation v-if="location" :name="location.name" :address="location.address" :compact="true" />
      </div>

      <p v-if="description" class="event-card__description">{{ truncatedDescription }}</p>

      <div v-if="$slots.actions" class="event-card__actions">
        <slot name="actions" />
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'
import EventDate from './EventDate.vue'
import EventTime from './EventTime.vue'
import EventLocation from './EventLocation.vue'

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  subtitle: {
    type: String,
    default: '',
  },
  date: {
    type: [Date, String],
    default: null,
  },
  time: {
    type: Object,
    default: null,
  },
  location: {
    type: Object,
    default: null,
  },
  image: {
    type: String,
    default: '',
  },
  price: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  horizontal: {
    type: Boolean,
    default: false,
  },
  showMeta: {
    type: Boolean,
    default: true,
  },
  maxDescriptionLength: {
    type: Number,
    default: 100,
  },
})

const truncatedDescription = computed(() => {
  if (!props.description) return ''
  if (props.description.length <= props.maxDescriptionLength) return props.description
  return props.description.substring(0, props.maxDescriptionLength) + '...'
})
</script>

<style lang="scss" scoped>
.event-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &__media {
    position: relative;
    aspect-ratio: 16 / 9;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__price {
    position: absolute;
    bottom: 0.5rem;
    right: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-small);
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1rem;
  }

  &__header {
    display: flex;
    gap: 0.75rem;
  }

  &__info {
    flex: 1;
    min-width: 0;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__subtitle {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0.25rem 0 0;
  }

  &__meta {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    line-height: 1.5;
    margin: 0;
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid var(--bulma-border);
  }

  &--horizontal {
    flex-direction: row;

    .event-card__media {
      width: 160px;
      aspect-ratio: auto;
      flex-shrink: 0;
    }

    .event-card__content {
      flex: 1;
    }

    @media (max-width: 480px) {
      flex-direction: column;

      .event-card__media {
        width: 100%;
        aspect-ratio: 16 / 9;
      }
    }
  }
}
</style>
