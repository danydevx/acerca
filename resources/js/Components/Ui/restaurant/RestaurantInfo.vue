<template>
  <div class="restaurant-info">
    <div v-if="address" class="restaurant-info__item">
      <i class="bi bi-geo-alt restaurant-info__icon"></i>
      <div class="restaurant-info__content">
        <span class="restaurant-info__label">Dirección</span>
        <span class="restaurant-info__value">{{ address }}</span>
      </div>
    </div>

    <div v-if="phone" class="restaurant-info__item">
      <i class="bi bi-telephone restaurant-info__icon"></i>
      <div class="restaurant-info__content">
        <span class="restaurant-info__label">Teléfono</span>
        <a :href="`tel:${phone}`" class="restaurant-info__link">{{ phone }}</a>
      </div>
    </div>

    <div v-if="email" class="restaurant-info__item">
      <i class="bi bi-envelope restaurant-info__icon"></i>
      <div class="restaurant-info__content">
        <span class="restaurant-info__label">Email</span>
        <a :href="`mailto:${email}`" class="restaurant-info__link">{{ email }}</a>
      </div>
    </div>

    <div v-if="website" class="restaurant-info__item">
      <i class="bi bi-globe restaurant-info__icon"></i>
      <div class="restaurant-info__content">
        <span class="restaurant-info__label">Web</span>
        <a :href="website" target="_blank" rel="noopener" class="restaurant-info__link">
          {{ formatWebsite(website) }}
        </a>
      </div>
    </div>

    <div v-if="hours" class="restaurant-info__item restaurant-info__item--hours">
      <i class="bi bi-clock restaurant-info__icon"></i>
      <div class="restaurant-info__content">
        <span class="restaurant-info__label">Horario</span>
        <div class="restaurant-info__hours">
          <div v-for="(schedule, day) in hours" :key="day" class="restaurant-info__schedule">
            <span class="restaurant-info__day">{{ day }}</span>
            <span class="restaurant-info__time">{{ schedule }}</span>
          </div>
        </div>
      </div>
    </div>

    <div v-if="social" class="restaurant-info__social">
      <a
        v-for="(url, network) in social"
        :key="network"
        :href="url"
        target="_blank"
        rel="noopener"
        class="restaurant-info__social-link"
        :aria-label="network"
      >
        <i :class="`bi bi-${network}`"></i>
      </a>
    </div>
  </div>
</template>

<script setup>
defineProps({
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
  website: {
    type: String,
    default: '',
  },
  hours: {
    type: Object,
    default: () => ({}),
  },
  social: {
    type: Object,
    default: () => ({}),
  },
})

const formatWebsite = (url) => {
  return url.replace(/^https?:\/\//, '').replace(/\/$/, '')
}
</script>

<style lang="scss" scoped>
.restaurant-info {
  display: flex;
  flex-direction: column;
  gap: 1rem;

  &__item {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;

    &--hours {
      align-items: flex-start;
    }
  }

  &__icon {
    font-size: 1.125rem;
    color: var(--bulma-link);
    flex-shrink: 0;
    width: 1.5rem;
    text-align: center;
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.025em;
  }

  &__value {
    font-size: 0.9375rem;
    color: var(--bulma-text);
  }

  &__link {
    font-size: 0.9375rem;
    color: var(--bulma-link);
    text-decoration: none;

    &:hover {
      text-decoration: underline;
    }
  }

  &__hours {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__schedule {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    font-size: 0.875rem;
  }

  &__day {
    color: var(--bulma-text);
    font-weight: 500;
  }

  &__time {
    color: var(--bulma-text-weak);
  }

  &__social {
    display: flex;
    gap: 0.75rem;
    padding-top: 0.5rem;
    border-top: 1px solid var(--bulma-border);
  }

  &__social-link {
    width: 2.25rem;
    height: 2.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    font-size: 1rem;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);
      transform: scale(1.1);
    }
  }
}
</style>
