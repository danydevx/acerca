<script setup>
import { ref, computed, watch } from 'vue'
import { useBodyScrollLock } from '@/Composables/OrpUI/useBodyScrollLock'
import { useEscapeKey } from '@/Composables/OrpUI/useEscapeKey'
import { useRestoreFocus } from '@/Composables/OrpUI/useRestoreFocus'
import { useFocusTrap } from '@/Composables/OrpUI/useFocusTrap'

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    position: {
        type: String,
        default: 'left',
        validator: (v) => ['left', 'right', 'start', 'end'].includes(v)
    },
    title: {
        type: String,
        default: ''
    },
    description: {
        type: String,
        default: ''
    },
    closeOnBackdrop: {
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

const panelRef = ref(null)

const close = () => {
    isOpen.value = false
    emit('close')
}

useBodyScrollLock(isOpen)
useEscapeKey(isOpen, () => props.closeOnEscape && close())
useRestoreFocus(isOpen)
useFocusTrap(isOpen, panelRef)
</script>

<template>
    <Teleport to="body">
        <Transition name="orp-drawer">
            <div
                v-if="isOpen"
                class="orp-drawer"
                :class="`orp-drawer--${position}`"
            >
                <div
                    class="orp-drawer__backdrop"
                    @click="closeOnBackdrop && close()"
                />

                <aside
                    ref="panelRef"
                    class="orp-drawer__panel"
                    role="dialog"
                    aria-modal="true"
                    :aria-labelledby="title ? 'orp-drawer-title' : undefined"
                    :aria-describedby="description ? 'orp-drawer-desc' : undefined"
                >
                    <header class="orp-drawer__header">
                        <h2
                            v-if="title"
                            id="orp-drawer-title"
                            class="orp-drawer__title"
                        >
                            {{ title }}
                        </h2>

                        <button
                            class="orp-drawer__close"
                            aria-label="Close"
                            @click="close"
                        >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </header>

                    <p
                        v-if="description"
                        id="orp-drawer-desc"
                        class="orp-drawer__description"
                    >
                        {{ description }}
                    </p>

                    <div class="orp-drawer__body">
                        <slot />
                    </div>

                    <footer v-if="$slots.footer" class="orp-drawer__footer">
                        <slot name="footer" />
                    </footer>
                </aside>
            </div>
        </Transition>
    </Teleport>
</template>
