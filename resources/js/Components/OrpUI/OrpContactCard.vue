<script setup>
defineProps({
    layout: {
        type: String,
        default: 'vertical',
        validator: (v) => ['vertical', 'horizontal'].includes(v)
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
        class="orp-contact-card"
        :class="{
            'orp-contact-card--horizontal': layout === 'horizontal'
        }"
    >
        <div v-if="$slots.title || $slots.subtitle || $slots.details || $slots.meta || $slots.actions" class="orp-contact-card__body">
            <slot name="title" />
            <slot name="subtitle" />
            <slot name="details" />
            <slot name="meta" />
            <slot name="actions" />
        </div>

        <div v-if="$slots.map" class="orp-contact-card__map">
            <slot name="map" />
        </div>

        <slot />
    </component>
</template>

<style lang="less">
@import '../../../less/orp-ui/_contact-card.less';
</style>
