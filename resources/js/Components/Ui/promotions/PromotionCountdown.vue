<template>
  <div class="promotion-countdown" :class="{ 'promotion-countdown--compact': compact }">
    <div v-if="showLabel && label" class="promotion-countdown__label">{{ label }}</div>
    <div class="promotion-countdown__timer">
      <div v-if="showDays && days > 0" class="promotion-countdown__unit">
        <span class="promotion-countdown__value">{{ padded(days) }}</span>
        <span class="promotion-countdown__name">{{ days === 1 ? 'día' : 'días' }}</span>
      </div>
      <span class="promotion-countdown__separator">:</span>
      <div class="promotion-countdown__unit">
        <span class="promotion-countdown__value">{{ padded(hours) }}</span>
        <span class="promotion-countdown__name">{{ hours === 1 ? 'hora' : 'horas' }}</span>
      </div>
      <span class="promotion-countdown__separator">:</span>
      <div class="promotion-countdown__unit">
        <span class="promotion-countdown__value">{{ padded(minutes) }}</span>
        <span class="promotion-countdown__name">min</span>
      </div>
      <span v-if="showSeconds" class="promotion-countdown__separator">:</span>
      <div v-if="showSeconds" class="promotion-countdown__unit">
        <span class="promotion-countdown__value">{{ padded(seconds) }}</span>
        <span class="promotion-countdown__name">seg</span>
      </div>
    </div>
    <div v-if="expiresText" class="promotion-countdown__expires">{{ expiresText }}</div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  endDate: {
    type: [Date, String],
    required: true,
  },
  label: {
    type: String,
    default: 'Termina en',
  },
  showLabel: {
    type: Boolean,
    default: true,
  },
  showDays: {
    type: Boolean,
    default: true,
  },
  showSeconds: {
    type: Boolean,
    default: true,
  },
  compact: {
    type: Boolean,
    default: false,
  },
  expiresText: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['expired'])

const now = ref(Date.now())
let interval = null

onMounted(() => {
  interval = setInterval(() => {
    now.value = Date.now()
    if (now.value >= endTime.value) {
      clearInterval(interval)
      emit('expired')
    }
  }, 1000)
})

onUnmounted(() => {
  if (interval) clearInterval(interval)
})

const endTime = computed(() => {
  return props.endDate instanceof Date
    ? props.endDate.getTime()
    : new Date(props.endDate).getTime()
})

const diff = computed(() => {
  return Math.max(0, endTime.value - now.value)
})

const days = computed(() => Math.floor(diff.value / (1000 * 60 * 60 * 24)))
const hours = computed(() => Math.floor((diff.value % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)))
const minutes = computed(() => Math.floor((diff.value % (1000 * 60 * 60)) / (1000 * 60)))
const seconds = computed(() => Math.floor((diff.value % (1000 * 60)) / 1000))

const padded = (n) => n.toString().padStart(2, '0')
</script>

<style lang="scss" scoped>
.promotion-countdown {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;

  &__label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__timer {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  &__unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 2.5rem;
  }

  &__value {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    height: 2.5rem;
    padding: 0.25rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 1.25rem;
    font-weight: 700;
    border-radius: var(--bulma-radius);
    line-height: 1;
  }

  &__name {
    font-size: 0.5625rem;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    margin-top: 0.25rem;
  }

  &__separator {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-text-weak);
    margin-bottom: 1rem;
  }

  &__expires {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &--compact {
    .promotion-countdown__value {
      min-width: 2rem;
      height: 2rem;
      font-size: 1rem;
    }

    .promotion-countdown__unit {
      min-width: 2rem;
    }

    .promotion-countdown__separator {
      font-size: 1rem;
      margin-bottom: 0.75rem;
    }
  }
}
</style>
