<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Basic Image Slider</h3>
      <p class="mb-3">Slider simple con paginación</p>
      <div class="swiper swiper-basic">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=1" alt="Slide 1" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=2" alt="Slide 2" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=3" alt="Slide 3" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=4" alt="Slide 4" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=5" alt="Slide 5" />
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Slider with Navigation</h3>
      <p class="mb-3">Flechas de navegación y paginación</p>
      <div class="swiper swiper-navigation">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=6" alt="Slide 1" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=7" alt="Slide 2" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=8" alt="Slide 3" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=9" alt="Slide 4" />
          </div>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Slider with Autoplay</h3>
      <p class="mb-3">Cambio automático cada 3 segundos</p>
      <div class="swiper swiper-autoplay">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=10" alt="Slide 1" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=11" alt="Slide 2" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=12" alt="Slide 3" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=13" alt="Slide 4" />
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Slider with Fade Effect</h3>
      <p class="mb-3">Efecto de fundido en lugar de deslizamiento</p>
      <div class="swiper swiper-fade">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=14" alt="Slide 1" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=15" alt="Slide 2" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=16" alt="Slide 3" />
          </div>
          <div class="swiper-slide">
            <img src="https://picsum.photos/800/400?random=17" alt="Slide 4" />
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Cards Slider</h3>
      <p class="mb-3">Responsive: 1 (mobile) / 2 (tablet) / 3 (desktop) / 4 (large)</p>
      <div class="swiper swiper-cards">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="product-card">
              <img src="https://picsum.photos/300/300?random=20" alt="Product 1" />
              <div class="product-card__content">
                <h4>Product 1</h4>
                <p class="has-text-primary has-text-weight-bold">$29.99</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-card">
              <img src="https://picsum.photos/300/300?random=21" alt="Product 2" />
              <div class="product-card__content">
                <h4>Product 2</h4>
                <p class="has-text-primary has-text-weight-bold">$49.99</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-card">
              <img src="https://picsum.photos/300/300?random=22" alt="Product 3" />
              <div class="product-card__content">
                <h4>Product 3</h4>
                <p class="has-text-primary has-text-weight-bold">$39.99</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-card">
              <img src="https://picsum.photos/300/300?random=23" alt="Product 4" />
              <div class="product-card__content">
                <h4>Product 4</h4>
                <p class="has-text-primary has-text-weight-bold">$59.99</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-card">
              <img src="https://picsum.photos/300/300?random=24" alt="Product 5" />
              <div class="product-card__content">
                <h4>Product 5</h4>
                <p class="has-text-primary has-text-weight-bold">$34.99</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-card">
              <img src="https://picsum.photos/300/300?random=25" alt="Product 6" />
              <div class="product-card__content">
                <h4>Product 6</h4>
                <p class="has-text-primary has-text-weight-bold">$44.99</p>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Multiple Slides Per View</h3>
      <p class="mb-3">3 slides simultáneos visibles</p>
      <div class="swiper swiper-multi">
        <div class="swiper-wrapper">
          <div class="swiper-slide" v-for="i in 8" :key="i">
            <div class="has-background-grey-light has-text-centered p-5">
              <p class="is-size-3 has-text-weight-bold">{{ i }}</p>
              <p class="is-size-7">Slide {{ i }}</p>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, nextTick } from 'vue'
import Swiper from 'swiper'
import { Pagination, Navigation, Autoplay } from 'swiper/modules'
import 'swiper/swiper-bundle.css'

let swipers = []

const initSwipers = () => {
  swipers.push(new Swiper('.swiper-basic', {
    modules: [Pagination],
    pagination: { el: '.swiper-basic .swiper-pagination', clickable: true },
    slidesPerView: 1,
    spaceBetween: 0,
  }))

  swipers.push(new Swiper('.swiper-navigation', {
    modules: [Navigation, Pagination],
    navigation: {
      nextEl: '.swiper-navigation .swiper-button-next',
      prevEl: '.swiper-navigation .swiper-button-prev',
    },
    pagination: { el: '.swiper-navigation .swiper-pagination', clickable: true },
    slidesPerView: 1,
    spaceBetween: 0,
  }))

  swipers.push(new Swiper('.swiper-autoplay', {
    modules: [Autoplay, Pagination],
    autoplay: { delay: 3000, disableOnInteraction: false },
    pagination: { el: '.swiper-autoplay .swiper-pagination', clickable: true },
    slidesPerView: 1,
    spaceBetween: 0,
  }))

  swipers.push(new Swiper('.swiper-fade', {
    modules: [Autoplay, Pagination],
    effect: 'fade',
    fadeEffect: { crossFade: true },
    autoplay: { delay: 3000, disableOnInteraction: false },
    pagination: { el: '.swiper-fade .swiper-pagination', clickable: true },
    slidesPerView: 1,
    spaceBetween: 0,
  }))

  swipers.push(new Swiper('.swiper-cards', {
    modules: [Pagination, Navigation],
    navigation: {
      nextEl: '.swiper-cards .swiper-button-next',
      prevEl: '.swiper-cards .swiper-button-prev',
    },
    pagination: { el: '.swiper-cards .swiper-pagination', clickable: true },
    slidesPerView: 1,
    spaceBetween: 16,
    breakpoints: {
      480: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      1024: { slidesPerView: 4 },
    },
  }))

  swipers.push(new Swiper('.swiper-multi', {
    modules: [Pagination],
    pagination: { el: '.swiper-multi .swiper-pagination', clickable: true },
    slidesPerView: 3,
    spaceBetween: 16,
    breakpoints: {
      640: { slidesPerView: 2 },
      1024: { slidesPerView: 4 },
    },
  }))
}

onMounted(async () => {
  await nextTick()
  initSwipers()
})
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-3 {
  margin-bottom: 1rem;
}

.swiper {
  width: 100%;
  border-radius: 8px;
  overflow: hidden;
  background: var(--bulma-scheme-main-bis);
}

.swiper-slide img {
  width: 100%;
  height: auto;
  display: block;
}

.swiper-cards .swiper-slide {
  height: auto;
}

.product-card {
  background: var(--bulma-scheme-main);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

  img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
  }

  &__content {
    padding: 1rem;

    h4 {
      margin: 0 0 0.5rem;
      font-size: 1rem;
    }
  }
}

:deep(.swiper-pagination-bullet) {
  background: var(--bulma-border);
  opacity: 0.7;
}

:deep(.swiper-pagination-bullet-active) {
  background: var(--bulma-link);
  opacity: 1;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
  color: var(--bulma-link);
}

:deep(.swiper-button-next::after),
:deep(.swiper-button-prev::after) {
  font-size: 1.5rem;
}
</style>
