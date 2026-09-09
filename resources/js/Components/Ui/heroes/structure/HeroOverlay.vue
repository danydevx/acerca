<template>
  <div
    class="hero-overlay"
    :class="`hero-overlay--${variant}`"
    :style="overlayStyle"
  ></div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'none',
    validator: (v) => [
      'none',
      'dark',
      'light',
      'gradient-bottom',
      'gradient-top',
      'gradient-center',
      'brand',
      'soft',
    ].includes(v),
  },
  intensity: {
    type: String,
    default: 'medium',
    validator: (v) => ['light', 'medium', 'strong'].includes(v),
  },
  color: {
    type: String,
    default: '',
  },
})

const intensityValues = {
  light: 0.3,
  medium: 0.5,
  strong: 0.7,
}

const overlayStyle = computed(() => {
  if (props.color) {
    return { background: props.color }
  }
  return {}
})
</script>

<style lang="scss" scoped>
.hero-overlay {
  position: absolute;
  inset: 0;
  pointer-events: none;

  &--none {
    display: none;
  }

  &--dark {
    background: oklch(0 0 0 / 0.6);
  }

  &--light {
    background: oklch(100% 0 0 / 0.3);
  }

  &--gradient-bottom {
    background: linear-gradient(
      to top,
      oklch(0 0 0 / 0.7) 0%,
      oklch(0 0 0 / 0.4) 50%,
      oklch(0 0 0 / 0) 100%
    );
  }

  &--gradient-top {
    background: linear-gradient(
      to bottom,
      oklch(0 0 0 / 0.7) 0%,
      oklch(0 0 0 / 0.4) 50%,
      oklch(0 0 0 / 0) 100%
    );
  }

  &--gradient-center {
    background: radial-gradient(
      ellipse at center,
      oklch(0 0 0 / 0.3) 0%,
      oklch(0 0 0 / 0.6) 100%
    );
  }

  &--brand {
    background: linear-gradient(
      135deg,
      oklch(50% 0.15 250 / 0.8) 0%,
      oklch(50% 0.15 300 / 0.6) 100%
    );
  }

  &--soft {
    background: linear-gradient(
      to top,
      oklch(0 0 0 / 0.4) 0%,
      oklch(0 0 0 / 0.1) 100%
    );
  }
}
</style>
