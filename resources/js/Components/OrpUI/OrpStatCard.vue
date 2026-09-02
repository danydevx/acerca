<script setup>
defineProps({
    tag: {
        type: String,
        default: 'div'
    }
})
</script>

<template>
    <component
        :is="tag"
        class="orp-stat-card"
    >
        <div v-if="$slots.icon || $slots.label" class="orp-stat-card__header">
            <div v-if="$slots.icon" class="orp-stat-card__icon">
                <slot name="icon" />
            </div>
            <div v-if="$slots.label" class="orp-stat-card__label">
                <slot name="label" />
            </div>
        </div>

        <div v-if="$slots.value" class="orp-stat-card__value">
            <slot name="value" />
        </div>

        <div v-if="$slots.trend || $slots.meta" class="orp-stat-card__context">
            <slot name="trend" />
            <slot name="meta" />
        </div>

        <div v-if="$slots.visual" class="orp-stat-card__visual">
            <slot name="visual" />
        </div>

        <div v-if="$slots.actions" class="orp-stat-card__actions">
            <slot name="actions" />
        </div>

        <slot />
    </component>
</template>

<style lang="less">
@import '../../../less/orp-ui/_stat-card.less';
</style>
