<template>
  <div class="image-input" :class="{ 'has-error': error }">
    <div v-if="!modelValue" class="image-input__placeholder" @click="triggerInput">
      <i class="bi bi-image"></i>
      <span>Click to select image</span>
    </div>

    <div v-else class="image-input__preview">
      <img :src="modelValue" :alt="alt">
      <div class="image-input__overlay">
        <button class="image-input__btn image-input__btn--light" @click="triggerInput">
          <i class="bi bi-arrow-repeat"></i>
        </button>
        <button v-if="removable" class="image-input__btn image-input__btn--danger" @click="removeImage">
          <i class="bi bi-trash"></i>
        </button>
      </div>
    </div>

    <input
      ref="inputRef"
      type="file"
      :accept="accept"
      class="image-input__input"
      @change="handleChange"
    >

    <p v-if="error" class="image-input__error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  modelValue: { type: String, default: '' },
  alt: { type: String, default: 'Image preview' },
  accept: { type: String, default: 'image/*' },
  removable: { type: Boolean, default: true },
  error: { type: String, default: '' },
})

const emit = defineEmits(['update:modelValue'])

const inputRef = ref(null)

const triggerInput = () => {
  inputRef.value?.click()
}

const handleChange = (e) => {
  const file = e.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = (event) => {
      emit('update:modelValue', event.target.result)
    }
    reader.readAsDataURL(file)
  }
}

const removeImage = () => {
  emit('update:modelValue', '')
  if (inputRef.value) {
    inputRef.value.value = ''
  }
}
</script>

<style lang="scss" scoped>
.image-input {
  position: relative;
  width: 200px;

  &__input {
    display: none;
  }

  &__placeholder {
    width: 200px;
    height: 150px;
    border: 2px dashed var(--bulma-border);
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s;

    i {
      font-size: 2rem;
      color: var(--bulma-text-weak);
    }

    span {
      font-size: 0.875rem;
      color: var(--bulma-text-weak);
    }

    &:hover {
      border-color: var(--bulma-link);
      background: var(--bulma-scheme-main-bis);
    }
  }

  &__preview {
    position: relative;
    width: 200px;
    height: 150px;
    border-radius: 8px;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &:hover .image-input__overlay {
      opacity: 1;
    }
  }

  &__overlay {
    position: absolute;
    inset: 0;
    background: var(--dl-overlay);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.2s;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.15s;

    &--light {
      background: var(--bulma-scheme-main);
      color: var(--bulma-text);

      &:hover {
        background: var(--bulma-scheme-main-bis);
      }
    }

    &--danger {
      background: var(--bulma-danger);
      color: var(--bulma-danger-invert);

      &:hover {
        background: color-mix(in oklch, var(--bulma-danger) 85%, black);
      }
    }
  }

  &__error {
    color: var(--bulma-danger);
    font-size: 0.875rem;
    margin-top: 0.5rem;
  }

  &.has-error {
    .image-input__placeholder {
      border-color: var(--bulma-danger);
    }
  }
}
</style>
