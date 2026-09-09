<template>
  <div
    class="availability-status"
    :class="{
      'availability-status--open': isOpen,
      'availability-status--closed': !isOpen,
    }"
  >
    <span class="availability-status__indicator"></span>
    <span class="availability-status__text">{{ statusText }}</span>
    <span v-if="showTime && isOpen && nextChange" class="availability-status__time">
      {{ nextChange }}
    </span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  opensAt: {
    type: String,
    default: '',
  },
  closesAt: {
    type: String,
    default: '',
  },
  nextChange: {
    type: String,
    default: '',
  },
  openLabel: {
    type: String,
    default: 'Abierto',
  },
  closedLabel: {
    type: String,
    default: 'Cerrado',
  },
  showTime: {
    type: Boolean,
    default: false,
  },
})

const statusText = computed(() => {
  if (props.isOpen) {
    if (props.showTime && props.closesAt) {
      return `${props.openLabel} · Cierra a las ${props.closesAt}`
    }
    return props.openLabel
  }
  if (props.showTime && props.opensAt) {
    return `${props.closedLabel} · Abre a las ${props.opensAt}`
  }
  return props.closedLabel
})
</script>

<style lang="scss" scoped>
.availability-status {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.375rem 0.75rem;
  border-radius: var(--bulma-radius-rounded);
  font-size: 0.8125rem;
  font-weight: 500;

  &__indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
  }

  &__text {
    color: inherit;
  }

  &__time {
    opacity: 0.8;
    font-weight: 400;
  }

  &--open {
    background: color-mix(in oklch, var(--bulma-success) 15%, transparent);
    color: var(--bulma-success);

    .availability-status__indicator {
      background: var(--bulma-success);
      box-shadow: 0 0 0 2px color-mix(in oklch, var(--bulma-success) 30%, transparent);
      animation: pulse 2s infinite;
    }
  }

  &--closed {
    background: color-mix(in oklch, var(--bulma-danger) 15%, transparent);
    color: var(--bulma-danger);

    .availability-status__indicator {
      background: var(--bulma-danger);
    }
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
