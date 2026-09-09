<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        default: null
    },
    icon: {
        type: String,
        default: null
    }
})
</script>

<template>
    <div class="orp-empty" role="status">
        <div v-if="icon" class="orp-empty__media">
            <i :class="icon" />
        </div>
        <h3 class="orp-empty__title">{{ title }}</h3>
        <p v-if="description" class="orp-empty__description">{{ description }}</p>
        <div v-if="$slots.default" class="orp-empty__actions">
            <slot />
        </div>
    </div>
</template>
