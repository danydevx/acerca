<template>
  <div class="service-stepper" :class="[`service-stepper--${variant}`]">
    <div class="service-stepper__header" v-if="title">
      <h3 class="service-stepper__title">{{ title }}</h3>
      <p v-if="description" class="service-stepper__description">{{ description }}</p>
    </div>

    <div class="service-stepper__progress" v-if="showProgress">
      <div class="service-stepper__progress-bar">
        <div
          class="service-stepper__progress-fill"
          :style="{ width: `${((currentStep - 1) / (steps.length - 1)) * 100}%` }"
        ></div>
      </div>
      <span class="service-stepper__progress-text">
        Paso {{ currentStep }} de {{ steps.length }}
      </span>
    </div>

    <div class="service-stepper__steps">
      <div
        v-for="(step, idx) in steps"
        :key="step.id"
        class="service-stepper__step"
        :class="{
          'is-active': idx + 1 === currentStep,
          'is-completed': idx + 1 < currentStep,
          'is-disabled': idx + 1 > currentStep && !allowSkip,
        }"
      >
        <div class="service-stepper__step-indicator">
          <div class="service-stepper__step-circle">
            <i v-if="idx + 1 < currentStep" class="bi bi-check"></i>
            <span v-else>{{ idx + 1 }}</span>
          </div>
          <div v-if="idx < steps.length - 1" class="service-stepper__step-line"></div>
        </div>

        <div class="service-stepper__step-content">
          <h4 class="service-stepper__step-title">{{ step.title }}</h4>
          <p v-if="step.description" class="service-stepper__step-description">
            {{ step.description }}
          </p>
        </div>
      </div>
    </div>

    <div class="service-stepper__body">
      <slot :name="`step-${currentStep}`" :step="currentStep">
        <div v-if="steps[currentStep - 1]" class="service-stepper__step-body">
          <slot :name="`body-${currentStep}`" :step="currentStep" />
        </div>
      </slot>
    </div>

    <div class="service-stepper__footer" v-if="showFooter">
      <button
        v-if="currentStep > 1"
        class="service-stepper__btn service-stepper__btn--prev"
        type="button"
        @click="prev"
      >
        <i class="bi bi-arrow-left"></i>
        Anterior
      </button>

      <div class="service-stepper__footer-spacer"></div>

      <button
        v-if="currentStep < steps.length"
        class="service-stepper__btn service-stepper__btn--next"
        :class="{ 'is-primary': !showSubmit }"
        type="button"
        @click="next"
      >
        Siguiente
        <i class="bi bi-arrow-right"></i>
      </button>

      <button
        v-if="showSubmit && currentStep === steps.length"
        class="service-stepper__btn service-stepper__btn--submit is-primary"
        type="button"
        @click="$emit('submit')"
      >
        <i v-if="submitIcon" :class="submitIcon"></i>
        {{ submitLabel }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  title: String,
  description: String,
  steps: {
    type: Array,
    required: true,
    default: () => [],
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'minimal', 'cards', 'vertical'].includes(v),
  },
  initialStep: {
    type: Number,
    default: 1,
  },
  showProgress: {
    type: Boolean,
    default: true,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
  allowSkip: {
    type: Boolean,
    default: false,
  },
  showSubmit: {
    type: Boolean,
    default: true,
  },
  submitLabel: {
    type: String,
    default: 'Completar',
  },
  submitIcon: {
    type: String,
    default: 'bi bi-check-lg',
  },
})

const emit = defineEmits(['update', 'next', 'prev', 'submit'])

const currentStep = ref(props.initialStep)

const next = () => {
  if (currentStep.value < props.steps.length) {
    currentStep.value++
    emit('next', currentStep.value)
    emit('update', currentStep.value)
  }
}

const prev = () => {
  if (currentStep.value > 1) {
    currentStep.value--
    emit('prev', currentStep.value)
    emit('update', currentStep.value)
  }
}

const goTo = (step) => {
  if (step >= 1 && step <= props.steps.length) {
    if (step <= currentStep.value || props.allowSkip) {
      currentStep.value = step
      emit('update', currentStep.value)
    }
  }
}
</script>

<style lang="scss" scoped>
.service-stepper {
  &__header {
    margin-bottom: 1.5rem;
    text-align: center;
  }

  &__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__progress {
    margin-bottom: 2rem;
  }

  &__progress-bar {
    height: 4px;
    background: var(--bulma-border);
    border-radius: 2px;
    overflow: hidden;
  }

  &__progress-fill {
    height: 100%;
    background: var(--bulma-link);
    transition: width 0.4s ease;
  }

  &__progress-text {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    text-align: center;
  }

  &__steps {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
  }

  &__step {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    max-width: 200px;
    position: relative;

    &:last-child {
      .service-stepper__step-line {
        display: none;
      }
    }
  }

  &__step-indicator {
    display: flex;
    align-items: center;
    width: 100%;
  }

  &__step-circle {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--bulma-border);
    border-radius: 50%;
    background: var(--bulma-scheme-main);
    color: var(--bulma-text-weak);
    font-size: 0.875rem;
    font-weight: 600;
    flex-shrink: 0;
    transition: all 0.25s;
    z-index: 1;
  }

  &__step-line {
    flex: 1;
    height: 2px;
    background: var(--bulma-border);
    margin: 0 0.5rem;
    transition: background 0.25s;
  }

  &__step-content {
    margin-top: 0.75rem;
    text-align: center;
  }

  &__step-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__step-description {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin: 0.25rem 0 0;
  }

  &__step {
    &.is-active {
      .service-stepper__step-circle {
        border-color: var(--bulma-link);
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
      }

      .service-stepper__step-title {
        color: var(--bulma-link);
      }
    }

    &.is-completed {
      .service-stepper__step-circle {
        border-color: var(--bulma-success);
        background: var(--bulma-success);
        color: white;
      }

      .service-stepper__step-line {
        background: var(--bulma-success);
      }
    }

    &.is-disabled {
      .service-stepper__step-circle {
        opacity: 0.5;
      }

      .service-stepper__step-title {
        color: var(--bulma-text-weak);
      }
    }
  }

  &__body {
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-large);
    padding: 1.5rem;
    min-height: 200px;
  }

  &__footer {
    display: flex;
    align-items: center;
    margin-top: 1.5rem;
    gap: 1rem;
  }

  &__footer-spacer {
    flex: 1;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.625rem 1.25rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: transparent;
    color: var(--bulma-text);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &.is-primary {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);

      &:hover {
        background: var(--bulma-link-hover);
      }
    }
  }

  &--minimal {
    .service-stepper__steps {
      margin-bottom: 1rem;
    }

    .service-stepper__step-circle {
      width: 24px;
      height: 24px;
      font-size: 0.75rem;
    }

    .service-stepper__step-title {
      font-size: 0.75rem;
    }

    .service-stepper__body {
      padding: 1rem;
      min-height: 150px;
    }
  }

  &--cards {
    .service-stepper__steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
    }

    .service-stepper__step {
      max-width: none;
      flex-direction: column;
      padding: 1rem;
      background: var(--bulma-scheme-main-bis);
      border-radius: var(--bulma-radius);
      border: 1px solid var(--bulma-border);
    }

    .service-stepper__step-indicator {
      width: auto;
      flex-direction: column;

      .service-stepper__step-circle {
        margin-bottom: 0.5rem;
      }

      .service-stepper__step-line {
        display: none;
      }
    }

    .service-stepper__step-content {
      text-align: center;
    }

    .service-stepper__step.is-active {
      border-color: var(--bulma-link);
      background: color-mix(in oklch, var(--bulma-link) 5%, var(--bulma-scheme-main));
    }
  }

  &--vertical {
    .service-stepper__steps {
      flex-direction: column;
      align-items: stretch;
      gap: 0;
    }

    .service-stepper__step {
      flex-direction: row;
      max-width: none;
      align-items: flex-start;
    }

    .service-stepper__step-indicator {
      flex-direction: column;
      width: auto;

      .service-stepper__step-line {
        width: 2px;
        height: 24px;
        margin: 0.25rem 0 0;
      }
    }

    .service-stepper__step-content {
      margin-top: 0;
      margin-left: 1rem;
      text-align: left;
      flex: 1;
    }
  }
}
</style>
