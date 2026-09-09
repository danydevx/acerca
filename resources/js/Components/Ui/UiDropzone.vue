<template>
  <div class="ui-dropzone-wrapper">
    <div
      class="ui-dropzone dl-bulma-dropzone"
      :class="{
        'dl-bulma-dropzone--disabled': disabled,
        'dl-bulma-dropzone--invalid': error,
        'is-active': dragActive
      }"
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
        class="dl-bulma-dropzone__input"
        :accept="accept"
        :multiple="multiple"
        :disabled="disabled"
        @change="onChange"
      >

      <div class="dl-bulma-dropzone__icon">
        <i class="bi bi-cloud-arrow-up"></i>
      </div>

      <div class="dl-bulma-dropzone__text">
        <div class="dl-bulma-dropzone__title">
          <span v-if="fileName">{{ fileName }}</span>
          <span v-else>{{ label }}</span>
        </div>
        <div class="dl-bulma-dropzone__subtitle">{{ subtitle }}</div>
      </div>

      <div v-if="help && !error" class="dl-bulma-dropzone__help">{{ help }}</div>
    </div>

    <div v-if="error" class="dl-bulma-dropzone__error">{{ error }}</div>
  </div>
</template>

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

const inputId = computed(() => `dl-bulma-dropzone-${Math.random().toString(36).substr(2, 9)}`)

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

<style lang="scss" scoped>
.dl-bulma-dropzone {
  border: 2px dashed var(--bulma-border);
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  transition: all 0.2s;
  background: var(--bulma-scheme-main-bis);
  cursor: pointer;

  &:hover:not(.dl-bulma-dropzone--disabled) {
    border-color: var(--bulma-link);
    background: color-mix(in oklch, var(--bulma-link) 5%, var(--bulma-scheme-main));
  }

  &.is-active {
    border-color: var(--bulma-link);
    background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main));
  }

  &--disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  &--invalid {
    border-color: var(--bulma-danger);
  }

  &__input {
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

  &__icon {
    font-size: 2rem;
    color: var(--bulma-text-weak);
    margin-bottom: 0.5rem;
  }

  &__text {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  &__title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__subtitle {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__help {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__error {
    font-size: 0.875rem;
    color: var(--bulma-danger);
  }
}
</style>
