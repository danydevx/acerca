<template>
  <div class="interactive-playground">
    <div class="interactive-playground__controls">
      <div class="field is-grouped is-flex-wrap-wrap">
        <div class="field">
          <label class="label is-small">Radius:</label>
          <div class="control">
            <div class="tags">
              <span v-for="r in radiusOptions" :key="r.value" class="tag" :class="{ 'is-primary': selected.radius === r.value }" @click="selected.radius = r.value">{{ r.label }}</span>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label is-small">Ratio:</label>
          <div class="control">
            <div class="tags">
              <span v-for="r in ratioOptions" :key="r.value" class="tag" :class="{ 'is-primary': selected.ratio === r.value }" @click="selected.ratio = r.value">{{ r.label }}</span>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label is-small">Opacity:</label>
          <div class="control">
            <div class="tags">
              <span v-for="o in opacityOptions" :key="o.value" class="tag" :class="{ 'is-primary': selected.opacity === o.value }" @click="selected.opacity = o.value">{{ o.label }}</span>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label is-small">Filter:</label>
          <div class="control">
            <div class="tags">
              <span v-for="f in filterOptions" :key="f.value" class="tag" :class="{ 'is-primary': selected.filter === f.value }" @click="selected.filter = f.value">{{ f.label }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="interactive-playground__preview">
      <div class="interactive-playground__box" :class="`radius-${selected.radius}`" :style="previewStyle">
        <img src="https://picsum.photos/seed/preview/400/300" alt="Preview">
      </div>
    </div>
    <div class="interactive-playground__info">
      <code>radius={{ selected.radius }}, ratio={{ selected.ratio }}, opacity={{ selected.opacity }}, filter={{ selected.filter }}</code>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'

const selected = reactive({
  radius: 'md',
  ratio: 'landscape',
  opacity: '100%',
  filter: 'none',
})

const radiusOptions = [
  { label: 'none', value: 'none' },
  { label: 'md', value: 'md' },
  { label: 'lg', value: 'lg' },
  { label: 'pill', value: 'pill' },
]

const ratioOptions = [
  { label: '1:1', value: 'square' },
  { label: '3:4', value: 'portrait' },
  { label: '4:3', value: 'landscape' },
  { label: '16:9', value: 'wide' },
]

const opacityOptions = [
  { label: '100%', value: '100%' },
  { label: '80%', value: '80%' },
  { label: '60%', value: '60%' },
  { label: '40%', value: '40%' },
]

const filterOptions = [
  { label: 'none', value: 'none' },
  { label: 'grayscale', value: 'grayscale' },
  { label: 'sepia', value: 'sepia' },
  { label: 'blur', value: 'blur' },
]

const previewStyle = computed(() => ({
  aspectRatio: selected.ratio === 'square' ? '1/1' : selected.ratio === 'portrait' ? '3/4' : selected.ratio === 'landscape' ? '4/3' : '16/9',
  opacity: parseInt(selected.opacity) / 100,
  filter: selected.filter === 'none' ? 'none' : `${selected.filter}(${selected.filter === 'blur' ? '2px' : ''})`,
}))
</script>

<style lang="scss" scoped>
.interactive-playground {
  &__controls {
    margin-bottom: 1.5rem;

    .field {
      margin-bottom: 0.5rem;
    }

    .label {
      color: var(--bulma-text);
      margin-bottom: 0.25rem;
    }

    .tag {
      cursor: pointer;
      transition: all 150ms;
    }
  }

  &__preview {
    margin-bottom: 1rem;
  }

  &__box {
    max-width: 300px;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &.radius-none { border-radius: 0; }
    &.radius-md { border-radius: 12px; }
    &.radius-lg { border-radius: 18px; }
    &.radius-pill { border-radius: 9999px; }
  }

  &__info {
    code {
      background: var(--bulma-scheme-main-bis);
      padding: 0.25rem 0.5rem;
      border-radius: var(--bulma-radius);
      font-size: 0.875rem;
    }
  }
}
</style>
