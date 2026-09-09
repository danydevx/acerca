<template>
  <div class="progress-bar" :class="{ 'progress-bar--stacked': stacked }">
    <div v-if="label || showValue" class="progress-bar__header">
      <span v-if="label" class="progress-bar__label">{{ label }}</span>
      <span v-if="showValue" class="progress-bar__value">{{ displayValue }}</span>
    </div>
    <div
      class="progress-bar__track"
      :class="[`progress-bar__track--${size}`]"
      role="progressbar"
      :aria-valuenow="indeterminate ? undefined : modelValue"
      :aria-valuemin="min"
      :aria-valuemax="max"
      :aria-label="label || 'Progress'"
    >
      <div
        class="progress-bar__fill"
        :class="[
          `progress-bar__fill--${variant}`,
          { 'progress-bar__fill--striped': striped },
          { 'progress-bar__fill--animated': animated },
        ]"
        :style="{ width: indeterminate ? '100%' : percentage + '%' }"
      >
        <span v-if="stacked && showValue" class="progress-bar__fill-text">
          {{ displayValue }}
        </span>
      </div>
    </div>
    <div v-if="hint" class="progress-bar__hint">{{ hint }}</div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Number,
    default: 0,
  },
  min: {
    type: Number,
    default: 0,
  },
  max: {
    type: Number,
    default: 100,
  },
  variant: {
    type: String,
    default: 'primary',
    validator: (v) => ['primary', 'success', 'warning', 'danger', 'info'].includes(v),
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
  label: {
    type: String,
    default: '',
  },
  showValue: {
    type: Boolean,
    default: false,
  },
  format: {
    type: String,
    default: 'percent',
    validator: (v) => ['percent', 'value', 'ratio'].includes(v),
  },
  hint: {
    type: String,
    default: '',
  },
  indeterminate: {
    type: Boolean,
    default: false,
  },
  striped: {
    type: Boolean,
    default: false,
  },
  animated: {
    type: Boolean,
    default: false,
  },
  stacked: {
    type: Boolean,
    default: false,
  },
})

const percentage = computed(() => {
  return Math.min(100, Math.max(0, ((props.modelValue - props.min) / (props.max - props.min)) * 100))
})

const displayValue = computed(() => {
  if (props.format === 'percent') {
    return `${Math.round(percentage.value)}%`
  }
  if (props.format === 'ratio') {
    return `${props.modelValue} / ${props.max}`
  }
  return props.modelValue.toString()
})
</script>

<style lang="scss" scoped>
.progress-bar {
  width: 100%;

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.375rem;
  }

  &__label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__track {
    width: 100%;
    background: var(--bulma-scheme-main-bis);
    border-radius: 9999px;
    overflow: hidden;

    &--sm {
      height: 4px;
    }

    &--md {
      height: 8px;
    }

    &--lg {
      height: 16px;
    }
  }

  &__fill {
    height: 100%;
    border-radius: 9999px;
    transition: width 0.3s ease;
    position: relative;

    &--primary {
      background: var(--bulma-link);
    }

    &--success {
      background: var(--bulma-success);
    }

    &--warning {
      background: var(--bulma-warning);
    }

    &--danger {
      background: var(--bulma-danger);
    }

    &--info {
      background: var(--bulma-info);
    }

    &--striped {
      background-image: linear-gradient(
        45deg,
        oklch(100% 0 0 / 0.15) 25%,
        transparent 25%,
        transparent 50%,
        oklch(100% 0 0 / 0.15) 50%,
        oklch(100% 0 0 / 0.15) 75%,
        transparent 75%,
        transparent
      );
      background-size: 1rem 1rem;
    }

    &--animated {
      animation: progress-stripes 1s linear infinite;
    }

    &--striped.progress-bar__fill--animated {
      animation: progress-stripes 1s linear infinite, progress-bar-indeterminate 1.5s ease-in-out infinite;
    }
  }

  &__fill-text {
    position: absolute;
    right: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-scheme-main);
    text-shadow: 0 1px 2px oklch(0% 0 0 / 0.2);
  }

  &__hint {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin-top: 0.25rem;
  }

  &--stacked {
    .progress-bar__track {
      height: 1.5rem;
    }
  }
}

@keyframes progress-stripes {
  0% {
    background-position: 1rem 0;
  }
  100% {
    background-position: 0 0;
  }
}

@keyframes progress-bar-indeterminate {
  0% {
    transform: translateX(-100%);
  }
  50% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(100%);
  }
}
</style>
