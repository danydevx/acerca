<template>
  <div class="file-item" :class="[`file-item--${status}`]">
    <div class="file-item__icon">
      <i :class="fileIcon"></i>
    </div>

    <div class="file-item__info">
      <div class="file-item__name">{{ fileName }}</div>
      <div class="file-item__meta">
        <span v-if="fileType">{{ fileType }}</span>
        <span v-if="fileSize">{{ formattedSize }}</span>
        <span v-if="dimensions">{{ dimensions }}</span>
      </div>
    </div>

    <div v-if="status === 'uploading'" class="file-item__progress">
      <UiProgress :value="progress" size="small" />
    </div>

    <div v-if="status === 'uploading'" class="file-item__status-text">
      Subiendo...
    </div>

    <div v-if="status === 'completed'" class="file-item__status-text file-item__status-text--success">
      <i class="bi bi-check-circle"></i>
      Subido
    </div>

    <div v-if="status === 'error'" class="file-item__status-text file-item__status-text--danger">
      <i class="bi bi-exclamation-circle"></i>
      Error
    </div>

    <div class="file-item__actions">
      <button v-if="removable" class="file-item__action" @click="$emit('remove')">
        <i class="bi bi-x"></i>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import UiProgress from './UiProgress.vue'

const props = defineProps({
  name: { type: String, default: '' },
  type: { type: String, default: '' },
  size: { type: Number, default: 0 },
  dimensions: { type: String, default: '' },
  status: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'uploading', 'completed', 'error'].includes(v),
  },
  progress: { type: Number, default: 0 },
  removable: { type: Boolean, default: true },
})

defineEmits(['remove'])

const fileName = computed(() => {
  if (props.name) return props.name
  return 'Archivo sin nombre'
})

const fileType = computed(() => {
  if (!props.type) return ''
  const ext = props.type.split('/')[1]?.toUpperCase() || props.type.toUpperCase()
  return ext
})

const formattedSize = computed(() => {
  if (!props.size) return ''
  const kb = props.size / 1024
  if (kb < 1024) return `${kb.toFixed(1)} KB`
  const mb = kb / 1024
  return `${mb.toFixed(1)} MB`
})

const fileIcon = computed(() => {
  if (!props.type) return 'bi bi-file-earmark'

  if (props.type.startsWith('image/')) return 'bi bi-file-earmark-image'
  if (props.type.startsWith('video/')) return 'bi bi-file-earmark-play'
  if (props.type.startsWith('audio/')) return 'bi bi-file-earmark-music'
  if (props.type.includes('pdf')) return 'bi bi-file-earmark-pdf'
  if (props.type.includes('word') || props.type.includes('document')) return 'bi bi-file-earmark-word'
  if (props.type.includes('excel') || props.type.includes('spreadsheet')) return 'bi bi-file-earmark-excel'

  return 'bi bi-file-earmark'
})
</script>

<style lang="scss" scoped>
.file-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius);
  transition: background 150ms;

  &:hover {
    background: var(--bulma-scheme-main-bis);
  }

  &--uploading {
    border-color: var(--bulma-info);
  }

  &--completed {
    border-color: var(--bulma-success);
  }

  &--error {
    border-color: var(--bulma-danger);
  }

  &__icon {
    flex-shrink: 0;
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius);
    color: var(--bulma-text-weak);

    i {
      font-size: 1.25rem;
    }
  }

  &__info {
    flex: 1;
    min-width: 0;
  }

  &__name {
    font-weight: 500;
    color: var(--bulma-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__meta {
    display: flex;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;

    span {
      &::after {
        content: '·';
        margin-left: 0.5rem;
      }

      &:last-child::after {
        content: '';
      }
    }
  }

  &__progress {
    width: 80px;
  }

  &__status-text {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    display: flex;
    align-items: center;
    gap: 0.25rem;

    &--success {
      color: var(--bulma-success);
    }

    &--danger {
      color: var(--bulma-danger);
    }
  }

  &__actions {
    flex-shrink: 0;
  }

  &__action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background: none;
    border: none;
    border-radius: var(--bulma-radius);
    color: var(--bulma-text-weak);
    cursor: pointer;

    &:hover {
      background: var(--bulma-scheme-main-bis);
      color: var(--bulma-danger);
    }
  }
}
</style>
