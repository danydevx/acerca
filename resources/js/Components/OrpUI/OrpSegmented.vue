<script setup>
const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    items: {
        type: Array,
        required: true
    },
    disabled: {
        type: Boolean,
        default: false
    },
    fullWidth: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const select = (value) => {
    if (props.disabled) return
    emit('update:modelValue', value)
    emit('change', value)
}
</script>

<template>
    <div
        class="orp-segmented"
        :class="{ 'orp-segmented--full': fullWidth }"
    >
        <button
            v-for="item in items"
            :key="item.value"
            type="button"
            class="orp-segmented__item"
            :class="{ 'orp-segmented__item--active': modelValue === item.value }"
            :disabled="disabled || item.disabled"
            @click="select(item.value)"
        >
            {{ item.label }}
        </button>
    </div>
</template>
