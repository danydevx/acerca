<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: [Number, String],
        default: null
    },
    min: {
        type: Number,
        default: null
    },
    max: {
        type: Number,
        default: null
    },
    step: {
        type: Number,
        default: 1
    },
    disabled: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    placeholder: {
        type: String,
        default: '0'
    },
    incrementLabel: {
        type: String,
        default: 'Increment'
    },
    decrementLabel: {
        type: String,
        default: 'Decrement'
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const inputRef = ref(null)

const numericValue = computed({
    get: () => props.modelValue,
    set: (val) => {
        if (val === '' || val === null || val === undefined) {
            emit('update:modelValue', null)
            emit('change', null)
            return
        }
        const num = parseFloat(val)
        if (!isNaN(num)) {
            emit('update:modelValue', num)
            emit('change', num)
        }
    }
})

const canDecrement = computed(() => {
    if (props.disabled || props.readonly) return false
    if (props.min === null || props.min === undefined) return true
    const current = parseFloat(props.modelValue)
    if (isNaN(current)) return true
    return current > props.min
})

const canIncrement = computed(() => {
    if (props.disabled || props.readonly) return false
    if (props.max === null || props.max === undefined) return true
    const current = parseFloat(props.modelValue)
    if (isNaN(current)) return true
    return current < props.max
})

const decrement = () => {
    if (!canDecrement.value) return

    let current = parseFloat(props.modelValue)
    if (isNaN(current)) current = 0

    let newValue = current - props.step

    if (props.min !== null && props.min !== undefined && newValue < props.min) {
        newValue = props.min
    }

    const precision = getPrecision(props.step)
    newValue = parseFloat(newValue.toFixed(precision))

    emit('update:modelValue', newValue)
    emit('change', newValue)
}

const increment = () => {
    if (!canIncrement.value) return

    let current = parseFloat(props.modelValue)
    if (isNaN(current)) current = 0

    let newValue = current + props.step

    if (props.max !== null && props.max !== undefined && newValue > props.max) {
        newValue = props.max
    }

    const precision = getPrecision(props.step)
    newValue = parseFloat(newValue.toFixed(precision))

    emit('update:modelValue', newValue)
    emit('change', newValue)
}

const getPrecision = (num) => {
    const str = num.toString()
    const dotIndex = str.indexOf('.')
    if (dotIndex === -1) return 0
    return str.length - dotIndex - 1
}

const handleInput = (e) => {
    const val = e.target.value
    if (val === '') {
        numericValue.value = null
        return
    }
    numericValue.value = val
}

const handleKeydown = (e) => {
    if (e.key === 'ArrowUp') {
        e.preventDefault()
        increment()
    } else if (e.key === 'ArrowDown') {
        e.preventDefault()
        decrement()
    }
}
</script>

<template>
    <div
        class="orp-number-stepper"
        :class="{ 'orp-number-stepper--disabled': disabled }"
    >
        <button
            type="button"
            class="orp-number-stepper__btn orp-number-stepper__btn--decrement"
            :disabled="!canDecrement"
            :aria-label="decrementLabel"
            @click="decrement"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </button>

        <input
            ref="inputRef"
            type="number"
            class="orp-number-stepper__input"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :readonly="readonly"
            :min="min"
            :max="max"
            :step="step"
            inputmode="numeric"
            @input="handleInput"
            @keydown="handleKeydown"
        >

        <button
            type="button"
            class="orp-number-stepper__btn orp-number-stepper__btn--increment"
            :disabled="!canIncrement"
            :aria-label="incrementLabel"
            @click="increment"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </button>
    </div>
</template>
