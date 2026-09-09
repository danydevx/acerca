<template>
  <div class="ui-file-input dl-bulma-file-input" :class="{ 'is-dragover': isDragover, 'has-error': error }">
    <input
      ref="inputRef"
      :accept="accept"
      :multiple="multiple"
      class="dl-bulma-file-input__input"
      type="file"
      @change="handleChange"
      @dragover.prevent="isDragover = true"
      @dragleave.prevent="isDragover = false"
      @drop.prevent="handleDrop"
    >
    <div class="dl-bulma-file-input__content is-clickable" @click="inputRef.click()">
      <i class="bi bi-cloud-arrow-up dl-bulma-file-input__icon is-size-2"></i>
      <p class="dl-bulma-file-input__text is-size-7">
        <span v-if="!selectedFiles.length">Drag and drop or <u>browse</u></span>
        <span v-else>{{ selectedFiles.length }} file(s) selected</span>
      </p>
      <p v-if="accept" class="dl-bulma-file-input__hint is-size-7 has-text-grey">{{ accept }}</p>
    </div>
    <div v-if="selectedFiles.length" class="dl-bulma-file-input__files">
      <div v-for="(file, index) in selectedFiles" :key="index" class="dl-bulma-file-input__file is-flex is-align-items-center">
        <i class="bi bi-file-earmark has-text-grey"></i>
        <span class="is-flex-grow-1 pl-2">{{ file.name }}</span>
        <button class="dl-bulma-file-input__remove" @click.stop="removeFile(index)">
          <i class="bi bi-x"></i>
        </button>
      </div>
    </div>
    <p v-if="error" class="dl-bulma-file-input__error is-size-7">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  modelValue: { type: Array, default: () => [] },
  accept: { type: String, default: null },
  multiple: { type: Boolean, default: false },
  error: { type: String, default: '' },
})

const emit = defineEmits(['update:modelValue'])

const inputRef = ref(null)
const isDragover = ref(false)
const selectedFiles = ref([])

const handleChange = (e) => {
  const files = Array.from(e.target.files)
  updateFiles(files)
}

const handleDrop = (e) => {
  isDragover.value = false
  const files = Array.from(e.dataTransfer.files)
  updateFiles(files)
}

const updateFiles = (files) => {
  selectedFiles.value = files
  emit('update:modelValue', files)
}

const removeFile = (index) => {
  selectedFiles.value.splice(index, 1)
  emit('update:modelValue', selectedFiles.value)
}
</script>

<style lang="scss" scoped>
.dl-bulma-file-input {
  border: 2px dashed var(--bulma-border);
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  transition: all 0.2s;
  background: var(--bulma-scheme-main-bis);

  &.is-dragover {
    border-color: var(--bulma-link);
    background: color-mix(in oklch, var(--bulma-link) 10%, var(--bulma-scheme-main));
  }

  &.has-error {
    border-color: var(--bulma-danger);
  }

  &__input {
    display: none;
  }

  &__icon {
    color: var(--bulma-text-weak);
    margin-bottom: 0.5rem;
  }

  &__text {
    color: var(--bulma-text-weak);
    margin: 0;

    u {
      color: var(--bulma-link);
    }
  }

  &__hint {
    margin: 0.5rem 0 0;
  }

  &__files {
    margin-top: 1rem;
    text-align: left;
  }

  &__file {
    padding: 0.5rem;
    background: var(--bulma-scheme-main);
    border-radius: 6px;
    margin-bottom: 0.5rem;
    color: var(--bulma-text);
  }

  &__remove {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--bulma-text-weak);
    padding: 0.25rem;
    border-radius: 4px;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-danger);
    }
  }

  &__error {
    color: var(--bulma-danger);
    margin: 0.5rem 0 0;
  }
}
</style>
