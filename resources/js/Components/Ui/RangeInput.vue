<template>
  <div class="range-input" :class="[`range-input--${size}`, { 'range-input--vertical': vertical }]">
    <label v-if="label" class="range-input__label">{{ label }}</label>
    <div class="range-input__wrapper">
      <span v-if="showValue && !vertical" class="range-input__value">{{ modelValue }}</span>
      <div class="range-input__track-wrapper">
        <input
          type="range"
          class="range-input__range"
          :min="min"
          :max="max"
          :step="step"
          :value="modelValue"
          :disabled="disabled"
          @input="onInput"
          @change="$emit('change', modelValue)"
        >
        <div class="range-input__track">
          <div class="range-input__fill" :style="{ width: `${fillPercent}%` }"></div>
        </div>
      </div>
      <span v-if="showValue && !vertical" class="range-input__value">{{ modelValue }}</span>
    </div>
    <div v-if="showMinMax" class="range-input__minmax">
      <span>{{ min }}</span>
      <span>{{ max }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: [Number, String], default: 0 },
  min: { type: Number, default: 0 },
  max: { type: Number, default: 100 },
  step: { type: Number, default: 1 },
  label: { type: String, default: '' },
  size: { type: String, default: 'default', validator: (v) => ['', 'small', 'medium', 'large'].includes(v) },
  disabled: { type: Boolean, default: false },
  showValue: { type: Boolean, default: false },
  showMinMax: { type: Boolean, default: false },
  vertical: { type: Boolean, default: false },
})

const emit = defineEmits(['update:modelValue', 'change'])

const fillPercent = computed(() => {
  const val = Number(props.modelValue)
  return ((val - props.min) / (props.max - props.min)) * 100
})

const onInput = (e) => {
  emit('update:modelValue', Number(e.target.value))
}
</script>

<style lang="scss" scoped>
.range-input {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  &--small {
    .range-input__range { height: 4px; }
    .range-input__track { height: 4px; }
  }

  &--medium {
    .range-input__range { height: 8px; }
    .range-input__track { height: 8px; }
  }

  &--large {
    .range-input__range { height: 12px; }
    .range-input__track { height: 12px; }
  }

  &--vertical {
    flex-direction: row;
    align-items: center;

    .range-input__wrapper {
      flex-direction: column;
      height: 150px;
    }

    .range-input__track-wrapper {
      width: 100%;
      height: 100%;
    }

    .range-input__range {
      writing-mode: vertical-lr;
      direction: rtl;
    }
  }

  &__label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  &__track-wrapper {
    position: relative;
    flex: 1;
  }

  &__track {
    position: absolute;
    inset: 0;
    background: var(--bulma-border);
    border-radius: 9999px;
    pointer-events: none;
  }

  &__fill {
    height: 100%;
    background: var(--bulma-primary);
    border-radius: 9999px;
    transition: width 50ms;
  }

  &__range {
    position: relative;
    width: 100%;
    height: 6px;
    margin: 0;
    padding: 0;
    background: transparent;
    appearance: none;
    cursor: pointer;
    z-index: 1;

    &::-webkit-slider-runnable-track {
      background: transparent;
    }

    &::-webkit-slider-thumb {
      appearance: none;
      width: 16px;
      height: 16px;
      background: var(--bulma-primary);
      border: 2px solid var(--bulma-primary-invert);
      border-radius: 50%;
      margin-top: -5px;
      cursor: pointer;
      transition: transform 150ms;

      &:hover {
        transform: scale(1.2);
      }
    }

    &::-moz-range-track {
      background: transparent;
    }

    &::-moz-range-thumb {
      width: 16px;
      height: 16px;
      background: var(--bulma-primary);
      border: 2px solid var(--bulma-primary-invert);
      border-radius: 50%;
      cursor: pointer;
    }

    &:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    &:focus {
      outline: none;
    }
  }

  &__value {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    font-variant-numeric: tabular-nums;
    min-width: 2.5rem;
    text-align: center;
  }

  &__minmax {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }
}
</style>
