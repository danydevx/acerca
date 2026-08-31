<template>
  <div class="col-12 d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-gradient rounded-pill" :disabled="sending || disabled">
      <span v-if="sending">{{ submittingText }}</span>
      <span v-else>{{ submitText }}</span>
    </button>
    <Link v-if="cancelHref" :href="cancelHref" class="btn btn-outline-dark rounded-pill">{{ cancelText }}</Link>
    <button v-else type="button" class="btn btn-outline-dark rounded-pill" @click="$emit('cancel')">{{ cancelText }}</button>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  submitText: {
    type: String,
    default: 'Guardar'
  },
  submittingText: {
    type: String,
    default: 'Guardando...'
  },
  cancelText: {
    type: String,
    default: 'Cancelar'
  },
  cancelHref: {
    type: String,
    default: null
  },
  sending: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

defineEmits(['cancel'])
</script>
