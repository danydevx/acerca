<template>
  <article
    class="service-card"
    :class="[
      `service-card--${variant}`,
      { 'service-card--selected': selected }
    ]"
    role="button"
    tabindex="0"
    @click="$emit('select', item)"
    @keydown.enter="$emit('select', item)"
    @keydown.space.prevent="$emit('select', item)"
  >
    <div v-if="showMedia && (item.image || item.media)" class="service-card__media">
      <img :src="item.image || item.media" :alt="item.name">
      <div v-if="item.badge || item.tag" class="service-card__badge">
        {{ item.badge || item.tag }}
      </div>
      <div v-if="item.discount" class="service-card__discount">-{{ item.discount }}%</div>
    </div>

    <div class="service-card__content">
      <h4 class="service-card__name">{{ item.name }}</h4>

      <p v-if="showDescription && item.description" class="service-card__description">
        {{ truncateText(item.description, descriptionLength) }}
      </p>

      <div v-if="item.meta?.length" class="service-card__meta">
        <span
          v-for="(m, idx) in item.meta.slice(0, maxMeta)"
          :key="idx"
          class="service-card__meta-item"
        >
          <i v-if="m.icon" :class="m.icon"></i>
          {{ m.label }}
        </span>
      </div>

      <div class="service-card__footer">
        <div v-if="showPrice && (item.price || item.price_from)" class="service-card__price-group">
          <span v-if="item.price_from" class="service-card__price-label">Desde</span>
          <span class="service-card__price">{{ formatPrice(item.price || item.price_from) }}</span>
          <span v-if="item.original_price" class="service-card__original-price">
            {{ formatPrice(item.original_price) }}
          </span>
        </div>

        <div v-if="item.actions?.length" class="service-card__actions">
          <button
            v-for="action in item.actions.slice(0, 2)"
            :key="action.id"
            class="service-card__action"
            :class="`service-card__action--${action.variant || 'default'}`"
            type="button"
            @click.stop="handleAction(action)"
          >
            <i v-if="action.icon" :class="action.icon"></i>
            <span v-if="!action.iconOnly">{{ action.label }}</span>
          </button>
        </div>

        <button
          v-else-if="showDefaultAction"
          class="service-card__action service-card__action--primary"
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
    validator: (v) => ['default', 'compact', 'featured', 'minimal', 'overlay'].includes(v),
  },
  selected: {
    type: Boolean,
    default: false,
  },
  showImage: {
    type: Boolean,
    default: true,
  },
  showMedia: {
    type: Boolean,
    default: true,
  },
  showDescription: {
    type: Boolean,
    default: true,
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
  showDefaultAction: {
    type: Boolean,
    default: true,
  },
  defaultActionLabel: {
    type: String,
    default: 'Agregar',
  },
  defaultActionIcon: {
    type: String,
    default: 'bi bi-plus',
  },
  descriptionLength: {
    type: Number,
    default: 80,
  },
  maxMeta: {
    type: Number,
    default: 3,
  },
})

const emit = defineEmits(['select', 'action'])

const formatPrice = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}

const handleAction = (action) => {
  emit('action', { item: props.item, action })
}
</script>

<style lang="scss" scoped>
.service-card {
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
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);

    .service-card__media img {
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

  &--minimal {
    flex-direction: row;
    align-items: center;
    padding: 0.75rem;
    gap: 0.75rem;

    .service-card__media {
      width: 60px;
      height: 60px;
      flex-shrink: 0;
    }

    .service-card__content {
      padding: 0;
    }
  }

  &--overlay {
    position: relative;

    .service-card__media {
      position: absolute;
      inset: 0;
    }

    .service-card__content {
      position: relative;
      margin-top: auto;
      background: linear-gradient(to top, oklch(0 0 0 / 0.8) 0%, transparent 100%);
      color: white;
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;
    }
  }

  &__badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--bulma-radius-small);
  }

  &__discount {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-danger);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: var(--bulma-radius-small);
  }

  &__content {
    padding: 0.875rem;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    flex: 1;
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

  &__price-group {
    display: flex;
    align-items: baseline;
    gap: 0.375rem;
    flex-wrap: wrap;
  }

  &__price-label {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
  }

  &__price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-success);
  }

  &__original-price {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
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
