<template>
  <div class="booking-selected-date">
    <div class="booking-selected-date__content">
      <i class="bi bi-calendar3"></i>
      <span class="booking-selected-date__text">{{ formattedDate }}</span>
    </div>
    <button
      v-if="showClear"
      type="button"
      class="booking-selected-date__clear"
      aria-label="Cambiar fecha"
      @click="$emit('clear')"
    >
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  date: {
    type: Date,
    required: true,
  },
  showClear: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['clear'])

const formattedDate = computed(() => {
  if (!props.date) return ''
  return props.date.toLocaleDateString('es-ES', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
})
</script>

<style lang="scss" scoped>
.booking-selected-date {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  background: var(--bulma-scheme-main-bis);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  gap: 0.75rem;

  &__content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--bulma-text);
  }

  i {
    color: var(--bulma-link);
    font-size: 1rem;
  }

  &__text {
    font-size: 0.9375rem;
    font-weight: 500;
    text-transform: capitalize;
  }

  &__clear {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    padding: 0;
    border: none;
    border-radius: var(--bulma-radius-small);
    background: transparent;
    color: var(--bulma-text-weak);
    cursor: pointer;
    transition: all 0.15s ease;

    &:hover {
      background: var(--bulma-scheme-main);
      color: var(--bulma-text);
    }

    &:focus-visible {
      outline: 2px solid var(--bulma-link);
      outline-offset: -2px;
    }

    i {
      font-size: 0.875rem;
      color: inherit;
    }
  }
}
</style>
