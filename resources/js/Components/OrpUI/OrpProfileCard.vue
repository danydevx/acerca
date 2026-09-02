<script setup>
defineProps({
    layout: {
        type: String,
        default: 'vertical',
        validator: (v) => ['vertical', 'horizontal'].includes(v)
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
        class="orp-profile-card"
        :class="{
            'orp-profile-card--horizontal': layout === 'horizontal',
            'orp-profile-card--disabled': disabled
        }"
    >
        <div v-if="$slots.media" class="orp-profile-card__media">
            <slot name="media" />
        </div>

        <div v-if="$slots.title || $slots.subtitle || $slots.meta || $slots.status || $slots.actions" class="orp-profile-card__body">
            <slot name="title" />
            <slot name="subtitle" />
            <slot name="meta" />
            <slot name="status" />
            <slot name="actions" />
        </div>

        <slot />
    </component>
</template>

<style lang="less">
@import '../../../less/orp-ui/_profile-card.less';
</style>
