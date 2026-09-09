<template>
  <div class="service-carousel" :class="[`service-carousel--${variant}`]">
    <div class="service-carousel__header" v-if="title || $slots.header">
      <slot name="header">
        <h3 class="service-carousel__title">{{ title }}</h3>
        <p v-if="description" class="service-carousel__description">{{ description }}</p>
      </slot>
    </div>

    <div class="service-carousel__wrapper">
      <button
        v-if="showArrows && !isFirst"
        class="service-carousel__arrow service-carousel__arrow--prev"
        type="button"
        @click="prev"
        :disabled="isFirst"
      >
        <i class="bi bi-chevron-left"></i>
      </button>

      <div class="service-carousel__track" ref="trackRef">
        <div
          class="service-carousel__slides"
          :style="trackStyle"
          @touchstart="onTouchStart"
          @touchmove="onTouchMove"
          @touchend="onTouchEnd"
        >
          <slot>
            <div
              v-for="item in items"
              :key="item.id"
              class="service-carousel__slide"
            >
              <ServiceCard
                :item="item"
                :variant="cardVariant"
                @select="$emit('select', $event)"
                @action="$emit('action', $event)"
              />
            </div>
          </slot>
        </div>
      </div>

      <button
        v-if="showArrows && !isLast"
        class="service-carousel__arrow service-carousel__arrow--next"
        type="button"
        @click="next"
        :disabled="isLast"
      >
        <i class="bi bi-chevron-right"></i>
      </button>
    </div>

    <div class="service-carousel__dots" v-if="showDots">
      <button
        v-for="(_, idx) in totalPages"
        :key="idx"
        class="service-carousel__dot"
        :class="{ 'is-active': currentPage === idx }"
        type="button"
        @click="goTo(idx)"
      />
    </div>

    <div class="service-carousel__counter" v-if="showCounter">
      {{ currentPage + 1 }} / {{ totalPages }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import ServiceCard from './ServiceCard.vue'

const props = defineProps({
  items: {
    type: Array,
    default: () => [],
  },
  title: String,
  description: String,
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'compact', 'wide', 'minimal'].includes(v),
  },
  cardVariant: {
    type: String,
    default: 'default',
  },
  slidesPerView: {
    type: Number,
    default: 3,
  },
  gap: {
    type: Number,
    default: 16,
  },
  loop: {
    type: Boolean,
    default: false,
  },
  showArrows: {
    type: Boolean,
    default: true,
  },
  showDots: {
    type: Boolean,
    default: true,
  },
  showCounter: {
    type: Boolean,
    default: false,
  },
  autoplay: {
    type: Boolean,
    default: false,
  },
  autoplayInterval: {
    type: Number,
    default: 4000,
  },
})

const emit = defineEmits(['select', 'action', 'change'])

const currentPage = ref(0)
const trackRef = ref(null)
const touchStartX = ref(0)
const touchEndX = ref(0)

const totalPages = computed(() => {
  return Math.max(1, Math.ceil(props.items.length / props.slidesPerView))
})

const isFirst = computed(() => currentPage.value === 0)
const isLast = computed(() => currentPage.value >= totalPages.value - 1)

const trackStyle = computed(() => ({
  transform: `translateX(-${currentPage.value * 100}%)`,
  gap: `${props.gap}px`,
}))

const next = () => {
  if (currentPage.value < totalPages.value - 1) {
    currentPage.value++
    emit('change', currentPage.value)
  } else if (props.loop) {
    currentPage.value = 0
    emit('change', currentPage.value)
  }
}

const prev = () => {
  if (currentPage.value > 0) {
    currentPage.value--
    emit('change', currentPage.value)
  } else if (props.loop) {
    currentPage.value = totalPages.value - 1
    emit('change', currentPage.value)
  }
}

const goTo = (idx) => {
  currentPage.value = idx
  emit('change', currentPage.value)
}

const onTouchStart = (e) => {
  touchStartX.value = e.touches[0].clientX
}

const onTouchMove = (e) => {
  touchEndX.value = e.touches[0].clientX
}

const onTouchEnd = () => {
  const diff = touchStartX.value - touchEndX.value
  if (Math.abs(diff) > 50) {
    if (diff > 0) next()
    else prev()
  }
}
</script>

<style lang="scss" scoped>
.service-carousel {
  &__header {
    margin-bottom: 1.5rem;
  }

  &__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__track {
    flex: 1;
    overflow: hidden;
  }

  &__slides {
    display: flex;
    transition: transform 0.4s ease;
  }

  &__slide {
    flex: 0 0 calc((100% - v-bind(gap) * (v-bind(slidesPerView) - 1)) / v-bind(slidesPerView));
    min-width: calc((100% - v-bind(gap) * (v-bind(slidesPerView) - 1)) / v-bind(slidesPerView));
  }

  &__arrow {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--bulma-border);
    border-radius: 50%;
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;

    &:hover:not(:disabled) {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }

    &:disabled {
      opacity: 0.3;
      cursor: not-allowed;
    }
  }

  &__dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.25rem;
  }

  &__dot {
    width: 8px;
    height: 8px;
    border: none;
    border-radius: 50%;
    background: var(--bulma-border);
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-text-weak);
    }

    &.is-active {
      background: var(--bulma-link);
      width: 24px;
      border-radius: 4px;
    }
  }

  &__counter {
    text-align: center;
    margin-top: 0.75rem;
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
  }

  &--compact {
    .service-carousel__slide {
      flex: 0 0 calc((100% - v-bind(gap) * (v-bind(slidesPerView) - 1)) / v-bind(slidesPerView));
    }
  }

  &--wide {
    .service-carousel__slide {
      flex: 0 0 calc((100% - v-bind(gap) * 2) / 3);
    }
  }

  &--minimal {
    .service-carousel__wrapper {
      gap: 0;
    }

    .service-carousel__arrow {
      display: none;
    }

    .service-carousel__track {
      border-radius: var(--bulma-radius);
    }
  }
}
</style>
