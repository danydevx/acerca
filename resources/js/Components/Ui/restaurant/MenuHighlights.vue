<template>
  <div class="menu-highlights" :class="{ 'menu-highlights--inline': inline }">
    <div
      v-for="item in items"
      :key="item.id"
      class="menu-highlight"
      :class="{ 'menu-highlight--clickable': !!item.action }"
      @click="item.action && item.action()"
    >
      <div v-if="item.media" class="menu-highlight__media">
        <img :src="item.media" :alt="item.title">
      </div>
      <div class="menu-highlight__content">
        <span class="menu-highlight__badge">{{ item.badge || 'Especial' }}</span>
        <h4 class="menu-highlight__title">{{ item.title }}</h4>
        <p v-if="item.description" class="menu-highlight__description">{{ item.description }}</p>
        <div class="menu-highlight__footer">
          <span v-if="item.price" class="menu-highlight__price">{{ formatPrice(item.price) }}</span>
          <button v-if="item.actionLabel" class="menu-highlight__action">
            {{ item.actionLabel }}
            <i class="bi bi-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    default: () => [],
  },
  inline: {
    type: Boolean,
    default: false,
  },
})

const formatPrice = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.menu-highlights {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1rem;

  &--inline {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;

    .menu-highlight {
      flex: 0 0 280px;
    }
  }
}

.menu-highlight {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  transition: all 0.2s;

  &--clickable {
    cursor: pointer;

    &:hover {
      border-color: var(--bulma-link);
      box-shadow: 0 4px 12px oklch(0 0 0 / 0.08);
      transform: translateY(-2px);
    }
  }

  &__media {
    aspect-ratio: 16 / 9;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__content {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    flex: 1;
  }

  &__badge {
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.125rem 0.5rem;
    background: var(--bulma-warning);
    color: var(--bulma-warning-invert);
    border-radius: var(--bulma-radius-small);
    width: fit-content;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
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
    padding-top: 0.5rem;
  }

  &__price {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--bulma-success);
  }

  &__action {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.75rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link-hover);
    }

    i {
      font-size: 0.75rem;
    }
  }
}
</style>
