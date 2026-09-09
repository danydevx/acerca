<template>
  <article
    class="doctor-card"
    :class="{ 'doctor-card--available': available }"
    role="button"
    tabindex="0"
    @click="available && $emit('select', doctor)"
  >
    <div class="doctor-card__header">
      <div class="doctor-card__avatar">
        <img v-if="doctor.avatar" :src="doctor.avatar" :alt="doctor.name">
        <div v-else class="doctor-card__placeholder">
          <i class="bi bi-person-badge"></i>
        </div>
        <span v-if="available" class="doctor-card__badge doctor-card__badge--available">
          <i class="bi bi-check-circle-fill"></i> Disponible
        </span>
        <span v-else class="doctor-card__badge doctor-card__badge--unavailable">
          <i class="bi bi-x-circle-fill"></i> No disponible
        </span>
      </div>
    </div>

    <div class="doctor-card__content">
      <h4 class="doctor-card__name">Dr. {{ doctor.name }}</h4>
      <p v-if="doctor.specialty" class="doctor-card__specialty">{{ doctor.specialty }}</p>

      <div v-if="doctor.credentials?.length" class="doctor-card__credentials">
        <span v-for="cred in doctor.credentials.slice(0, 2)" :key="cred" class="doctor-card__credential">
          {{ cred }}
        </span>
      </div>

      <div class="doctor-card__rating">
        <div class="doctor-card__stars">
          <i v-for="n in 5" :key="n" class="bi" :class="n <= (doctor.rating || 5) ? 'bi-star-fill' : 'bi-star'"></i>
        </div>
        <span class="doctor-card__rating-text">{{ doctor.rating || 5.0 }} ({{ doctor.reviews || 0 }})</span>
      </div>
    </div>

    <div class="doctor-card__footer">
      <div v-if="doctor.next_available" class="doctor-card__next">
        <i class="bi bi-calendar-event"></i>
        <span>Próxima: {{ doctor.next_available }}</span>
      </div>
      <button
        v-if="available"
        class="doctor-card__btn"
        type="button"
        @click.stop="$emit('book', doctor)"
      >
        Reservar cita
      </button>
    </div>
  </article>
</template>

<script setup>
defineProps({
  doctor: {
    type: Object,
    required: true,
    default: () => ({
      name: '',
      avatar: '',
      specialty: '',
      credentials: [],
      rating: null,
      reviews: null,
      next_available: null,
    }),
  },
  available: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['select', 'book'])
</script>

<style lang="scss" scoped>
.doctor-card {
  display: flex;
  flex-direction: column;
  padding: 1.25rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  transition: all 0.2s;

  &:hover:not(&--available) {
    cursor: not-allowed;
  }

  &--available:hover {
    border-color: var(--bulma-link);
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.1);
  }

  &__header {
    margin-bottom: 1rem;
  }

  &__avatar {
    position: relative;
    width: 5rem;
    height: 5rem;
    margin: 0 auto;
    border-radius: 50%;
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

    i {
      font-size: 2.5rem;
      color: var(--bulma-text-weak);
    }
  }

  &__badge {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.5rem;
    font-size: 0.625rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-rounded);
    white-space: nowrap;

    &--available {
      background: var(--bulma-success);
      color: white;
    }

    &--unavailable {
      background: var(--bulma-grey);
      color: white;
    }
  }

  &__content {
    text-align: center;
    margin-bottom: 1rem;
  }

  &__name {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.125rem;
  }

  &__specialty {
    font-size: 0.8125rem;
    color: var(--bulma-link);
    font-weight: 500;
    margin: 0;
  }

  &__credentials {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.25rem;
    margin-top: 0.5rem;
  }

  &__credential {
    font-size: 0.6875rem;
    padding: 0.125rem 0.375rem;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    border-radius: var(--bulma-radius-small);
  }

  &__rating {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
  }

  &__stars {
    display: flex;
    gap: 0.125rem;

    i {
      font-size: 0.75rem;
      color: var(--bulma-warning);
    }
  }

  &__rating-text {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__footer {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  &__next {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 1rem;
    }
  }

  &__btn {
    width: 100%;
    padding: 0.75rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link-hover);
    }
  }
}
</style>
