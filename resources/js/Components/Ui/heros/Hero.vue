<template>
  <section class="hero" :class="heroClasses" :style="heroStyle">
    <div v-if="image" class="hero-image-overlay"></div>
    <div class="hero-body">
      <div class="container">
        <slot>
          <div class="hero-content" :class="{ 'has-text-white': hasOverlay }">
            <div v-if="eyebrow" class="hero-eyebrow">{{ eyebrow }}</div>
            <h1 v-if="title" class="title" :class="titleClass">{{ title }}</h1>
            <p v-if="description" class="subtitle">{{ description }}</p>
            <div v-if="$slots.actions" class="hero-actions">
              <slot name="actions"></slot>
            </div>
          </div>
        </slot>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: { type: String, default: '' },
  eyebrow: { type: String, default: '' },
  description: { type: String, default: '' },
  image: { type: String, default: '' },
  color: {
    type: String,
    default: '',
    validator: (v) => ['', 'primary', 'info', 'success', 'warning', 'danger', 'link', 'dark'].includes(v),
  },
  size: {
    type: String,
    default: '',
    validator: (v) => ['', 'small', 'medium', 'large'].includes(v),
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'secondary', 'compact', 'image'].includes(v),
  },
  bold: { type: Boolean, default: false },
  fullheight: { type: Boolean, default: false },
})

const heroClasses = computed(() => ({
  [`is-${props.color}`]: !!props.color,
  [`is-${props.size}`]: !!props.size,
  'is-bold': props.bold,
  'is-fullheight': props.fullheight,
  [`hero--${props.variant}`]: true,
}))

const hasOverlay = computed(() => props.variant === 'image' || !!props.image)

const heroStyle = computed(() => {
  if (props.image) {
    return {
      backgroundImage: `url(${props.image})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    }
  }
  return {}
})

const titleClass = computed(() => ({
  'is-1': props.size === 'large',
  'is-2': props.size === 'medium' || !props.size,
  'is-3': props.size === 'small',
}))
</script>

<style lang="scss" scoped>
.hero {
  position: relative;

  &--compact {
    .hero-body {
      padding: 1.5rem 1rem;
    }

    .title {
      font-size: 1.5rem;
    }

    .subtitle {
      font-size: 0.875rem;
    }

    .hero-actions {
      margin-top: 1rem;
    }
  }

  &--secondary {
    background: var(--bulma-scheme-main-bis);

    .hero-body {
      padding: 2rem 1rem;
    }
  }

  &--image {
    // Image variant relies on hero-content has-text-white for text color
  }
}

.hero-image-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, oklch(0 0 0 / 0.7) 0%, oklch(0 0 0 / 0.3) 100%);
  pointer-events: none;
}

.hero-content {
  max-width: 600px;
  position: relative;
  z-index: 1;

  &.has-text-white {
    color: white !important;
    text-shadow: 0 1px 3px oklch(0 0 0 / 0.3);

    .title {
      color: white !important;
    }

    .subtitle {
      color: oklch(100% 0 0 / 0.9) !important;
    }

    .hero-eyebrow {
      color: var(--bulma-primary-light) !important;
    }
  }
}

.hero-eyebrow {
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--bulma-primary);
  margin-bottom: 0.5rem;
}

.hero-actions {
  margin-top: 1.5rem;
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
}
</style>
