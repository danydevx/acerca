<template>
  <div class="menu-category">
    <header v-if="title || description" class="menu-category__header">
      <h3 v-if="title" class="menu-category__title">{{ title }}</h3>
      <p v-if="description" class="menu-category__description">{{ description }}</p>
    </header>

    <nav v-if="items.length > 1" class="menu-category__tabs">
      <button
        v-for="category in items"
        :key="category.id"
        class="menu-category__tab"
        :class="{ 'menu-category__tab--active': activeCategory === category.id }"
        @click="activeCategory = category.id"
      >
        {{ category.name }}
      </button>
    </nav>

    <div class="menu-category__content">
      <div
        v-for="category in items"
        :key="category.id"
        v-show="items.length === 1 || activeCategory === category.id"
        class="menu-category__section"
      >
        <slot :category="category" :view-mode="viewMode" />
      </div>
    </div>

    <footer v-if="showFooter" class="menu-category__footer">
      <button
        v-if="hasMoreItems"
        class="menu-category__show-all"
        @click="$emit('showAll', activeCategory)"
      >
        Ver todos ({{ totalItems }})
      </button>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true,
    default: () => [],
  },
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  viewMode: {
    type: String,
    default: 'grid',
    validator: (v) => ['grid', 'list', 'carousel'].includes(v),
  },
  maxItems: {
    type: Number,
    default: 12,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['showAll'])

const activeCategory = ref(props.items[0]?.id || null)

watch(() => props.items, (newItems) => {
  if (newItems.length > 0 && !activeCategory.value) {
    activeCategory.value = newItems[0].id
  }
}, { immediate: true })

const currentCategory = computed(() => {
  return props.items.find(c => c.id === activeCategory.value)
})

const hasMoreItems = computed(() => {
  const category = currentCategory.value
  if (!category) return false
  const products = category.products || []
  return products.length > props.maxItems
})

const totalItems = computed(() => {
  const category = currentCategory.value
  if (!category) return 0
  return (category.products || []).length
})
</script>

<style lang="scss" scoped>
.menu-category {
  &__header {
    margin-bottom: 1.5rem;
  }

  &__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__description {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--bulma-border);
  }

  &__tab {
    padding: 0.5rem 1rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-rounded);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text-weak);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      border-color: var(--bulma-text-weak);
    }

    &--active {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }
  }

  &__content {
    margin-bottom: 1rem;
  }

  &__section {
    width: 100%;
  }

  &__footer {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
  }

  &__show-all {
    padding: 0.5rem 1.5rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: transparent;
    color: var(--bulma-text);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }
  }
}
</style>
