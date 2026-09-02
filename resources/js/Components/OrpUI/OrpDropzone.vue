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
        default: 'Drop files here'
    },
    subtitle: {
        type: String,
        default: 'or click to browse'
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
const dragActive = ref(false)
const dragCounter = ref(0)

const inputId = computed(() => `orp-dropzone-${Math.random().toString(36).substr(2, 9)}`)

const onDragEnter = (e) => {
    e.preventDefault()
    dragCounter.value++
    if (!props.disabled) {
        dragActive.value = true
    }
}

const onDragLeave = (e) => {
    e.preventDefault()
    dragCounter.value--
    if (dragCounter.value === 0) {
        dragActive.value = false
    }
}

const onDragOver = (e) => {
    e.preventDefault()
}

const onDrop = (e) => {
    e.preventDefault()
    dragActive.value = false
    dragCounter.value = 0

    if (props.disabled) return

    const files = e.dataTransfer?.files
    if (files && files.length > 0) {
        handleFiles(files)
    }
}

const handleFiles = (files) => {
    error.value = ''

    if (props.multiple) {
        const fileArray = Array.from(files)
        validateAndEmit(fileArray)
    } else {
        const file = files[0]
        validateAndEmit([file])
    }
}

const validateAndEmit = (fileList) => {
    for (const file of fileList) {
        if (props.maxSize > 0 && file.size > props.maxSize * 1024 * 1024) {
            error.value = `File too large. Maximum size is ${props.maxSize}MB.`
            emit('invalid', { type: 'size', file })
            return
        }
    }

    fileName.value = fileList.length === 1 ? fileList[0].name : `${fileList.length} files`
    emit('change', props.multiple ? fileList : fileList[0])
}

const onChange = (e) => {
    const files = e.target.files
    if (files && files.length > 0) {
        handleFiles(files)
    }
    e.target.value = ''
}

const openPicker = () => {
    if (!props.disabled) {
        inputRef.value?.click()
    }
}
</script>

<template>
    <div class="orp-dropzone-wrapper">
        <div
            class="orp-dropzone"
            :class="{
                'orp-dropzone--disabled': disabled,
                'orp-dropzone--invalid': error,
                'orp-dropzone--compact': false
            }"
            :data-orp-drag-active="dragActive"
            @click="openPicker"
            @dragenter="onDragEnter"
            @dragleave="onDragLeave"
            @dragover="onDragOver"
            @drop="onDrop"
        >
            <input
                ref="inputRef"
                :id="inputId"
                type="file"
                class="orp-dropzone__input"
                :accept="accept"
                :multiple="multiple"
                :disabled="disabled"
                @change="onChange"
            >

            <div class="orp-dropzone__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
            </div>

            <div class="orp-dropzone__text">
                <div class="orp-dropzone__title">
                    <span v-if="fileName">{{ fileName }}</span>
                    <span v-else>{{ label }}</span>
                </div>
                <div class="orp-dropzone__subtitle">{{ subtitle }}</div>
            </div>

            <div v-if="help && !error" class="orp-dropzone__help">{{ help }}</div>
        </div>

        <div v-if="error" class="orp-dropzone__error">{{ error }}</div>
    </div>
</template>

<style scoped>
.orp-dropzone__input {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.orp-dropzone-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-2);
}

.orp-dropzone__error {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-danger);
}
</style>
