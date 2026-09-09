<template>
  <div
    class="service-media-overlay"
    :class="[`service-media-overlay--${variant}`, { 'service-media-overlay--hoverable': showHoverOverlay }]"
  >
    <img
      v-if="src"
      :src="src"
      :alt="alt"
      class="service-media-overlay__image"
    >
    <div v-else class="service-media-overlay__placeholder">
      <i class="bi bi-image"></i>
    </div>

    <div class="service-media-overlay__overlay"></div>

    <div v-if="badge || discount" class="service-media-overlay__badges">
      <span v-if="discount" class="service-media-overlay__badge service-media-overlay__badge--discount">
        -{{ discount }}%
      </span>
      <span v-if="badge" class="service-media-overlay__badge">
        {{ badge }}
      </span>
    </div>

    <div v-if="showHoverOverlay" class="service-media-overlay__hover-content">
      <div class="service-media-overlay__hover-inner">
        <span v-if="hoverTitle" class="service-media-overlay__hover-title">{{ hoverTitle }}</span>
        <span v-if="hoverSubtitle" class="service-media-overlay__hover-subtitle">{{ hoverSubtitle }}</span>
        <span v-if="hoverAction" class="service-media-overlay__hover-action">
          {{ hoverAction }}
          <i class="bi bi-arrow-right"></i>
        </span>
      </div>
    </div>

    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  src: {
    type: String,
    default: '',
  },
  alt: {
    type: String,
    default: '',
  },
  badge: {
    type: String,
    default: '',
  },
  discount: {
    type: Number,
    default: null,
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'dark', 'light', 'gradient-bottom', 'gradient-center', 'brand'].includes(v),
  },
  showHoverOverlay: {
    type: Boolean,
    default: true,
  },
  hoverTitle: {
    type: String,
    default: 'Ver detalles',
  },
  hoverSubtitle: {
    type: String,
    default: '',
  },
  hoverAction: {
    type: String,
    default: 'Ver más',
  },
})
</script>

<style lang="scss" scoped>
.service-media-overlay {
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background: var(--bulma-scheme-main-bis);

  &__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 2rem;
    }
  }

  &__overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
  }

  &__badges {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    display: flex;
    gap: 0.25rem;
    z-index: 1;
  }

  &__badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-small);
    background: var(--bulma-link);
    color: var(--bulma-link-invert);

    &--discount {
      background: var(--bulma-danger);
      color: var(--bulma-danger-invert);
    }
  }

  &--default {
    .service-media-overlay__overlay {
      background: transparent;
    }
  }

  &--dark {
    .service-media-overlay__overlay {
      background: oklch(0 0 0 / 0.4);
    }

    :deep(.service-media-overlay__content) {
      color: var(--bulma-scheme-main);
    }
  }

  &--light {
    .service-media-overlay__overlay {
      background: oklch(100% 0 0 / 0.3);
    }
  }

  &--gradient-bottom {
    .service-media-overlay__overlay {
      background: linear-gradient(
        to top,
        oklch(0 0 0 / 0.7) 0%,
        oklch(0 0 0 / 0.3) 40%,
        transparent 100%
      );
    }

    :deep(.service-media-overlay__content) {
      color: var(--bulma-scheme-main);
    }
  }

  &--gradient-center {
    .service-media-overlay__overlay {
      background: radial-gradient(
        ellipse at center,
        oklch(0 0 0 / 0.5) 0%,
        oklch(0 0 0 / 0.2) 50%,
        transparent 100%
      );
    }

    :deep(.service-media-overlay__content) {
      color: var(--bulma-scheme-main);
    }
  }

  &--brand {
    .service-media-overlay__overlay {
      background: linear-gradient(
        135deg,
        var(--bulma-primary) 0%,
        color-mix(in oklch, var(--bulma-primary) 70%, black) 100%
      );
      opacity: 0.6;
    }

    :deep(.service-media-overlay__content) {
      color: var(--bulma-primary-invert);
    }
  }

  &__hover-content {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s ease;
    z-index: 3;
    background: oklch(0 0 0 / 0.5);
  }

  &__hover-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.375rem;
    text-align: center;
    padding: 1rem;
  }

  &__hover-title {
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    text-shadow: 0 1px 2px oklch(0 0 0 / 0.3);
  }

  &__hover-subtitle {
    font-size: 0.8125rem;
    color: oklch(100% 0 0 / 0.9);
  }

  &__hover-action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    margin-top: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #fff;
    background: var(--bulma-link);
    border-radius: var(--bulma-radius);
    transition: background 0.15s ease;

    i {
      font-size: 0.875rem;
      transition: transform 0.15s ease;
    }
  }

  &--hoverable {
    &:hover {
      .service-media-overlay__hover-content {
        opacity: 1;
      }

      .service-media-overlay__image {
        transform: scale(1.05);
      }

      .service-media-overlay__hover-action i {
        transform: translateX(3px);
      }
    }
  }
}
</style>
