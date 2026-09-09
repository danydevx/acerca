<template>
  <button
    type="button"
    class="calendar-day"
    :class="{
      'calendar-day--today': isToday,
      'calendar-day--selected': isSelected,
      'calendar-day--outside': isOutside,
      'calendar-day--disabled': disabled,
      'calendar-day--has-events': hasEvents,
    }"
    :disabled="disabled"
    :aria-label="ariaLabel"
    :aria-selected="isSelected"
    @click="$emit('select', date)"
  >
    <span class="calendar-day__number">{{ dayNumber }}</span>
    <div v-if="hasEvents" class="calendar-day__events">
      <span
        v-for="(event, index) in visibleEvents"
        :key="event.id || index"
        class="calendar-day__event-dot"
        :style="{ backgroundColor: event.color || 'var(--bulma-link)' }"
      />
    </div>
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  date: {
    type: Date,
    required: true,
  },
  today: {
    type: Date,
    default: () => new Date(),
  },
  selected: {
    type: Date,
    default: null,
  },
  events: {
    type: Array,
    default: () => [],
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  maxEvents: {
    type: Number,
    default: 3,
  },
})

defineEmits(['select'])

const dayNumber = computed(() => props.date.getDate())

const isToday = computed(() => {
  const t = props.today
  return (
    props.date.getDate() === t.getDate() &&
    props.date.getMonth() === t.getMonth() &&
    props.date.getFullYear() === t.getFullYear()
  )
})

const isSelected = computed(() => {
  if (!props.selected) return false
  return (
    props.date.getDate() === props.selected.getDate() &&
    props.date.getMonth() === props.selected.getMonth() &&
    props.date.getFullYear() === props.selected.getFullYear()
  )
})

const isOutside = computed(() => {
  const cur = props.date
  const sel = props.selected || new Date()
  return cur.getMonth() !== sel.getMonth()
})

const hasEvents = computed(() => props.events.length > 0)

const visibleEvents = computed(() => props.events.slice(0, props.maxEvents))

const ariaLabel = computed(() => {
  return props.date.toLocaleDateString('es-ES', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
})
</script>

<style lang="scss" scoped>
.calendar-day {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  aspect-ratio: 1;
  min-width: 0;
  padding: 0.25rem;
  border: none;
  border-radius: var(--bulma-radius-small);
  background: transparent;
  cursor: pointer;
  transition: background-color 0.15s, color 0.15s;
  position: relative;

  &:hover:not(:disabled) {
    background: var(--bulma-scheme-main-bis);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: -2px;
  }

  &:disabled {
    cursor: not-allowed;
    opacity: 0.3;
  }

  &--today {
    .calendar-day__number {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);
      border-radius: 50%;
      width: 1.75rem;
      height: 1.75rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  }

  &--selected {
    background: var(--bulma-scheme-main-bis);

    .calendar-day__number {
      font-weight: 700;
      color: var(--bulma-link);
    }
  }

  &--outside {
    .calendar-day__number {
      color: var(--bulma-text-weak);
    }
  }

  &__number {
    font-size: 0.875rem;
    line-height: 1;
    color: var(--bulma-text);
  }

  &__events {
    display: flex;
    gap: 0.125rem;
    margin-top: 0.125rem;
    position: absolute;
    bottom: 0.25rem;
  }

  &__event-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
  }
}
</style>
