<script setup>
import { ref, computed, watch, onUnmounted } from 'vue'
import { useClickOutside } from '@/Composables/OrpUI/useClickOutside'
import { useEscapeKey } from '@/Composables/OrpUI/useEscapeKey'
import { usePositioning } from '@/Composables/OrpUI/usePositioning'
import { useRestoreFocus } from '@/Composables/OrpUI/useRestoreFocus'

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    placement: {
        type: String,
        default: 'bottom-start'
    },
    closeOnOutside: {
        type: Boolean,
        default: true
    },
    closeOnEscape: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['update:modelValue', 'close'])

const isOpen = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

const containerRef = ref(null)
const triggerRef = ref(null)
const contentRef = ref(null)
const contentId = computed(() => `orp-popover-content-${Math.random().toString(36).substr(2, 9)}`)

const close = () => {
    isOpen.value = false
    emit('close')
}

const { position, adjustedPlacement, compute } = usePositioning({ placement: props.placement })

const updatePosition = () => {
    if (isOpen.value && triggerRef.value && contentRef.value) {
        compute(triggerRef.value, contentRef.value)
    }
}

watch(isOpen, (open) => {
    if (open) {
        setTimeout(updatePosition, 0)
    }
})

useClickOutside(containerRef, close, { enabled: computed(() => isOpen.value && props.closeOnOutside) })
useEscapeKey(isOpen, () => props.closeOnEscape && close())
useRestoreFocus(isOpen)

let resizeHandler = null
let scrollHandler = null

watch(isOpen, (open) => {
    if (open) {
        resizeHandler = () => updatePosition()
        scrollHandler = () => updatePosition()
        window.addEventListener('resize', resizeHandler, { passive: true })
        window.addEventListener('scroll', scrollHandler, { passive: true })
    } else {
        if (resizeHandler) {
            window.removeEventListener('resize', resizeHandler)
            resizeHandler = null
        }
        if (scrollHandler) {
            window.removeEventListener('scroll', scrollHandler)
            scrollHandler = null
        }
    }
})

onUnmounted(() => {
    if (resizeHandler) window.removeEventListener('resize', resizeHandler)
    if (scrollHandler) window.removeEventListener('scroll', scrollHandler)
})
</script>

<template>
    <div ref="containerRef" class="orp-popover">
        <div
            ref="triggerRef"
            class="orp-popover__trigger"
            :aria-expanded="isOpen ? 'true' : 'false'"
            :aria-haspopup="'true'"
            :aria-controls="contentId"
            @click="isOpen = !isOpen"
        >
            <slot name="trigger" />
        </div>

        <Teleport to="body">
            <Transition name="orp-popover">
                <div
                    v-if="isOpen"
                    :id="contentId"
                    ref="contentRef"
                    class="orp-popover__content"
                    :class="`orp-popover__content--${adjustedPlacement}`"
                    :style="{ top: `${position.top}px`, left: `${position.left}px` }"
                    role="dialog"
                >
                    <slot />
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
