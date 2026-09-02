<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    items: {
        type: Array,
        required: true
    },
    variant: {
        type: String,
        default: 'default',
        validator: (v) => ['default', 'pill', 'underline'].includes(v)
    },
    stretch: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'change'])

const select = (value) => {
    emit('update:modelValue', value)
    emit('change', value)
}

const handleKeydown = (e, index) => {
    const len = props.items.length

    if (e.key === 'ArrowRight') {
        e.preventDefault()
        const next = (index + 1) % len
        emit('update:modelValue', props.items[next].value)
    } else if (e.key === 'ArrowLeft') {
        e.preventDefault()
        const prev = (index - 1 + len) % len
        emit('update:modelValue', props.items[prev].value)
    } else if (e.key === 'Home') {
        e.preventDefault()
        emit('update:modelValue', props.items[0].value)
    } else if (e.key === 'End') {
        e.preventDefault()
        emit('update:modelValue', props.items[len - 1].value)
    }
}
</script>

<template>
    <div
        class="orp-tabs"
        :class="[
            `orp-tabs--${variant}`,
            { 'orp-tabs--stretch': stretch }
        ]"
    >
        <div
            class="orp-tabs__list"
            role="tablist"
        >
            <button
                v-for="(item, index) in items"
                :key="item.value"
                class="orp-tabs__item"
                :class="{ 'orp-tabs__item--active': modelValue === item.value }"
                role="tab"
                :aria-selected="modelValue === item.value"
                @click="select(item.value)"
                @keydown="handleKeydown($event, index)"
            >
                {{ item.label }}
            </button>
        </div>
    </div>
</template>
