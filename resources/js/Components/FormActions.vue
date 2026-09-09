<template>
  <div class="d-flex justify-content-end gap-2">
    test
    <Link v-if="cancelHref" :href="cancelHref" class="btn btn-secondary rounded-pill" preserve-scroll>{{ cancelText }}</Link>
    <button v-else type="button" class="btn btn-secondary rounded-pill" @click="$emit('cancel')">{{ cancelText }}</button>
    <button type="submit" class="btn btn-primary rounded-pill" :disabled="sending || disabled">
      <span v-if="sending">{{ submittingText }}</span>
      <span v-else>{{ submitText }}</span>
    </button>
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
