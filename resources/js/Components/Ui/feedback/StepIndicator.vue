<template>
  <div class="step-indicator" :class="{ 'step-indicator--horizontal': horizontal }">
    <div
      v-for="(step, index) in steps"
      :key="index"
      class="step-indicator__item"
      :class="{
        'step-indicator__item--active': index === currentStep,
        'step-indicator__item--completed': index < currentStep,
        'step-indicator__item--clickable': clickable && index < currentStep,
      }"
      @click="clickable && index < currentStep && $emit('step', index)"
    >
      <div class="step-indicator__header">
        <div class="step-indicator__dot">
          <i v-if="index < currentStep" class="bi bi-check"></i>
          <span v-else>{{ index + 1 }}</span>
        </div>
        <div v-if="index < steps.length - 1 && showLines" class="step-indicator__line"></div>
      </div>
      <div class="step-indicator__content">
        <span class="step-indicator__label">{{ typeof step === 'string' ? step : (step.label || '') }}</span>
        <span v-if="typeof step === 'object' && step.description" class="step-indicator__description">{{ step.description }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  steps: {
    type: Array,
    required: true,
  },
  currentStep: {
    type: Number,
    default: 0,
  },
  clickable: {
    type: Boolean,
    default: true,
  },
  horizontal: {
    type: Boolean,
    default: true,
  },
  showLines: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['step'])
</script>

<style lang="scss" scoped>
.step-indicator {
  display: flex;
  flex-direction: column;
  gap: 0;

  &--horizontal {
    flex-direction: row;
    align-items: flex-start;
    gap: 0;
    padding: 0.5rem 0;
  }

  &__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;

    &--clickable {
      cursor: pointer;
    }
  }

  &__header {
    display: flex;
    align-items: center;
    width: 100%;
  }

  &__dot {
    width: 2.25rem;
    height: 2.25rem;
    min-width: 2.25rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    background: var(--bulma-scheme-main-bis);
    border: 2px solid var(--bulma-border);
    color: var(--bulma-text-weak);
    transition: all 0.2s;
    z-index: 2;

    i {
      font-size: 0.875rem;
    }
  }

  &__line {
    flex: 1;
    height: 2px;
    background: var(--bulma-border);
    transition: background-color 0.3s;
    margin: 0 0.5rem;
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
    margin-top: 0.625rem;
    padding: 0 0.25rem;
    max-width: 100%;
  }

  &__label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--bulma-text-weak);
    transition: color 0.2s;
    line-height: 1.3;
    word-wrap: break-word;
  }

  &__description {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
    transition: color 0.2s;
    line-height: 1.3;
  }

  &__item--active {
    .step-indicator__dot {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
      transform: scale(1.1);
    }

    .step-indicator__label {
      color: var(--bulma-link);
      font-weight: 600;
    }
  }

  &__item--completed {
    .step-indicator__dot {
      background: var(--bulma-success);
      border-color: var(--bulma-success);
      color: white;
    }

    .step-indicator__line {
      background: var(--bulma-success);
    }

    .step-indicator__label {
      color: var(--bulma-success);
    }
  }

  &__item--clickable:hover {
    .step-indicator__dot {
      transform: scale(1.05);
      box-shadow: 0 0 0 4px color-mix(in oklch, var(--bulma-success) 20%, transparent);
    }
  }
}
</style>
