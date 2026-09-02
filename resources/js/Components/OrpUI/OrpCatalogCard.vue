<script setup>
defineProps({
    interactive: {
        type: Boolean,
        default: false
    },
    mediaRatio: {
        type: String,
        default: 'landscape',
        validator: (v) => ['square', 'portrait', 'landscape', 'wide'].includes(v)
    },
    tag: {
        type: String,
        default: 'div'
    }
})

const ratioClass = {
    square: 'orp-catalog-card__media--square',
    portrait: 'orp-catalog-card__media--portrait',
    landscape: 'orp-catalog-card__media--landscape',
    wide: 'orp-catalog-card__media--wide'
}
</script>

<template>
    <component
        :is="tag"
        class="orp-catalog-card"
        :class="{
            'orp-catalog-card--interactive': interactive
        }"
    >
        <div
            v-if="$slots.media"
            class="orp-catalog-card__media"
            :class="ratioClass[mediaRatio]"
        >
            <slot name="media" />
            <div v-if="$slots.overlay" class="orp-catalog-card__overlay">
                <slot name="overlay" />
            </div>
        </div>

        <div v-if="$slots.title || $slots.description || $slots.meta || $slots.value || $slots.actions" class="orp-catalog-card__body">
            <slot name="title" />

            <slot name="description" />

            <slot name="meta" />

            <slot name="value" />

            <slot name="actions" />
        </div>

        <slot />
    </component>
</template>

<style lang="less">
@import '../../../less/orp-ui/_catalog-card.less';
</style>
