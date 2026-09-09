<template>
  <section class="hero-slider" :class="{ 'hero-slider--fullscreen': fullscreen }">
    <div ref="swiperEl" class="hero-slider__container">
      <div class="swiper-wrapper">
        <div
          v-for="(slide, index) in slides"
          :key="index"
          class="swiper-slide hero-slider__slide"
          :style="getSlideStyle(slide)"
        >
          <HeroOverlay :variant="slide.overlayVariant || overlayVariant" />
          <div class="hero-slider__content" :class="[`hero-slider__content--${contentAlign}`]">
            <HeroLogo v-if="slide.logo" :src="slide.logo" :name="slide.name || name" size="lg" />
            <HeroIdentity
              :name="slide.name"
              :title="slide.title"
              :company="slide.company"
              :size="nameSize"
            />
            <HeroBadges v-if="slide.badges?.length" :badges="slide.badges" />
            <HeroDescription v-if="slide.description" :text="slide.description" />
            <HeroActions v-if="slide.actions?.length" :actions="slide.actions" />
          </div>
        </div>
      </div>
    </div>

    <div v-if="showNavigation" class="hero-slider__navigation">
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>

    <div v-if="showPagination" class="hero-slider__pagination">
      <div class="swiper-pagination"></div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue'
import Swiper from 'swiper'
import { Pagination, Navigation, Autoplay } from 'swiper/modules'
import HeroOverlay from './structure/HeroOverlay.vue'
import HeroLogo from './structure/HeroLogo.vue'
import HeroIdentity from './structure/HeroIdentity.vue'
import HeroBadges from './structure/HeroBadges.vue'
import HeroDescription from './structure/HeroDescription.vue'
import HeroActions from './structure/HeroActions.vue'

const props = defineProps({
  slides: {
    type: Array,
    required: true,
    default: () => [],
  },
  name: {
    type: String,
    default: '',
  },
  overlayVariant: {
    type: String,
    default: 'gradient-bottom',
  },
  nameSize: {
    type: String,
    default: 'xl',
  },
  contentAlign: {
    type: String,
    default: 'center',
    validator: (v) => ['left', 'center', 'right'].includes(v),
  },
  fullscreen: {
    type: Boolean,
    default: false,
  },
  autoplay: {
    type: [Boolean, Object],
    default: false,
  },
  delay: {
    type: Number,
    default: 5000,
  },
  showNavigation: {
    type: Boolean,
    default: true,
  },
  showPagination: {
    type: Boolean,
    default: true,
  },
  loop: {
    type: Boolean,
    default: true,
  },
  effect: {
    type: String,
    default: 'slide',
    validator: (v) => ['slide', 'fade', 'cube', 'coverflow'].includes(v),
  },
})

const emit = defineEmits(['slideChange', 'swiper'])

const swiperEl = ref(null)
let swiperInstance = null

const getSlideStyle = (slide) => {
  if (slide.cover) {
    return {
      backgroundImage: `url(${slide.cover})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    }
  }
  return {
    background: slide.background || `linear-gradient(135deg, var(--bulma-primary) 0%, var(--bulma-link) 100%)`,
  }
}

const initSwiper = () => {
  if (!swiperEl.value || swiperInstance) return

  const modules = [Pagination, Navigation]
  if (props.autoplay) {
    modules.push(Autoplay)
  }

  const swiperParams = {
    modules,
    effect: props.effect,
    slidesPerView: 1,
    spaceBetween: 0,
    loop: props.loop,
    pagination: props.showPagination ? {
      el: '.hero-slider__pagination .swiper-pagination',
      clickable: true,
      bulletActiveClass: 'is-active',
      bulletClass: 'hero-slider__bullet',
    } : false,
    navigation: props.showNavigation ? {
      nextEl: '.hero-slider__navigation .swiper-button-next',
      prevEl: '.hero-slider__navigation .swiper-button-prev',
    } : false,
    on: {
      slideChange: () => emit('slideChange'),
    },
  }

  if (props.autoplay) {
    if (typeof props.autoplay === 'object') {
      swiperParams.autoplay = props.autoplay
    } else {
      swiperParams.autoplay = {
        delay: props.delay,
        disableOnInteraction: false,
      }
    }
  }

  if (props.effect === 'fade') {
    swiperParams.fadeEffect = {
      crossFade: true,
    }
  }

  swiperInstance = new Swiper(swiperEl.value, swiperParams)
  emit('swiper', swiperInstance)
}

onMounted(() => {
  nextTick(() => initSwiper())
})

onBeforeUnmount(() => {
  if (swiperInstance) {
    swiperInstance.destroy()
    swiperInstance = null
  }
})
</script>

<style lang="scss" scoped>
.hero-slider {
  position: relative;
  width: 100%;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &--fullscreen {
    border-radius: 0;
    min-height: 100vh;
  }

  &__container {
    width: 100%;
    overflow: hidden;
  }

  &__slide {
    position: relative;
    min-height: 25rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &__content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 1rem;
    padding: 3rem 2rem;
    max-width: 650px;
    color: var(--bulma-scheme-main);

    &--left {
      align-items: flex-start;
      text-align: left;
      margin-right: auto;
      margin-left: 5%;
    }

    &--right {
      align-items: flex-end;
      text-align: right;
      margin-left: auto;
      margin-right: 5%;
    }

    :deep(.hero-identity__name) {
      color: var(--bulma-scheme-main);
    }

    :deep(.hero-identity__title),
    :deep(.hero-identity__company) {
      color: var(--bulma-scheme-main);
      opacity: 0.9;
    }

    :deep(.hero-description) {
      color: var(--bulma-scheme-main);
      opacity: 0.9;
    }

    :deep(.hero-badge--default) {
      background: oklch(100% 0 0 / 0.2);
      color: var(--bulma-scheme-main);
    }

    :deep(.hero-actions__btn--primary) {
      background: var(--bulma-scheme-main);
      color: var(--bulma-link);

      &:hover {
        background: var(--bulma-scheme-main);
        opacity: 0.9;
      }
    }
  }

  &__navigation {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    pointer-events: none;
    z-index: 10;
    padding: 0 1rem;

    .swiper-button-prev,
    .swiper-button-next {
      pointer-events: auto;
      position: static;
      transform: none;
      width: 44px;
      height: 44px;
      background: var(--bulma-scheme-main);
      border-radius: 50%;
      color: var(--bulma-primary);
      box-shadow: var(--dl-shadow-sm);

      &::after {
        font-size: 1rem;
        font-weight: bold;
      }

      &:hover {
        background: var(--bulma-scheme-main-bis);
        box-shadow: var(--dl-shadow-md);
      }
    }

    .swiper-button-prev {
      margin-left: 0.5rem;
    }

    .swiper-button-next {
      margin-right: 0.5rem;
    }
  }

  &__pagination {
    position: absolute;
    bottom: 1.5rem;
    left: 0;
    right: 0;
    z-index: 10;
    display: flex;
    justify-content: center;

    :deep(.swiper-pagination) {
      display: flex;
      gap: 0.375rem;
    }

    :deep(.hero-slider__bullet) {
      width: 0.5rem;
      height: 0.5rem;
      background: oklch(100% 0 0 / 0.5);
      border-radius: 50%;
      transition: all 0.2s ease;
      cursor: pointer;

      &.is-active {
        width: 1.5rem;
        border-radius: var(--bulma-radius-small);
        background: var(--bulma-scheme-main);
      }
    }
  }
}
</style>
