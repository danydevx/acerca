<script setup>
import { computed } from 'vue'
import { OrpSheet } from '@/orp-ui'

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    actions: {
        type: Array,
        default: () => []
    },
    cancelLabel: {
        type: String,
        default: 'Cancel'
    },
    showCancel: {
        type: Boolean,
        default: true
    },
    closeOnSelect: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['update:modelValue', 'select', 'cancel'])

const close = () => {
    emit('update:modelValue', false)
}

const onSelect = (action) => {
    if (action.disabled) return
    emit('select', action)
    if (props.closeOnSelect) {
        close()
    }
}

const onCancel = () => {
    emit('cancel')
    close()
}
</script>

<template>
    <OrpSheet
        :model-value="modelValue"
        :title="title"
        height="auto"
        @update:model-value="$emit('update:modelValue', $event)"
        @close="close"
    >
        <div class="orp-action-sheet">
            <div
                class="orp-action-sheet__group"
                role="menu"
            >
                <button
                    v-for="action in actions"
                    :key="action.value"
                    type="button"
                    role="menuitem"
                    class="orp-action-sheet__item"
                    :class="{ 'orp-action-sheet__item--danger': action.variant === 'danger', 'orp-action-sheet__item--disabled': action.disabled }"
                    :disabled="action.disabled"
                    :aria-disabled="action.disabled || undefined"
                    @click="onSelect(action)"
                >
                    {{ action.label }}
                </button>
            </div>

            <button
                v-if="showCancel"
                type="button"
                class="orp-action-sheet__cancel"
                @click="onCancel"
            >
                {{ cancelLabel }}
            </button>
        </div>
    </OrpSheet>
</template>
