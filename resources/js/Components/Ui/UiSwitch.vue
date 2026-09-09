<template>
  <label class="ui-switch dl-bulma-switch" :class="{ 'dl-bulma-switch--disabled': disabled }">
    <input
      type="checkbox"
      class="dl-bulma-switch__input"
      role="switch"
      :aria-checked="modelValue"
      :checked="modelValue"
      :disabled="disabled"
      :name="name"
      :value="value"
      @change="toggle"
    >
    <span class="dl-bulma-switch__control">
      <span class="dl-bulma-switch__thumb" />
    </span>
    <span v-if="label" class="dl-bulma-switch__label">
      {{ label }}
    </span>
  </label>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  label: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  },
  name: {
    type: String,
    default: ''
  },
  value: {
    type: String,
    default: '1'
  }
})

const emit = defineEmits(['update:modelValue', 'change'])

const toggle = (e) => {
  if (props.disabled) return
  const newValue = e.target.checked
  emit('update:modelValue', newValue)
  emit('change', newValue)
}
</script>

<style lang="scss" scoped>
.dl-bulma-switch {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;

  &--disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  &__input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;

    &:focus-visible + .dl-bulma-switch__control {
      outline: 2px solid var(--bulma-link);
      outline-offset: 2px;
    }
  }

  &__control {
    position: relative;
    display: inline-flex;
    align-items: center;
    width: 44px;
    height: 24px;
    background: var(--bulma-border);
    border-radius: 12px;
    transition: background-color 0.2s;

    .dl-bulma-switch__input:checked + & {
      background: var(--bulma-link);
    }

    .dl-bulma-switch__input:disabled + & {
      opacity: 0.5;
    }
  }

  &__thumb {
    position: absolute;
    left: 2px;
    width: 20px;
    height: 20px;
    background: var(--bulma-scheme-main);
    border-radius: 50%;
    box-shadow: 0 1px 3px oklch(0 0 0 / 0.2);
    transition: transform 0.2s;

    .dl-bulma-switch__input:checked + .dl-bulma-switch__control & {
      transform: translateX(20px);
    }
  }

  &__label {
    font-size: 0.875rem;
    color: var(--bulma-text);
  }
}
</style>
