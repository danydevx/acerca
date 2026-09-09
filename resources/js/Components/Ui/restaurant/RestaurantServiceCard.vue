<template>
  <article class="restaurant-card" :class="{ 'restaurant-card--featured': featured }">
    <div class="restaurant-card__media">
      <img :src="item.image || item.media" :alt="item.name">
      <div class="restaurant-card__overlay">
        <span v-if="item.badge" class="restaurant-card__badge">{{ item.badge }}</span>
        <span v-if="item.discount" class="restaurant-card__discount">-{{ item.discount }}%</span>
      </div>
      <div class="restaurant-card__time" v-if="item.wait_time">
        <i class="bi bi-clock"></i>
        {{ item.wait_time }} min
      </div>
    </div>

    <div class="restaurant-card__content">
      <h4 class="restaurant-card__name">{{ item.name }}</h4>

      <p v-if="item.description" class="restaurant-card__description">
        {{ item.description }}
      </p>

      <div class="restaurant-card__tags" v-if="item.tags?.length">
        <span v-for="tag in item.tags.slice(0, 3)" :key="tag" class="restaurant-card__tag">
          {{ tag }}
        </span>
      </div>

      <div class="restaurant-card__footer">
        <div class="restaurant-card__price">
          <span class="restaurant-card__price-value">{{ formatPrice(item.price) }}</span>
          <span v-if="item.original_price" class="restaurant-card__price-original">
            {{ formatPrice(item.original_price) }}
          </span>
        </div>

        <div class="restaurant-card__actions">
          <slot name="actions">
            <button
              v-if="showAddButton"
              class="restaurant-card__add-btn"
              type="button"
              @click.stop="$emit('add', item)"
            >
              <i class="bi bi-plus"></i>
            </button>
          </slot>
        </div>
      </div>
    </div>
  </article>
</template>

<script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  featured: {
    type: Boolean,
    default: false,
  },
  showAddButton: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['add', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.restaurant-card {
  --rest-card-primary: #e85d04;
  --rest-card-accent: #f48c06;
  --rest-card-bg: #fffbf5;
  --rest-card-text: #2d2d2d;
  --rest-card-muted: #6b6b6b;

  display: flex;
  flex-direction: column;
  background: var(--rest-card-bg);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px oklch(0 0 0 / 0.06);
  transition: all 0.25s ease;
  height: 100%;

  &:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.12);

    .restaurant-card__media img {
      transform: scale(1.06);
    }

    .restaurant-card__add-btn {
      background: var(--rest-card-primary);
      color: white;
    }
  }

  &--featured {
    border: 2px solid var(--rest-card-primary);

    .restaurant-card__badge {
      background: var(--rest-card-primary);
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 3 / 2;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f4f0 0%, #efe8e0 100%);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
  }

  &__overlay {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    display: flex;
    gap: 0.375rem;
  }

  &__badge {
    padding: 0.25rem 0.625rem;
    background: var(--rest-card-accent);
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 4px;
  }

  &__discount {
    padding: 0.25rem 0.625rem;
    background: #dc2626;
    color: white;
    font-size: 0.6875rem;
    font-weight: 700;
    border-radius: 4px;
  }

  &__time {
    position: absolute;
    bottom: 0.75rem;
    right: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    background: white;
    color: var(--rest-card-text);
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: 4px;
    box-shadow: 0 2px 4px oklch(0 0 0 / 0.1);

    i {
      color: var(--rest-card-primary);
    }
  }

  &__content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
  }

  &__name {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--rest-card-text);
    margin: 0;
    line-height: 1.3;
    font-family: 'Playfair Display', serif;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--rest-card-muted);
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
    gap: 0.375rem;
    margin-top: 0.25rem;
  }

  &__tag {
    padding: 0.125rem 0.5rem;
    background: oklch(var(--rest-card-primary) 15%);
    color: var(--rest-card-primary);
    font-size: 0.6875rem;
    font-weight: 500;
    border-radius: 3px;
    text-transform: capitalize;
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.75rem;
    border-top: 1px solid oklch(var(--rest-card-primary) 10%);
  }

  &__price {
    display: flex;
    align-items: baseline;
    gap: 0.375rem;
  }

  &__price-value {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--rest-card-primary);
  }

  &__price-original {
    font-size: 0.875rem;
    color: var(--rest-card-muted);
    text-decoration: line-through;
  }

  &__actions {
    display: flex;
    gap: 0.375rem;
  }

  &__add-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 50%;
    background: oklch(var(--rest-card-primary) 10%);
    color: var(--rest-card-primary);
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      transform: scale(1.1);
    }
  }
}
</style>
