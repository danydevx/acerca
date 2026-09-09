<template>
  <div class="product-variant" :class="{ 'product-variant--disabled': disabled }">
    <label v-if="label" class="product-variant__label">{{ label }}</label>
    <div class="product-variant__options">
      <button
        v-for="option in options"
        :key="option.value"
        type="button"
        class="product-variant__option"
        :class="{
          'product-variant__option--selected': modelValue === option.value,
          'product-variant__option--disabled': option.disabled,
        }"
        :disabled="disabled || option.disabled"
        @click="selectOption(option)"
      >
        <span v-if="option.color" class="product-variant__color" :style="{ backgroundColor: option.color }"></span>
        <span v-if="option.image" class="product-variant__image">
          <img :src="option.image" :alt="option.label">
        </span>
        <span class="product-variant__text">{{ option.label }}</span>
      </button>
    </div>
    <p v-if="helperText" class="product-variant__helper">{{ helperText }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: String,
    default: null,
  },
  options: {
    type: Array,
    required: true,
  },
  label: {
    type: String,
    default: '',
  },
  helperText: {
    type: String,
    default: '',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['update:modelValue'])

const selectOption = (option) => {
  if (option.disabled) return
  emit('update:modelValue', option.value)
}
</script>

<style lang="scss" scoped>
.product-variant {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  &--disabled {
    opacity: 0.5;
    pointer-events: none;
  }

  &__label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__options {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  &__option {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.15s;

    &:hover:not(:disabled) {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &--selected {
      border-color: var(--bulma-link);
      background: color-mix(in oklch, var(--bulma-link) 10%, transparent);
      color: var(--bulma-link);
    }

    &--disabled {
      opacity: 0.4;
      cursor: not-allowed;
      text-decoration: line-through;
    }
  }

  &__color {
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 1px solid var(--bulma-border);
  }

  &__image {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: var(--bulma-radius-small);
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__text {
    line-height: 1;
  }

  &__helper {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }
}
</style>
