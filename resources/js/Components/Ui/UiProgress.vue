<template>
  <div
    class="ui-progress"
    :class="[`ui-progress--${size}`, { 'ui-progress--indeterminate': indeterminate }]"
    role="progressbar"
    :aria-valuenow="indeterminate ? undefined : currentValue"
    :aria-valuemin="min"
    :aria-valuemax="max"
    :aria-label="label"
  >
    <div
      class="ui-progress__bar"
      :class="[`ui-progress__bar--${variant}`]"
      :style="{ width: percentage + '%' }"
    ></div>
    <span v-if="showValue" class="ui-progress__value">{{ percentage }}%</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Number,
    default: 0
  },
  value: {
    type: Number,
    default: null
  },
  min: {
    type: Number,
    default: 0
  },
  max: {
    type: Number,
    default: 100
  },
  variant: {
    type: String,
    default: 'primary',
    validator: (v) => ['primary', 'success', 'warning', 'danger', 'info'].includes(v)
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v)
  },
  indeterminate: {
    type: Boolean,
    default: false
  },
  label: {
    type: String,
    default: null
  },
  showValue: {
    type: Boolean,
    default: false
  }
})

const currentValue = computed(() => {
  return props.value !== null ? props.value : props.modelValue
})

const percentage = computed(() => {
  if (props.indeterminate) return 0
  return Math.min(100, Math.max(0, ((currentValue.value - props.min) / (props.max - props.min)) * 100))
})
</script>

<style lang="scss" scoped>
.ui-progress {
  width: 100%;
  background: var(--bulma-scheme-main-bis);
  border-radius: 9999px;
  overflow: hidden;
  display: flex;
  align-items: center;
  position: relative;

  &--sm {
    height: 4px;
  }

  &--md {
    height: 8px;
  }

  &--lg {
    height: 16px;
  }

  &--indeterminate {
    .ui-progress__bar {
      animation: ui-progress-indeterminate 1.5s ease-in-out infinite;
    }
  }

  &__bar {
    height: 100%;
    border-radius: 9999px;
    transition: width 0.3s ease;

    &--primary {
      background: var(--bulma-primary);
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
  }

  &__value {
    position: absolute;
    right: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
  }
}

@keyframes ui-progress-indeterminate {
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
