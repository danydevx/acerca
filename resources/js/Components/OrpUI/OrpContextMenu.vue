<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'

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

<template>
    <div
        ref="triggerRef"
        class="orp-context-menu-trigger"
        @contextmenu="handleContextMenu"
    >
        <slot></slot>

        <Teleport to="body">
            <div
                v-if="isOpen"
                ref="menuRef"
                class="orp-context-menu"
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
                        class="orp-context-menu__separator"
                    ></div>
                    <div
                        v-else
                        class="orp-context-menu__item"
                        :class="{
                            'orp-context-menu__item--disabled': item.disabled,
                            'orp-context-menu__item--danger': item.danger
                        }"
                        role="menuitem"
                        :aria-disabled="item.disabled"
                        @click="selectItem(item)"
                    >
                        <div class="orp-context-menu__item-icon" v-if="item.icon">
                            <i :class="item.icon" aria-hidden="true"></i>
                        </div>
                        <div class="orp-context-menu__item-content">
                            <div class="orp-context-menu__item-label">{{ item.label }}</div>
                            <div class="orp-context-menu__item-desc" v-if="item.description">
                                {{ item.description }}
                            </div>
                        </div>
                        <div class="orp-context-menu__item-shortcut" v-if="item.shortcut">
                            <span class="orp-kbd orp-kbd--sm">{{ item.shortcut }}</span>
                        </div>
                    </div>
                </template>
            </div>
        </Teleport>
    </div>
</template>

<style scoped>
.orp-context-menu {
    min-width: 180px;
    max-width: 280px;
    background: var(--orp-surface);
    border: 1px solid var(--orp-border);
    border-radius: var(--orp-radius-md);
    box-shadow: var(--orp-shadow-lg);
    padding: var(--orp-space-1);
    z-index: var(--orp-z-popover);
}

.orp-context-menu__item {
    display: flex;
    align-items: center;
    gap: var(--orp-space-2);
    padding: var(--orp-space-2) var(--orp-space-3);
    border-radius: var(--orp-radius-sm);
    cursor: pointer;
    transition: background var(--orp-duration-fast);

    &:hover:not(.orp-context-menu__item--disabled) {
        background: var(--orp-surface-muted);
    }

    &--disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    &--danger {
        color: var(--orp-danger);

        &:hover:not(.orp-context-menu__item--disabled) {
            background: color-mix(in srgb, var(--orp-danger) 10%, transparent);
        }
    }
}

.orp-context-menu__item-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    color: var(--orp-muted-foreground);
    flex-shrink: 0;
}

.orp-context-menu__item--danger .orp-context-menu__item-icon {
    color: var(--orp-danger);
}

.orp-context-menu__item-content {
    flex: 1;
    min-width: 0;
}

.orp-context-menu__item-label {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-surface-foreground);
}

.orp-context-menu__item--danger .orp-context-menu__item-label {
    color: var(--orp-danger);
}

.orp-context-menu__item-desc {
    font-size: var(--orp-font-size-xs);
    color: var(--orp-muted-foreground);
}

.orp-context-menu__item-shortcut {
    flex-shrink: 0;
}

.orp-context-menu__separator {
    height: 1px;
    background: var(--orp-border);
    margin: var(--orp-space-1) 0;
}
</style>
