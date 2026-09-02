<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    accept: {
        type: String,
        default: ''
    },
    multiple: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    label: {
        type: String,
        default: 'Choose file'
    },
    help: {
        type: String,
        default: ''
    },
    maxSize: {
        type: Number,
        default: 0
    }
})

const emit = defineEmits(['change', 'invalid'])

const inputRef = ref(null)
const fileName = ref('')
const error = ref('')

const inputId = computed(() => `orp-file-${Math.random().toString(36).substr(2, 9)}`)

const onChange = (e) => {
    error.value = ''
    const files = e.target.files

    if (!files || files.length === 0) return

    const file = props.multiple ? files[0] : files[0]

    if (props.maxSize > 0 && file.size > props.maxSize * 1024 * 1024) {
        error.value = `File too large. Maximum size is ${props.maxSize}MB.`
        emit('invalid', { type: 'size', file })
        return
    }

    fileName.value = file.name
    emit('change', file)
}

const openPicker = () => {
    inputRef.value?.click()
}
</script>

<template>
    <div class="orp-file">
        <input
            ref="inputRef"
            :id="inputId"
            type="file"
            class="orp-file__input"
            :accept="accept"
            :multiple="multiple"
            :disabled="disabled"
            @change="onChange"
        >

        <div
            class="orp-file__dropzone"
            :class="{ 'orp-file__dropzone--disabled': disabled }"
            @click="openPicker"
        >
            <div class="orp-file__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
            </div>

            <div class="orp-file__label">
                <span v-if="fileName">{{ fileName }}</span>
                <span v-else>{{ label }}</span>
            </div>
        </div>

        <div v-if="help && !error" class="orp-file__help">{{ help }}</div>
        <div v-if="error" class="orp-file__error">{{ error }}</div>
    </div>
</template>
