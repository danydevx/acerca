<script setup>
defineProps({
    variant: {
        type: String,
        default: 'rect',
        validator: (v) => ['rect', 'circle', 'text'].includes(v)
    },
    width: {
        type: String,
        default: null
    },
    height: {
        type: String,
        default: null
    }
})
</script>

<template>
    <div
        class="orp-skeleton"
        :class="`orp-skeleton--${variant}`"
        :style="{ width, height }"
        aria-busy="true"
        aria-label="Loading content"
    />
</template>
