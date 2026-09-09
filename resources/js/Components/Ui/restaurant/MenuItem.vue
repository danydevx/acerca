<template>
  <article
    class="menu-item"
    :class="{ 'menu-item--horizontal': horizontal }"
    role="button"
    tabindex="0"
    @click="$emit('select', item)"
    @keydown.enter="$emit('select', item)"
    @keydown.space.prevent="$emit('select', item)"
  >
    <div v-if="showImage && item.image" class="menu-item__image">
      <img :src="item.image" :alt="item.name" loading="lazy">
    </div>
    <div v-else-if="showImage" class="menu-item__placeholder">
      <i class="bi bi-basket"></i>
    </div>

    <div class="menu-item__content">
      <h4 class="menu-item__name">{{ item.name }}</h4>
      <p v-if="showDescription && item.description" class="menu-item__description">
        {{ truncateText(item.description, descriptionLength) }}
      </p>
      <div v-if="showPrice && item.price" class="menu-item__price">
        {{ formatPrice(item.price) }}
      </div>
      <div v-if="item.has_variants" class="menu-item__badges">
        <span class="menu-item__badge">
          <i class="bi bi-list-ul"></i>Con variantes
        </span>
      </div>
    </div>

    <button v-if="showAddButton" class="menu-item__add" type="button" @click.stop="$emit('add', item)">
      <i class="bi bi-plus-lg"></i>
    </button>
  </article>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  item: {
    type: Object,
    required: true,
    default: () => ({ name: '', price: 0, image: '', description: '', has_variants: false }),
  },
  horizontal: {
    type: Boolean,
    default: false,
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
  showAddButton: {
    type: Boolean,
    default: true,
  },
  descriptionLength: {
    type: Number,
    default: 80,
  },
})

defineEmits(['select', 'add'])

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
.menu-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 1rem;
  background: var(--bulma-scheme-main-bis);
  border-radius: var(--bulma-radius-large);
  cursor: pointer;
  transition: background-color 0.2s;

  &:hover {
    background: var(--bulma-scheme-main-ter);
  }

  &--horizontal {
    flex-direction: row;
    text-align: left;
    gap: 0.75rem;
    padding: 0.75rem;
  }

  &__image {
    width: 64px;
    height: 64px;
    border-radius: var(--bulma-radius);
    overflow: hidden;
    flex-shrink: 0;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 64px;
    height: 64px;
    border-radius: var(--bulma-radius);
    background: var(--bulma-border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);
    flex-shrink: 0;

    i {
      font-size: 1.5rem;
    }
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__name {
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
    margin: 0.25rem 0 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__price {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-success);
    margin-top: 0.25rem;
  }

  &__badges {
    margin-top: 0.25rem;
  }

  &__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.6875rem;
    padding: 0.125rem 0.375rem;
    background: var(--bulma-scheme-main-ter);
    border-radius: var(--bulma-radius-small);
    color: var(--bulma-text-weak);
  }

  &__add {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: background-color 0.2s, transform 0.15s;

    &:hover {
      background: var(--bulma-link-hover);
      transform: scale(1.05);
    }

    &:active {
      transform: scale(0.95);
    }
  }
}
</style>
