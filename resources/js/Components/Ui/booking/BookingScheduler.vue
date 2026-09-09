<template>
  <div
    class="booking-scheduler"
    :class="[`booking-scheduler--${variant}`]"
  >
    <div class="booking-scheduler__inner">
      <slot name="header" />

      <div class="booking-scheduler__layout">
        <aside v-if="showServiceInfo" class="booking-scheduler__sidebar">
          <slot name="service-info">
            <BookingServiceInfo
              v-if="service"
              :service="service"
            />
          </slot>
        </aside>

        <main class="booking-scheduler__main">
          <div class="booking-scheduler__calendar-section">
            <slot name="calendar-header" />
            <BookingCalendar
              :selected-date="selectedDate"
              :available-dates="availableDates"
              :events="calendarEvents"
              @date-select="handleDateSelect"
              @month-change="$emit('month-change', $event)"
            />
          </div>

          <div v-if="selectedDate" class="booking-scheduler__times-section">
            <BookingSelectedDate
              :date="selectedDate"
              :show-clear="allowClearDate"
              @clear="handleDateClear"
            />

            <div v-if="hasSlots" class="booking-scheduler__slots">
              <BookingTimeSlots
                :slots="currentSlots"
                :selected-time="selectedTime"
                :loading="loading"
                @time-select="handleTimeSelect"
              />
            </div>

            <BookingEmptyState
              v-else-if="!loading"
              :message="emptySlotsMessage"
              type="no-slots"
            />

            <div v-if="loading" class="booking-scheduler__loading">
              <i class="bi bi-arrow-repeat spin"></i>
              <span>{{ loadingText }}</span>
            </div>
          </div>

          <div v-else class="booking-scheduler__placeholder">
            <BookingEmptyState
              :message="selectDateMessage"
              type="select-date"
            />
          </div>
        </main>
      </div>

      <footer v-if="showFooter" class="booking-scheduler__footer">
        <slot name="footer">
          <div v-if="timezone" class="booking-scheduler__timezone">
            <BookingTimezone :timezone="timezone" />
          </div>
          <div v-if="showConfirmButton" class="booking-scheduler__actions">
            <button
              type="button"
              class="button is-link"
              :disabled="!canConfirm"
              @click="handleConfirm"
            >
              {{ confirmText }}
            </button>
          </div>
        </slot>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import BookingServiceInfo from './BookingServiceInfo.vue'
import BookingCalendar from './BookingCalendar.vue'
import BookingTimeSlots from './BookingTimeSlots.vue'
import BookingSelectedDate from './BookingSelectedDate.vue'
import BookingEmptyState from './BookingEmptyState.vue'
import BookingTimezone from './BookingTimezone.vue'

const props = defineProps({
  service: {
    type: Object,
    default: null,
  },
  availability: {
    type: Object,
    default: () => ({}),
  },
  timezone: {
    type: Object,
    default: null,
  },
  selectedDate: {
    type: Date,
    default: null,
  },
  selectedTime: {
    type: String,
    default: null,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'compact', 'embedded'].includes(v),
  },
  showServiceInfo: {
    type: Boolean,
    default: true,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
  showConfirmButton: {
    type: Boolean,
    default: true,
  },
  allowClearDate: {
    type: Boolean,
    default: true,
  },
  loadingText: {
    type: String,
    default: 'Cargando disponibilidad...',
  },
  selectDateMessage: {
    type: String,
    default: 'Selecciona una fecha para ver horarios disponibles',
  },
  emptySlotsMessage: {
    type: String,
    default: 'No hay horarios disponibles para esta fecha',
  },
  confirmText: {
    type: String,
    default: 'Confirmar',
  },
})

const emit = defineEmits([
  'update:selectedDate',
  'update:selectedTime',
  'date-change',
  'time-change',
  'month-change',
  'confirm',
])

const calendarEvents = computed(() => {
  if (!props.availability) return []
  return Object.keys(props.availability).map((date) => ({
    date,
    available: true,
  }))
})

const availableDates = computed(() => {
  if (!props.availability) return []
  return Object.keys(props.availability)
})

const currentSlots = computed(() => {
  if (!props.selectedDate || !props.availability) return []
  const dateKey = formatDateKey(props.selectedDate)
  const slots = props.availability[dateKey] || []
  return slots.map((time) => ({
    time,
    disabled: false,
  }))
})

const hasSlots = computed(() => currentSlots.value.length > 0)

const canConfirm = computed(() => {
  return props.selectedDate && props.selectedTime
})

const formatDateKey = (date) => {
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}

const handleDateSelect = (date) => {
  emit('update:selectedDate', date)
  emit('update:selectedTime', null)
  emit('date-change', date)
}

const handleDateClear = () => {
  emit('update:selectedDate', null)
  emit('update:selectedTime', null)
}

const handleTimeSelect = (slot) => {
  emit('update:selectedTime', slot.time)
  emit('time-change', slot.time)
}

const handleConfirm = () => {
  if (!canConfirm.value) return
  emit('confirm', {
    date: props.selectedDate,
    time: props.selectedTime,
    timezone: props.timezone,
    service: props.service,
  })
}
</script>

<style lang="scss" scoped>
.booking-scheduler {
  width: 100%;

  &__inner {
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-large);
    overflow: hidden;
  }

  &__layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    min-height: 400px;

    .booking-scheduler--embedded & {
      grid-template-columns: 1fr;
    }
  }

  &__sidebar {
    border-right: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main-bis);
    padding: 1.5rem;

    .booking-scheduler--compact & {
      padding: 1rem;
    }

    .booking-scheduler--embedded & {
      border-right: none;
      border-bottom: 1px solid var(--bulma-border);
    }
  }

  &__main {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    gap: 1.5rem;

    .booking-scheduler--compact & {
      padding: 1rem;
      gap: 1rem;
    }
  }

  &__calendar-section {
    flex-shrink: 0;
  }

  &__times-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    min-width: 0;
  }

  &__slots {
    flex: 1;
    overflow-y: auto;
  }

  &__placeholder {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }

  &__loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 2rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 1.25rem;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main-bis);

    .booking-scheduler--compact & {
      padding: 0.75rem 1rem;
    }
  }

  &__timezone {
    flex: 1;
  }

  &__actions {
    display: flex;
    gap: 0.75rem;

    .button {
      min-width: 120px;
    }
  }
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.spin {
  animation: spin 1s linear infinite;
}
</style>
