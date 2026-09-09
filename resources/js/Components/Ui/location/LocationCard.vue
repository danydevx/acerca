<template>
  <article class="location-card">
    <div v-if="image" class="location-card__media">
      <img :src="image" :alt="name" loading="lazy">
    </div>

    <div class="location-card__content">
      <div class="location-card__header">
        <h3 class="location-card__name">{{ name }}</h3>
        <span v-if="distance" class="location-card__distance">{{ distance }}</span>
      </div>

      <p v-if="address" class="location-card__address">
        <i class="bi bi-geo-alt"></i>
        {{ address }}
      </p>

      <div v-if="hasContact" class="location-card__contact">
        <a
          v-if="phone"
          :href="`tel:${phone}`"
          class="location-card__contact-item"
        >
          <i class="bi bi-telephone"></i>
          {{ phone }}
        </a>
        <a
          v-if="email"
          :href="`mailto:${email}`"
          class="location-card__contact-item"
        >
          <i class="bi bi-envelope"></i>
          {{ email }}
        </a>
      </div>

      <div v-if="hasHours" class="location-card__hours">
        <AvailabilityStatus
          :is-open="isOpen"
          :closes-at="closesAt"
          :show-time="true"
        />
      </div>

      <div class="location-card__actions">
        <a
          v-if="directionsUrl"
          :href="directionsUrl"
          target="_blank"
          rel="noopener noreferrer"
          class="location-card__action"
        >
          <i class="bi bi-sign-turn-right"></i>
          <span>Cómo llegar</span>
        </a>
        <a
          v-if="mapUrl"
          :href="mapUrl"
          target="_blank"
          rel="noopener noreferrer"
          class="location-card__action"
        >
          <i class="bi bi-map"></i>
          <span>Ver mapa</span>
        </a>
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'
import AvailabilityStatus from '@/Components/Ui/availability/AvailabilityStatus.vue'

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  address: {
    type: String,
    default: '',
  },
  phone: {
    type: String,
    default: '',
  },
  email: {
    type: String,
    default: '',
  },
  image: {
    type: String,
    default: '',
  },
  distance: {
    type: String,
    default: '',
  },
  isOpen: {
    type: Boolean,
    default: false,
  },
  closesAt: {
    type: String,
    default: '',
  },
  directionsUrl: {
    type: String,
    default: '',
  },
  mapUrl: {
    type: String,
    default: '',
  },
})

const hasContact = computed(() => props.phone || props.email)
const hasHours = computed(() => props.closesAt)
</script>

<style lang="scss" scoped>
.location-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &__media {
    aspect-ratio: 16 / 9;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1rem;
  }

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 0.5rem;
  }

  &__name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__distance {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--bulma-link);
    background: color-mix(in oklch, var(--bulma-link) 10%, transparent);
    padding: 0.25rem 0.5rem;
    border-radius: var(--bulma-radius-small);
    white-space: nowrap;
  }

  &__address {
    display: flex;
    align-items: flex-start;
    gap: 0.375rem;
    font-size: 0.875rem;
    color: var(--bulma-text);
    margin: 0;

    i {
      color: var(--bulma-text-weak);
      margin-top: 0.125rem;
    }
  }

  &__contact {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__contact-item {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--bulma-link);
    text-decoration: none;

    &:hover {
      text-decoration: underline;
    }

    i {
      color: var(--bulma-text-weak);
    }
  }

  &__hours {
    padding-top: 0.25rem;
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
    padding-top: 0.25rem;
    border-top: 1px solid var(--bulma-border);
  }

  &__action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--bulma-link);
    background: color-mix(in oklch, var(--bulma-link) 10%, transparent);
    border-radius: var(--bulma-radius);
    text-decoration: none;
    transition: background-color 0.15s;

    &:hover {
      background: color-mix(in oklch, var(--bulma-link) 20%, transparent);
    }

    i {
      font-size: 0.875rem;
    }
  }
}
</style>
