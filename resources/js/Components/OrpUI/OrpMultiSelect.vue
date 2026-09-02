<script setup>
import { ref, computed, watch, nextTick } from 'vue'
import { useClickOutside } from '@/Composables/OrpUI/useClickOutside'
import { useEscapeKey } from '@/Composables/OrpUI/useEscapeKey'

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
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
    max: {
        type: Number,
        default: null
    },
    removeLabel: {
        type: String,
        default: 'Remove'
    }
})

const emit = defineEmits(['update:modelValue', 'change', 'search', 'open', 'close'])

const isOpen = ref(false)
const activeIndex = ref(-1)
const searchQuery = ref('')
const inputRef = ref(null)
const listRef = ref(null)
const containerRef = ref(null)

const selectedOptions = computed(() => {
    return props.options.filter(opt => {
        const val = getOptionValue(opt)
        return props.modelValue.includes(val)
    })
})

const displayValue = computed(() => {
    if (props.modelValue.length === 0) return ''
    if (isOpen.value && props.searchable) return searchQuery.value
    return `${props.modelValue.length} selected`
})

const filteredOptions = computed(() => {
    if (!props.searchable || !searchQuery.value) return props.options
    const query = searchQuery.value.toLowerCase()
    return props.options.filter(opt => {
        const label = getOptionLabel(opt)
        return String(label).toLowerCase().includes(query)
    })
})

const getOptionLabel = (opt) => typeof opt === 'object' ? opt[props.optionLabel] : opt
const getOptionValue = (opt) => typeof opt === 'object' ? opt[props.optionValue] : opt
const getOptionId = (index) => `multiselect-option-${index}`

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
    const current = [...props.modelValue]
    const idx = current.indexOf(val)

    if (idx > -1) {
        current.splice(idx, 1)
    } else {
        if (props.max && current.length >= props.max) return
        current.push(val)
    }

    emit('update:modelValue', current)
    emit('change', current)
}

const handleRemove = (opt, e) => {
    e.stopPropagation()
    const val = getOptionValue(opt)
    const current = props.modelValue.filter(v => v !== val)
    emit('update:modelValue', current)
    emit('change', current)
}

const handleClear = (e) => {
    e.stopPropagation()
    emit('update:modelValue', [])
    emit('change', [])
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
        case 'Backspace':
            if (!searchQuery.value && props.modelValue.length > 0) {
                const lastVal = props.modelValue[props.modelValue.length - 1]
                const lastOpt = props.options.find(opt => getOptionValue(opt) === lastVal)
                if (lastOpt) handleRemove(lastOpt, e)
            }
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

useClickOutside(containerRef, handleClose, { enabled: computed(() => isOpen.value) })
useEscapeKey(isOpen, handleClose)
</script>

<template>
    <div
        ref="containerRef"
        class="orp-multiselect"
        :class="{ 'orp-multiselect--open': isOpen, 'orp-multiselect--disabled': disabled }"
    >
        <div
            class="orp-multiselect__control"
            @click="handleToggle"
            @keydown="handleKeydown"
        >
            <div class="orp-multiselect__content">
                <div v-if="selectedOptions.length > 0" class="orp-multiselect__chips">
                    <span
                        v-for="opt in selectedOptions"
                        :key="getOptionValue(opt)"
                        class="orp-multiselect__chip"
                    >
                        <span class="orp-multiselect__chip-label">{{ getOptionLabel(opt) }}</span>
                        <button
                            type="button"
                            class="orp-multiselect__chip-remove"
                            :aria-label="`${removeLabel} ${getOptionLabel(opt)}`"
                            @click="handleRemove(opt, $event)"
                        >
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                        </button>
                    </span>
                </div>

                <input
                    v-if="searchable || selectedOptions.length === 0"
                    ref="inputRef"
                    type="text"
                    class="orp-multiselect__input"
                    :value="isOpen ? searchQuery : displayValue"
                    :placeholder="selectedOptions.length === 0 ? placeholder : ''"
                    :disabled="disabled"
                    :readonly="!searchable"
                    :aria-expanded="isOpen"
                    :aria-controls="isOpen ? 'multiselect-list' : undefined"
                    aria-autocomplete="list"
                    role="combobox"
                    autocomplete="off"
                    @input="handleSearch"
                    @focus="!isOpen && handleOpen()"
                >
            </div>

            <div class="orp-multiselect__actions">
                <button
                    v-if="clearable && modelValue.length > 0"
                    type="button"
                    class="orp-multiselect__clear"
                    aria-label="Clear selection"
                    @click="handleClear"
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>

                <span class="orp-multiselect__arrow" :class="{ 'orp-multiselect__arrow--open': isOpen }">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </span>
            </div>
        </div>

        <Teleport to="body">
            <Transition name="orp-multiselect">
                <div
                    v-if="isOpen"
                    id="multiselect-list"
                    ref="listRef"
                    class="orp-multiselect__dropdown"
                    role="listbox"
                    aria-multiselectable="true"
                    :aria-label="placeholder"
                >
                    <div v-if="filteredOptions.length === 0" class="orp-multiselect__empty">
                        {{ noResultsText }}
                    </div>

                    <div
                        v-for="(option, index) in filteredOptions"
                        :key="getOptionValue(option)"
                        :id="getOptionId(index)"
                        class="orp-multiselect__option"
                        :class="{
                            'orp-multiselect__option--active': index === activeIndex,
                            'orp-multiselect__option--selected': modelValue.includes(getOptionValue(option))
                        }"
                        role="option"
                        :aria-selected="modelValue.includes(getOptionValue(option))"
                        :data-active="index === activeIndex"
                        @click="handleSelect(option)"
                        @mouseenter="activeIndex = index"
                    >
                        <span class="orp-multiselect__checkbox">
                            <span v-if="modelValue.includes(getOptionValue(option))" class="orp-multiselect__check">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M20 6L9 17l-5-5"/>
                                </svg>
                            </span>
                        </span>
                        <span class="orp-multiselect__option-label">
                            {{ getOptionLabel(option) }}
                        </span>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
