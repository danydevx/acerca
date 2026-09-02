<script setup>
defineProps({
    emphasized: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    tag: {
        type: String,
        default: 'div'
    }
})
</script>

<template>
    <component
        :is="tag"
        class="orp-pricing-card"
        :class="{
            'orp-pricing-card--emphasized': emphasized,
            'orp-pricing-card--disabled': disabled
        }"
    >
        <div v-if="$slots.eyebrow" class="orp-pricing-card__eyebrow">
            <slot name="eyebrow" />
        </div>

        <div v-if="$slots.title || $slots.description" class="orp-pricing-card__header">
            <slot name="title" />
            <slot name="description" />
        </div>

        <div v-if="$slots.value || $slots.valueMeta" class="orp-pricing-card__value-section">
            <slot name="value" />
            <slot name="valueMeta" />
        </div>

        <div v-if="$slots.features" class="orp-pricing-card__features">
            <slot name="features" />
        </div>

        <div v-if="$slots.actions" class="orp-pricing-card__actions">
            <slot name="actions" />
        </div>

        <slot />
    </component>
</template>

<style lang="less">
@import '../../../less/orp-ui/_pricing-card.less';
</style>
