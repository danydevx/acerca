<template>
  <div class="opening-hours" :class="{ 'opening-hours--compact': compact }">
    <div
      v-for="day in visibleDays"
      :key="day.key"
      class="opening-hours__day"
      :class="{ 'opening-hours__day--today': day.isToday, 'opening-hours__day--closed': day.isClosed }"
    >
      <span class="opening-hours__day-name">{{ day.label }}</span>
      <div class="opening-hours__hours">
        <template v-if="day.isClosed">
          <span class="opening-hours__closed">{{ closedLabel }}</span>
        </template>
        <template v-else>
          <span
            v-for="(slot, index) in day.slots"
            :key="index"
            class="opening-hours__slot"
          >
            {{ slot.open }} - {{ slot.close }}
          </span>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  schedule: {
    type: Object,
    required: true,
  },
  highlightToday: {
    type: Boolean,
    default: true,
  },
  compact: {
    type: Boolean,
    default: false,
  },
  closedLabel: {
    type: String,
    default: 'Cerrado',
  },
  dayNames: {
    type: Array,
    default: () => ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
  },
  closedDays: {
    type: Array,
    default: () => [],
  },
})

const dayKeys = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']

const getToday = () => {
  const d = new Date()
  return dayKeys[d.getDay()]
}

const parseSlots = (schedule) => {
  const slots = []
  if (schedule.open && schedule.close) {
    slots.push({ open: schedule.open, close: schedule.close })
  }
  if (schedule.open2 && schedule.close2) {
    slots.push({ open: schedule.open2, close: schedule.close2 })
  }
  return slots
}

const visibleDays = computed(() => {
  return dayKeys.map((key, index) => {
    const isClosed = props.closedDays.includes(index) || !props.schedule[key]?.open
    const daySchedule = props.schedule[key] || {}
    const slots = parseSlots(daySchedule)

    return {
      key,
      label: props.dayNames[index],
      slots,
      isClosed,
      isToday: props.highlightToday && key === getToday(),
    }
  })
})
</script>

<style lang="scss" scoped>
.opening-hours {
  display: flex;
  flex-direction: column;
  gap: 0.375rem;

  &__day {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0.75rem;
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main-bis);

    &--today {
      background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main-bis));
      border: 1px solid color-mix(in oklch, var(--bulma-link) 30%, transparent);

      .opening-hours__day-name {
        color: var(--bulma-link);
        font-weight: 600;
      }
    }

    &--closed {
      opacity: 0.7;
    }
  }

  &__day-name {
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__hours {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.125rem;
  }

  &__slot {
    font-size: 0.8125rem;
    color: var(--bulma-text);
  }

  &__closed {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    font-style: italic;
  }

  &--compact {
    .opening-hours__day {
      padding: 0.375rem 0.5rem;
    }

    .opening-hours__day-name,
    .opening-hours__slot {
      font-size: 0.75rem;
    }
  }
}
</style>
