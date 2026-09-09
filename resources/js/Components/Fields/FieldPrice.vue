<template>
  <div class="form-group" :class="classObject">
    <label :for="id" class="form-label">{{ label }} <strong v-if="required">*</strong></label>
    <input
      type="hidden"
      :name="id"
      :value="modelValue"
    />
    <input
      :id="id"
      type="text"
      class="form-control"
      inputmode="decimal"
      :placeholder="placeholder || '0.00'"
      :readonly="readonly"
      :disabled="readonly"
      :value="isFocused ? inputValue : displayValue"
      :class="{ 'is-invalid': hasError }"
      @input="onInput"
      @blur="onBlur"
      @focus="onFocus"
      autocomplete="off"
    />
    <small v-if="helpText" class="form-text text-muted">{{ helpText }}</small>
    <div v-if="hasError" class="invalid-feedback d-block">
      {{ formError || validationMessage }}
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  label: { type: String, default: '' },
  modelValue: { type: [Number, String], default: '' },
  placeholder: { type: String, default: '' },
  required: { type: Boolean, default: false },
  showValidation: { type: Boolean, default: false },
  formError: { type: String, default: '' },
  validateFunction: { type: Function, default: null },
  helpText: { type: String, default: '' },
  readonly: { type: Boolean, default: false },
  min: { type: Number, default: 0 },
  max: { type: Number, default: 100000000 },
  currencyLabel: { type: String, default: '$' },
  classObject: { type: [String, Object, Array], default: '' },
})

const validationMessage = computed(() => {
  if (props.validateFunction) return props.validateFunction()
  const v = parseFloat(props.modelValue)
  if (!isNaN(v)) {
    if (v < props.min) return `El valor debe ser mayor o igual a ${props.min}`
    if (v > props.max) return `El valor debe ser menor o igual a ${props.max.toLocaleString('es-MX')}`
  }
  return ''
})

const hasError = computed(() => {
  return (props.showValidation && !!validationMessage.value) || !!props.formError
})

const emit = defineEmits(['update:modelValue', 'blur'])

const isFocused = ref(false)

const formatNumber = (value) => {
  if (value === '' || value === null || typeof value === 'undefined') return ''
  const num = parseFloat(value)
  if (Number.isNaN(num)) return ''
  const parts = num.toFixed(2).split('.')
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  return `${props.currencyLabel}${parts.join('.')}`
}

const displayValue = computed(() => formatNumber(props.modelValue))

const inputValue = computed(() => {
  if (props.modelValue === '' || props.modelValue === null || typeof props.modelValue === 'undefined') return ''
  return String(props.modelValue)
})

const onFocus = () => {
  isFocused.value = true
}

const onInput = (e) => {
  if (props.readonly) return

  let raw = e.target.value.replace(/[^\d.]/g, '')

  const parts = raw.split('.')
  if (parts.length > 2) {
    raw = parts[0] + '.' + parts.slice(1).join('')
  }

  if (parts.length === 2 && parts[1].length > 2) {
    raw = parts[0] + '.' + parts[1].substring(0, 2)
  }

  if (raw === '' || raw === '.') {
    emit('update:modelValue', '')
    return
  }

  let num = parseFloat(raw)
  if (Number.isNaN(num)) {
    emit('update:modelValue', '')
    return
  }

  num = Math.min(Math.max(num, props.min), props.max)

  emit('update:modelValue', num)
}

const onBlur = () => {
  isFocused.value = false
  if (props.readonly) {
    emit('blur')
    return
  }
  emit('blur')
}
</script>
