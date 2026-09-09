<template>
  <div class="booking-summary">
    <h4 class="booking-summary__title">{{ title }}</h4>

    <div class="booking-summary__items">
      <div v-if="date" class="booking-summary__item">
        <i class="bi bi-calendar"></i>
        <span>{{ formattedDate }}</span>
      </div>
      <div v-if="time" class="booking-summary__item">
        <i class="bi bi-clock"></i>
        <span>{{ time }}</span>
      </div>
      <div v-if="service" class="booking-summary__item">
        <i class="bi bi-scissors"></i>
        <span>{{ service }}</span>
      </div>
      <div v-if="guests > 1" class="booking-summary__item">
        <i class="bi bi-people"></i>
        <span>{{ guests }} personas</span>
      </div>
    </div>

    <div v-if="price" class="booking-summary__footer">
      <span class="booking-summary__total">{{ totalLabel }}</span>
      <span class="booking-summary__price">{{ price }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: 'Resumen de Reserva',
  },
  date: {
    type: [Date, String],
    default: null,
  },
  time: {
    type: String,
    default: '',
  },
  service: {
    type: String,
    default: '',
  },
  guests: {
    type: Number,
    default: 1,
  },
  price: {
    type: [String, Number],
    default: '',
  },
  totalLabel: {
    type: String,
    default: 'Total',
  },
})

const formattedDate = computed(() => {
  if (!props.date) return ''
  const d = props.date instanceof Date ? props.date : new Date(props.date)
  return d.toLocaleDateString('es-ES', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
})
</script>

<style lang="scss" scoped>
.booking-summary {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  padding: 1rem;
  background: var(--bulma-scheme-main-bis);
  border-radius: var(--bulma-radius-large);
  border: 1px solid var(--bulma-border);

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--bulma-border);
  }

  &__items {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--bulma-text);

    i {
      color: var(--bulma-text-weak);
      font-size: 1rem;
      width: 1.25rem;
      text-align: center;
    }
  }

  &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.75rem;
    border-top: 1px solid var(--bulma-border);
    margin-top: 0.25rem;
  }

  &__total {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text-weak);
  }

  &__price {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--bulma-link);
  }
}
</style>
