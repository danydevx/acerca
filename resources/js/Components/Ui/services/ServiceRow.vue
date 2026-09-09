<template>
  <div
    class="service-row"
    :class="[`service-row--${variant}`, { 'service-row--clickable': clickable }]"
    role="button"
    tabindex="0"
    @click="handleClick"
    @keydown.enter="handleClick"
    @keydown.space.prevent="handleClick"
  >
    <div v-if="showMedia && (item.image || item.media)" class="service-row__media">
      <img :src="item.image || item.media" :alt="item.name">
    </div>

    <div class="service-row__content">
      <div class="service-row__main">
        <h4 class="service-row__name">{{ item.name }}</h4>
        <p v-if="showDescription && item.description" class="service-row__description">
          {{ item.description }}
        </p>
      </div>

      <div v-if="item.meta?.length" class="service-row__meta">
        <span v-for="(m, idx) in item.meta" :key="idx" class="service-row__meta-item">
          <i v-if="m.icon" :class="m.icon"></i>
          {{ m.label }}
        </span>
      </div>
    </div>

    <div class="service-row__aside">
      <div v-if="showPrice" class="service-row__price-group">
        <span v-if="item.price_from" class="service-row__price-label">Desde</span>
        <span class="service-row__price">{{ formatPrice(item.price || item.price_from) }}</span>
      </div>

      <button
        v-if="item.actions?.length"
        v-for="action in item.actions.slice(0, 1)"
        :key="action.id"
        class="service-row__action"
        type="button"
        @click.stop="handleAction(action)"
      >
        <i v-if="action.icon" :class="action.icon"></i>
        <span v-if="!action.iconOnly">{{ action.label }}</span>
      </button>
    </div>
  </div>
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
    validator: (v) => ['default', 'minimal', 'rich', 'compact'].includes(v),
  },
  showMedia: {
    type: Boolean,
    default: true,
  },
  showDescription: {
    type: Boolean,
    default: false,
  },
  showPrice: {
    type: Boolean,
    default: true,
  },
  clickable: {
    type: Boolean,
    default: true,
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

const handleClick = () => {
  emit('select', props.item)
}

const handleAction = (action) => {
  emit('action', { item: props.item, action })
}
</script>

<style lang="scss" scoped>
.service-row {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  padding: 0.75rem;
  margin-bottom: 0.75rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  transition: all 0.15s;

  &--clickable {
    cursor: pointer;

    &:hover {
      border-color: var(--bulma-link);
      background: var(--bulma-scheme-main-bis);
    }
  }

  &--minimal {
    padding: 0.5rem;
    gap: 0.5rem;
    border: none;
    background: transparent;
  }

  &--compact {
    padding: 0.5rem;
    gap: 0.625rem;
  }

  &--rich {
    padding: 1rem;
    gap: 1rem;
  }

  &__media {
    width: 56px;
    height: 56px;
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

  &--minimal &__media {
    width: 40px;
    height: 40px;
  }

  &--rich &__media {
    width: 72px;
    height: 72px;
  }

  &__content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__main {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
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
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
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

  &__aside {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.5rem;
    flex-shrink: 0;
  }

  &__price-group {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
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
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }

    i {
      font-size: 0.875rem;
    }
  }
}
</style>
