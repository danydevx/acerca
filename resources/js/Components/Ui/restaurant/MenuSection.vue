<template>
  <section class="menu-section">
    <header v-if="title || description" class="menu-section__header">
      <h3 v-if="title" class="menu-section__title">{{ title }}</h3>
      <p v-if="description" class="menu-section__description">{{ description }}</p>
    </header>

    <nav v-if="tabs.length > 1" class="menu-section__tabs">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        class="menu-section__tab"
        :class="{ 'menu-section__tab--active': activeTab === tab.id }"
        @click="activeTab = tab.id"
      >
        {{ tab.label }}
      </button>
    </nav>

    <div class="menu-section__content">
      <slot :active-tab="activeTab"></slot>
    </div>

    <footer v-if="$slots.footer" class="menu-section__footer">
      <slot name="footer"></slot>
    </footer>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  description: {
    type: String,
    default: '',
  },
  tabs: {
    type: Array,
    default: () => [],
  },
  defaultTab: {
    type: String,
    default: '',
  },
})

const activeTab = ref(props.defaultTab || props.tabs[0]?.id || '')
</script>

<style lang="scss" scoped>
.menu-section {
  &__header {
    margin-bottom: 1.5rem;
  }

  &__title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__description {
    font-size: 0.9375rem;
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
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &--active {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }
  }

  &__content {
    width: 100%;
  }

  &__footer {
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--bulma-border);
  }
}
</style>
