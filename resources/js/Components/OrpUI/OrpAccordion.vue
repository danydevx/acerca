<script setup>
import { computed } from 'vue'

const props = defineProps({
    items: {
        type: Array,
        required: true
    },
    modelValue: {
        type: [String, Array],
        default: null
    },
    multiple: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const isOpen = (value) => {
    if (Array.isArray(props.modelValue)) {
        return props.modelValue.includes(value)
    }
    return props.modelValue === value
}

const toggle = (value) => {
    if (props.multiple) {
        const current = Array.isArray(props.modelValue) ? [...props.modelValue] : []
        const index = current.indexOf(value)
        if (index > -1) {
            current.splice(index, 1)
        } else {
            current.push(value)
        }
        emit('update:modelValue', current)
        emit('change', current)
    } else {
        const newValue = isOpen(value) ? null : value
        emit('update:modelValue', newValue)
        emit('change', newValue)
    }
}
</script>

<template>
    <div class="orp-accordion">
        <div
            v-for="item in items"
            :key="item.value"
            class="orp-accordion__item"
            :class="{ 'orp-accordion__item--open': isOpen(item.value) }"
        >
            <button
                class="orp-accordion__trigger"
                :aria-expanded="isOpen(item.value)"
                :aria-controls="`accordion-content-${item.value}`"
                @click="toggle(item.value)"
            >
                <span class="orp-accordion__title">{{ item.title }}</span>
                <svg
                    class="orp-accordion__icon"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <Transition name="orp-accordion">
                <div
                    v-show="isOpen(item.value)"
                    :id="`accordion-content-${item.value}`"
                    class="orp-accordion__content"
                >
                    <div class="orp-accordion__body">
                        {{ item.content }}
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>
