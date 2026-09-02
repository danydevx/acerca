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
    closeOnBackdrop: {
        type: Boolean,
        default: true
    },
    closeOnEscape: {
        type: Boolean,
        default: true
    },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['sm', 'md', 'lg'].includes(v)
    }
})

const emit = defineEmits(['update:modelValue', 'open', 'close'])

const isOpen = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

const dialogRef = ref(null)

const close = () => {
    isOpen.value = false
    emit('close')
}

useBodyScrollLock(isOpen)
useEscapeKey(isOpen, () => props.closeOnEscape && close())
useRestoreFocus(isOpen)
useFocusTrap(isOpen, dialogRef)

watch(isOpen, (val) => {
    if (val) {
        emit('open')
    }
})
</script>

<template>
    <Teleport to="body">
        <Transition name="orp-modal">
            <div
                v-if="isOpen"
                class="orp-modal"
                @click.self="closeOnBackdrop && close()"
            >
                <div
                    class="orp-modal__backdrop"
                    @click="closeOnBackdrop && close()"
                />

                <section
                    ref="dialogRef"
                    class="orp-modal__dialog"
                    :class="`orp-modal__dialog--${size}`"
                    role="dialog"
                    aria-modal="true"
                    :aria-labelledby="title ? 'orp-modal-title' : undefined"
                    :aria-describedby="description ? 'orp-modal-desc' : undefined"
                >
                    <header class="orp-modal__header">
                        <h2
                            v-if="title"
                            id="orp-modal-title"
                            class="orp-modal__title"
                        >
                            {{ title }}
                        </h2>

                        <button
                            class="orp-modal__close"
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
                        id="orp-modal-desc"
                        class="orp-modal__description"
                    >
                        {{ description }}
                    </p>

                    <div class="orp-modal__body">
                        <slot />
                    </div>

                    <footer v-if="$slots.footer" class="orp-modal__footer">
                        <slot name="footer" />
                    </footer>
                </section>
            </div>
        </Transition>
    </Teleport>
</template>
