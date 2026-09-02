<script setup>
defineProps({
    variant: {
        type: String,
        default: 'ghost',
        validator: (v) => ['primary', 'ghost', 'danger'].includes(v)
    },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v)
    },
    disabled: {
        type: Boolean,
        default: false
    },
    ariaLabel: {
        type: String,
        default: ''
    }
})
</script>

<template>
    <button
        class="orp-icon-btn"
        :class="[
            `orp-icon-btn--${variant}`,
            `orp-icon-btn--${size}`
        ]"
        :disabled="disabled"
        :aria-label="ariaLabel"
    >
        <slot />
    </button>
</template>
