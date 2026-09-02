<template>
  <section class="section-faqs">
    <div class="section-faqs__inner">
      <h2 v-if="title" class="section-faqs__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-faqs__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-faqs__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay preguntas frecuentes disponibles.
      </div>

      <OrpAccordion
        v-else
        :items="accordionItems"
        v-model="openFaq"
      />

      <div v-if="buttons && buttons.length" class="section-faqs__buttons">
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
import { computed } from 'vue'
import OrpAccordion from '@/Components/OrpUI/OrpAccordion.vue'

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

const showQuestions = computed(() => props.config?.show_questions !== false)

const accordionItems = computed(() =>
  props.items.map((item) => ({
    value: String(item.id),
    title: item.question,
    content: item.answer,
  }))
)

const openFaq = defineModel()
</script>

<script>
import { defineComponent } from 'vue'
export default defineComponent({ name: 'SectionFaqs' })
</script>

<style lang="less">
.section-faqs {
  padding: var(--orp-space-5) var(--orp-space-2);

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
    color: var(--orp-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__description-text {
    font-size: var(--orp-font-size-md);
    color: var(--orp-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__buttons {
    display: flex;
    justify-content: center;
    gap: var(--orp-space-2);
    margin-top: var(--orp-space-4);
  }
}
</style>
