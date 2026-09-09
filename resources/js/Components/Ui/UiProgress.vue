<template>
  <div
    class="ui-progress dl-bulma-progress"
    :class="[`dl-bulma-progress--${size}`, { 'dl-bulma-progress--indeterminate': indeterminate }]"
    role="progressbar"
    :aria-valuenow="indeterminate ? undefined : modelValue"
    :aria-valuemin="min"
    :aria-valuemax="max"
    :aria-label="label"
  >
    <div
      class="dl-bulma-progress__bar"
      :class="`dl-bulma-progress__bar--${variant}`"
      :style="{ width: percentage + '%' }"
    ></div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Number,
    default: 0
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
    validator: (v) => ['primary', 'success', 'warning', 'danger'].includes(v)
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
  }
})

const percentage = computed(() => {
  if (props.indeterminate) return 0
  return Math.min(100, Math.max(0, ((props.modelValue - props.min) / (props.max - props.min)) * 100))
})
</script>

<style lang="scss" scoped>
.dl-bulma-progress {
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

  &--indeterminate {
    .dl-bulma-progress__bar {
      animation: dl-bulma-progress-indeterminate 1.5s ease-in-out infinite;
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
  }
}

@keyframes dl-bulma-progress-indeterminate {
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
