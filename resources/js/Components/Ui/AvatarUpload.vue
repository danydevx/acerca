<template>
  <div class="avatar-upload" :class="{ 'avatar-upload--loading': uploading }">
    <div class="avatar-upload__preview">
      <img v-if="src" :src="src" :alt="alt">
      <div v-else class="avatar-upload__placeholder">
        <i class="bi bi-person"></i>
      </div>

      <div v-if="uploading" class="avatar-upload__progress">
        <UiProgress :value="progress" size="small" />
      </div>
    </div>

    <div v-if="!uploading" class="avatar-upload__info">
      <p class="avatar-upload__name">{{ label }}</p>
      <div class="avatar-upload__actions">
        <button class="avatar-upload__btn avatar-upload__btn--primary" @click="$emit('change')">
          {{ changeLabel }}
        </button>
        <button v-if="removable && src" class="avatar-upload__btn avatar-upload__btn--danger" @click="$emit('remove')">
          {{ removeLabel }}
        </button>
      </div>
    </div>

    <div v-else class="avatar-upload__status">
      Subiendo... {{ progress }}%
    </div>
  </div>
</template>

<script setup>
import UiProgress from './UiProgress.vue'

defineProps({
  src: { type: String, default: '' },
  alt: { type: String, default: 'Avatar' },
  label: { type: String, default: 'Profile photo' },
  changeLabel: { type: String, default: 'Change photo' },
  removeLabel: { type: String, default: 'Remove' },
  uploading: { type: Boolean, default: false },
  progress: { type: Number, default: 0 },
  removable: { type: Boolean, default: true },
})

defineEmits(['change', 'remove'])
</script>

<style lang="scss" scoped>
.avatar-upload {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;

  &__preview {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 3rem;
    }
  }

  &__progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0.5rem;
    background: var(--dl-overlay);
  }

  &__info {
    text-align: center;
  }

  &__name {
    font-weight: 500;
    color: var(--bulma-text);
    margin: 0 0 0.75rem;
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: var(--bulma-radius);
    cursor: pointer;
    transition: all 0.15s;

    &--primary {
      background: var(--bulma-primary);
      color: var(--bulma-primary-invert);
      border: 1px solid var(--bulma-primary);

      &:hover {
        background: color-mix(in oklch, var(--bulma-primary) 85%, black);
      }
    }

    &--danger {
      background: transparent;
      color: var(--bulma-danger);
      border: 1px solid var(--bulma-danger);

      &:hover {
        background: var(--bulma-danger);
        color: var(--bulma-danger-invert);
      }
    }
  }

  &__status {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }

  &--loading {
    .avatar-upload__preview {
      opacity: 0.7;
    }
  }
}
</style>
