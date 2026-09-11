<template>
  <div class="form-group">
    <label :for="id" class="form-label">{{ label }} <span v-if="required" class="text-danger fw-bold">*</span></label>
    <div class="input-group">
      <button
        class="btn btn-secondary dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        :disabled="readonly"
      >
        <span v-if="selectedCountry">{{ getFlag(selectedCountry) }} {{ selectedCountry }}</span>
        <span v-else>+52</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-start">
        <li v-for="country in countries" :key="country.code">
          <a
            class="dropdown-item d-flex align-items-center gap-2"
            href="#"
            @click.prevent="selectCountry(country.code)"
          >
            <span>{{ getFlag(country.code) }}</span>
            <span>{{ country.name }}</span>
            <span class="text-muted ms-auto">{{ country.code }}</span>
          </a>
        </li>
      </ul>
      <input
        :id="id"
        type="tel"
        v-model="phoneValue"
        class="form-control"
        :placeholder="placeholder || 'XX XXX XXXX'"
        :readonly="readonly"
        :disabled="readonly"
        :class="{ 'is-invalid': formError }"
        @input="validateNumeric"
        @blur="onBlur"
      />
    </div>
    <small class="text-muted d-block mt-1">Numero de telefono sin el prefijo del pais</small>
    <div v-if="formError" class="invalid-feedback d-block">{{ formError }}</div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  id: String,
  label: String,
  modelValue: String,
  countryValue: String,
  placeholder: String,
  required: Boolean,
  formError: String,
  readonly: { type: Boolean, default: false },
})

const emit = defineEmits(['update:modelValue', 'update:countryValue', 'blur'])

const countries = [
  { code: '+52', name: 'Mexico', flag: '🇲🇽' },
  { code: '+1', name: 'EEUU', flag: '🇺🇸' },
]

const selectedCountry = computed({
  get: () => props.countryValue || '+52',
  set: (val) => emit('update:countryValue', val),
})

const phoneValue = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})

const selectCountry = (code) => {
  selectedCountry.value = code
}

const getFlag = (code) => {
  const country = countries.find((c) => c.code === code)
  return country ? country.flag : '🌐'
}

const validateNumeric = (event) => {
  const value = event.target.value
  event.target.value = value.replace(/\D/g, '')
  phoneValue.value = event.target.value
}

const onBlur = () => {
  emit('blur')
}
</script>

<style scoped>
.dropdown-toggle::after {
  margin-left: 0.5rem;
}
</style>
