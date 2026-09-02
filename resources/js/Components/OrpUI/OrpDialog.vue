<script setup>
import { ref, computed, watch } from 'vue'

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
    tone: {
        type: String,
        default: 'neutral',
        validator: (v) => ['neutral', 'info', 'success', 'warning', 'danger'].includes(v)
    },
    icon: {
        type: String,
        default: ''
    },
    size: {
        type: String,
        default: 'sm',
        validator: (v) => ['sm', 'md', 'lg'].includes(v)
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    },
    closeOnEscape: {
        type: Boolean,
        default: true
    },
    dismissible: {
        type: Boolean,
        default: true
    },
    verticalActions: {
        type: Boolean,
        default: false
    },
    showClose: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['update:modelValue', 'close', 'confirm', 'cancel'])

const isOpen = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

const dialogRef = ref(null)
const titleId = computed(() => `orp-dialog-title-${Math.random().toString(36).slice(2, 9)}`)
const descId = computed(() => `orp-dialog-desc-${Math.random().toString(36).slice(2, 9)}`)

const close = () => {
    if (!props.dismissible) return
    isOpen.value = false
    emit('close')
}

const confirm = (result) => {
    isOpen.value = false
    emit('confirm', result)
}

const cancel = () => {
    if (!props.dismissible) return
    isOpen.value = false
    emit('cancel')
}

const handleBackdropClick = () => {
    if (props.closeOnBackdrop) {
        close()
    }
}

const handleEscape = () => {
    if (props.closeOnEscape && props.dismissible) {
        close()
    }
}

const iconMap = {
    neutral: 'bi-info-circle',
    info: 'bi-info-circle',
    success: 'bi-check-circle',
    warning: 'bi-exclamation-triangle',
    danger: 'bi-x-circle'
}

const iconClass = computed(() => {
    if (props.icon) return props.icon
    return iconMap[props.tone] || iconMap.neutral
})

const hasHeader = computed(() => props.title || props.description || (props.showClose && props.dismissible))

watch(isOpen, (val) => {
    if (!val) {
        emit('close')
    }
})

defineExpose({ close, confirm, cancel })
</script>

<template>
    <Teleport to="body">
        <Transition name="orp-modal">
            <div
                v-if="isOpen"
                class="orp-modal"
                role="dialog"
                aria-modal="true"
                :aria-labelledby="title ? titleId : undefined"
                :aria-describedby="description ? descId : undefined"
                @click.self="handleBackdropClick"
                @keydown.esc="handleEscape"
            >
                <div class="orp-modal__backdrop" @click="handleBackdropClick" />

                <div
                    ref="dialogRef"
                    class="orp-modal__dialog orp-dialog"
                    :class="`orp-modal__dialog--${size}`"
                >
                    <div v-if="hasHeader" class="orp-dialog__header">
                        <div class="orp-dialog__header-content">
                            <div v-if="icon || tone !== 'neutral'" class="orp-dialog__icon" :class="`orp-dialog__icon--${tone}`">
                                <i :class="['bi', iconClass]" aria-hidden="true"></i>
                            </div>
                            <div class="orp-dialog__header-text">
                                <h2 v-if="title" :id="titleId" class="orp-dialog__title">{{ title }}</h2>
                                <p v-if="description" :id="descId" class="orp-dialog__description">{{ description }}</p>
                            </div>
                        </div>
                        <button
                            v-if="showClose && dismissible"
                            class="orp-dialog__close"
                            aria-label="Close"
                            @click="close"
                        >
                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="orp-dialog__body">
                        <slot />
                    </div>

                    <div
                        v-if="$slots.actions"
                        class="orp-dialog__actions"
                        :class="{ 'orp-dialog__actions--vertical': verticalActions }"
                    >
                        <slot name="actions" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
