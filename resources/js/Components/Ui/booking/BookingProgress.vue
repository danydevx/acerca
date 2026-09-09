<template>
  <div class="booking-progress">
    <div class="booking-progress__steps">
      <div
        v-for="(step, index) in steps"
        :key="index"
        class="booking-progress__step"
        :class="{
          'booking-progress__step--active': index === currentStep,
          'booking-progress__step--completed': index < currentStep,
          'booking-progress__step--clickable': clickable,
        }"
        @click="clickable && index < currentStep && goToStep(index)"
      >
        <div class="booking-progress__indicator">
          <i v-if="index < currentStep" class="bi bi-check"></i>
          <span v-else>{{ index + 1 }}</span>
        </div>
        <span class="booking-progress__label">{{ step }}</span>
      </div>
    </div>
    <div class="booking-progress__bar">
      <div
        class="booking-progress__fill"
        :style="{ width: progressWidth }"
      ></div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
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
})

const emit = defineEmits(['step'])

const progressWidth = computed(() => {
  if (props.steps.length <= 1) return '100%'
  return `${(props.currentStep / (props.steps.length - 1)) * 100}%`
})

const goToStep = (index) => {
  emit('step', index)
}
</script>

<style lang="scss" scoped>
.booking-progress {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;

  &__steps {
    display: flex;
    justify-content: space-between;
    position: relative;
  }

  &__step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.375rem;
    position: relative;
    z-index: 1;

    &--clickable {
      cursor: pointer;
    }

    &--completed {
      .booking-progress__indicator {
        background: var(--bulma-success);
        border-color: var(--bulma-success);
        color: white;
      }

      .booking-progress__label {
        color: var(--bulma-success);
      }
    }

    &--active {
      .booking-progress__indicator {
        background: var(--bulma-link);
        border-color: var(--bulma-link);
        color: var(--bulma-link-invert);
        transform: scale(1.1);
      }

      .booking-progress__label {
        color: var(--bulma-link);
        font-weight: 600;
      }
    }
  }

  &__indicator {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    border: 2px solid var(--bulma-border);
    background: var(--bulma-scheme-main);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    transition: all 0.2s;

    i {
      font-size: 0.875rem;
    }
  }

  &__label {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
    text-align: center;
    max-width: 4rem;
    line-height: 1.2;
  }

  &__bar {
    height: 4px;
    background: var(--bulma-border);
    border-radius: 2px;
    overflow: hidden;
    margin-top: -1.25rem;
    padding: 0 1rem;
  }

  &__fill {
    height: 100%;
    background: var(--bulma-link);
    border-radius: 2px;
    transition: width 0.3s ease;
  }
}
</style>
