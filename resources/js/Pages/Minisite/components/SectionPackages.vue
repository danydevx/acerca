<template>
  <section class="section-packages">
    <div class="section-packages__inner">
      <h2 v-if="title" class="section-packages__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-packages__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-packages__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay paquetes disponibles.
      </div>

      <div v-else class="section-packages__grid">
        <article
          v-for="item in displayedItems"
          :key="item.id"
          class="section-packages__card orp-card"
        >
          <div class="section-packages__card-image-wrapper">
            <img
              v-if="showImage && item.image"
              :src="item.image"
              :alt="item.title"
              class="section-packages__card-image"
              loading="lazy"
            />
            <div v-else class="section-packages__card-image-placeholder">
              <i class="bi bi-box-seam"></i>
            </div>
            <span v-if="item.promo_price" class="section-packages__discount-badge orp-badge orp-badge--danger">
              -{{ discountPercent(item) }}%
            </span>
          </div>
          <div class="section-packages__card-body">
            <h3 class="section-packages__card-title">{{ item.title }}</h3>
            <p v-if="item.short_description" class="section-packages__card-desc">
              {{ truncateText(item.short_description, 80) }}
            </p>
            <ul v-if="item.features && item.features.length" class="section-packages__features orp-list orp-list--divided orp-list--inset">
              <li v-for="(feature, index) in item.features.slice(0, 4)" :key="index" class="orp-list__item">
                <i class="bi bi-check-circle"></i> {{ feature }}
              </li>
            </ul>
            <div class="section-packages__card-footer">
              <div class="section-packages__card-prices">
                <span v-if="showPrice && item.promo_price" class="section-packages__card-price orp-price">
                  <span class="orp-price__value">{{ formatCurrency(item.promo_price) }}</span>
                </span>
                <span v-if="showPrice && item.promo_price" class="section-packages__card-price-compare">
                  {{ formatCurrency(item.price) }}
                </span>
                <span v-else-if="showPrice && item.price" class="section-packages__card-price orp-price">
                  <span class="orp-price__value">{{ formatCurrency(item.price) }}</span>
                </span>
              </div>
              <a
                v-if="item.whatsapp"
                :href="`https://wa.me/${item.whatsapp}?text=${encodeURIComponent(item.whatsapp_message || 'Hola, me interesa este paquete')}`"
                target="_blank"
                class="orp-btn btn-whatsapp orp-btn--sm"
              >
                <i class="bi bi-whatsapp"></i> Contactar
              </a>
            </div>
          </div>
        </article>
      </div>

      <div v-if="buttons && buttons.length" class="section-packages__buttons orp-mt-4">
        <a
          v-for="(btn, index) in buttons"
          :key="index"
          :href="btn.url"
          class="orp-btn orp-btn--primary orp-mr-2 orp-mb-2"
        >
          {{ btn.text }}
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  title: String,
  subtitle: String,
  items: {
    type: Array,
    default: () => [],
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
})

const showImage = computed(() => props.config?.show_image !== false)
const showPrice = computed(() => props.config?.show_price !== false)
const viewMode = computed(() => props.config?.view_mode || 'grid')
const maxItems = computed(() => props.config?.max_items || 12)
const displayedItems = computed(() => {
  const max = maxItems.value
  const items = props.items || []
  if (items.length <= max) {
    return items
  }
  return items.slice(0, max)
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}

const discountPercent = (item) => {
  if (!item.promo_price || !item.price) return 0
  return Math.round((1 - parseFloat(item.promo_price) / parseFloat(item.price)) * 100)
}

const truncateText = (text, length) => {
  if (!text || text.length <= length) return text
  return text.substring(0, length) + '...'
}
</script>

<script>
import { defineComponent } from 'vue'
import { computed } from 'vue'
export default defineComponent({ name: 'SectionPackages' })
</script>

<style lang="less">
.section-packages {
  padding: var(--orp-space-6) var(--orp-space-2);

  &__inner {
    max-width: 1024px;
    margin: 0 auto;
  }

  &__title {
    font-weight: 700;
    margin: 0 0 var(--orp-space-1);
    text-align: center;
    color: var(--orp-foreground);
  }

  &__subtitle {
    font-weight: 600;
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__description-text {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__buttons {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: var(--orp-space-2);
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--orp-space-3);

    @media (max-width: 768px) {
      grid-template-columns: repeat(2, 1fr);
    }

    @media (max-width: 480px) {
      grid-template-columns: 1fr;
    }
  }

  &__card {
    display: flex;
    flex-direction: column;

    &-image-wrapper {
      position: relative;
    }

    &-body {
      padding: var(--orp-space-3);
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    &-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: auto;
      padding-top: var(--orp-space-2);
    }

    &-prices {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }
  }

  &__card-image {
    width: 100%;
    height: 140px;
    object-fit: cover;
  }

  &__card-image-placeholder {
    width: 100%;
    height: 140px;
    background: var(--orp-surface-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orp-muted-foreground);
    font-size: 2.5rem;
  }

  &__discount-badge {
    position: absolute;
    top: var(--orp-space-2);
    right: var(--orp-space-2);
    font-size: var(--orp-font-size-xs);
    font-weight: 700;
  }

  &__card-title {
    font-size: var(--orp-font-size-md);
    font-weight: 600;
    margin: 0 0 var(--orp-space-2);
    color: var(--orp-surface-foreground);
  }

  &__card-desc {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-2);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
  }

  &__features {
    list-style: none;
    padding: 0;
    margin: 0 0 var(--orp-space-3);
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);

    li {
      display: flex;
      align-items: center;
      gap: var(--orp-space-2);
      margin-bottom: var(--orp-space-1);

      i {
        color: var(--orp-success);
      }
    }
  }

  &__card-price {
    font-size: var(--orp-font-size-lg);
    font-weight: 700;
    color: var(--orp-success);
    margin: 0;
  }

  &__card-price-compare {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    text-decoration: line-through;
    margin: 0;
  }
}
</style>
