<script setup>
defineProps({
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v)
    },
    label: {
        type: String,
        default: 'Loading'
    }
})
</script>

<template>
    <div class="orp-spinner" :class="`orp-spinner--${size}`" role="status" :aria-label="label">
        <span class="orp-sr-only">{{ label }}</span>
    </div>
</template>
