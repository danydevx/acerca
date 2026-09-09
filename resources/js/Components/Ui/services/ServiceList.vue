<template>
  <div class="service-list" :class="[`service-list--${variant}`, `service-list--${density}`]">
    <div v-if="title" class="service-list__header">
      <h3 class="service-list__title">{{ title }}</h3>
      <p v-if="description" class="service-list__description">{{ description }}</p>
    </div>

    <div class="service-list__tabs" v-if="tabs?.length">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        class="service-list__tab"
        :class="{ 'is-active': activeTab === tab.id }"
        type="button"
        @click="activeTab = tab.id"
      >
        {{ tab.label }}
      </button>
    </div>

    <div class="service-list__items">
      <slot :active-tab="activeTab">
        <ServiceRow
          v-for="item in filteredItems"
          :key="item.id"
          :item="item"
          :variant="rowVariant"
          @select="$emit('select', $event)"
          @action="$emit('action', $event)"
        />
      </slot>
    </div>

    <div v-if="showFooter && items.length > visibleCount" class="service-list__footer">
      <button class="service-list__show-more" type="button" @click="showAll = !showAll">
        {{ showAll ? 'Ver menos' : `Ver ${items.length - visibleCount} más` }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import ServiceRow from './ServiceRow.vue'

const props = defineProps({
  title: String,
  description: String,
  items: {
    type: Array,
    default: () => [],
  },
  tabs: {
    type: Array,
    default: () => null,
  },
  variant: {
    type: String,
    default: 'default',
  },
  density: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'compact', 'relaxed'].includes(v),
  },
  rowVariant: {
    type: String,
    default: 'default',
  },
  visibleCount: {
    type: Number,
    default: 0,
  },
  showFooter: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['select', 'action'])

const activeTab = ref(props.tabs?.[0]?.id || null)
const showAll = ref(false)

const filteredItems = computed(() => {
  let result = props.items
  if (props.tabs?.length && activeTab.value) {
    result = result.filter(item => item.category === activeTab.value)
  }
  if (props.visibleCount > 0 && !showAll.value) {
    result = result.slice(0, props.visibleCount)
  }
  return result
})
</script>

<style lang="scss" scoped>
.service-list {
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
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
  }

  &__tab {
    padding: 0.5rem 1rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
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
  }

  &__items {
    display: flex;
    flex-direction: column;
  }

  &__footer {
    margin-top: 1rem;
    text-align: center;
  }

  &__show-more {
    padding: 0.5rem 1.5rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: transparent;
    color: var(--bulma-link);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);
    }
  }

  &--compact {
    .service-list__items {
      gap: 0.5rem;
    }
  }

  &--relaxed {
    .service-list__items {
      gap: 1rem;
    }
  }
}
</style>
