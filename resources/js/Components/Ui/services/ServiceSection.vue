<template>
  <section class="service-section">
    <header v-if="title || description" class="service-section__header">
      <h3 v-if="title" class="service-section__title">{{ title }}</h3>
      <p v-if="description" class="service-section__description">{{ description }}</p>
    </header>

    <nav v-if="categories?.length" class="service-section__categories">
      <button
        v-for="cat in categories"
        :key="cat.id"
        class="service-section__category"
        :class="{ 'is-active': activeCategory === cat.id }"
        type="button"
        @click="activeCategory = cat.id"
      >
        <i v-if="cat.icon" :class="cat.icon"></i>
        {{ cat.label }}
      </button>
    </nav>

    <div class="service-section__content">
      <slot :active-category="activeCategory" />
    </div>

    <footer v-if="$slots.footer" class="service-section__footer">
      <slot name="footer" />
    </footer>
  </section>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  title: String,
  description: String,
  categories: {
    type: Array,
    default: () => null,
  },
})

defineSlots()

const activeCategory = ref(null)
</script>

<style lang="scss" scoped>
.service-section {
  &__header {
    margin-bottom: 1.5rem;
  }

  &__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.375rem;
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__categories {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
  }

  &__category {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-rounded);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &.is-active {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }

    i {
      font-size: 1rem;
    }
  }

  &__content {
    //
  }

  &__footer {
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--bulma-border);
  }
}
</style>
