<script setup>
import { ref } from 'vue'

defineProps({
    content: {
        type: String,
        required: true
    },
    placement: {
        type: String,
        default: 'top',
        validator: (v) => ['top', 'bottom', 'left', 'right'].includes(v)
    }
})

const show = ref(false)
</script>

<template>
    <div class="orp-tooltip" @mouseenter="show = true" @mouseleave="show = false" @focus="show = true" @blur="show = false">
        <div class="orp-tooltip__trigger">
            <slot />
        </div>
        <Teleport to="body">
            <Transition name="orp-tooltip-fade">
                <div v-if="show" class="orp-tooltip__content" :class="`orp-tooltip__content--${placement}`" role="tooltip">
                    {{ content }}
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style>
.orp-tooltip {
    display: inline-block;
    position: relative;
}

.orp-tooltip__trigger {
    display: inline-flex;
}

.orp-tooltip__content {
    position: absolute;
    z-index: var(--orp-z-tooltip, 1070);
    padding: var(--orp-space-1) var(--orp-space-2);
    background: var(--orp-tooltip-background, var(--orp-surface-foreground));
    color: var(--orp-tooltip-foreground, var(--orp-surface));
    font-size: var(--orp-font-size-xs);
    border-radius: var(--orp-radius-sm);
    white-space: nowrap;
    pointer-events: none;
}

.orp-tooltip__content--top {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-bottom: var(--orp-space-1);
}

.orp-tooltip__content--bottom {
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-top: var(--orp-space-1);
}

.orp-tooltip__content--left {
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-right: var(--orp-space-1);
}

.orp-tooltip__content--right {
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: var(--orp-space-1);
}

.orp-tooltip-fade-enter-active,
.orp-tooltip-fade-leave-active {
    transition: opacity var(--orp-duration-fast);
}

.orp-tooltip-fade-enter-from,
.orp-tooltip-fade-leave-to {
    opacity: 0;
}
</style>
