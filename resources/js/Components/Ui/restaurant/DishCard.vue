<template>
  <article
    class="dish-card"
    :class="{ 'dish-card--featured': featured }"
    role="button"
    tabindex="0"
    @click="$emit('select', dish)"
    @keydown.enter="$emit('select', dish)"
    @keydown.space.prevent="$emit('select', dish)"
  >
    <div v-if="showImage" class="dish-card__media">
      <img v-if="dish.image" :src="dish.image" :alt="dish.name" loading="lazy">
      <div v-else class="dish-card__placeholder">
        <i class="bi bi-utensils"></i>
      </div>
      <div v-if="featured" class="dish-card__featured-badge">
        <i class="bi bi-star-fill"></i>Destacado
      </div>
      <div v-if="dish.discount" class="dish-card__discount">
        -{{ dish.discount }}%
      </div>
    </div>

    <div class="dish-card__content">
      <div class="dish-card__header">
        <h4 class="dish-card__name">{{ dish.name }}</h4>
        <span v-if="dish.wait_time" class="dish-card__wait-time">
          <i class="bi bi-clock"></i>
          {{ dish.wait_time }} min
        </span>
      </div>

      <p v-if="showDescription && dish.description" class="dish-card__description">
        {{ truncateText(dish.description, 80) }}
      </p>

      <div v-if="dish.tags?.length" class="dish-card__tags">
        <span
          v-for="tag in dish.tags.slice(0, maxTags)"
          :key="tag"
          class="dish-card__tag"
          :class="`dish-card__tag--${getTagType(tag)}`"
        >
          {{ formatTag(tag) }}
        </span>
        <span v-if="dish.tags.length > maxTags" class="dish-card__tag dish-card__tag--more">
          +{{ dish.tags.length - maxTags }}
        </span>
      </div>

      <div class="dish-card__footer">
        <div class="dish-card__price-group">
          <span v-if="showPrice && dish.price" class="dish-card__price">
            {{ formatPrice(dish.price) }}
          </span>
          <span v-if="showPrice && dish.original_price" class="dish-card__original-price">
            {{ formatPrice(dish.original_price) }}
          </span>
        </div>
        <button
          v-if="showAddButton"
          class="dish-card__add"
          type="button"
          @click.stop="$emit('add', dish)"
        >
          <i class="bi bi-plus"></i>
        </button>
      </div>
    </div>
  </article>
</template>

<script setup>
const props = defineProps({
  dish: {
    type: Object,
    required: true,
    default: () => ({
      name: '',
      price: 0,
      original_price: null,
      image: '',
      description: '',
      tags: [],
      wait_time: null,
      discount: null,
    }),
  },
  featured: {
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
  maxTags: {
    type: Number,
    default: 3,
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

const getTagType = (tag) => {
  const tagLower = tag.toLowerCase()
  if (['vegetariano', 'veggie', 'vegetarian'].includes(tagLower)) return 'veggie'
  if (['vegano', 'vegan'].includes(tagLower)) return 'vegan'
  if (['sin gluten', 'gluten free'].includes(tagLower)) return 'gluten-free'
  if (['picante', 'spicy'].includes(tagLower)) return 'spicy'
  if (['nuevo', 'new'].includes(tagLower)) return 'new'
  if (['popular', 'bestseller'].includes(tagLower)) return 'popular'
  return 'default'
}

const formatTag = (tag) => {
  const tagMap = {
    vegetariano: '🥬 Veg',
    veggie: '🥬 Veg',
    vegetarian: '🥬 Veg',
    vegano: '🌱 Vega',
    vegan: '🌱 Vega',
    'sin gluten': '🌾 S/Gluten',
    'gluten free': '🌾 S/Gluten',
    picante: '🌶️ Picante',
    spicy: '🌶️ Spicy',
    nuevo: '✨ Nuevo',
    new: '✨ New',
    popular: '⭐ Popular',
    bestseller: '⭐ Bestseller',
  }
  return tagMap[tag.toLowerCase()] || tag
}
</script>

<style lang="scss" scoped>
.dish-card {
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
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.12);

    .dish-card__media img {
      transform: scale(1.05);
    }
  }

  &:active {
    transform: scale(0.98);
  }

  &--featured {
    border-color: var(--bulma-warning);
    box-shadow: 0 0 0 1px var(--bulma-warning);
  }

  &__media {
    position: relative;
    aspect-ratio: 16 / 10;
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
      font-size: 3rem;
    }
  }

  &__featured-badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    background: var(--bulma-warning);
    color: var(--bulma-warning-invert);
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
    color: var(--bulma-danger-invert);
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: var(--bulma-radius-small);
  }

  &__content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
  }

  &__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.5rem;
  }

  &__name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__wait-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    white-space: nowrap;
    flex-shrink: 0;

    i {
      font-size: 0.875rem;
    }
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
  }

  &__tag {
    display: inline-flex;
    align-items: center;
    font-size: 0.625rem;
    padding: 0.125rem 0.375rem;
    border-radius: var(--bulma-radius-small);
    font-weight: 500;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);

    &--veggie {
      background: oklch(60% 0.15 140);
      color: oklch(20% 0.15 140);
    }

    &--vegan {
      background: oklch(65% 0.15 130);
      color: oklch(20% 0.15 130);
    }

    &--gluten-free {
      background: oklch(65% 0.1 80);
      color: oklch(25% 0.1 80);
    }

    &--spicy {
      background: oklch(65% 0.18 25);
      color: oklch(20% 0.18 25);
    }

    &--new {
      background: oklch(65% 0.15 250);
      color: oklch(20% 0.15 250);
    }

    &--popular {
      background: oklch(65% 0.15 45);
      color: oklch(20% 0.15 45);
    }

    &--more {
      background: var(--bulma-scheme-main-ter);
      color: var(--bulma-text-weak);
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.5rem;
  }

  &__price-group {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
  }

  &__price {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--bulma-success);
  }

  &__original-price {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    text-decoration: line-through;
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
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link-hover);
      transform: scale(1.1);
    }

    &:active {
      transform: scale(0.9);
    }
  }
}
</style>
