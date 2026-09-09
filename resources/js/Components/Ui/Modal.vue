<template>
  <Teleport to="body">
    <div v-if="modelValue" class="modal is-active" @click.self="closeOnBackdrop && close()">
      <div class="modal-background" @click="closeOnBackdrop && close()"></div>
      <div class="modal-card dl-bulma-modal" :class="sizeClass">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ title }}</p>
          <button class="delete" aria-label="close" @click="close"></button>
        </header>
        <section class="modal-card-body">
          <slot></slot>
        </section>
        <footer class="modal-card-foot" v-if="$slots.footer">
          <slot name="footer"></slot>
        </footer>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: '',
  },
  size: {
    type: String,
    default: 'md',
    validator: (val) => ['sm', 'md', 'lg'].includes(val),
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['update:modelValue', 'close'])

const sizeClass = computed(() => {
  const map = { sm: 'is-small', md: '', lg: 'is-large' }
  return map[props.size] || ''
})

const close = () => {
  emit('update:modelValue', false)
  emit('close')
}
</script>

<style lang="scss" scoped>
.dl-bulma-modal {
  max-width: 90vw;

  &.is-small {
    max-width: 400px;
  }

  &.is-large {
    max-width: 800px;
  }
}

.modal-card-head,
.modal-card-foot {
  border-radius: 0;
  padding: 0.75rem 1rem;
}

.modal-card-head {
  padding-bottom: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: space-between;

  :deep(.delete) {
    width: 1.5rem;
    height: 1.5rem;
    max-width: 1.5rem;
    max-height: 1.5rem;
  }
}

.modal-card-title {
  font-weight: 600;
  margin-bottom: 0;
}

.modal-card-foot {
  justify-content: flex-end;
  gap: 0.5rem;
}
</style>
