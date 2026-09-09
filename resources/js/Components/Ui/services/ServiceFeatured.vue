<template>
  <article
    class="service-featured"
    :class="[`service-featured--${variant}`, { 'service-featured--selected': selected }]"
  >
    <div v-if="showMedia && (item.image || item.media)" class="service-featured__media">
      <img :src="item.image || item.media" :alt="item.name">
      <div v-if="item.badge || item.tag" class="service-featured__badge">
        {{ item.badge || item.tag }}
      </div>
      <div v-if="item.discount" class="service-featured__discount">-{{ item.discount }}%</div>
    </div>

    <div class="service-featured__content">
      <div class="service-featured__eyebrow" v-if="item.eyebrow">
        {{ item.eyebrow }}
      </div>

      <h3 class="service-featured__name">{{ item.name }}</h3>

      <p v-if="showDescription && item.description" class="service-featured__description">
        {{ item.description }}
      </p>

      <div class="service-featured__meta" v-if="item.meta?.length">
        <span v-for="(m, idx) in item.meta" :key="idx" class="service-featured__meta-item">
          <i v-if="m.icon" :class="m.icon"></i>
          {{ m.label }}
        </span>
      </div>

      <div class="service-featured__footer">
        <div v-if="showPrice" class="service-featured__price-block">
          <span v-if="item.price_from" class="service-featured__price-label">Desde</span>
          <span class="service-featured__price">{{ formatPrice(item.price || item.price_from) }}</span>
          <span v-if="item.original_price" class="service-featured__original">
            {{ formatPrice(item.original_price) }}
          </span>
        </div>

        <div class="service-featured__actions" v-if="item.actions?.length">
          <button
            v-for="action in item.actions"
            :key="action.id"
            class="service-featured__action"
            :class="[`service-featured__action--${action.variant || 'primary'}`]"
            type="button"
            @click.stop="$emit('action', { item, action })"
          >
            <i v-if="action.icon" :class="action.icon"></i>
            <span v-if="!action.iconOnly">{{ action.label }}</span>
          </button>
        </div>
      </div>
    </div>

    <div v-if="variant === 'split'" class="service-featured__aside">
      <slot name="aside" />
    </div>
  </article>
</template>

<script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'horizontal', 'split', 'overlay', 'minimal'].includes(v),
  },
  selected: Boolean,
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
})

defineEmits(['select', 'action'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.service-featured {
  position: relative;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  transition: all 0.25s ease;
  height: 100%;

  &:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px oklch(0 0 0 / 0.1);
  }

  &--selected {
    border-color: var(--bulma-link);
    box-shadow: 0 0 0 2px color-mix(in oklch, var(--bulma-link) 30%, transparent);
  }

  &--horizontal {
    display: flex;
    flex-direction: row;

    .service-featured__media {
      width: 45%;
      aspect-ratio: auto;
    }

    .service-featured__content {
      flex: 1;
      padding: 1.5rem;
    }
  }

  &--split {
    display: grid;
    grid-template-columns: 1fr 1fr;

    .service-featured__media {
      aspect-ratio: auto;
      height: 100%;
    }
  }

  &--overlay {
    position: relative;

    .service-featured__media {
      position: absolute;
      inset: 0;
    }

    .service-featured__content {
      position: relative;
      margin-top: auto;
      background: linear-gradient(to top, oklch(0 0 0 / 0.85) 0%, oklch(0 0 0 / 0.4) 60%, transparent 100%);
      color: white;
      padding-top: 3rem;
    }

    .service-featured__name,
    .service-featured__price {
      color: white;
    }
  }

  &--minimal {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 1rem;
    gap: 1rem;

    .service-featured__media {
      width: 80px;
      height: 80px;
      border-radius: var(--bulma-radius);
    }

    .service-featured__content {
      padding: 0;
    }

    .service-featured__description {
      -webkit-line-clamp: 1;
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
  }

  &:hover &__media img {
    transform: scale(1.05);
  }

  &__badge {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    padding: 0.25rem 0.625rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: var(--bulma-radius-small);
  }

  &__discount {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    padding: 0.25rem 0.625rem;
    background: var(--bulma-danger);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: var(--bulma-radius-small);
  }

  &__content {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__eyebrow {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--bulma-link);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  &__name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 0.25rem;
  }

  &__meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);

    i {
      color: var(--bulma-link);
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid var(--bulma-border);
    flex-wrap: wrap;
  }

  &__price-block {
    display: flex;
    align-items: baseline;
    gap: 0.375rem;
    flex-wrap: wrap;
  }

  &__price-label {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
  }

  &__price {
    font-size: 1.375rem;
    font-weight: 800;
    color: var(--bulma-success);
  }

  &__original {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
  }

  &__action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: transparent;
    color: var(--bulma-text);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
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
      }
    }

    &--success {
      background: var(--bulma-success);
      border-color: var(--bulma-success);
      color: white;

      &:hover {
        filter: brightness(1.1);
      }
    }

    &--outline {
      background: transparent;
      border-color: var(--bulma-link);
      color: var(--bulma-link);

      &:hover {
        background: var(--bulma-link);
        color: var(--bulma-link-invert);
      }
    }

    i {
      font-size: 0.875rem;
    }
  }

  &__aside {
    padding: 1.25rem;
    background: var(--bulma-scheme-main-bis);
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
}
</style>
