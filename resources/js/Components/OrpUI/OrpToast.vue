<script setup>
import { ref, watch, onUnmounted } from 'vue'

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    message: {
        type: String,
        default: ''
    },
    variant: {
        type: String,
        default: 'default',
        validator: (v) => ['default', 'success', 'warning', 'danger'].includes(v)
    },
    duration: {
        type: Number,
        default: 3000
    },
    position: {
        type: String,
        default: 'bottom',
        validator: (v) => ['top', 'bottom'].includes(v)
    },
    closable: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['update:modelValue', 'close'])

const timer = ref(null)

const close = () => {
    emit('update:modelValue', false)
    emit('close')
}

const clearTimer = () => {
    if (timer.value) {
        clearTimeout(timer.value)
        timer.value = null
    }
}

watch(() => props.modelValue, (isOpen) => {
    clearTimer()
    if (isOpen && props.duration > 0) {
        timer.value = setTimeout(() => {
            close()
        }, props.duration)
    }
}, { immediate: true })

onUnmounted(() => {
    clearTimer()
})
</script>

<template>
    <Teleport to="body">
        <Transition name="orp-toast">
            <div
                v-if="modelValue"
                class="orp-toast"
                :class="[
                    `orp-toast--${variant}`,
                    `orp-toast--${position}`
                ]"
                :role="variant === 'danger' ? 'alert' : 'status'"
                :aria-live="variant === 'danger' ? 'assertive' : 'polite'"
                aria-atomic="true"
            >
                <div class="orp-toast__content">
                    <span class="orp-toast__message">{{ message }}</span>
                </div>

                <button
                    v-if="closable"
                    class="orp-toast__close"
                    aria-label="Close"
                    @click="close"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </Transition>
    </Teleport>
</template>
