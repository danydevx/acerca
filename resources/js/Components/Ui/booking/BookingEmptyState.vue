<template>
  <div class="booking-empty-state" :class="`booking-empty-state--${type}`">
    <div class="booking-empty-state__icon">
      <i :class="icon"></i>
    </div>
    <p class="booking-empty-state__message">{{ message }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  message: {
    type: String,
    default: 'No hay información disponible',
  },
  type: {
    type: String,
    default: 'empty',
    validator: (v) => ['empty', 'no-slots', 'select-date', 'loading', 'error'].includes(v),
  },
})

const icon = computed(() => {
  switch (props.type) {
    case 'no-slots':
      return 'bi bi-calendar-x'
    case 'select-date':
      return 'bi bi-calendar-week'
    case 'loading':
      return 'bi bi-arrow-repeat'
    case 'error':
      return 'bi bi-exclamation-triangle'
    default:
      return 'bi bi-inbox'
  }
})
</script>

<style lang="scss" scoped>
.booking-empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  text-align: center;

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    margin-bottom: 0.75rem;
    border-radius: 50%;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);

    i {
      font-size: 1.5rem;
    }
  }

  &__message {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
    max-width: 240px;
    line-height: 1.5;
  }

  &--no-slots {
    .booking-empty-state__icon {
      background: color-mix(in oklch, var(--bulma-warning) 15%, transparent);
      color: var(--bulma-warning);
    }
  }

  &--error {
    .booking-empty-state__icon {
      background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
      color: var(--bulma-danger);
    }
  }

  &--loading {
    .booking-empty-state__icon {
      i {
        animation: spin 1s linear infinite;
      }
    }
  }
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>
