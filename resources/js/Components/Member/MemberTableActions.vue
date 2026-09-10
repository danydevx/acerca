<template>
  <div class="dropdown actions-cell">
    <button
      class="btn btn-sm btn-secondary rounded-circle d-flex align-items-center justify-content-center"
      style="width: 28px; height: 28px;"
      type="button"
      data-bs-toggle="dropdown"
    >
      <i class="bi bi-three-dots-vertical" style="font-size: 12px;"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" data-bs-boundary="viewport">
      <li v-for="action in regularActions" :key="action.label">
        <button
          class="dropdown-item"
          :class="{ disabled: action.disabled }"
          :title="action.disabledMessage"
          @click="handleClick(action)"
        >
          <i v-if="action.icon" :class="[action.icon, 'me-2']"></i>
          {{ action.label }}
        </button>
      </li>
      <li v-if="dangerActions.length">
        <hr class="dropdown-divider">
      </li>
      <li v-for="action in dangerActions" :key="action.label">
        <button
          class="dropdown-item text-danger"
          :class="{ disabled: action.disabled }"
          :title="action.disabledMessage"
          @click="handleClick(action)"
        >
          <i v-if="action.icon" :class="[action.icon, 'me-2']"></i>
          {{ action.label }}
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  actions: {
    type: Array,
    required: true,
    validator: (value) => {
      return value.every(action =>
        typeof action.label === 'string' &&
        typeof action.onClick === 'function'
      )
    }
  }
})

const emit = defineEmits(['action'])

const regularActions = computed(() =>
  props.actions.filter(a => !a.danger)
)

const dangerActions = computed(() =>
  props.actions.filter(a => a.danger)
)

const handleClick = (action) => {
  if (action.disabled) return
  action.onClick()
  emit('action', action)
}
</script>

<script>
export default {
  name: 'MemberTableActions'
}
</script>

<style scoped>
.actions-cell {
  display: flex;
  justify-content: center;
}

:deep(.dropdown-menu) {
  min-width: 8rem;
  padding: 0.25rem 0;
}

:deep(.dropdown-item) {
  padding: 0.35rem 1rem;
  font-size: 0.85rem;
}

:deep(.dropdown-item.disabled) {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}
</style>
