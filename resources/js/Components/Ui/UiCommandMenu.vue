<template>
  <Teleport to="body">
    <div
      v-if="localOpen"
      class="ui-command-backdrop dl-bulma-command-backdrop"
      @click="onBackdropClick"
    >
      <div
        class="dl-bulma-command"
        role="dialog"
        aria-modal="true"
        aria-label="Command menu"
      >
        <div class="dl-bulma-command__header">
          <div class="dl-bulma-command__search">
            <i class="bi bi-search dl-bulma-command__search-icon" aria-hidden="true"></i>
            <input
              ref="searchRef"
              type="text"
              class="dl-bulma-command__input"
              :placeholder="placeholder"
              :value="query"
              @input="onSearch"
              @keydown="onKeyDown"
            >
            <div class="dl-bulma-command__kbd-hint">
              <kbd class="kbd kbd--sm">Esc</kbd>
            </div>
          </div>
        </div>

        <div ref="listRef" class="dl-bulma-command__list" role="listbox">
          <template v-if="filteredItems.length > 0">
            <template v-for="(groupItems, groupName) in groupedItems" :key="groupName">
              <div class="dl-bulma-command__group" v-if="Object.keys(groupedItems).length > 1">
                {{ groupName }}
              </div>
              <div
                v-for="(item, idx) in groupItems"
                :key="item.id || idx"
                class="dl-bulma-command__item"
                :class="{
                  'dl-bulma-command__item--active': item.flatIndex === activeIndex,
                  'dl-bulma-command__item--disabled': item.disabled
                }"
                :data-active="item.flatIndex === activeIndex"
                role="option"
                :aria-selected="item.flatIndex === activeIndex"
                @click="selectItem(item)"
                @mouseenter="activeIndex = item.flatIndex"
              >
                <div class="dl-bulma-command__item-icon" v-if="item.icon">
                  <i :class="item.icon" aria-hidden="true"></i>
                </div>
                <div class="dl-bulma-command__item-content">
                  <div class="dl-bulma-command__item-label">{{ item.label }}</div>
                  <div class="dl-bulma-command__item-desc" v-if="item.description">
                    {{ item.description }}
                  </div>
                </div>
                <div class="dl-bulma-command__item-shortcut" v-if="item.shortcut">
                  <kbd class="kbd kbd--sm">{{ item.shortcut }}</kbd>
                </div>
              </div>
            </template>
          </template>
          <div v-else class="dl-bulma-command__empty">
            <i class="bi bi-search dl-bulma-command__empty-icon" aria-hidden="true"></i>
            <span>{{ emptyText }}</span>
          </div>
        </div>

        <div class="dl-bulma-command__footer">
          <div class="dl-bulma-command__hint">
            <kbd class="kbd kbd--sm">↑</kbd>
            <kbd class="kbd kbd--sm">↓</kbd>
            <span class="dl-bulma-command__hint-text">to navigate</span>
            <kbd class="kbd kbd--sm">Enter</kbd>
            <span class="dl-bulma-command__hint-text">to select</span>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  items: {
    type: Array,
    default: () => []
  },
  placeholder: {
    type: String,
    default: 'Type a command...'
  },
  emptyText: {
    type: String,
    default: 'No results found'
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'select', 'search', 'close'])

const searchRef = ref(null)
const listRef = ref(null)
const query = ref('')
const activeIndex = ref(0)
const localOpen = ref(false)

const filteredItems = computed(() => {
  if (!query.value.trim()) {
    return props.items
  }
  const q = query.value.toLowerCase()
  return props.items.filter(item => {
    const labelMatch = item.label?.toLowerCase().includes(q)
    const descMatch = item.description?.toLowerCase().includes(q)
    const kwMatch = item.keywords?.some(k => k.toLowerCase().includes(q))
    return labelMatch || descMatch || kwMatch
  })
})

const groupedItems = computed(() => {
  const groups = {}
  filteredItems.value.forEach((item, index) => {
    const group = item.group || 'General'
    if (!groups[group]) {
      groups[group] = []
    }
    groups[group].push({ ...item, flatIndex: index })
  })
  return groups
})

const totalItems = computed(() => filteredItems.value.length)

watch(() => props.modelValue, (val) => {
  localOpen.value = val
  if (val) {
    activeIndex.value = 0
    query.value = ''
    nextTick(() => {
      searchRef.value?.focus()
    })
  }
})

const close = () => {
  localOpen.value = false
  emit('update:modelValue', false)
  emit('close')
}

const onSearch = (e) => {
  emit('search', e.target.value)
}

const selectItem = (item) => {
  if (item.disabled) return
  emit('select', item)
  close()
}

const onKeyDown = (e) => {
  switch (e.key) {
    case 'ArrowDown':
      e.preventDefault()
      activeIndex.value = Math.min(activeIndex.value + 1, totalItems.value - 1)
      scrollActiveIntoView()
      break
    case 'ArrowUp':
      e.preventDefault()
      activeIndex.value = Math.max(activeIndex.value - 1, 0)
      scrollActiveIntoView()
      break
    case 'Home':
      e.preventDefault()
      activeIndex.value = 0
      scrollActiveIntoView()
      break
    case 'End':
      e.preventDefault()
      activeIndex.value = totalItems.value - 1
      scrollActiveIntoView()
      break
    case 'Enter':
      e.preventDefault()
      if (filteredItems.value[activeIndex.value]) {
        selectItem(filteredItems.value[activeIndex.value])
      }
      break
    case 'Escape':
      e.preventDefault()
      close()
      break
  }
}

const scrollActiveIntoView = () => {
  nextTick(() => {
    const active = listRef.value?.querySelector('[data-active="true"]')
    active?.scrollIntoView({ block: 'nearest' })
  })
}

const onBackdropClick = (e) => {
  if (e.target === e.currentTarget) {
    close()
  }
}

const onGlobalKeyDown = (e) => {
  if (e.key === 'Escape' && localOpen.value) {
    close()
  }
}

onMounted(() => {
  document.addEventListener('keydown', onGlobalKeyDown)
})

onUnmounted(() => {
  document.removeEventListener('keydown', onGlobalKeyDown)
})
</script>

<style lang="scss" scoped>
.dl-bulma-command-backdrop {
  position: fixed;
  inset: 0;
  z-index: 100;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  padding-top: 10vh;
  background: oklch(0 0 0 / 0.5);
  backdrop-filter: blur(2px);
}

.dl-bulma-command {
  width: 100%;
  max-width: 560px;
  max-height: 70vh;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: 12px;
  box-shadow: 0 25px 50px -12px oklch(0 0 0 / 0.25);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  margin: 0 1rem;

  &__header {
    padding: 0.75rem;
    border-bottom: 1px solid var(--bulma-border);
  }

  &__search {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
  }

  &__search-icon {
    color: var(--bulma-text-weak);
    flex-shrink: 0;
  }

  &__input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font: inherit;
    color: var(--bulma-text);
    min-width: 0;

    &::placeholder {
      color: var(--bulma-text-weak);
    }
  }

  &__kbd-hint {
    flex-shrink: 0;
  }

  &__list {
    flex: 1;
    overflow-y: auto;
    padding: 0.5rem;
  }

  &__group {
    padding: 0.5rem 0.75rem;
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  &__item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s;

    &--active {
      background: var(--bulma-scheme-main-bis);
    }

    &--disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  }

  &__item-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    flex-shrink: 0;
  }

  &__item-content {
    flex: 1;
    min-width: 0;
  }

  &__item-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  &__item-desc {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  &__item-shortcut {
    flex-shrink: 0;
  }

  &__empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 2rem;
    color: var(--bulma-text-weak);
  }

  &__empty-icon {
    opacity: 0.5;
  }

  &__footer {
    padding: 0.5rem 0.75rem;
    border-top: 1px solid var(--bulma-border);
  }

  &__hint {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  &__hint-text {
    font-size: 0.6875rem;
    color: var(--bulma-text-weak);
    margin-right: 0.5rem;
  }
}

.kbd {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.125rem 0.375rem;
  font-size: 0.75rem;
  font-family: inherit;
  background: var(--bulma-scheme-main-bis);
  border: 1px solid var(--bulma-border);
  border-radius: 4px;
  color: var(--bulma-text-weak);

  &--sm {
    padding: 0.125rem 0.375rem;
    font-size: 0.6875rem;
  }
}
</style>
