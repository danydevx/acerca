<template>
  <div class="swiperslider" :class="[`swiperslider--${variant}`]">
    <div ref="swiperEl" class="swiperslider__container">
      <div class="swiper-wrapper">
        <slot></slot>
      </div>
    </div>
    <div v-if="showPagination && paginationType === 'bullets'" class="swiper-pagination"></div>
    <div v-if="showNavigation && navigationType === 'arrows'" class="swiperslider__navigation">
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue'
import Swiper from 'swiper'
import { Pagination, Navigation, Autoplay } from 'swiper/modules'

const props = defineProps({
  variant: {
    type: String,
    default: 'default',
  },
  effect: {
    type: String,
    default: 'slide',
  },
  slidesPerView: {
    type: [Number, String],
    default: 1,
  },
  spaceBetween: {
    type: [Number, String],
    default: 16,
  },
  loop: {
    type: Boolean,
    default: false,
  },
  autoplay: {
    type: [Boolean, Object],
    default: false,
  },
  delay: {
    type: Number,
    default: 3000,
  },
  showPagination: {
    type: Boolean,
    default: true,
  },
  paginationType: {
    type: String,
    default: 'bullets',
  },
  showNavigation: {
    type: Boolean,
    default: false,
  },
  navigationType: {
    type: String,
    default: 'arrows',
  },
  breakpoints: {
    type: Object,
    default: () => ({}),
  },
})

const emit = defineEmits(['swiper', 'slideChange', 'reachEnd'])

const swiperEl = ref(null)
let swiperInstance = null

const initSwiper = () => {
  if (!swiperEl.value || swiperInstance) return

  const modules = [Pagination, Navigation]
  if (props.autoplay) {
    modules.push(Autoplay)
  }

  const swiperParams = {
    modules,
    effect: props.effect,
    slidesPerView: props.slidesPerView,
    spaceBetween: props.spaceBetween,
    loop: props.loop,
    pagination: props.showPagination ? {
      el: '.swiper-pagination',
      clickable: true,
    } : false,
    navigation: props.showNavigation ? {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    } : false,
    on: {
      slideChange: () => emit('slideChange'),
      reachEnd: () => emit('reachEnd'),
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

  if (Object.keys(props.breakpoints).length > 0) {
    swiperParams.breakpoints = props.breakpoints
  }

  swiperInstance = new Swiper(swiperEl.value, swiperParams)
  emit('swiper', swiperInstance)
}

watch(() => props.autoplay, () => {
  if (swiperInstance) {
    if (props.autoplay) {
      swiperInstance.autoplay.start()
    } else {
      swiperInstance.autoplay.stop()
    }
  }
})

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
.swiperslider {
  position: relative;
  width: 100%;

  &__container {
    width: 100%;
    border-radius: var(--bulma-radius-large);
    overflow: hidden;
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

    .swiper-button-prev,
    .swiper-button-next {
      pointer-events: auto;
      position: static;
      transform: none;
      width: 36px;
      height: 36px;
      background: var(--bulma-scheme-main);
      border-radius: 50%;
      color: var(--bulma-primary);

      &::after {
        font-size: 1rem;
      }
    }

    .swiper-button-prev {
      margin-left: 0.5rem;
    }

    .swiper-button-next {
      margin-right: 0.5rem;
    }
  }

  &--cards {
    .swiper-slide {
      height: auto;
      display: flex;
    }
  }
}

.swiper-pagination {
  margin-top: 1rem;
  text-align: center;

  &-bullet {
    background: var(--bulma-border);
    opacity: 0.5;
    width: 0.5rem;
    height: 0.5rem;
    margin: 0 0.25rem;

    &-active {
      background: var(--bulma-primary);
      opacity: 1;
    }
  }
}
</style>
