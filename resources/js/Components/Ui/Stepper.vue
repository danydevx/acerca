<template>
  <div class="stepper" :class="[`stepper--${size}`, `stepper--${orientation}`]">
    <div
      v-for="(step, index) in steps"
      :key="index"
      class="stepper__item"
      :class="{
        'is-completed': index < modelValue,
        'is-active': index === modelValue - 1 || index === modelValue,
        'is-clickable': clickable,
      }"
      @click="clickable && onStepClick(index)"
    >
      <div class="stepper__indicator">
        <div class="stepper__line" v-if="index > 0"></div>
        <div class="stepper__circle">
          <i v-if="index < modelValue" class="bi bi-check"></i>
          <span v-else>{{ index + 1 }}</span>
        </div>
        <div class="stepper__line" v-if="index < steps.length - 1"></div>
      </div>
      <div class="stepper__content">
        <span v-if="step.label" class="stepper__label">{{ step.label }}</span>
        <span v-if="step.description" class="stepper__description">{{ step.description }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  steps: { type: Array, default: () => [] },
  modelValue: { type: Number, default: 0 },
  size: { type: String, default: 'default', validator: (v) => ['small', 'default', 'medium', 'large'].includes(v) },
  orientation: { type: String, default: 'horizontal', validator: (v) => ['horizontal', 'vertical'].includes(v) },
  clickable: { type: Boolean, default: false },
})

const emit = defineEmits(['update:modelValue', 'step-click'])

const onStepClick = (index) => {
  emit('step-click', index)
  emit('update:modelValue', index + 1)
}
</script>

<style lang="scss" scoped>
.stepper {
  display: flex;
  align-items: flex-start;
  width: 100%;

  &--vertical {
    flex-direction: column;

    .stepper__item {
      flex-direction: row;
      align-items: flex-start;
      text-align: left;
      gap: 1rem;
      flex: none;
      width: 100%;
    }

    .stepper__indicator {
      flex-direction: column;
      width: auto;
      height: 100%;
    }

    .stepper__line {
      width: 2px;
      height: 100%;
      min-height: 2rem;
    }

    .stepper__content {
      margin-top: 0;
      padding-top: 0.25rem;
      flex: 1;
    }
  }

  &__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    text-align: center;
    position: relative;

    &.is-clickable {
      cursor: pointer;
    }
  }

  &__indicator {
    display: flex;
    align-items: center;
    width: 100%;
    position: relative;
  }

  &__line {
    flex: 1;
    height: 2px;
    background: var(--bulma-border);
    transition: background 150ms;
    min-width: 1rem;
  }

  &__circle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--bulma-border);
    color: var(--bulma-text-weak);
    font-size: 0.875rem;
    font-weight: 600;
    flex-shrink: 0;
    transition: all 150ms;
    position: relative;
    z-index: 1;

    i {
      font-size: 0.875rem;
    }
  }

  &__content {
    margin-top: 0.75rem;
    padding: 0 0.25rem;
    text-align: center;
    width: 100%;
  }

  &__label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
    line-height: 1.3;
  }

  &__description {
    display: block;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin-top: 0.25rem;
    line-height: 1.3;
  }

  // States
  &.is-completed {
    .stepper__circle {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);
    }

    & + .stepper__item .stepper__line,
    .stepper__item.is-completed .stepper__line {
      background: var(--bulma-link);
    }
  }

  &__item.is-completed {
    .stepper__circle {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);
    }

    .stepper__line {
      background: var(--bulma-link);
    }
  }

  &__item.is-active {
    .stepper__circle {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);
      box-shadow: 0 0 0 4px color-mix(in oklch, var(--bulma-link) 20%, transparent);
    }

    .stepper__label {
      color: var(--bulma-link);
      font-weight: 600;
    }
  }

  // Sizes
  &--small {
    .stepper__circle {
      width: 1.5rem;
      height: 1.5rem;
      font-size: 0.75rem;
    }

    .stepper__label { font-size: 0.75rem; }
    .stepper__description { font-size: 0.625rem; }
    .stepper__content { margin-top: 0.5rem; }
  }

  &--medium {
    .stepper__circle {
      width: 2.5rem;
      height: 2.5rem;
      font-size: 1rem;
    }

    .stepper__label { font-size: 1rem; }
    .stepper__description { font-size: 0.875rem; }
    .stepper__content { margin-top: 1rem; }
  }

  &--large {
    .stepper__circle {
      width: 3rem;
      height: 3rem;
      font-size: 1.125rem;
    }

    .stepper__label { font-size: 1.125rem; }
    .stepper__description { font-size: 1rem; }
    .stepper__content { margin-top: 1rem; }
  }
}
</style>
