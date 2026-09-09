<template>
  <div class="stat-value" :class="{ 'stat-value--compact': compact }">
    <div class="stat-value__header">
      <span v-if="label" class="stat-value__label">{{ label }}</span>
      <i v-if="icon" class="stat-value__icon" :class="icon"></i>
    </div>
    <div class="stat-value__body">
      <span class="stat-value__value">{{ formattedValue }}</span>
      <span v-if="suffix" class="stat-value__suffix">{{ suffix }}</span>
    </div>
    <div v-if="change !== null" class="stat-value__change" :class="changeClass">
      <i :class="changeIcon"></i>
      <span>{{ formattedChange }}%</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  value: {
    type: [Number, String],
    required: true,
  },
  label: {
    type: String,
    default: '',
  },
  suffix: {
    type: String,
    default: '',
  },
  icon: {
    type: String,
    default: '',
  },
  change: {
    type: Number,
    default: null,
  },
  changeLabel: {
    type: String,
    default: 'vs last period',
  },
  compact: {
    type: Boolean,
    default: false,
  },
  format: {
    type: String,
    default: 'number',
    validator: (v) => ['number', 'currency', 'percent'].includes(v),
  },
  locale: {
    type: String,
    default: 'es-ES',
  },
})

const formattedValue = computed(() => {
  if (typeof props.value === 'string') return props.value

  if (props.format === 'currency') {
    return new Intl.NumberFormat(props.locale, {
      style: 'currency',
      currency: 'MXN',
      minimumFractionDigits: 0,
    }).format(props.value)
  }

  if (props.format === 'percent') {
    return `${props.value}%`
  }

  return props.value.toLocaleString(props.locale)
})

const changeClass = computed(() => {
  if (props.change === null) return ''
  if (props.change > 0) return 'stat-value__change--up'
  if (props.change < 0) return 'stat-value__change--down'
  return ''
})

const changeIcon = computed(() => {
  if (props.change === null) return ''
  if (props.change > 0) return 'bi bi-arrow-up'
  if (props.change < 0) return 'bi bi-arrow-down'
  return 'bi bi-dash'
})

const formattedChange = computed(() => {
  if (props.change === null) return ''
  return Math.abs(props.change)
})
</script>

<style lang="scss" scoped>
.stat-value {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  padding: 1rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  &__label {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__icon {
    font-size: 1rem;
    color: var(--bulma-text-weak);
  }

  &__body {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
  }

  &__value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--bulma-text);
    line-height: 1;
  }

  &__suffix {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }

  &__change {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;

    i {
      font-size: 0.625rem;
    }

    &--up {
      color: var(--bulma-success);
    }

    &--down {
      color: var(--bulma-danger);
    }
  }

  &--compact {
    padding: 0.75rem;

    .stat-value__value {
      font-size: 1.25rem;
    }
  }
}
</style>
