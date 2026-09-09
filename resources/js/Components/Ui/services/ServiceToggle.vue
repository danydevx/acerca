<template>
  <div class="service-toggle" :class="[`service-toggle--${variant}`]">
    <div class="service-toggle__header" v-if="title">
      <h4 class="service-toggle__title">{{ title }}</h4>
      <p v-if="description" class="service-toggle__description">{{ description }}</p>
    </div>

    <div class="service-toggle__items">
      <div
        v-for="item in items"
        :key="item.id"
        class="service-toggle__item"
        :class="{
          'is-selected': isSelected(item),
          'is-disabled': item.disabled,
        }"
        role="button"
        tabindex="0"
        @click="toggle(item)"
        @keydown.enter="toggle(item)"
        @keydown.space.prevent="toggle(item)"
      >
        <div class="service-toggle__item-media" v-if="showMedia && (item.image || item.media)">
          <img :src="item.image || item.media" :alt="item.name">
        </div>

        <div class="service-toggle__item-content">
          <div class="service-toggle__item-header">
            <span class="service-toggle__item-name">{{ item.name }}</span>
            <span v-if="item.duration" class="service-toggle__item-duration">{{ item.duration }}</span>
          </div>

          <p v-if="showDescription && item.description" class="service-toggle__item-description">
            {{ item.description }}
          </p>

          <div class="service-toggle__item-footer">
            <span class="service-toggle__item-price">{{ formatPrice(item.price) }}</span>
            <span v-if="item.price_from" class="service-toggle__item-price-label">desde</span>
          </div>
        </div>

        <div class="service-toggle__check">
          <i :class="isSelected(item) ? 'bi bi-check-circle-fill' : 'bi bi-circle'"></i>
        </div>
      </div>
    </div>

    <div class="service-toggle__footer" v-if="selectedItems.length">
      <div class="service-toggle__total">
        <span class="service-toggle__total-label">Total:</span>
        <span class="service-toggle__total-value">{{ formatPrice(total) }}</span>
      </div>

      <button
        class="service-toggle__action"
        :class="[`service-toggle__action--${actionVariant}`]"
        type="button"
        @click="$emit('submit', selectedItems)"
      >
        <i v-if="actionIcon" :class="actionIcon"></i>
        {{ actionLabel }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  title: String,
  description: String,
  items: {
    type: Array,
    default: () => [],
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'list', 'cards', 'compact'].includes(v),
  },
  showMedia: {
    type: Boolean,
    default: true,
  },
  showDescription: {
    type: Boolean,
    default: true,
  },
  multiple: {
    type: Boolean,
    default: false,
  },
  actionLabel: {
    type: String,
    default: 'Continuar',
  },
  actionIcon: {
    type: String,
    default: 'bi bi-arrow-right',
  },
  actionVariant: {
    type: String,
    default: 'primary',
  },
})

const emit = defineEmits(['select', 'change', 'submit'])

const selected = ref([])

const selectedItems = computed(() => {
  return props.items.filter(item => selected.value.includes(item.id))
})

const total = computed(() => {
  return selectedItems.value.reduce((sum, item) => sum + (item.price || 0), 0)
})

const isSelected = (item) => {
  return selected.value.includes(item.id)
}

const toggle = (item) => {
  if (item.disabled) return

  if (props.multiple) {
    const idx = selected.value.indexOf(item.id)
    if (idx > -1) {
      selected.value.splice(idx, 1)
    } else {
      selected.value.push(item.id)
    }
  } else {
    selected.value = [item.id]
  }

  emit('change', selectedItems.value)
  emit('select', item)
}

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.service-toggle {
  &__header {
    margin-bottom: 1.25rem;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__items {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  &__item {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.875rem;
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    cursor: pointer;
    transition: all 0.2s;

    &:hover:not(.is-disabled) {
      border-color: var(--bulma-link);
      background: var(--bulma-scheme-main-bis);
    }

    &.is-selected {
      border-color: var(--bulma-link);
      background: color-mix(in oklch, var(--bulma-link) 5%, var(--bulma-scheme-main));

      .service-toggle__check {
        color: var(--bulma-link);
      }
    }

    &.is-disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  }

  &__item-media {
    width: 64px;
    height: 64px;
    flex-shrink: 0;
    border-radius: var(--bulma-radius);
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__item-content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__item-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  &__item-name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__item-duration {
    font-size: 0.6875rem;
    font-weight: 500;
    color: var(--bulma-text-weak);
    padding: 0.125rem 0.375rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius-small);
  }

  &__item-description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__item-footer {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
  }

  &__item-price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-success);
  }

  &__item-price-label {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
  }

  &__check {
    font-size: 1.5rem;
    color: var(--bulma-border);
    transition: color 0.15s;
    flex-shrink: 0;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--bulma-border);
  }

  &__total {
    display: flex;
    align-items: baseline;
    gap: 0.375rem;
  }

  &__total-label {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }

  &__total-value {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--bulma-success);
  }

  &__action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;

    &--primary {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);

      &:hover {
        background: var(--bulma-link-hover);
      }
    }

    &--success {
      background: var(--bulma-success);
      color: white;

      &:hover {
        filter: brightness(1.1);
      }
    }

    i {
      font-size: 1rem;
    }
  }

  &--list {
    .service-toggle__item {
      padding: 0.75rem;
      gap: 0.75rem;
    }

    .service-toggle__item-media {
      width: 48px;
      height: 48px;
    }
  }

  &--cards {
    .service-toggle__items {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1rem;
    }

    .service-toggle__item {
      flex-direction: column;
      text-align: center;
      padding: 1rem;
    }

    .service-toggle__item-media {
      width: 100%;
      height: 120px;
    }

    .service-toggle__check {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
    }
  }

  &--compact {
    .service-toggle__item {
      padding: 0.5rem;
      gap: 0.5rem;
    }

    .service-toggle__item-media {
      width: 40px;
      height: 40px;
    }

    .service-toggle__item-description {
      display: none;
    }
  }
}
</style>
