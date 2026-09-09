<template>
  <article
    class="service-card-overlay"
    :class="[
      `service-card-overlay--${variant}`,
      `service-card-overlay--${overlayPosition}`,
      { 'service-card-overlay--selected': selected }
    ]"
    role="button"
    tabindex="0"
    @click="$emit('select', item)"
    @keydown.enter="$emit('select', item)"
    @keydown.space.prevent="$emit('select', item)"
  >
    <ServiceMediaOverlay
      v-if="showMedia && (item.image || item.media)"
      :src="item.image || item.media"
      :alt="item.name"
      :badge="item.badge || item.tag"
      :discount="item.discount"
      :variant="overlayVariant"
      :show-hover-overlay="showHoverOverlay"
      :hover-title="hoverTitle || item.name"
      :hover-subtitle="hoverSubtitle || item.description"
      :hover-action="hoverAction"
      class="service-card-overlay__media"
    >
      <div v-if="$slots.overlay" class="service-card-overlay__overlay-content">
        <slot name="overlay"></slot>
      </div>
    </ServiceMediaOverlay>

    <div class="service-card-overlay__content">
      <div v-if="item.category || item.tag" class="service-card-overlay__category">
        {{ item.category || item.tag }}
      </div>

      <h4 class="service-card-overlay__name">{{ item.name }}</h4>

      <p
        v-if="showDescription && item.description"
        class="service-card-overlay__description"
      >
        {{ truncateText(item.description, descriptionLength) }}
      </p>

      <div
        v-if="showMeta && item.meta?.length"
        class="service-card-overlay__meta"
      >
        <span
          v-for="(m, idx) in item.meta.slice(0, maxMeta)"
          :key="idx"
          class="service-card-overlay__meta-item"
        >
          <i v-if="m.icon" :class="m.icon"></i>
          {{ m.label }}
        </span>
      </div>

      <div v-if="showFooter" class="service-card-overlay__footer">
        <ServicePriceDisplay
          v-if="showPrice && (item.price || item.price_from)"
          :price="item.price || item.price_from"
          :original-price="item.original_price"
          :price-from="item.price_from"
          :currency="currency"
        />

        <div v-if="item.actions?.length" class="service-card-overlay__actions">
          <button
            v-for="action in item.actions.slice(0, 2)"
            :key="action.id"
            class="service-card-overlay__action"
            :class="`service-card-overlay__action--${action.variant || 'default'}`"
            type="button"
            @click.stop="handleAction(action)"
          >
            <i v-if="action.icon" :class="action.icon"></i>
            <span v-if="!action.iconOnly">{{ action.label }}</span>
          </button>
        </div>

        <button
          v-else-if="showDefaultAction"
          class="service-card-overlay__action service-card-overlay__action--primary"
          type="button"
          @click.stop="$emit('action', item)"
        >
          <i :class="defaultActionIcon"></i>
          <span>{{ defaultActionLabel }}</span>
        </button>
      </div>
    </div>
  </article>
</template>

<script setup>
import ServiceMediaOverlay from './structure/overlay/ServiceMediaOverlay.vue'
import ServicePriceDisplay from './structure/overlay/ServicePriceDisplay.vue'

const props = defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({
      name: '',
      price: null,
      price_from: null,
      original_price: null,
      image: '',
      media: '',
      description: '',
      category: '',
      badge: '',
      tag: '',
      discount: null,
      meta: [],
      actions: [],
    }),
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'compact', 'featured', 'minimal'].includes(v),
  },
  overlayVariant: {
    type: String,
    default: 'gradient-bottom',
    validator: (v) => ['default', 'dark', 'light', 'gradient-bottom', 'gradient-center', 'brand'].includes(v),
  },
  overlayPosition: {
    type: String,
    default: 'bottom',
    validator: (v) => ['top', 'bottom', 'center'].includes(v),
  },
  selected: {
    type: Boolean,
    default: false,
  },
  showMedia: {
    type: Boolean,
    default: true,
  },
  showDescription: {
    type: Boolean,
    default: true,
  },
  showMeta: {
    type: Boolean,
    default: true,
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
  showDefaultAction: {
    type: Boolean,
    default: true,
  },
  defaultActionLabel: {
    type: String,
    default: 'Ver más',
  },
  defaultActionIcon: {
    type: String,
    default: 'bi bi-arrow-right',
  },
  descriptionLength: {
    type: Number,
    default: 80,
  },
  maxMeta: {
    type: Number,
    default: 3,
  },
  currency: {
    type: String,
    default: 'MXN',
  },
  showHoverOverlay: {
    type: Boolean,
    default: true,
  },
  hoverTitle: {
    type: String,
    default: '',
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

const emit = defineEmits(['select', 'action'])

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}

const handleAction = (action) => {
  emit('action', { item: props.item, action })
}
</script>

<style lang="scss" scoped>
.service-card-overlay {
  position: relative;
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  cursor: pointer;
  transition: all 0.2s;
  height: 100%;

  &:hover {
    transform: translateY(-2px);
    box-shadow: var(--dl-shadow-sm);

    .service-card-overlay__media img {
      transform: scale(1.03);
    }
  }

  &--selected {
    border-color: var(--bulma-link);
    box-shadow: 0 0 0 2px color-mix(in oklch, var(--bulma-link) 30%, transparent);
  }

  &--featured {
    border-color: var(--bulma-warning);
  }

  &--compact {
    .service-card-overlay__media {
      aspect-ratio: 1 / 1;
    }

    .service-card-overlay__content {
      padding: 0.75rem;
    }
  }

  &--minimal {
    flex-direction: row;
    align-items: center;
    padding: 0.75rem;
    gap: 0.75rem;

    .service-card-overlay__media {
      width: 4rem;
      height: 4rem;
      flex-shrink: 0;
      border-radius: var(--bulma-radius);
    }

    .service-card-overlay__content {
      padding: 0;
    }
  }

  &--bottom {
    .service-card-overlay__content {
      margin-top: auto;
    }
  }

  &--center {
    .service-card-overlay__content {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 1rem;
    }
  }

  &__media {
    aspect-ratio: 4 / 3;
    flex-shrink: 0;

    img {
      transition: transform 0.3s ease;
    }
  }

  &__overlay-content {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    padding: 0.875rem;
    flex: 1;
    position: relative;
    z-index: 1;
  }

  &__category {
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--bulma-text-weak);
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.25rem;
  }

  &__meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    margin-top: auto;
    padding-top: 0.5rem;
    flex-wrap: wrap;
  }

  &__actions {
    display: flex;
    gap: 0.375rem;
  }

  &__action {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.625rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &--primary {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);

      &:hover {
        background: var(--bulma-link-hover);
        border-color: var(--bulma-link-hover);
        color: var(--bulma-link-invert);
      }
    }

    i {
      font-size: 0.875rem;
    }
  }
}
</style>
