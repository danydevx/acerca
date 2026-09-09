<template>
  <div class="mini-calendar" :class="{ 'mini-calendar--compact': compact }">
    <div class="mini-calendar__header">
      <button
        type="button"
        class="mini-calendar__nav mini-calendar__nav--prev"
        aria-label="Mes anterior"
        @click="prevMonth"
      >
        <i class="bi bi-chevron-left"></i>
      </button>

      <span class="mini-calendar__month">{{ monthYearLabel }}</span>

      <button
        type="button"
        class="mini-calendar__nav mini-calendar__nav--next"
        aria-label="Mes siguiente"
        @click="nextMonth"
      >
        <i class="bi bi-chevron-right"></i>
      </button>
    </div>

    <div class="mini-calendar__weekdays">
      <span
        v-for="day in weekdays"
        :key="day"
        class="mini-calendar__weekday"
      >
        {{ day }}
      </span>
    </div>

    <div class="mini-calendar__grid">
      <CalendarDay
        v-for="(date, index) in calendarDays"
        :key="index"
        :date="date.date"
        :today="today"
        :selected="modelValue"
        :events="date.events"
        :disabled="date.disabled"
        @select="selectDate"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import CalendarDay from './CalendarDay.vue'

const props = defineProps({
  modelValue: {
    type: Date,
    default: null,
  },
  events: {
    type: Array,
    default: () => [],
  },
  compact: {
    type: Boolean,
    default: false,
  },
  weeksToShow: {
    type: Number,
    default: 6,
    validator: (v) => [4, 6].includes(v),
  },
})

const emit = defineEmits(['update:modelValue'])

const weekdays = ['D', 'L', 'M', 'X', 'J', 'V', 'S']

const today = new Date()

const currentMonth = ref(props.modelValue ? new Date(props.modelValue) : new Date())

const monthYearLabel = computed(() => {
  return currentMonth.value.toLocaleDateString('es-ES', {
    month: 'long',
    year: 'numeric',
  })
})

const getMonthDays = (year, month) => {
  const firstDay = new Date(year, month, 1)
  const lastDay = new Date(year, month + 1, 0)
  const daysInMonth = lastDay.getDate()
  const startingDay = firstDay.getDay()

  const days = []

  for (let i = 0; i < startingDay; i++) {
    const d = new Date(year, month, -startingDay + i + 1)
    days.push({
      date: d,
      disabled: true,
      events: [],
    })
  }

  for (let i = 1; i <= daysInMonth; i++) {
    const d = new Date(year, month, i)
    const dayEvents = props.events.filter((event) => {
      const eventDate = new Date(event.date)
      return (
        eventDate.getDate() === i &&
        eventDate.getMonth() === month &&
        eventDate.getFullYear() === year
      )
    })
    days.push({
      date: d,
      disabled: false,
      events: dayEvents,
    })
  }

  const remaining = props.weeksToShow * 7 - days.length
  for (let i = 1; i <= remaining; i++) {
    const d = new Date(year, month + 1, i)
    days.push({
      date: d,
      disabled: true,
      events: [],
    })
  }

  return days
}

const calendarDays = computed(() => {
  return getMonthDays(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth()
  )
})

const prevMonth = () => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() - 1,
    1
  )
}

const nextMonth = () => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() + 1,
    1
  )
}

const selectDate = (date) => {
  emit('update:modelValue', date)
}
</script>

<style lang="scss" scoped>
.mini-calendar {
  width: 100%;
  max-width: 20rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  padding: 0.75rem;

  &__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
  }

  &__month {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    text-transform: capitalize;
  }

  &__nav {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    padding: 0;
    border: none;
    border-radius: var(--bulma-radius);
    background: transparent;
    color: var(--bulma-text-weak);
    cursor: pointer;
    transition: background-color 0.15s, color 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-text);
    }

    &:focus-visible {
      outline: 2px solid var(--bulma-link);
      outline-offset: -2px;
    }

    i {
      font-size: 1rem;
    }
  }

  &__weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    margin-bottom: 0.25rem;
  }

  &__weekday {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem;
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.125rem;
  }

  &--compact {
    max-width: 17.5rem;
    padding: 0.5rem;

    .mini-calendar__header {
      margin-bottom: 0.5rem;
    }

    .mini-calendar__month {
      font-size: 0.8125rem;
    }

    .mini-calendar__grid {
      gap: 0.125rem;
    }
  }
}
</style>
