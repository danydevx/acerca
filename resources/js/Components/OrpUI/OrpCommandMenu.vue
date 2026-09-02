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

const emit = defineEmits(['update:modelValue', 'select', 'search', 'open', 'close'])

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
        groups[group].push({ ...item, originalIndex: index })
    })
    return groups
})

const flatItems = computed(() => {
    return filteredItems.value.map((item, index) => ({ ...item, flatIndex: index }))
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
            if (flatItems.value[activeIndex.value]) {
                selectItem(flatItems.value[activeIndex.value])
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
        const active = listRef.value?.querySelector('[data-orp-active="true"]')
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

<template>
    <Teleport to="body">
        <div
            v-if="localOpen"
            class="orp-command-backdrop"
            @click="onBackdropClick"
        >
            <div
                class="orp-command"
                role="dialog"
                aria-modal="true"
                aria-label="Command menu"
            >
                <div class="orp-command__header">
                    <div class="orp-command__search">
                        <i class="bi bi-search orp-command__search-icon" aria-hidden="true"></i>
                        <input
                            ref="searchRef"
                            type="text"
                            class="orp-command__input"
                            :placeholder="placeholder"
                            :value="query"
                            @input="onSearch"
                            @keydown="onKeyDown"
                        >
                        <div class="orp-command__kbd-hint">
                            <span class="orp-kbd orp-kbd--sm">Esc</span>
                        </div>
                    </div>
                </div>

                <div ref="listRef" class="orp-command__list" role="listbox">
                    <template v-if="filteredItems.length > 0">
                        <template v-for="(groupItems, groupName) in groupedItems" :key="groupName">
                            <div class="orp-command__group" v-if="Object.keys(groupedItems).length > 1">
                                {{ groupName }}
                            </div>
                            <div
                                v-for="(item, idx) in groupItems"
                                :key="item.id || idx"
                                class="orp-command__item"
                                :class="{
                                    'orp-command__item--active': item.flatIndex === activeIndex,
                                    'orp-command__item--disabled': item.disabled
                                }"
                                :data-orp-active="item.flatIndex === activeIndex"
                                role="option"
                                :aria-selected="item.flatIndex === activeIndex"
                                @click="selectItem(item)"
                                @mouseenter="activeIndex = item.flatIndex"
                            >
                                <div class="orp-command__item-icon" v-if="item.icon">
                                    <i :class="item.icon" aria-hidden="true"></i>
                                </div>
                                <div class="orp-command__item-content">
                                    <div class="orp-command__item-label">{{ item.label }}</div>
                                    <div class="orp-command__item-desc" v-if="item.description">
                                        {{ item.description }}
                                    </div>
                                </div>
                                <div class="orp-command__item-shortcut" v-if="item.shortcut">
                                    <span class="orp-kbd orp-kbd--sm">{{ item.shortcut }}</span>
                                </div>
                            </div>
                        </template>
                    </template>
                    <div v-else class="orp-command__empty">
                        <i class="bi bi-search orp-command__empty-icon" aria-hidden="true"></i>
                        <span>{{ emptyText }}</span>
                    </div>
                </div>

                <div class="orp-command__footer">
                    <div class="orp-command__hint">
                        <span class="orp-kbd orp-kbd--sm">↑</span>
                        <span class="orp-kbd orp-kbd--sm">↓</span>
                        <span class="orp-command__hint-text">to navigate</span>
                        <span class="orp-kbd orp-kbd--sm">Enter</span>
                        <span class="orp-command__hint-text">to select</span>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.orp-command-backdrop {
    position: fixed;
    inset: 0;
    z-index: var(--orp-z-modal);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 10vh;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(2px);
}

.orp-command {
    width: 100%;
    max-width: 560px;
    max-height: 70vh;
    background: var(--orp-surface);
    border: 1px solid var(--orp-border);
    border-radius: var(--orp-radius-lg);
    box-shadow: var(--orp-shadow-xl);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    margin: 0 var(--orp-space-4);
}

.orp-command__header {
    padding: var(--orp-space-3);
    border-bottom: 1px solid var(--orp-border);
}

.orp-command__search {
    display: flex;
    align-items: center;
    gap: var(--orp-space-2);
    background: var(--orp-surface-muted);
    border-radius: var(--orp-radius-md);
    padding: var(--orp-space-2) var(--orp-space-3);
}

.orp-command__search-icon {
    color: var(--orp-muted-foreground);
    flex-shrink: 0;
}

.orp-command__input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font: inherit;
    color: var(--orp-surface-foreground);
    min-width: 0;
}

.orp-command__input::placeholder {
    color: var(--orp-muted-foreground);
}

.orp-command__kbd-hint {
    flex-shrink: 0;
}

.orp-command__list {
    flex: 1;
    overflow-y: auto;
    padding: var(--orp-space-2);
}

.orp-command__group {
    padding: var(--orp-space-2) var(--orp-space-3);
    font-size: var(--orp-font-size-xs);
    font-weight: 600;
    color: var(--orp-muted-foreground);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.orp-command__item {
    display: flex;
    align-items: center;
    gap: var(--orp-space-3);
    padding: var(--orp-space-2) var(--orp-space-3);
    border-radius: var(--orp-radius-md);
    cursor: pointer;
    transition: background var(--orp-duration-fast);
}

.orp-command__item--active {
    background: var(--orp-surface-muted);
}

.orp-command__item--disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.orp-command__item-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: var(--orp-radius-sm);
    background: var(--orp-surface-muted);
    color: var(--orp-muted-foreground);
    flex-shrink: 0;
}

.orp-command__item-content {
    flex: 1;
    min-width: 0;
}

.orp-command__item-label {
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-surface-foreground);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.orp-command__item-desc {
    font-size: var(--orp-font-size-xs);
    color: var(--orp-muted-foreground);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.orp-command__item-shortcut {
    flex-shrink: 0;
}

.orp-command__empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: var(--orp-space-2);
    padding: var(--orp-space-8);
    color: var(--orp-muted-foreground);
}

.orp-command__empty-icon {
    opacity: 0.5;
}

.orp-command__footer {
    padding: var(--orp-space-2) var(--orp-space-3);
    border-top: 1px solid var(--orp-border);
}

.orp-command__hint {
    display: flex;
    align-items: center;
    gap: var(--orp-space-1);
}

.orp-command__hint-text {
    font-size: var(--orp-font-size-xs);
    color: var(--orp-muted-foreground);
    margin-inline-end: var(--orp-space-2);
}
</style>
