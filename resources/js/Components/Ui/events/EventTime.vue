<template>
  <div class="event-time" :class="{ 'event-time--compact': compact }">
    <i class="bi bi-clock"></i>
    <span class="event-time__start">{{ formattedStart }}</span>
    <span v-if="end" class="event-time__separator">-</span>
    <span v-if="end" class="event-time__end">{{ formattedEnd }}</span>
    <span v-if="timezone" class="event-time__timezone">{{ timezone }}</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  start: {
    type: [Date, String],
    required: true,
  },
  end: {
    type: [Date, String],
    default: null,
  },
  timezone: {
    type: String,
    default: '',
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

const formatTime = (date) => {
  const d = date instanceof Date ? date : new Date(date)
  return d.toLocaleTimeString('es-ES', {
    hour: '2-digit',
    minute: '2-digit',
  })
}

const formattedStart = computed(() => formatTime(props.start))
const formattedEnd = computed(() => props.end ? formatTime(props.end) : '')
</script>

<style lang="scss" scoped>
.event-time {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.875rem;
  color: var(--bulma-text);

  i {
    color: var(--bulma-text-weak);
    font-size: 1rem;
  }

  &__start {
    font-weight: 500;
  }

  &__separator {
    color: var(--bulma-text-weak);
  }

  &__end {
    font-weight: 500;
  }

  &__timezone {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin-left: 0.25rem;
  }

  &--compact {
    font-size: 0.8125rem;

    i {
      font-size: 0.875rem;
    }
  }
}
</style>
