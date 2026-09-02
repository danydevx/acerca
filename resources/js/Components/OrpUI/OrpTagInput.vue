<script setup>
import { ref, computed, watch, nextTick } from 'vue'

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: 'Add tag...'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    separator: {
        type: String,
        default: null
    },
    max: {
        type: Number,
        default: null
    },
    removeLabel: {
        type: String,
        default: 'Remove'
    },
    duplicateError: {
        type: String,
        default: 'Duplicate tag'
    }
})

const emit = defineEmits(['update:modelValue', 'change', 'invalid'])

const inputRef = ref(null)
const inputValue = ref('')
const containerRef = ref(null)
const isFocused = ref(false)

const tags = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

const canAdd = computed(() => {
    if (props.disabled || props.readonly) return false
    if (!inputValue.value.trim()) return false
    if (props.max && tags.value.length >= props.max) return false
    return true
})

const addTag = () => {
    if (!canAdd.value) return

    let value = inputValue.value.trim()

    if (props.separator && value.includes(props.separator)) {
        const parts = value.split(props.separator).map(v => v.trim()).filter(v => v)
        parts.forEach(part => addSingleTag(part))
    } else {
        addSingleTag(value)
    }
}

const addSingleTag = (value) => {
    if (!value) return

    const trimmed = value.trim()
    if (!trimmed) return

    if (tags.value.some(t => t.toLowerCase() === trimmed.toLowerCase())) {
        emit('invalid', { type: 'duplicate', value: trimmed })
        return
    }

    tags.value = [...tags.value, trimmed]
    emit('change', tags.value)
    inputValue.value = ''
    nextTick(() => inputRef.value?.focus())
}

const removeTag = (index) => {
    if (props.disabled || props.readonly) return
    const newTags = [...tags.value]
    newTags.splice(index, 1)
    tags.value = newTags
    emit('change', tags.value)
}

const handleKeydown = (e) => {
    if (props.disabled || props.readonly) return

    switch (e.key) {
        case 'Enter':
            e.preventDefault()
            addTag()
            break
        case 'Backspace':
            if (!inputValue.value && tags.value.length > 0) {
                removeTag(tags.value.length - 1)
            }
            break
        case ',':
            if (props.separator === ',') {
                e.preventDefault()
                addTag()
            }
            break
    }
}

const handleInput = (e) => {
    inputValue.value = e.target.value
}

const handlePaste = (e) => {
    if (!props.separator) return

    const pasted = e.clipboardData.getData('text')
    if (pasted.includes(props.separator)) {
        e.preventDefault()
        const parts = pasted.split(props.separator).map(v => v.trim()).filter(v => v)
        parts.forEach(part => addSingleTag(part))
    }
}

const handleFocus = () => {
    isFocused.value = true
}

const handleBlur = () => {
    isFocused.value = false
    if (inputValue.value.trim()) {
        addTag()
    }
}

const handleContainerClick = () => {
    inputRef.value?.focus()
}
</script>

<template>
    <div
        ref="containerRef"
        class="orp-tag-input"
        :class="{
            'orp-tag-input--disabled': disabled,
            'orp-tag-input--readonly': readonly,
            'orp-tag-input--focused': isFocused
        }"
        @click="handleContainerClick"
    >
        <div class="orp-tag-input__content">
            <span
                v-for="(tag, index) in tags"
                :key="tag"
                class="orp-tag-input__tag"
            >
                <span class="orp-tag-input__tag-label">{{ tag }}</span>
                <button
                    v-if="!disabled && !readonly"
                    type="button"
                    class="orp-tag-input__tag-remove"
                    :aria-label="`${removeLabel} ${tag}`"
                    @click.stop="removeTag(index)"
                >
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>
            </span>

            <input
                v-if="!disabled && !readonly"
                ref="inputRef"
                type="text"
                class="orp-tag-input__input"
                :value="inputValue"
                :placeholder="tags.length === 0 ? placeholder : ''"
                :disabled="disabled"
                :aria-label="placeholder"
                autocomplete="off"
                @input="handleInput"
                @keydown="handleKeydown"
                @paste="handlePaste"
                @focus="handleFocus"
                @blur="handleBlur"
            >
            <span v-else-if="tags.length === 0" class="orp-tag-input__placeholder">
                {{ placeholder }}
            </span>
        </div>
    </div>
</template>
