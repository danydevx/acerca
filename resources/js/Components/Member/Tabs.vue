<template>
  <div class="member-tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li v-for="tab in tabs" :key="tab.key" class="nav-item" role="presentation">
        <button
          class="nav-link"
          :class="{ active: modelValue === tab.key }"
          @click="$emit('update:modelValue', tab.key)"
          type="button"
        >
          <i v-if="tab.icon" :class="tab.icon + ' me-2'"></i>{{ tab.label }}
        </button>
      </li>
    </ul>

    <div class="tab-content">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  tabs: {
    type: Array,
    required: true,
  },
  modelValue: {
    type: String,
    required: true,
  },
})

defineEmits(['update:modelValue'])
</script>

<style lang="less" scoped>
.member-tabs {
  padding: 0 0 48px;
}

.nav-tabs {
  border-bottom: 2px solid #dee2e6;

  .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    padding: 12px 20px;
    font-weight: 500;

    &:hover {
      color: #0d6efd;
      border-color: transparent;
    }

    &.active {
      color: #0d6efd;
      border-bottom-color: #0d6efd;
      background: transparent;
    }
  }
}

.tab-content {
  padding-top: 24px;
}
</style>
