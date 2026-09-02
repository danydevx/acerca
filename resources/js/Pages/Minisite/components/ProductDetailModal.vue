<template>
  <OrpModal
    v-model="isOpen"
    :title="product?.name"
    size="lg"
  >
    <div class="product-detail-modal">
      <div class="product-detail-modal__gallery">
        <div v-if="product?.image" class="product-detail-modal__main-image">
          <a :href="product.image" class="glightbox" data-gallery="product-gallery" :data-title="product.name">
            <img :src="product.image" :alt="product.name" />
          </a>
        </div>
        <div v-if="product?.gallery && product.gallery.length > 1" class="product-detail-modal__thumbs">
          <a
            v-for="img in product.gallery"
            :key="img.id"
            :href="img.path"
            class="product-detail-modal__thumb glightbox"
            data-gallery="product-gallery"
            :data-title="product.name"
          >
            <img :src="img.path" :alt="img.title || product.name" />
          </a>
        </div>
      </div>

      <div class="product-detail-modal__body">
        <div class="product-detail-modal__header">
          <span v-if="product?.category_name" class="product-detail-modal__category">{{ product.category_name }}</span>
          <h2 class="product-detail-modal__name">{{ product?.name }}</h2>
          <div class="product-detail-modal__pricing">
            <div v-if="product?.price" class="product-detail-modal__price orp-price">
              <span class="orp-price__value">{{ formatCurrency(product.price) }}</span>
            </div>
            <div v-if="product?.compare_at_price" class="product-detail-modal__price-compare">
              {{ formatCurrency(product.compare_at_price) }}
            </div>
            <div v-if="product?.compare_at_price" class="product-detail-modal__discount orp-badge orp-badge--danger">
              -{{ discountPercent(product) }}% OFF
            </div>
          </div>
        </div>

        <div class="product-detail-modal__meta orp-cluster orp-cluster--3">
          <div v-if="showStock && product?.quantity !== null" class="product-detail-modal__meta-item" :class="product.quantity > 0 ? 'product-detail-modal__meta-item--success' : ''">
            <i :class="product.quantity > 0 ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill'"></i>
            <span>{{ product.quantity > 0 ? `En stock (${product.quantity})` : 'Agotado' }}</span>
          </div>
          <div v-if="product?.location_name" class="product-detail-modal__meta-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span>{{ product.location_name }}</span>
          </div>
          <div v-if="product?.sku" class="product-detail-modal__meta-item">
            <i class="bi bi-upc"></i>
            <span>SKU: {{ product.sku }}</span>
          </div>
        </div>

        <p v-if="product?.description" class="product-detail-modal__description">
          {{ product.description }}
        </p>

        <div class="product-detail-modal__actions orp-stack orp-stack--3">
          <button
            v-if="orderSettings?.is_active && hasValidPrice"
            class="orp-btn orp-btn--primary orp-btn--lg product-detail-modal__btn-primary"
            @click="addToCart"
          >
            <i class="bi bi-cart-plus"></i>
            Agregar al carrito
          </button>
          <a
            v-if="product?.whatsapp_contact"
            :href="`https://wa.me/${product.whatsapp_contact}?text=Hola, me interesa el producto: ${product?.name}`"
            target="_blank"
            class="orp-btn orp-btn--secondary orp-btn--lg product-detail-modal__btn-whatsapp"
          >
            <i class="bi bi-whatsapp"></i>
            Contactar por WhatsApp
          </a>
          <a
            :href="`/m/${businessSlug}/productos/${product?.slug}`"
            class="product-detail-modal__tertiary"
          >
            Ver información completa
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </OrpModal>
</template>

<script setup>
import { computed, watch, nextTick, onBeforeUnmount } from 'vue'
import OrpModal from '@/Components/OrpUI/OrpModal.vue'
import GLightbox from 'glightbox'
import 'glightbox/dist/css/glightbox.min.css'
import { usePriceFormatter } from '@/Composables/usePriceFormatter'
import { useCart } from '@/composables/useCart'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  product: {
    type: Object,
    default: null,
  },
  businessSlug: {
    type: String,
    default: '',
  },
  orderSettings: {
    type: Object,
    default: null,
  },
  showStock: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['update:modelValue', 'close'])

const cart = useCart()

const isOpen = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})

const { formatPrice } = usePriceFormatter({
  locale: 'es-MX',
  currency: '$',
  decimals: 2,
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return formatPrice(value) || ''
}

const discountPercent = (item) => {
  if (!item.compare_at_price || !item.price) return 0
  return Math.round((1 - item.price / item.compare_at_price) * 100)
}

const hasValidPrice = computed(() => {
  if (!props.product) return false
  const price = parseFloat(props.product.price)
  return !isNaN(price) && price > 0
})

let lightboxInstance = null

const initLightbox = () => {
  nextTick(() => {
    if (lightboxInstance) {
      lightboxInstance.destroy()
    }
    lightboxInstance = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: false,
      selector: '.product-detail-modal__gallery .glightbox',
    })
  })
}

watch(isOpen, (val) => {
  if (val) {
    initLightbox()
  } else {
    if (lightboxInstance) {
      lightboxInstance.destroy()
      lightboxInstance = null
    }
  }
})

onBeforeUnmount(() => {
  if (lightboxInstance) {
    lightboxInstance.destroy()
    lightboxInstance = null
  }
})

const addToCart = () => {
  if (!props.product) return
  const product = props.product
  cart.addItem({
    id: product.id,
    business_id: product.business_id,
    title: product.name,
    image: product.image,
    base_price: product.price,
  }, {
    productType: 'product',
    quantity: 1,
  })
  isOpen.value = false
  emit('close')
  cart.openCart()
}
</script>

<style lang="less">
.product-detail-modal {
  display: flex;
  flex-direction: column;
  gap: 0;

  @media (min-width: 768px) {
    flex-direction: row;
    gap: var(--orp-space-6);
  }

  &__gallery {
    flex-shrink: 0;

    @media (min-width: 768px) {
      width: 45%;
    }
  }

  &__main-image {
    width: 100%;
    aspect-ratio: 4 / 3;
    border-radius: var(--orp-radius-lg);
    overflow: hidden;
    background: var(--orp-surface-muted);
    margin-bottom: var(--orp-space-3);

    a {
      display: block;
      width: 100%;
      height: 100%;
    }

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__thumbs {
    display: flex;
    gap: var(--orp-space-2);
    overflow-x: auto;
    padding-bottom: var(--orp-space-2);
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;

    &::-webkit-scrollbar {
      height: 3px;
    }

    &::-webkit-scrollbar-thumb {
      background: var(--orp-border);
      border-radius: 2px;
    }
  }

  &__thumb {
    flex: 0 0 64px;
    height: 64px;
    border-radius: var(--orp-radius-md);
    overflow: hidden;
    display: block;
    scroll-snap-align: start;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &:hover {
      opacity: 0.85;
    }
  }

  &__body {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-4);
    padding-top: var(--orp-space-1);

    @media (min-width: 768px) {
      padding-top: 0;
    }
  }

  &__header {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-2);
  }

  &__category {
    display: inline-block;
    font-size: var(--orp-font-size-xs);
    font-weight: 600;
    color: var(--orp-primary);
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  &__name {
    font-size: var(--orp-font-size-xl);
    font-weight: 700;
    margin: 0;
    color: var(--orp-surface-foreground);
    line-height: 1.2;
  }

  &__pricing {
    display: flex;
    align-items: baseline;
    gap: var(--orp-space-3);
    flex-wrap: wrap;
  }

  &__price {
    .orp-price__value {
      font-size: var(--orp-font-size-2xl);
      font-weight: 700;
      color: var(--orp-surface-foreground);
    }
  }

  &__price-compare {
    font-size: var(--orp-font-size-base);
    color: var(--orp-muted-foreground);
    text-decoration: line-through;
  }

  &__discount {
    font-size: var(--orp-font-size-sm);
    font-weight: 700;
  }

  &__meta {
    flex-wrap: wrap;
    gap: var(--orp-space-3);
    padding: var(--orp-space-3) 0;
    border-top: 1px solid var(--orp-border);
    border-bottom: 1px solid var(--orp-border);
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: var(--orp-space-1);
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);

    i {
      font-size: 0.875rem;
      color: var(--orp-muted-foreground);
    }

    &--success {
      color: var(--orp-success);

      i {
        color: var(--orp-success);
      }
    }
  }

  &__description {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-surface-foreground);
    line-height: 1.6;
    margin: 0;
  }

  &__actions {
    margin-top: auto;
    padding-top: var(--orp-space-2);
  }

  &__btn-primary {
    width: 100%;
    justify-content: center;
    gap: var(--orp-space-2);
  }

  &__btn-whatsapp {
    width: 100%;
    justify-content: center;
    gap: var(--orp-space-2);
    background-color: #25d366;
    border-color: #25d366;
    color: #fff;

    &:hover:not(:disabled) {
      background-color: #20bd5a;
      border-color: #20bd5a;
      color: #fff;
    }

    &:active:not(:disabled) {
      transform: scale(0.98);
    }
  }

  &__tertiary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--orp-space-1);
    padding: var(--orp-space-2);
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-muted-foreground);
    text-decoration: none;
    transition: color var(--orp-duration-fast);

    &:hover {
      color: var(--orp-surface-foreground);
    }

    i {
      font-size: 0.75rem;
      transition: transform var(--orp-duration-fast);
    }

    &:hover i {
      transform: translateX(2px);
    }
  }
}
</style>
