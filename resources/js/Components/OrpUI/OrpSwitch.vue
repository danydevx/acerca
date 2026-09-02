<script setup>
const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    label: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    name: {
        type: String,
        default: ''
    },
    value: {
        type: String,
        default: '1'
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const toggle = (e) => {
    if (props.disabled) return
    const newValue = e.target.checked
    emit('update:modelValue', newValue)
    emit('change', newValue)
}
</script>

<template>
    <label class="orp-switch" :class="{ 'orp-switch--disabled': disabled }">
        <input
            type="checkbox"
            class="orp-switch__input"
            role="switch"
            :aria-checked="modelValue"
            :checked="modelValue"
            :disabled="disabled"
            :name="name"
            :value="value"
            @change="toggle"
        >

        <span class="orp-switch__control">
            <span class="orp-switch__thumb" />
        </span>

        <span v-if="label" class="orp-switch__label">
            {{ label }}
        </span>
    </label>
</template>
