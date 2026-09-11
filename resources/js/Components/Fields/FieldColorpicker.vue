<template>
  <div class="form-group">
    <label v-if="label" :for="id" class="form-label">
      {{ label }} <span v-if="required" class="text-danger fw-bold">*</span>
    </label>
    <div class="d-flex align-items-center gap-2">
      <input
        :id="id + '-color'"
        type="color"
        :value="modelValue"
        class="form-control form-control-color"
        :style="{ width: '50px', height: '38px', padding: '4px' }"
        @input="onColorInput"
      />
      <input
        :id="id"
        type="text"
        :value="modelValue"
        class="form-control"
        :placeholder="placeholder || '#000000'"
        :class="{ 'is-invalid': hasError }"
        @input="onTextInput"
        @blur="onBlur"
      />
    </div>
    <div v-if="hint" class="form-text">{{ hint }}</div>
    <div v-if="hasError" class="invalid-feedback">
      {{ formError || validationMessage }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  label: String,
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: '#000000' },
  required: Boolean,
  showValidation: { type: Boolean, default: false },
  formError: { type: String, default: '' },
  validateFunction: { type: Function, default: null },
  hint: String,
})

const emit = defineEmits(['update:modelValue', 'blur'])

const validationMessage = computed(() => {
  return props.validateFunction ? props.validateFunction() : ''
})

const hasError = computed(() => {
  return (props.showValidation && !!props.validationMessage) || !!props.formError
})

const isValidHex = (value) => /^#([0-9A-Fa-f]{3}){1,2}$/.test(value)

const onColorInput = (e) => {
  emit('update:modelValue', e.target.value)
}

const onTextInput = (e) => {
  let value = e.target.value.trim()
  if (value && !value.startsWith('#')) {
    value = '#' + value
  }
  emit('update:modelValue', value)
}

const onBlur = () => {
  emit('blur')
}
</script>
