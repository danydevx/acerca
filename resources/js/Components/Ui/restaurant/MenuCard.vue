<template>
  <article
    class="menu-card"
    role="button"
    tabindex="0"
    @click="$emit('select', item)"
    @keydown.enter="$emit('select', item)"
    @keydown.space.prevent="$emit('select', item)"
  >
    <div v-if="showImage" class="menu-card__media">
      <img v-if="item.image" :src="item.image" :alt="item.name" loading="lazy">
      <div v-else class="menu-card__placeholder">
        <i class="bi bi-basket"></i>
      </div>
      <div v-if="item.badge" class="menu-card__badge">{{ item.badge }}</div>
    </div>

    <div class="menu-card__content">
      <h4 class="menu-card__title">{{ item.name }}</h4>
      <p v-if="showDescription && item.description" class="menu-card__description">
        {{ truncateText(item.description, 60) }}
      </p>
      <div class="menu-card__footer">
        <span v-if="showPrice && item.price" class="menu-card__price">
          {{ formatPrice(item.price) }}
        </span>
        <span v-if="item.has_variants" class="menu-card__badge-inline">
          <i class="bi bi-list-ul"></i>Variantes
        </span>
      </div>
    </div>
  </article>
</template>

<script setup>
defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({ name: '', price: 0, image: '', description: '', has_variants: false, badge: '' }),
  },
  showImage: {
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

defineEmits(['select'])

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
</script>

<style lang="scss" scoped>
.menu-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  height: 100%;

  &:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);

    .menu-card__media img {
      transform: scale(1.05);
    }
  }

  &:active {
    transform: scale(0.98);
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

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 2.5rem;
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

  &__content {
    padding: 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
  }

  &__title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.25rem;
  }

  &__price {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-success);
  }

  &__badge-inline {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.6875rem;
    padding: 0.125rem 0.375rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius-small);
    color: var(--bulma-text-weak);
  }
}
</style>
