<template>
  <nav class="panel" :class="[`is-${color}`]">
    <p v-if="title" class="panel-heading">{{ title }}</p>

    <div v-if="$slots.tabs || tabs.length" class="panel-tabs">
      <a
        v-for="(tab, index) in tabs"
        :key="index"
        class="panel-tab"
        :class="{ 'is-active': activeTab === tab.value }"
        @click="selectTab(tab.value)"
      >
        {{ tab.label }}
      </a>
      <slot name="tabs"></slot>
    </div>

    <div v-if="$slots.search || searchable" class="panel-block">
      <p class="control has-icons-left">
        <input
          v-model="searchQuery"
          class="input"
          :placeholder="searchPlaceholder"
          @input="$emit('search', searchQuery)"
        >
        <span class="icon is-left">
          <i class="bi bi-search"></i>
        </span>
      </p>
    </div>

    <div class="panel-content">
      <slot :active-tab="activeTab" :search-query="searchQuery"></slot>
    </div>

    <div v-if="$slots.footer" class="panel-block">
      <slot name="footer"></slot>
    </div>
  </nav>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  title: { type: String, default: '' },
  tabs: {
    type: Array,
    default: () => [],
  },
  modelValue: { type: String, default: '' },
  color: {
    type: String,
    default: '',
    validator: (v) => ['', 'primary', 'info', 'success', 'warning', 'danger', 'link'].includes(v),
  },
  searchable: { type: Boolean, default: false },
  searchPlaceholder: { type: String, default: 'Search...' },
})

const emit = defineEmits(['update:modelValue', 'tab-change', 'search'])

const searchQuery = ref('')
const activeTab = ref(props.modelValue || (props.tabs.length ? props.tabs[0].value : ''))

watch(activeTab, (val) => {
  emit('update:modelValue', val)
  emit('tab-change', val)
})

watch(() => props.modelValue, (val) => {
  if (val) activeTab.value = val
})

const selectTab = (value) => {
  activeTab.value = value
}
</script>

<style lang="scss" scoped>
.panel {
  border-radius: var(--bulma-radius-large);
  box-shadow: none;
  border: 1px solid var(--bulma-border);

  &-heading {
    background: var(--bulma-scheme-main-bis);
    border-bottom: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-large) var(--bulma-radius-large) 0 0;
  }

  &-tabs {
    border-bottom: 1px solid var(--bulma-border);

    .panel-tab {
      color: var(--bulma-text-weak);
      border-bottom: 2px solid transparent;
      margin-bottom: -1px;
      padding: 0.75rem 1rem;
      cursor: pointer;
      transition: all 150ms;

      &:hover {
        color: var(--bulma-text);
      }

      &.is-active {
        color: var(--bulma-link);
        border-bottom-color: var(--bulma-link);
      }
    }
  }

  &-block {
    border-bottom: 1px solid var(--bulma-border);

    &:last-child {
      border-bottom: none;
    }
  }

  &-content {
    // Content slot
  }
}
</style>
