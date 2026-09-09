<template>
  <div class="booking-time-slots">
    <div class="booking-time-slots__header">
      <h4 class="booking-time-slots__title">Horarios disponibles</h4>
      <span class="booking-time-slots__count">{{ slots.length }} opción{{ slots.length !== 1 ? 'es' : '' }}</span>
    </div>

    <div class="booking-time-slots__grid">
      <button
        v-for="slot in slots"
        :key="slot.time"
        type="button"
        class="booking-time-slot"
        :class="{
          'booking-time-slot--selected': selectedTime === slot.time,
          'booking-time-slot--disabled': slot.disabled,
        }"
        :disabled="slot.disabled"
        @click="selectSlot(slot)"
      >
        {{ formatTime(slot.time) }}
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  slots: {
    type: Array,
    required: true,
  },
  selectedTime: {
    type: String,
    default: null,
  },
  loading: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['time-select'])

const formatTime = (time) => {
  if (!time) return ''
  const [hours, minutes] = time.split(':')
  const hour = parseInt(hours, 10)
  const ampm = hour >= 12 ? 'pm' : 'am'
  const hour12 = hour % 12 || 12
  return `${hour12}:${minutes} ${ampm}`
}

const selectSlot = (slot) => {
  if (slot.disabled) return
  emit('time-select', slot)
}
</script>

<style lang="scss" scoped>
.booking-time-slots {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  &__title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__count {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 0.5rem;
  }
}

.booking-time-slot {
  padding: 0.625rem 0.75rem;
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  background: var(--bulma-scheme-main);
  color: var(--bulma-text);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s ease;

  &:hover:not(:disabled) {
    border-color: var(--bulma-link);
    color: var(--bulma-link);
    background: var(--bulma-scheme-main-bis);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  &--selected {
    background: var(--bulma-link);
    border-color: var(--bulma-link);
    color: var(--bulma-link-invert);

    &:hover:not(:disabled) {
      background: var(--bulma-link-hover);
      border-color: var(--bulma-link-hover);
      color: var(--bulma-link-invert);
    }
  }

  &--disabled {
    opacity: 0.4;
    cursor: not-allowed;
    text-decoration: line-through;
  }
}
</style>
