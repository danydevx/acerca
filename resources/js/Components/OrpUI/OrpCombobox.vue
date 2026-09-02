<script setup>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue'
import { useClickOutside } from '@/Composables/OrpUI/useClickOutside'
import { useEscapeKey } from '@/Composables/OrpUI/useEscapeKey'

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: null
    },
    options: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: 'Select...'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    clearable: {
        type: Boolean,
        default: false
    },
    searchable: {
        type: Boolean,
        default: false
    },
    optionLabel: {
        type: String,
        default: 'label'
    },
    optionValue: {
        type: String,
        default: 'value'
    },
    noResultsText: {
        type: String,
        default: 'No results found'
    },
    loading: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'change', 'search', 'open', 'close'])

const isOpen = ref(false)
const activeIndex = ref(-1)
const searchQuery = ref('')
const inputRef = ref(null)
const listRef = ref(null)
const containerRef = ref(null)

const selectedOption = computed(() => {
    if (props.modelValue === null || props.modelValue === undefined) return null
    return props.options.find(opt =>
        getOptionValue(opt) === props.modelValue
    )
})

const displayValue = computed(() => {
    if (isOpen.value && props.searchable) return searchQuery.value
    return selectedOption.value ? getOptionLabel(selectedOption.value) : ''
})

const filteredOptions = computed(() => {
    if (!props.searchable || !searchQuery.value) return props.options
    const query = searchQuery.value.toLowerCase()
    return props.options.filter(opt => {
        const label = getOptionLabel(opt)
        return String(label).toLowerCase().includes(query)
    })
})

const getOptionLabel = (opt) => {
    return typeof opt === 'object' ? opt[props.optionLabel] : opt
}

const getOptionValue = (opt) => {
    return typeof opt === 'object' ? opt[props.optionValue] : opt
}

const getOptionId = (index) => `combobox-option-${index}`

const handleOpen = () => {
    if (props.disabled || props.readonly) return
    isOpen.value = true
    activeIndex.value = -1
    if (props.searchable) {
        searchQuery.value = ''
        nextTick(() => inputRef.value?.focus())
    }
    emit('open')
}

const handleClose = () => {
    isOpen.value = false
    activeIndex.value = -1
    searchQuery.value = ''
    emit('close')
}

const handleToggle = () => {
    if (isOpen.value) handleClose()
    else handleOpen()
}

const handleSelect = (opt) => {
    const val = getOptionValue(opt)
    emit('update:modelValue', val)
    emit('change', val)
    handleClose()
    nextTick(() => inputRef.value?.focus())
}

const handleClear = (e) => {
    e.stopPropagation()
    emit('update:modelValue', null)
    emit('change', null)
    handleOpen()
}

const handleKeydown = (e) => {
    if (!isOpen.value) {
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp' || e.key === 'Enter') {
            e.preventDefault()
            handleOpen()
        }
        return
    }

    switch (e.key) {
        case 'ArrowDown':
            e.preventDefault()
            if (activeIndex.value < filteredOptions.value.length - 1) {
                activeIndex.value++
                scrollToActive()
            }
            break
        case 'ArrowUp':
            e.preventDefault()
            if (activeIndex.value > 0) {
                activeIndex.value--
                scrollToActive()
            }
            break
        case 'Enter':
            e.preventDefault()
            if (activeIndex.value >= 0 && filteredOptions.value[activeIndex.value]) {
                handleSelect(filteredOptions.value[activeIndex.value])
            }
            break
        case 'Escape':
            e.preventDefault()
            handleClose()
            inputRef.value?.focus()
            break
        case 'Home':
            e.preventDefault()
            activeIndex.value = 0
            scrollToActive()
            break
        case 'End':
            e.preventDefault()
            activeIndex.value = filteredOptions.value.length - 1
            scrollToActive()
            break
    }
}

const handleSearch = (e) => {
    if (!props.searchable) return
    searchQuery.value = e.target.value
    activeIndex.value = 0
    emit('search', searchQuery.value)
    scrollToActive()
}

const scrollToActive = () => {
    nextTick(() => {
        const activeEl = listRef.value?.querySelector(`[data-active="true"]`)
        activeEl?.scrollIntoView({ block: 'nearest' })
    })
}

const handleInputClick = () => {
    handleToggle()
}

useClickOutside(containerRef, handleClose, { enabled: computed(() => isOpen.value) })
useEscapeKey(isOpen, handleClose)

watch(isOpen, (open) => {
    if (!open) {
        searchQuery.value = ''
    }
})
</script>

<template>
    <div
        ref="containerRef"
        class="orp-combobox"
        :class="{ 'orp-combobox--open': isOpen, 'orp-combobox--disabled': disabled }"
    >
        <div
            class="orp-combobox__control"
            @click="handleInputClick"
            @keydown="handleKeydown"
        >
            <div class="orp-combobox__trigger">
                <input
                    ref="inputRef"
                    type="text"
                    class="orp-combobox__input"
                    :value="displayValue"
                    :placeholder="placeholder"
                    :disabled="disabled"
                    :readonly="!searchable"
                    :aria-expanded="isOpen"
                    :aria-controls="isOpen ? 'combobox-list' : undefined"
                    aria-autocomplete="list"
                    role="combobox"
                    autocomplete="off"
                    @input="handleSearch"
                    @focus="!isOpen && handleOpen()"
                >
            </div>

            <div class="orp-combobox__actions">
                <button
                    v-if="clearable && modelValue !== null"
                    type="button"
                    class="orp-combobox__clear"
                    aria-label="Clear selection"
                    @click="handleClear"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>

                <span class="orp-combobox__arrow" :class="{ 'orp-combobox__arrow--open': isOpen }">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </span>
            </div>
        </div>

        <Teleport to="body">
            <Transition name="orp-combobox">
                <div
                    v-if="isOpen"
                    id="combobox-list"
                    ref="listRef"
                    class="orp-combobox__dropdown"
                    role="listbox"
                    :aria-label="placeholder"
                >
                    <div v-if="loading" class="orp-combobox__loading">
                        <span class="orp-spinner orp-spinner--sm"></span>
                    </div>

                    <template v-else>
                        <div
                            v-if="filteredOptions.length === 0"
                            class="orp-combobox__empty"
                        >
                            {{ noResultsText }}
                        </div>

                        <div
                            v-for="(option, index) in filteredOptions"
                            :key="getOptionValue(option)"
                            :id="getOptionId(index)"
                            class="orp-combobox__option"
                            :class="{
                                'orp-combobox__option--active': index === activeIndex,
                                'orp-combobox__option--selected': getOptionValue(option) === modelValue
                            }"
                            role="option"
                            :aria-selected="getOptionValue(option) === modelValue"
                            :data-active="index === activeIndex"
                            @click="handleSelect(option)"
                            @mouseenter="activeIndex = index"
                        >
                            <span class="orp-combobox__option-label">
                                {{ getOptionLabel(option) }}
                            </span>
                            <span
                                v-if="getOptionValue(option) === modelValue"
                                class="orp-combobox__check"
                            >
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 6L9 17l-5-5"/>
                                </svg>
                            </span>
                        </div>
                    </template>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
