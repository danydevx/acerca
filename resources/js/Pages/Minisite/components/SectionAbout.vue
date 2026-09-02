<template>
  <section class="section-about">
    <div class="section-about__inner">
      <h2 v-if="title" class="section-about__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-about__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-about__description-text">{{ description }}</p>

      <div v-if="content" class="section-about__content">
        <div v-if="showImage && (content.logo || content.image)" class="section-about__image-wrapper">
          <img
            :src="content.logo || content.image"
            :alt="content.name"
            class="section-about__image"
          />
        </div>

        <div v-if="showDescription && content.description" class="section-about__description">
          <p>{{ content.description }}</p>
        </div>
      </div>

      <div v-else class="orp-text-muted orp-text-center orp-p-4">
        No hay información disponible.
      </div>

      <div v-if="buttons && buttons.length" class="section-about__buttons">
        <a
          v-for="(btn, index) in buttons"
          :key="index"
          :href="btn.url"
          class="orp-btn"
          :class="'orp-btn--' + (btn.style || 'primary')"
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
  content: {
    type: Object,
    default: null,
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
const showDescription = computed(() => props.config?.show_description !== false)
</script>

<script>
import { computed, defineComponent } from 'vue'
export default defineComponent({ name: 'SectionAbout' })
</script>

<style lang="less">
.section-about {
  padding: var(--orp-space-6) var(--orp-space-2);

  &__inner {
    max-width: 1024px;
    margin: 0 auto;
    text-align: center;
  }

  &__title {
    font-weight: 700;
    margin: 0 0 var(--orp-space-4);
    color: var(--orp-foreground);
  }

  &__subtitle {
    font-weight: 600;
    margin: 0 0 var(--orp-space-3);
    color: var(--orp-muted-foreground);
  }

  &__description-text {
    font-size: var(--orp-font-size-md);
    line-height: 1.6;
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-3);
  }

  &__image-wrapper {
    margin-bottom: var(--orp-space-4);
  }

  &__image {
    width: 120px;
    height: 120px;
    object-fit: contain;
    border-radius: 50%;
  }

  &__description {
    font-size: var(--orp-font-size-md);
    line-height: 1.6;
    color: var(--orp-muted-foreground);

    p {
      margin: 0;
    }
  }

  &__buttons {
    display: flex;
    justify-content: center;
    gap: var(--orp-space-2);
    margin-top: var(--orp-space-4);
  }
}
</style>
