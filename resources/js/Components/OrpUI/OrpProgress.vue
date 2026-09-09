<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: Number,
        default: 0
    },
    min: {
        type: Number,
        default: 0
    },
    max: {
        type: Number,
        default: 100
    },
    variant: {
        type: String,
        default: 'primary',
        validator: (v) => ['primary', 'success', 'warning', 'danger'].includes(v)
    },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v)
    },
    indeterminate: {
        type: Boolean,
        default: false
    },
    label: {
        type: String,
        default: null
    }
})

const percentage = computed(() => {
    if (props.indeterminate) return 0
    return Math.min(100, Math.max(0, ((props.modelValue - props.min) / (props.max - props.min)) * 100))
})
</script>

<template>
    <div
        class="orp-progress"
        :class="[`orp-progress--${size}`, { 'orp-progress--indeterminate': indeterminate }]"
        role="progressbar"
        :aria-valuenow="indeterminate ? undefined : modelValue"
        :aria-valuemin="min"
        :aria-valuemax="max"
        :aria-label="label"
    >
        <div
            class="orp-progress__bar"
            :class="`orp-progress__bar--${variant}`"
            :style="{ width: percentage + '%' }"
        />
    </div>
</template>
