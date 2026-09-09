<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Keyboard Shortcuts</h3>
      <div class="is-flex is-flex-wrap-wrap is-align-items-center is-gap-4">
        <UiKeyboardShortcut key="Ctrl" label="Copy" />
        <UiKeyboardShortcut key="Ctrl" label="Paste" size="small" />
        <UiKeyboardShortcut key="Ctrl + C" label="Cut" size="large" />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Quick Actions</h3>
      <UiQuickActions :actions="quickActions" @select="handleQuickAction" />
    </div>

    <div class="box">
      <h3 class="title is-4">Selection Bar</h3>
      <UiSelectionBar :visible="selectionVisible" :selected-count="3" label="selected" @close="selectionVisible = false">
        <button class="button is-small is-info">Move</button>
        <button class="button is-small is-danger">Delete</button>
      </UiSelectionBar>
      <button class="button is-primary" @click="selectionVisible = true">Show Selection Bar</button>
    </div>

    <div class="box">
      <h3 class="title is-4">Context Menu</h3>
      <p class="mb-3">Right-click on the box below to see the context menu</p>
      <UiContextMenu :items="contextMenuItems" @select="handleContextSelect">
        <div class="notification is-info is-light">
          <p>Right-click here to open context menu</p>
        </div>
      </UiContextMenu>
    </div>

    <div class="box">
      <h3 class="title is-4">Command Menu</h3>
      <button class="button is-primary" @click="commandMenuOpen = true">Open Command Menu</button>
      <UiCommandMenu
        v-model="commandMenuOpen"
        :items="commandMenuItems"
        placeholder="Search commands..."
        @select="handleCommandSelect"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">File Item</h3>
      <div class="is-flex is-flex-direction-column is-gap-3">
        <UiFileItem name="document.pdf" type="application/pdf" :size="256000" />
        <UiFileItem name="image.png" type="image/png" :size="1048576" dimensions="1920x1080" status="completed" />
        <UiFileItem name="video.mp4" type="video/mp4" :size="15728640" status="uploading" :progress="65" />
        <UiFileItem name="error-file.zip" type="application/zip" :size="512000" status="error" />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Dropzone</h3>
      <UiDropzone
        label="Drop files here"
        subtitle="or click to browse"
        help="Maximum file size: 10MB"
        accept="image/*"
        :multiple="true"
        @change="handleFileChange"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Map</h3>
      <UiMap
        :center="[20.6736, -103.344]"
        :zoom="13"
        height="300px"
        :markers="mapMarkers"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Comment</h3>
      <UiComment
        author="Maria Garcia"
        timestamp="hace 2 horas"
        message="Este es un comentario de ejemplo con informacion relevante."
        :likes="42"
        :liked="false"
        :verified="true"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">List</h3>
      <UiList :items="listItems" variant="divided" :interactive="true" />
    </div>

    <div class="box">
      <h3 class="title is-4">Badges</h3>
      <div class="is-flex is-flex-wrap-wrap is-align-items-center is-gap-3">
        <span class="tag is-primary">Primary</span>
        <span class="tag is-link">Link</span>
        <span class="tag is-info">Info</span>
        <span class="tag is-success">Success</span>
        <span class="tag is-warning">Warning</span>
        <span class="tag is-danger">Danger</span>
        <span class="tag is-dark">Dark</span>
        <span class="tag is-light">Light</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiKeyboardShortcut from '@/Components/Ui/KeyboardShortcut.vue'
import UiQuickActions from '@/Components/Ui/QuickActions.vue'
import UiSelectionBar from '@/Components/Ui/SelectionBar.vue'
import UiContextMenu from '@/Components/Ui/UiContextMenu.vue'
import UiCommandMenu from '@/Components/Ui/UiCommandMenu.vue'
import UiFileItem from '@/Components/Ui/FileItem.vue'
import UiDropzone from '@/Components/Ui/UiDropzone.vue'
import UiMap from '@/Components/Ui/Map.vue'
import UiComment from '@/Components/Ui/Comment.vue'
import UiList from '@/Components/Ui/List.vue'

const selectionVisible = ref(false)
const commandMenuOpen = ref(false)

const quickActions = [
  { label: 'New File', icon: 'bi bi-plus-circle', shortcut: 'Ctrl+N' },
  { label: 'Open Folder', icon: 'bi bi-folder', shortcut: 'Ctrl+O' },
  { label: 'Save', icon: 'bi bi-save', shortcut: 'Ctrl+S' },
  { label: 'Export', icon: 'bi bi-download' },
]

const contextMenuItems = [
  { label: 'Copy', icon: 'bi bi-copy', shortcut: 'Ctrl+C' },
  { label: 'Paste', icon: 'bi bi-clipboard', shortcut: 'Ctrl+V' },
  { type: 'separator' },
  { label: 'Delete', icon: 'bi bi-trash', danger: true },
]

const commandMenuItems = [
  { id: 1, label: 'New Document', icon: 'bi bi-file-earmark-plus', group: 'File', shortcut: 'Ctrl+N' },
  { id: 2, label: 'Open File', icon: 'bi bi-folder-open', group: 'File', shortcut: 'Ctrl+O' },
  { id: 3, label: 'Save Document', icon: 'bi bi-save', group: 'File', shortcut: 'Ctrl+S' },
  { id: 4, label: 'Copy', icon: 'bi bi-copy', group: 'Edit', shortcut: 'Ctrl+C' },
  { id: 5, label: 'Paste', icon: 'bi bi-clipboard', group: 'Edit', shortcut: 'Ctrl+V' },
  { id: 6, label: 'Settings', icon: 'bi bi-gear', group: 'General' },
]

const mapMarkers = [
  { position: [20.6736, -103.344], popup: 'Zapopan, Jalisco' },
]

const listItems = [
  { title: 'Inbox', subtitle: '5 mensajes nuevos', icon: 'bi bi-inbox', badge: '5', badgeType: 'info' },
  { title: 'Sent', subtitle: 'Mensajes enviados', icon: 'bi bi-send' },
  { title: 'Drafts', subtitle: '2 borradores', icon: 'bi bi-file-earmark', badge: '2', badgeType: 'warning' },
  { title: 'Trash', subtitle: 'Elementos eliminados', icon: 'bi bi-trash', disabled: true },
]

const handleQuickAction = (action, index) => {
  console.log('Quick action:', action.label)
}

const handleContextSelect = (item) => {
  console.log('Context menu:', item.label)
}

const handleCommandSelect = (item) => {
  console.log('Command:', item.label)
}

const handleFileChange = (files) => {
  console.log('Files selected:', files)
}
</script>
