<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    length: {
        type: Number,
        default: 6
    },
    type: {
        type: String,
        default: 'text',
        validator: (v) => ['text', 'password', 'number'].includes(v)
    },
    placeholder: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    readonly: {
        type: Boolean,
        default: false
    },
    invalid: {
        type: Boolean,
        default: false
    },
    autocomplete: {
        type: String,
        default: 'one-time-code'
    }
})

const emit = defineEmits(['update:modelValue', 'change', 'complete'])

const inputs = ref([])
const containerRef = ref(null)

const digits = computed(() => {
    const value = props.modelValue || ''
    const arr = value.split('').slice(0, props.length)
    while (arr.length < props.length) {
        arr.push('')
    }
    return arr
})

const focusIndex = ref(-1)

const getInputProps = (index) => {
    const inputmode = props.type === 'number' ? 'numeric' : 'text'
    return {
        type: props.type === 'password' ? 'password' : 'text',
        inputmode,
        maxlength: 1,
        placeholder: index === 0 && props.placeholder ? props.placeholder : '',
        disabled: props.disabled,
        readonly: props.readonly,
        'aria-label': `Digit ${index + 1}`,
        autocomplete: index === 0 ? props.autocomplete : 'off'
    }
}

const handleInput = (index, e) => {
    const value = e.target.value

    if (value === '' || value === undefined) return

    const char = value.slice(-1)

    if (!/^[a-zA-Z0-9]$/.test(char) && props.type !== 'password') return

    updateDigit(index, char)
}

const updateDigit = (index, char) => {
    const currentDigits = props.modelValue ? props.modelValue.split('') : []
    currentDigits[index] = char

    const newValue = currentDigits.slice(0, props.length).join('')
    emit('update:modelValue', newValue)
    emit('change', newValue)

    if (newValue.length === props.length) {
        emit('complete', newValue)
    } else if (index < props.length - 1) {
        nextTick(() => focusInput(index + 1))
    }
}

const handleKeydown = (index, e) => {
    switch (e.key) {
        case 'ArrowLeft':
            e.preventDefault()
            if (index > 0) focusInput(index - 1)
            break
        case 'ArrowRight':
            e.preventDefault()
            if (index < props.length - 1) focusInput(index + 1)
            break
        case 'Backspace':
            e.preventDefault()
            if (digits.value[index]) {
                const newDigits = [...digits.value]
                newDigits[index] = ''
                const newValue = newDigits.join('')
                emit('update:modelValue', newValue)
                emit('change', newValue)
            } else if (index > 0) {
                focusInput(index - 1)
                const newDigits = [...digits.value]
                newDigits[index - 1] = ''
                const newValue = newDigits.join('')
                emit('update:modelValue', newValue)
                emit('change', newValue)
            }
            break
        case 'Delete':
            e.preventDefault()
            if (digits.value[index]) {
                const newDigits = [...digits.value]
                newDigits[index] = ''
                const newValue = newDigits.join('')
                emit('update:modelValue', newValue)
                emit('change', newValue)
            }
            break
    }
}

const handlePaste = (e) => {
    e.preventDefault()
    const pasted = e.clipboardData.getData('text').slice(0, props.length)

    if (props.type === 'password') {
        const chars = pasted.split('').slice(0, props.length)
        chars.forEach((char, i) => {
            updateDigit(i, char)
        })
        return
    }

    const filtered = pasted.split('').filter(c => /^[a-zA-Z0-9]$/.test(c)).slice(0, props.length)
    if (filtered.length === 0) return

    const newValue = [...digits.value]
    filtered.forEach((char, i) => {
        if (i < props.length) newValue[i] = char
    })

    const value = newValue.join('')
    emit('update:modelValue', value)
    emit('change', value)

    const lastIndex = Math.min(filtered.length, props.length) - 1
    nextTick(() => focusInput(lastIndex))
}

const handleFocus = (index) => {
    focusIndex.value = index
}

const handleBlur = () => {
    focusIndex.value = -1
}

const focusInput = (index) => {
    if (index < 0 || index >= props.length) return
    inputs.value[index]?.focus()
}

const focusFirstEmpty = () => {
    const emptyIndex = digits.value.findIndex(d => !d)
    const indexToFocus = emptyIndex >= 0 ? emptyIndex : 0
    focusInput(indexToFocus)
}

defineExpose({
    focus: focusFirstEmpty,
    focusInput
})
</script>

<template>
    <div
        ref="containerRef"
        class="orp-otp-input"
        :class="{
            'orp-otp-input--disabled': disabled,
            'orp-otp-input--invalid': invalid,
            'orp-otp-input--filled': modelValue && modelValue.length > 0
        }"
        role="group"
        :aria-label="`One-time code, ${length} digits`"
    >
        <input
            v-for="(digit, index) in digits"
            :key="index"
            :ref="el => inputs[index] = el"
            class="orp-otp-input__digit"
            :class="{ 'orp-otp-input__digit--active': focusIndex === index }"
            :value="digit"
            v-bind="getInputProps(index)"
            @input="handleInput(index, $event)"
            @keydown="handleKeydown(index, $event)"
            @paste="handlePaste"
            @focus="handleFocus(index)"
            @blur="handleBlur"
        >
    </div>
</template>
