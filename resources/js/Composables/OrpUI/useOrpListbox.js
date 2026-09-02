import { ref, computed, watch, onUnmounted } from 'vue'

export function useOrpListbox({
    options = ref([]),
    modelValue = ref(null),
    optionLabel = 'label',
    optionValue = 'value',
    searchable = ref(false),
    multiple = ref(false)
} = {}) {
    const isOpen = ref(false)
    const activeIndex = ref(-1)
    const searchQuery = ref('')
    const containerRef = ref(null)

    const filteredOptions = computed(() => {
        if (!searchable.value || !searchQuery.value) {
            return options.value
        }
        const query = searchQuery.value.toLowerCase()
        return options.value.filter(opt => {
            const label = typeof opt === 'object' ? opt[optionLabel] : opt
            return String(label).toLowerCase().includes(query)
        })
    })

    const selectedValue = computed({
        get: () => modelValue.value,
        set: (val) => {
            modelValue.value = val
        }
    })

    const selectedOption = computed(() => {
        if (!modelValue.value) return null
        if (multiple.value && Array.isArray(modelValue.value)) {
            return modelValue.value.map(v =>
                options.value.find(opt =>
                    (typeof opt === 'object' ? opt[optionValue] : opt) === v
                )
            ).filter(Boolean)
        }
        return options.value.find(opt =>
            (typeof opt === 'object' ? opt[optionValue] : opt) === modelValue.value
        )
    })

    const getOptionLabel = (opt) => {
        return typeof opt === 'object' ? opt[optionLabel] : opt
    }

    const getOptionValue = (opt) => {
        return typeof opt === 'object' ? opt[optionValue] : opt
    }

    const isSelected = (opt) => {
        const val = getOptionValue(opt)
        if (multiple.value && Array.isArray(modelValue.value)) {
            return modelValue.value.includes(val)
        }
        return modelValue.value === val
    }

    const open = () => {
        isOpen.value = true
        if (activeIndex.value === -1 && filteredOptions.value.length > 0) {
            activeIndex.value = 0
        }
    }

    const close = () => {
        isOpen.value = false
        activeIndex.value = -1
        searchQuery.value = ''
    }

    const toggle = () => {
        if (isOpen.value) close()
        else open()
    }

    const select = (opt) => {
        const val = getOptionValue(opt)
        if (multiple.value) {
            const current = Array.isArray(modelValue.value) ? [...modelModelValue.value] : []
            const idx = current.indexOf(val)
            if (idx > -1) {
                current.splice(idx, 1)
            } else {
                current.push(val)
            }
            modelValue.value = current
        } else {
            modelValue.value = val
            close()
        }
    }

    const handleKeydown = (e) => {
        if (!isOpen.value) {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault()
                open()
            }
            return
        }

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault()
                if (activeIndex.value < filteredOptions.value.length - 1) {
                    activeIndex.value++
                }
                break
            case 'ArrowUp':
                e.preventDefault()
                if (activeIndex.value > 0) {
                    activeIndex.value--
                }
                break
            case 'Enter':
                e.preventDefault()
                if (activeIndex.value >= 0 && filteredOptions.value[activeIndex.value]) {
                    select(filteredOptions.value[activeIndex.value])
                }
                break
            case 'Escape':
                e.preventDefault()
                close()
                break
            case 'Home':
                e.preventDefault()
                activeIndex.value = 0
                break
            case 'End':
                e.preventDefault()
                activeIndex.value = filteredOptions.value.length - 1
                break
        }
    }

    const handleSearch = (query) => {
        if (searchable.value) {
            searchQuery.value = query
            activeIndex.value = 0
        }
    }

    return {
        isOpen,
        activeIndex,
        searchQuery,
        filteredOptions,
        selectedValue,
        selectedOption,
        containerRef,
        getOptionLabel,
        getOptionValue,
        isSelected,
        open,
        close,
        toggle,
        select,
        handleKeydown,
        handleSearch
    }
}
