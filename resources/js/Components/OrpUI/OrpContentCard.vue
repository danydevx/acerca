<script setup>
defineProps({
    layout: {
        type: String,
        default: 'vertical',
        validator: (v) => ['vertical', 'horizontal'].includes(v)
    },
    mediaRatio: {
        type: String,
        default: 'landscape',
        validator: (v) => ['square', 'portrait', 'landscape', 'wide', 'auto'].includes(v)
    },
    interactive: {
        type: Boolean,
        default: false
    },
    tag: {
        type: String,
        default: 'div'
    }
})

const ratioClass = {
    square: 'orp-content-card__media--square',
    portrait: 'orp-content-card__media--portrait',
    landscape: 'orp-content-card__media--landscape',
    wide: 'orp-content-card__media--wide',
    auto: 'orp-content-card__media--auto'
}
</script>

<template>
    <component
        :is="tag"
        class="orp-content-card"
        :class="{
            'orp-content-card--horizontal': layout === 'horizontal',
            'orp-content-card--interactive': interactive
        }"
    >
        <div
            v-if="$slots.media"
            class="orp-content-card__media"
            :class="ratioClass[mediaRatio]"
        >
            <slot name="media" />
        </div>

        <div v-if="$slots.eyebrow || $slots.title || $slots.excerpt || $slots.meta || $slots.byline || $slots.actions" class="orp-content-card__body">
            <slot name="eyebrow" />

            <slot name="title" />

            <slot name="excerpt" />

            <slot name="meta" />

            <slot name="byline" />

            <slot name="actions" />
        </div>

        <slot />
    </component>
</template>

<style lang="less">
@import '../../../less/orp-ui/_content-card.less';
</style>
