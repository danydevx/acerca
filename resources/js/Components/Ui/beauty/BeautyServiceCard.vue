<template>
  <article class="beauty-card" :class="{ 'beauty-card--featured': featured }">
    <div class="beauty-card__media" v-if="item.image || item.media">
      <img :src="item.image || item.media" :alt="item.name">
      <div class="beauty-card__gradient"></div>
    </div>

    <div class="beauty-card__content">
      <div class="beauty-card__category" v-if="item.category">
        {{ item.category }}
      </div>

      <h4 class="beauty-card__name">{{ item.name }}</h4>

      <p v-if="item.description" class="beauty-card__description">
        {{ item.description }}
      </p>

      <div class="beauty-card__details" v-if="item.duration || item.technician">
        <span v-if="item.duration" class="beauty-card__detail">
          <i class="bi bi-clock"></i>
          {{ item.duration }}
        </span>
        <span v-if="item.technician" class="beauty-card__detail">
          <i class="bi bi-person"></i>
          {{ item.technician }}
        </span>
      </div>

      <div class="beauty-card__footer">
        <div class="beauty-card__price">
          <span class="beauty-card__price-value">{{ formatPrice(item.price) }}</span>
        </div>

        <button
          class="beauty-card__book-btn"
          type="button"
          @click.stop="$emit('book', item)"
        >
          Agendar
        </button>
      </div>
    </div>

    <div class="beauty-card__decoration">
      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4"/>
      </svg>
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
})

defineEmits(['book', 'select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.beauty-card {
  --beauty-primary: #d4a5a5;
  --beauty-accent: #c48b9f;
  --beauty-gold: #c9a227;
  --beauty-bg: #fff9f9;
  --beauty-text: #3d3d3d;
  --beauty-muted: #8a8a8a;

  position: relative;
  background: var(--beauty-bg);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 16px oklch(0 0 0 / 0.06);
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;

  &:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 12px 32px oklch(0 0 0 / 0.12);

    .beauty-card__media img {
      transform: scale(1.08);
    }

    .beauty-card__book-btn {
      background: linear-gradient(135deg, var(--beauty-accent) 0%, var(--beauty-primary) 100%);
      color: white;
      border-color: transparent;
    }
  }

  &--featured {
    .beauty-card__name {
      color: var(--beauty-accent);
    }

    &::before {
      content: '★ Popular';
      position: absolute;
      top: 1rem;
      right: 1rem;
      padding: 0.25rem 0.75rem;
      background: linear-gradient(135deg, var(--beauty-gold) 0%, #e6c547 100%);
      color: white;
      font-size: 0.625rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-radius: 20px;
      z-index: 2;
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
  }

  &__gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to top, var(--beauty-bg) 0%, transparent 100%);
  }

  &__content {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__category {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--beauty-accent);
    text-transform: uppercase;
    letter-spacing: 1.5px;
  }

  &__name {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--beauty-text);
    margin: 0;
    line-height: 1.3;
    font-family: 'Cormorant Garamond', serif;
  }

  &__description {
    font-size: 0.8125rem;
    color: var(--beauty-muted);
    margin: 0;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  &__details {
    display: flex;
    gap: 1rem;
    margin-top: 0.25rem;
  }

  &__detail {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--beauty-muted);

    i {
      color: var(--beauty-accent);
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid oklch(var(--beauty-accent) 15%);
  }

  &__price {
    display: flex;
    flex-direction: column;
  }

  &__price-value {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--beauty-accent);
  }

  &__book-btn {
    padding: 0.625rem 1.25rem;
    border: 1.5px solid var(--beauty-accent);
    border-radius: 25px;
    background: transparent;
    color: var(--beauty-accent);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
  }

  &__decoration {
    position: absolute;
    top: -30px;
    right: -30px;
    width: 120px;
    height: 120px;
    color: oklch(var(--beauty-primary) 20%);
    pointer-events: none;
    opacity: 0.5;
  }
}
</style>
