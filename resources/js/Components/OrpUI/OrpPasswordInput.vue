<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Enter password'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    autocomplete: {
        type: String,
        default: 'current-password'
    },
    showToggle: {
        type: Boolean,
        default: true
    },
    visibilityLabel: {
        type: String,
        default: 'Show password'
    },
    hideLabel: {
        type: String,
        default: 'Hide password'
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const isVisible = ref(false)

const inputType = computed(() => isVisible.value ? 'text' : 'password')

const handleInput = (e) => {
    emit('update:modelValue', e.target.value)
    emit('change', e.target.value)
}

const toggleVisibility = () => {
    isVisible.value = !isVisible.value
}
</script>

<template>
    <div class="orp-password-input" :class="{ 'orp-password-input--disabled': disabled }">
        <input
            :type="inputType"
            class="orp-password-input__input"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :readonly="readonly"
            :autocomplete="autocomplete"
            @input="handleInput"
        >

        <button
            v-if="showToggle && !disabled && !readonly"
            type="button"
            class="orp-password-input__toggle"
            :aria-label="isVisible ? hideLabel : visibilityLabel"
            @click="toggleVisibility"
        >
            <svg v-if="isVisible" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
            <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </button>
    </div>
</template>
