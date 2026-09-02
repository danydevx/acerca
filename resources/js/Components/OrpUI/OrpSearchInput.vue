<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Search...'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    clearable: {
        type: Boolean,
        default: true
    },
    autofocus: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'search', 'clear'])

const inputRef = ref(null)

const hasValue = computed(() => props.modelValue.length > 0)

const onInput = (e) => {
    emit('update:modelValue', e.target.value)
}

const onKeydown = (e) => {
    if (e.key === 'Escape' && hasValue.value && props.clearable) {
        emit('update:modelValue', '')
        emit('clear')
        e.preventDefault()
    } else if (e.key === 'Enter') {
        emit('search', props.modelValue)
    }
}

const clear = () => {
    emit('update:modelValue', '')
    emit('clear')
    inputRef.value?.focus()
}
</script>

<template>
    <div class="orp-search">
        <svg
            class="orp-search__icon"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
        >
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
        </svg>

        <input
            ref="inputRef"
            type="search"
            class="orp-search__input"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :autofocus="autofocus"
            @input="onInput"
            @keydown="onKeydown"
        >

        <button
            v-if="clearable && hasValue && !disabled"
            type="button"
            class="orp-search__clear"
            aria-label="Clear search"
            @click="clear"
        >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
    </div>
</template>
