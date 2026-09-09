<template>
  <div class="menu-quick-add">
    <button
      v-if="showButton"
      class="menu-quick-add__btn"
      :class="{ 'menu-quick-add__btn--active': added }"
      type="button"
      @click="handleAdd"
    >
      <i :class="added ? 'bi bi-check' : 'bi bi-plus'"></i>
      <span v-if="!compact">{{ added ? 'Agregado' : 'Agregar' }}</span>
    </button>

    <div v-if="showQuantity && quantity > 0" class="menu-quick-add__quantity">
      <button
        class="menu-quick-add__qty-btn"
        type="button"
        @click="decrement"
      >
        <i class="bi bi-dash"></i>
      </button>
      <span class="menu-quick-add__qty-value">{{ quantity }}</span>
      <button
        class="menu-quick-add__qty-btn"
        type="button"
        @click="increment"
      >
        <i class="bi bi-plus"></i>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  initialQuantity: {
    type: Number,
    default: 0,
  },
  min: {
    type: Number,
    default: 0,
  },
  max: {
    type: Number,
    default: 99,
  },
  showButton: {
    type: Boolean,
    default: true,
  },
  showQuantity: {
    type: Boolean,
    default: false,
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

const emit = defineEmits(['add', 'remove', 'update'])

const quantity = ref(props.initialQuantity)
const added = ref(false)

const handleAdd = () => {
  if (added.value) {
    return
  }
  quantity.value++
  added.value = true
  emit('add', { item: props.item, quantity: quantity.value })

  setTimeout(() => {
    added.value = false
  }, 2000)
}

const increment = () => {
  if (quantity.value < props.max) {
    quantity.value++
    emit('update', { item: props.item, quantity: quantity.value })
  }
}

const decrement = () => {
  if (quantity.value > props.min) {
    quantity.value--
    emit('update', { item: props.item, quantity: quantity.value })
    if (quantity.value === 0) {
      emit('remove', props.item)
    }
  }
}

watch(() => props.initialQuantity, (val) => {
  quantity.value = val
})
</script>

<style lang="scss" scoped>
.menu-quick-add {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;

  &__btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link-hover);
      transform: scale(1.02);
    }

    &--active {
      background: var(--bulma-success);

      &:hover {
        background: var(--bulma-success);
      }
    }

    i {
      font-size: 1rem;
    }
  }

  &__quantity {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius);
  }

  &__qty-btn {
    width: 1.75rem;
    height: 1.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: var(--bulma-radius-small);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      background: var(--bulma-link);
      color: var(--bulma-link-invert);
    }

    i {
      font-size: 0.875rem;
    }
  }

  &__qty-value {
    min-width: 1.5rem;
    text-align: center;
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
  }
}
</style>
