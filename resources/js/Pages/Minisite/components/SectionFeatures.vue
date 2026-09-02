<template>
  <section class="section-features">
    <div class="section-features__inner">
      <h2 v-if="title" class="section-features__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-features__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-features__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay características disponibles.
      </div>

      <div v-else class="section-features__grid">
        <article
          v-for="item in items"
          :key="item.id"
          class="section-features__item orp-card"
        >
          <div v-if="showIcon && item.icon" class="section-features__icon">
            <i :class="item.icon"></i>
          </div>
          <div class="section-features__content">
            <h3 v-if="showTitle && item.title" class="section-features__item-title">
              {{ item.title }}
            </h3>
            <p v-if="showDescription && item.description" class="section-features__item-desc">
              {{ item.description }}
            </p>
          </div>
        </article>
      </div>

      <div v-if="buttons && buttons.length" class="section-features__buttons">
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

const showIcon = computed(() => props.config?.show_icon !== false)
const showTitle = computed(() => props.config?.show_title !== false)
const showDescription = computed(() => props.config?.show_description !== false)
</script>

<script>
import { computed, defineComponent } from 'vue'
export default defineComponent({ name: 'SectionFeatures' })
</script>

<style lang="less">
.section-features {
  padding: var(--orp-space-6) var(--orp-space-2);
  background: var(--orp-surface-muted);

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

  &__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: var(--orp-space-3);
  }

  &__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: var(--orp-space-4);
  }

  &__icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: color-mix(in srgb, var(--orp-primary) 15%, transparent);
    border-radius: 50%;
    color: var(--orp-primary);
    font-size: 1.25rem;
    margin-bottom: var(--orp-space-3);
  }

  &__content {
    flex: 1;
  }

  &__item-title {
    font-size: var(--orp-font-size-sm);
    font-weight: 600;
    margin: 0 0 var(--orp-space-2);
    color: var(--orp-surface-foreground);
  }

  &__item-desc {
    font-size: var(--orp-font-size-xs);
    color: var(--orp-muted-foreground);
    margin: 0;
    line-height: 1.4;
  }

  &__buttons {
    display: flex;
    justify-content: center;
    gap: var(--orp-space-2);
    margin-top: var(--orp-space-4);
  }
}
</style>
