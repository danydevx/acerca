<template>
  <article
    class="property-card"
    :class="{ 'property-card--horizontal': horizontal }"
    tabindex="0"
    role="button"
    @click="$emit('click', property)"
    @keydown.enter="$emit('click', property)"
  >
    <div v-if="image" class="property-card__media">
      <img :src="image" :alt="title" loading="lazy">
      <div v-if="badge" class="property-card__badge">{{ badge }}</div>
      <button
        type="button"
        class="property-card__favorite"
        :aria-label="isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos'"
        @click.stop="$emit('favorite', property)"
      >
        <i :class="isFavorite ? 'bi bi-heart-fill' : 'bi bi-heart'"></i>
      </button>
    </div>

    <div class="property-card__content">
      <div class="property-card__header">
        <PropertyPrice
          v-if="price"
          :price="price"
          :price-type="priceType"
          class="property-card__price"
        />
        <PropertyStatus
          v-if="status"
          :status="status"
          class="property-card__status"
        />
      </div>

      <h3 class="property-card__title">{{ title }}</h3>

      <p v-if="address" class="property-card__address">
        <i class="bi bi-geo-alt"></i>
        {{ address }}
      </p>

      <PropertyFeatures
        v-if="beds || baths || area"
        :beds="beds"
        :baths="baths"
        :area="area"
        :area-unit="areaUnit"
        class="property-card__features"
      />

      <div v-if="showFooter" class="property-card__footer">
        <span v-if="agent" class="property-card__agent">
          <i class="bi bi-person"></i>
          {{ agent }}
        </span>
        <span v-if="date" class="property-card__date">{{ formattedDate }}</span>
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'
import PropertyPrice from './PropertyPrice.vue'
import PropertyStatus from './PropertyStatus.vue'
import PropertyFeatures from './PropertyFeatures.vue'

const props = defineProps({
  property: {
    type: Object,
    required: true,
  },
  image: {
    type: String,
    default: '',
  },
  title: {
    type: String,
    required: true,
  },
  address: {
    type: String,
    default: '',
  },
  price: {
    type: [String, Number],
    default: '',
  },
  priceType: {
    type: String,
    default: 'sale',
    validator: (v) => ['sale', 'rent', 'both'].includes(v),
  },
  status: {
    type: String,
    default: '',
  },
  badge: {
    type: String,
    default: '',
  },
  beds: {
    type: Number,
    default: null,
  },
  baths: {
    type: Number,
    default: null,
  },
  area: {
    type: Number,
    default: null,
  },
  areaUnit: {
    type: String,
    default: 'm²',
  },
  agent: {
    type: String,
    default: '',
  },
  date: {
    type: [Date, String],
    default: null,
  },
  isFavorite: {
    type: Boolean,
    default: false,
  },
  horizontal: {
    type: Boolean,
    default: false,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['click', 'favorite'])

const formattedDate = computed(() => {
  if (!props.date) return ''
  const d = props.date instanceof Date ? props.date : new Date(props.date)
  return d.toLocaleDateString('es-ES', { year: 'numeric', month: 'short', day: 'numeric' })
})
</script>

<style lang="scss" scoped>
.property-card {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s;

  &:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px oklch(0 0 0 / 0.1);
  }

  &--horizontal {
    flex-direction: row;

    .property-card__media {
      width: 200px;
      aspect-ratio: auto;
      flex-shrink: 0;
    }

    .property-card__content {
      flex: 1;
      padding: 1rem;
    }

    @media (max-width: 600px) {
      flex-direction: column;

      .property-card__media {
        width: 100%;
        aspect-ratio: 16 / 9;
      }
    }
  }

  &__media {
    position: relative;
    aspect-ratio: 16 / 10;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;
    }

    &:hover img {
      transform: scale(1.03);
    }
  }

  &__badge {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    padding: 0.25rem 0.625rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: var(--bulma-radius-small);
  }

  &__favorite {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.15s, color 0.15s;

    i {
      font-size: 1rem;
      color: var(--bulma-text-weak);
      transition: color 0.15s;
    }

    &:hover {
      background: var(--bulma-scheme-main-ter);
    }
  }

  &__favorite:hover i,
  &__favorite i.bi-heart-fill {
    color: var(--bulma-danger);
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1rem;
    flex: 1;
  }

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.3;
  }

  &__address {
    display: flex;
    align-items: flex-start;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;

    i {
      margin-top: 0.125rem;
      flex-shrink: 0;
    }
  }

  &__features {
    margin-top: 0.25rem;
  }

  &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.75rem;
    margin-top: auto;
    border-top: 1px solid var(--bulma-border);
  }

  &__agent {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);

    i {
      font-size: 0.875rem;
    }
  }

  &__date {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }
}
</style>
