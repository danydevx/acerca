<template>
  <div class="booking-calendar">
    <div class="booking-calendar__wrapper">
      <MiniCalendar
        v-model="selectedDateModel"
        :events="events"
        :weeks-to-show="6"
        @update:model-value="handleSelect"
        @nav="handleNav"
      />
    </div>

    <div v-if="showLegend" class="booking-calendar__legend">
      <div class="booking-calendar__legend-item">
        <span class="booking-calendar__legend-dot booking-calendar__legend-dot--available"></span>
        <span>Disponible</span>
      </div>
      <div class="booking-calendar__legend-item">
        <span class="booking-calendar__legend-dot booking-calendar__legend-dot--selected"></span>
        <span>Seleccionado</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import MiniCalendar from '../calendar/MiniCalendar.vue'

const props = defineProps({
  selectedDate: {
    type: Date,
    default: null,
  },
  availableDates: {
    type: Array,
    default: () => [],
  },
  events: {
    type: Array,
    default: () => [],
  },
  showLegend: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['date-select', 'month-change'])

const selectedDateModel = computed({
  get: () => props.selectedDate,
  set: (val) => emit('date-select', val),
})

const handleSelect = (date) => {
  emit('date-select', date)
}

const handleNav = (direction) => {
  emit('month-change', direction)
}
</script>

<style lang="scss" scoped>
.booking-calendar {
  display: flex;
  flex-direction: column;
  gap: 1rem;

  &__wrapper {
    width: 100%;
    max-width: 320px;

    :deep(.mini-calendar) {
      max-width: none;
    }
  }

  &__legend {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  &__legend-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;

    &--available {
      background: var(--bulma-success);
    }

    &--selected {
      background: var(--bulma-link);
    }
  }
}
</style>
