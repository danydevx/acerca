<template>
  <div class="time-slot-group">
    <div v-if="label" class="time-slot-group__label">{{ label }}</div>
    <div class="time-slot-group__slots">
      <button
        v-for="slot in slots"
        :key="slot.time"
        type="button"
        class="time-slot"
        :class="{
          'time-slot--selected': selectedTime === slot.time,
          'time-slot--disabled': slot.disabled,
        }"
        :disabled="slot.disabled"
        @click="selectSlot(slot)"
      >
        {{ slot.time }}
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
  label: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['select'])

const selectSlot = (slot) => {
  if (slot.disabled) return
  emit('select', slot)
}
</script>

<style lang="scss" scoped>
.time-slot-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  &__label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__slots {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
}

.time-slot {
  padding: 0.5rem 0.875rem;
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  background: var(--bulma-scheme-main);
  color: var(--bulma-text);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s;

  &:hover:not(:disabled) {
    border-color: var(--bulma-link);
    color: var(--bulma-link);
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
