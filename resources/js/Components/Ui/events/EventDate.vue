<template>
  <div class="event-date" :class="{ 'event-date--compact': compact }">
    <div class="event-date__day">{{ day }}</div>
    <div class="event-date__month">{{ month }}</div>
    <div v-if="!compact && year" class="event-date__year">{{ year }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  date: {
    type: [Date, String],
    required: true,
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

const d = computed(() => {
  return props.date instanceof Date ? props.date : new Date(props.date)
})

const day = computed(() => d.value.getDate().toString().padStart(2, '0'))

const month = computed(() => {
  return d.value.toLocaleDateString('es-ES', { month: 'short' }).toUpperCase()
})

const year = computed(() => d.value.getFullYear())
</script>

<style lang="scss" scoped>
.event-date {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-width: 3rem;
  padding: 0.5rem 0.75rem;
  background: var(--bulma-link);
  color: var(--bulma-link-invert);
  border-radius: var(--bulma-radius);
  text-align: center;

  &__day {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
  }

  &__month {
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.125rem;
  }

  &__year {
    font-size: 0.625rem;
    opacity: 0.8;
    margin-top: 0.125rem;
  }

  &--compact {
    min-width: 2.5rem;
    padding: 0.375rem 0.5rem;

    .event-date__day {
      font-size: 1.125rem;
    }

    .event-date__month {
      font-size: 0.5625rem;
    }
  }
}
</style>
