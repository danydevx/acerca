<template>
  <div class="quantity-selector" :class="{ 'quantity-selector--disabled': disabled }">
    <button
      type="button"
      class="quantity-selector__btn"
      :disabled="disabled || modelValue <= min"
      @click="decrement"
    >
      <i class="bi bi-dash"></i>
    </button>
    <input
      type="number"
      class="quantity-selector__input"
      :value="modelValue"
      :min="min"
      :max="max"
      :disabled="disabled"
      @change="handleChange"
    >
    <button
      type="button"
      class="quantity-selector__btn"
      :disabled="disabled || modelValue >= max"
      @click="increment"
    >
      <i class="bi bi-plus"></i>
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Number,
    required: true,
  },
  min: {
    type: Number,
    default: 1,
  },
  max: {
    type: Number,
    default: 99,
  },
  step: {
    type: Number,
    default: 1,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['update:modelValue', 'change'])

const increment = () => {
  if (props.modelValue < props.max) {
    emit('update:modelValue', Math.min(props.modelValue + props.step, props.max))
  }
}

const decrement = () => {
  if (props.modelValue > props.min) {
    emit('update:modelValue', Math.max(props.modelValue - props.step, props.min))
  }
}

const handleChange = (e) => {
  let value = parseInt(e.target.value) || props.min
  value = Math.max(props.min, Math.min(props.max, value))
  emit('update:modelValue', value)
  emit('change', value)
}
</script>

<style lang="scss" scoped>
.quantity-selector {
  display: inline-flex;
  align-items: center;
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  overflow: hidden;

  &--disabled {
    opacity: 0.5;
    pointer-events: none;
  }

  &__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    padding: 0;
    border: none;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text);
    cursor: pointer;
    transition: background-color 0.15s;

    &:hover:not(:disabled) {
      background: var(--bulma-scheme-main-ter);
      color: var(--bulma-link);
    }

    &:disabled {
      cursor: not-allowed;
      opacity: 0.4;
    }

    i {
      font-size: 0.875rem;
    }
  }

  &__input {
    width: 3rem;
    height: 2.5rem;
    padding: 0;
    border: none;
    border-left: 1px solid var(--bulma-border);
    border-right: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    font-size: 0.875rem;
    font-weight: 600;
    text-align: center;
    -moz-appearance: textfield;

    &::-webkit-outer-spin-button,
    &::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    &:focus {
      outline: none;
      background: var(--bulma-scheme-main-bis);
    }
  }
}
</style>
