<template>
  <div
    ref="triggerRef"
    class="dl-bulma-context-menu__trigger"
    @contextmenu="handleContextMenu"
  >
    <slot></slot>

    <Teleport to="body">
      <div
        v-if="isOpen"
        ref="menuRef"
        class="dl-bulma-context-menu"
        role="menu"
        :style="{
          position: 'fixed',
          left: position.x + 'px',
          top: position.y + 'px'
        }"
      >
        <template v-for="(item, idx) in items" :key="idx">
          <div
            v-if="item.type === 'separator'"
            class="dl-bulma-context-menu__separator"
          ></div>
          <div
            v-else
            class="dl-bulma-context-menu__item"
            :class="{
              'dl-bulma-context-menu__item--disabled': item.disabled,
              'dl-bulma-context-menu__item--danger': item.danger
            }"
            role="menuitem"
            :aria-disabled="item.disabled"
            @click="selectItem(item)"
          >
            <div class="dl-bulma-context-menu__item-icon" v-if="item.icon">
              <i :class="item.icon" aria-hidden="true"></i>
            </div>
            <div class="dl-bulma-context-menu__item-content">
              <div class="dl-bulma-context-menu__item-label">{{ item.label }}</div>
              <div class="dl-bulma-context-menu__item-desc" v-if="item.description">
                {{ item.description }}
              </div>
            </div>
            <div class="dl-bulma-context-menu__item-shortcut" v-if="item.shortcut">
              <kbd class="kbd kbd--sm">{{ item.shortcut }}</kbd>
            </div>
          </div>
        </template>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['select'])

const isOpen = ref(false)
const menuRef = ref(null)
const triggerRef = ref(null)
const position = ref({ x: 0, y: 0 })

const handleContextMenu = (e) => {
  if (props.disabled) return
  e.preventDefault()
  openAt(e.clientX, e.clientY)
}

const openAt = (x, y) => {
  const menuWidth = 200
  const menuHeight = 200
  const padding = 8

  let finalX = x
  let finalY = y

  if (x + menuWidth + padding > window.innerWidth) {
    finalX = window.innerWidth - menuWidth - padding
  }
  if (finalX < padding) {
    finalX = padding
  }

  if (y + menuHeight + padding > window.innerHeight) {
    finalY = window.innerHeight - menuHeight - padding
  }
  if (finalY < padding) {
    finalY = padding
  }

  position.value = { x: finalX, y: finalY }
  isOpen.value = true
}

const close = () => {
  isOpen.value = false
}

const selectItem = (item) => {
  if (item.disabled) return
  emit('select', item)
  close()
}

const onClickOutside = (e) => {
  if (isOpen.value && menuRef.value && !menuRef.value.contains(e.target)) {
    close()
  }
}

const onKeyDown = (e) => {
  if (e.key === 'Escape') {
    close()
  }
}

onMounted(() => {
  document.addEventListener('click', onClickOutside)
  document.addEventListener('keydown', onKeyDown)
})

onUnmounted(() => {
  document.removeEventListener('click', onClickOutside)
  document.removeEventListener('keydown', onKeyDown)
})

defineExpose({
  openAt,
  close
})
</script>

<style lang="scss" scoped>
.dl-bulma-context-menu {
  min-width: 180px;
  max-width: 280px;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: 8px;
  box-shadow: 0 10px 15px -3px oklch(0 0 0 / 0.1), 0 4px 6px -2px oklch(0 0 0 / 0.05);
  padding: 0.25rem;
  z-index: 50;

  &__item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.15s;

    &:hover:not(.dl-bulma-context-menu__item--disabled) {
      background: var(--bulma-scheme-main-bis);
    }

    &--disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    &--danger {
      color: var(--bulma-danger);

      &:hover:not(.dl-bulma-context-menu__item--disabled) {
        background: color-mix(in oklch, var(--bulma-danger) 10%, var(--bulma-scheme-main));
      }
    }
  }

  &__item-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    color: var(--bulma-text-weak);
    flex-shrink: 0;
  }

  &__item--danger &__item-icon {
    color: var(--bulma-danger);
  }

  &__item-content {
    flex: 1;
    min-width: 0;
  }

  &__item-label {
    font-size: 0.875rem;
    color: var(--bulma-text);
  }

  &__item--danger &__item-label {
    color: var(--bulma-danger);
  }

  &__item-desc {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__item-shortcut {
    flex-shrink: 0;
  }

  &__separator {
    height: 1px;
    background: var(--bulma-border);
    margin: 0.25rem 0;
  }
}

.kbd {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.125rem 0.375rem;
  font-size: 0.75rem;
  font-family: inherit;
  background: var(--bulma-scheme-main-bis);
  border: 1px solid var(--bulma-border);
  border-radius: 4px;
  color: var(--bulma-text-weak);

  &--sm {
    padding: 0.125rem 0.375rem;
    font-size: 0.6875rem;
  }
}
</style>
