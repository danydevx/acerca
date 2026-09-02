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
    title: {
        type: String,
        default: ''
    },
    description: {
        type: String,
        default: ''
    },
    showHandle: {
        type: Boolean,
        default: true
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    },
    closeOnEscape: {
        type: Boolean,
        default: true
    },
    height: {
        type: String,
        default: 'auto',
        validator: (v) => ['auto', 'half', 'large'].includes(v)
    }
})

const emit = defineEmits(['update:modelValue', 'open', 'close'])

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

watch(isOpen, (val) => {
    if (val) {
        emit('open')
    }
})
</script>

<template>
    <Teleport to="body">
        <Transition name="orp-sheet">
            <div
                v-if="isOpen"
                class="orp-sheet"
                @click.self="closeOnBackdrop && close()"
            >
                <div
                    class="orp-sheet__backdrop"
                    @click="closeOnBackdrop && close()"
                />

                <section
                    ref="panelRef"
                    class="orp-sheet__panel"
                    :class="`orp-sheet__panel--${height}`"
                    role="dialog"
                    aria-modal="true"
                    :aria-labelledby="title ? 'orp-sheet-title' : undefined"
                    :aria-describedby="description ? 'orp-sheet-desc' : undefined"
                >
                    <div v-if="showHandle" class="orp-sheet__handle" />

                    <header class="orp-sheet__header">
                        <h2
                            v-if="title"
                            id="orp-sheet-title"
                            class="orp-sheet__title"
                        >
                            {{ title }}
                        </h2>

                        <button
                            class="orp-sheet__close"
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
                        id="orp-sheet-desc"
                        class="orp-sheet__description"
                    >
                        {{ description }}
                    </p>

                    <div class="orp-sheet__body">
                        <slot />
                    </div>

                    <footer v-if="$slots.footer" class="orp-sheet__footer">
                        <slot name="footer" />
                    </footer>
                </section>
            </div>
        </Transition>
    </Teleport>
</template>
