<script setup>
import { ref } from 'vue'
import {
    OrpTabs, OrpModal, OrpSheet, OrpSwitch,
    OrpToast, OrpAccordion, OrpDropdown, OrpPopover,
    OrpDrawer, OrpIconButton,
    OrpSegmented, OrpSearchInput, OrpFileInput, OrpActionSheet,
    OrpDropzone, OrpCommandMenu, OrpContextMenu,
    OrpDataTable, OrpVideoPlayer, OrpAudioPlayer,
    OrpDialog, OrpDialogHost,
    useOrpDialog
} from '@/orp-ui'
import { useOrpTheme } from '@/Composables/OrpUI/useOrpTheme'

const { theme, toggleTheme } = useOrpTheme()

const tabs = [
    { value: 'profile', label: 'Perfil' },
    { value: 'contact', label: 'Contacto' },
    { value: 'settings', label: 'Ajustes' }
]

const activeTab = ref('profile')
const activeTab2 = ref('tab1')
const activeTabPill = ref('tab1')
const activeTabUnderline = ref('tab1')

const tabsOverflow = [
    { value: 'tab1', label: 'Primero' },
    { value: 'tab2', label: 'Segundo' },
    { value: 'tab3', label: 'Tercero' },
    { value: 'tab4', label: 'Cuarto' },
    { value: 'tab5', label: 'Quinto' },
    { value: 'tab6', label: 'Sexto' }
]

const showModalSm = ref(false)
const showModalMd = ref(false)
const showModalLg = ref(false)

const showSheetAuto = ref(false)
const showSheetHalf = ref(false)
const showSheetLarge = ref(false)

const switchChecked = ref(false)
const switchDisabled = ref(false)
const switchLabel = ref(true)

// Toast
const showToast = ref(false)
const showToastSuccess = ref(false)
const showToastWarning = ref(false)
const showToastDanger = ref(false)

// Command Menu
const showCommandMenu = ref(false)
const commandMenuItems = [
    { id: 'dashboard', label: 'Dashboard', description: 'Go to main dashboard', icon: 'bi bi-grid', shortcut: 'G D', group: 'Navigation' },
    { id: 'users', label: 'Users', description: 'Manage user accounts', icon: 'bi bi-people', shortcut: 'G U', group: 'Navigation' },
    { id: 'settings', label: 'Settings', description: 'Application settings', icon: 'bi bi-gear', shortcut: 'G S', group: 'Navigation' },
    { id: 'create', label: 'Create new', description: 'Create a new item', icon: 'bi bi-plus-circle', shortcut: 'N', group: 'Actions' },
    { id: 'edit', label: 'Edit', description: 'Edit selected item', icon: 'bi bi-pencil', shortcut: 'E', group: 'Actions' },
    { id: 'delete', label: 'Delete', description: 'Delete selected item', icon: 'bi bi-trash', shortcut: 'Del', group: 'Actions', danger: true },
    { id: 'share', label: 'Share', description: 'Share this item', icon: 'bi bi-share', shortcut: 'S', group: 'Actions' },
    { id: 'download', label: 'Download', description: 'Download as file', icon: 'bi bi-download', shortcut: 'D', group: 'Actions' },
]

// Context Menu
const contextMenuItems = [
    { label: 'Open', icon: 'bi bi-folder-open' },
    { label: 'Edit', icon: 'bi bi-pencil' },
    { label: 'Duplicate', icon: 'bi bi-copy' },
    { type: 'separator' },
    { label: 'Move to...', icon: 'bi bi-folder-plus' },
    { label: 'Copy link', icon: 'bi bi-link' },
    { type: 'separator' },
    { label: 'Delete', icon: 'bi bi-trash', danger: true },
]

// Selection Bar
const selectedCount = ref(3)

// Accordion
const accordionSingle = ref('one')
const accordionMultiple = ref(['one', 'two'])

const accordionItems = [
    { value: 'one', title: 'Información', content: 'Este es el contenido de la sección de información.' },
    { value: 'two', title: 'Contacto', content: 'Puedes contactarnos por email o teléfono.' },
    { value: 'three', title: 'Privacidad', content: 'Tu información está segura con nosotros.' }
]

// Dropdown
const dropdownOpen = ref(false)
const dropdownBottomEnd = ref(false)

// Popover
const popoverOpen = ref(false)

// Drawer
const showDrawerLeft = ref(false)
const showDrawerRight = ref(false)

// Segmented
const segmentedView = ref('grid')
const segmentedItems = [
    { value: 'grid', label: 'Grid' },
    { value: 'list', label: 'Lista' },
    { value: 'compact', label: 'Compact' }
]

// Search
const searchQuery = ref('')

// ActionSheet
const showActionSheet = ref(false)
const actionSheetActions = [
    { value: 'edit', label: 'Editar' },
    { value: 'share', label: 'Compartir' },
    { value: 'delete', label: 'Eliminar', variant: 'danger' }
]

// DataTable
const tableColumns = [
    { key: 'name', label: 'Name', sortable: true },
    { key: 'email', label: 'Email', sortable: true },
    { key: 'role', label: 'Role', sortable: true },
    { key: 'status', label: 'Status', sortable: true },
    { key: 'actions', label: '' }
]

const tableRows = [
    { id: 1, name: 'Alice Chen', email: 'alice@example.com', role: 'Admin', status: 'Active' },
    { id: 2, name: 'Bob Smith', email: 'bob@example.com', role: 'Editor', status: 'Active' },
    { id: 3, name: 'Carol White', email: 'carol@example.com', role: 'Viewer', status: 'Inactive' },
    { id: 4, name: 'David Brown', email: 'david@example.com', role: 'Editor', status: 'Active' },
    { id: 5, name: 'Eve Davis', email: 'eve@example.com', role: 'Admin', status: 'Pending' }
]

const tableSortKey = ref('name')
const tableSortDirection = ref('asc')
const tableSelectedKeys = ref([])
const tableLoading = ref(false)

// Dialogs
const dialog = useOrpDialog()

const showAlertNeutral = async () => {
    await dialog.alert({
        title: 'Information',
        description: 'This is an informational message.',
        tone: 'neutral',
        confirmText: 'OK'
    })
}

const showAlertSuccess = async () => {
    await dialog.alert({
        title: 'Success',
        description: 'Your changes have been saved successfully.',
        tone: 'success',
        confirmText: 'Got it'
    })
}

const showAlertWarning = async () => {
    await dialog.alert({
        title: 'Warning',
        description: 'Please review your settings before proceeding.',
        tone: 'warning',
        confirmText: 'I understand'
    })
}

const showAlertDanger = async () => {
    await dialog.alert({
        title: 'Error',
        description: 'Something went wrong. Please try again.',
        tone: 'danger',
        confirmText: 'Close'
    })
}

const showConfirm = async () => {
    const confirmed = await dialog.confirm({
        title: 'Delete item?',
        description: 'This action cannot be undone.',
        confirmText: 'Delete',
        cancelText: 'Cancel'
    })
    console.log('Confirmed:', confirmed)
}

const showConfirmDanger = async () => {
    const confirmed = await dialog.confirm({
        title: 'Delete account?',
        description: 'This will permanently delete your account and all associated data. This action cannot be undone.',
        tone: 'danger',
        confirmText: 'Delete Forever',
        cancelText: 'Cancel'
    })
    console.log('Destructive confirmed:', confirmed)
}

const showPrompt = async () => {
    const value = await dialog.prompt({
        title: 'Rename file',
        description: 'Enter a new name for the file.',
        label: 'File name',
        placeholder: 'Enter file name',
        value: 'document.pdf',
        confirmText: 'Rename',
        cancelText: 'Cancel'
    })
    console.log('Prompt value:', value)
}

const showConfirmVertical = async () => {
    const confirmed = await dialog.confirm({
        title: 'Choose an action',
        description: 'What would you like to do with the selected items?',
        confirmText: 'Archive',
        cancelText: 'Keep',
        verticalActions: true
    })
    console.log('Vertical confirm:', confirmed)
}

const showDialogSm = async () => {
    await dialog.alert({
        title: 'Small Dialog',
        description: 'This is a small dialog.',
        size: 'sm',
        confirmText: 'OK'
    })
}

const showDialogMd = async () => {
    await dialog.alert({
        title: 'Medium Dialog',
        description: 'This is a medium-sized dialog with more content.',
        size: 'md',
        confirmText: 'OK'
    })
}

const showDialogLg = async () => {
    await dialog.alert({
        title: 'Large Dialog',
        description: 'This is a large dialog for content that requires more space. It can accommodate longer messages and more complex layouts.',
        size: 'lg',
        confirmText: 'OK'
    })
}
</script>

<template>
  <div class="orp-playground">
    <header class="orp-playground__header">
      <div class="orp-playground__theme-toggle">
        <button
          class="orp-btn orp-btn--ghost"
          @click="toggleTheme"
        >
          {{ theme === 'light' ? '🌙' : '☀️' }} {{ theme === 'light' ? 'Dark' : 'Light' }}
        </button>
      </div>
      <h1 class="orp-h1">ORP UI Playground</h1>
      <p class="orp-text-muted">Mobile-first UI Kit by Orpot</p>
    </header>

    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Colors</h2>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="color-grid">
            <div class="color-swatch" style="background: var(--orp-primary);">Primary</div>
            <div class="color-swatch" style="background: var(--orp-secondary);">Secondary</div>
            <div class="color-swatch" style="background: var(--orp-success);">Success</div>
            <div class="color-swatch" style="background: var(--orp-warning);">Warning</div>
            <div class="color-swatch" style="background: var(--orp-danger);">Danger</div>
            <div class="color-swatch" style="background: var(--orp-surface); border: 1px solid var(--orp-border);">Surface</div>
            <div class="color-swatch" style="background: var(--orp-background);">Background</div>
          </div>
        </div>
      </div>
    </section>

    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Typography</h2>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <h1 class="orp-h1">Heading 1</h1>
          <h2 class="orp-h2">Heading 2</h2>
          <h3 class="orp-h3">Heading 3</h3>
          <h4 class="orp-h4">Heading 4</h4>
          <p>Regular paragraph text with some <span class="orp-text-muted">muted text</span> inside.</p>
        </div>
      </div>
    </section>

    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Buttons</h2>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <p class="orp-mb-3"><strong>Variants</strong></p>
          <div class="orp-flex-row orp-gap-2 orp-mb-4">
            <button class="orp-btn orp-btn--primary">Primary</button>
            <button class="orp-btn orp-btn--secondary">Secondary</button>
            <button class="orp-btn orp-btn--ghost">Ghost</button>
            <button class="orp-btn orp-btn--danger">Danger</button>
          </div>

          <p class="orp-mb-3"><strong>Sizes</strong></p>
          <div class="orp-flex-row orp-gap-2 orp-mb-4">
            <button class="orp-btn orp-btn--primary orp-btn--sm">Small</button>
            <button class="orp-btn orp-btn--primary orp-btn--md">Medium</button>
            <button class="orp-btn orp-btn--primary orp-btn--lg">Large</button>
          </div>

          <p class="orp-mb-3"><strong>Block</strong></p>
          <button class="orp-btn orp-btn--primary orp-btn--block">Block Button</button>
        </div>
      </div>
    </section>

    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Cards</h2>
      <div class="orp-card orp-mb-4">
        <div class="orp-card__header">
          Card Header
        </div>
        <div class="orp-card__body">
          <p>This is a raised card default variant.</p>
        </div>
        <div class="orp-card__footer">
          <button class="orp-btn orp-btn--primary orp-btn--sm">Action</button>
        </div>
      </div>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <p>This is an outlined card variant.</p>
        </div>
      </div>

      <div class="orp-card orp-card--interactive orp-mb-4" tabindex="0">
        <div class="orp-card__body">
          <p><strong>Interactive Card</strong></p>
          <p class="orp-text-muted">Hover or focus to see the effect.</p>
        </div>
      </div>
    </section>

    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Utilities</h2>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <p class="orp-mb-3"><strong>Flex & Gap</strong></p>
          <div class="orp-flex-row orp-gap-3 orp-mb-4">
            <div class="demo-box">1</div>
            <div class="demo-box">2</div>
            <div class="demo-box">3</div>
          </div>

          <p class="orp-mb-3"><strong>Spacing</strong></p>
          <div class="orp-flex-row orp-gap-2">
            <div class="demo-box orp-p-1">p-1</div>
            <div class="demo-box orp-p-2">p-2</div>
            <div class="demo-box orp-p-3">p-3</div>
            <div class="demo-box orp-p-4">p-4</div>
            <div class="demo-box orp-p-5">p-5</div>
          </div>
        </div>
      </div>
    </section>

    <!-- AppBar Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">AppBar</h2>

      <p class="orp-mb-3"><strong>Default</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <header class="orp-app-bar">
          <div class="orp-app-bar__leading">
            <button class="orp-btn orp-btn--ghost orp-icon-btn" aria-label="Volver">
              <i class="bi bi-arrow-left orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-app-bar__content">
            <div class="orp-app-bar__title">Title</div>
          </div>
        </header>
      </div>

      <p class="orp-mb-3"><strong>Bordered</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <header class="orp-app-bar orp-app-bar--bordered">
          <div class="orp-app-bar__leading">
            <button class="orp-btn orp-btn--ghost orp-icon-btn" aria-label="Menu">
              <i class="bi bi-list orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-app-bar__content">
            <div class="orp-app-bar__title">Mi perfil</div>
          </div>
          <div class="orp-app-bar__actions">
            <button class="orp-btn orp-btn--ghost orp-icon-btn" aria-label="Settings">
              <i class="bi bi-gear orp-icon" aria-hidden="true"></i>
            </button>
          </div>
        </header>
      </div>

      <p class="orp-mb-3"><strong>With subtitle</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <header class="orp-app-bar orp-app-bar--bordered">
          <div class="orp-app-bar__leading">
            <button class="orp-btn orp-btn--ghost orp-icon-btn" aria-label="Volver">
              <i class="bi bi-arrow-left orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-app-bar__content">
            <div class="orp-app-bar__title">Daniel López</div>
            <div class="orp-app-bar__subtitle">Editar perfil</div>
          </div>
        </header>
      </div>
    </section>

    <!-- BottomNav Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">BottomNav</h2>

      <p class="orp-mb-3"><strong>3 items</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <nav class="orp-bottom-nav" aria-label="Navegación principal">
          <button class="orp-bottom-nav__item orp-bottom-nav__item--active" aria-current="page">
            <i class="bi bi-house orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Inicio</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-search orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Buscar</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-person orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Perfil</span>
          </button>
        </nav>
      </div>

      <p class="orp-mb-3"><strong>4 items</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <nav class="orp-bottom-nav" aria-label="Navegación principal">
          <button class="orp-bottom-nav__item orp-bottom-nav__item--active" aria-current="page">
            <i class="bi bi-house orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Inicio</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-clipboard orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Citas</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-chat orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Chat</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-person orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Perfil</span>
          </button>
        </nav>
      </div>

      <p class="orp-mb-3"><strong>With badge</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <nav class="orp-bottom-nav" aria-label="Navegación principal">
          <button class="orp-bottom-nav__item orp-bottom-nav__item--active" aria-current="page">
            <i class="bi bi-house orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Inicio</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-chat orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Chat</span>
            <span class="orp-badge orp-badge--danger" style="position: absolute; top: 4px; right: 20%;">3</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-person orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Perfil</span>
          </button>
        </nav>
      </div>
    </section>

    <!-- Avatar Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Avatar</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-3 orp-align-center">
            <div class="orp-avatar orp-avatar--sm">
              <span class="orp-avatar__fallback">SM</span>
            </div>
            <div class="orp-avatar orp-avatar--md">
              <span class="orp-avatar__fallback">MD</span>
            </div>
            <div class="orp-avatar orp-avatar--lg">
              <span class="orp-avatar__fallback">LG</span>
            </div>
            <div class="orp-avatar orp-avatar--xl">
              <span class="orp-avatar__fallback">XL</span>
            </div>
          </div>

          <hr style="margin: 16px 0; border: none; border-top: 1px solid var(--orp-border);">

          <p class="orp-mb-3"><strong>With image</strong></p>
          <div class="orp-flex-row orp-gap-3 orp-align-center">
            <div class="orp-avatar orp-avatar--md">
              <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=1" alt="User 1">
            </div>
            <div class="orp-avatar orp-avatar--lg">
              <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=2" alt="User 2">
            </div>
          </div>

          <hr style="margin: 16px 0; border: none; border-top: 1px solid var(--orp-border);">

          <p class="orp-mb-3"><strong>With status</strong></p>
          <div class="orp-flex-row orp-gap-3 orp-align-center">
            <div class="orp-avatar orp-avatar--md">
              <span class="orp-avatar__fallback">DL</span>
              <span class="orp-avatar__status orp-avatar__status--online"></span>
            </div>
            <div class="orp-avatar orp-avatar--md">
              <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=3" alt="User 3">
              <span class="orp-avatar__status orp-avatar__status--offline"></span>
            </div>
            <div class="orp-avatar orp-avatar--md">
              <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=4" alt="User 4">
              <span class="orp-avatar__status orp-avatar__status--busy"></span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Badge Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Badge</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-2 orp-align-center" style="flex-wrap: wrap;">
            <span class="orp-badge orp-badge--primary">Primary</span>
            <span class="orp-badge orp-badge--secondary">Secondary</span>
            <span class="orp-badge orp-badge--success">Success</span>
            <span class="orp-badge orp-badge--warning">Warning</span>
            <span class="orp-badge orp-badge--danger">Danger</span>
            <span class="orp-badge orp-badge--outline">Outline</span>
          </div>
        </div>
      </div>
    </section>

    <!-- List Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">List</h2>

      <p class="orp-mb-3"><strong>Default</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-list">
          <div class="orp-list__item">
            <div class="orp-list__leading">
              <div class="orp-avatar orp-avatar--md">
                <span class="orp-avatar__fallback">DL</span>
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Daniel López</div>
              <div class="orp-list__subtitle">daniel@ejemplo.com</div>
            </div>
          </div>
          <div class="orp-list__item">
            <div class="orp-list__leading">
              <div class="orp-avatar orp-avatar--md">
                <span class="orp-avatar__fallback">MR</span>
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">María Rodríguez</div>
              <div class="orp-list__subtitle">maria@ejemplo.com</div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Divided</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-list orp-list--divided">
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <div class="orp-avatar orp-avatar--md">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=5" alt="User">
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Configuración</div>
              <div class="orp-list__subtitle">Preferencias de la cuenta</div>
            </div>
            <div class="orp-list__trailing">
              <span class="orp-badge orp-badge--success">Activo</span>
            </div>
          </button>
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <div class="orp-avatar orp-avatar--md">
                <span class="orp-avatar__fallback">NS</span>
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Notificaciones</div>
              <div class="orp-list__subtitle">3 nuevas</div>
            </div>
            <div class="orp-list__trailing">
              <span class="orp-badge orp-badge--danger">3</span>
            </div>
          </button>
          <button class="orp-list__item orp-list__item--interactive" disabled>
            <div class="orp-list__leading">
              <div class="orp-avatar orp-avatar--md">
                <span class="orp-avatar__fallback">AP</span>
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Ayuda</div>
              <div class="orp-list__subtitle">Deshabilitado</div>
            </div>
          </button>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Inset</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-list orp-list--inset">
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <i class="bi bi-folder orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Documentos</div>
            </div>
          </button>
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <i class="bi bi-image orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Fotos</div>
            </div>
          </button>
        </div>
      </div>
    </section>

    <!-- Composition Example -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Composition</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <header class="orp-app-bar orp-app-bar--bordered">
          <div class="orp-app-bar__leading">
            <button class="orp-btn orp-btn--ghost orp-icon-btn" aria-label="Volver">
              <i class="bi bi-arrow-left orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-app-bar__content">
            <div class="orp-app-bar__title">Mi cuenta</div>
          </div>
        </header>

        <div class="orp-list orp-list--divided">
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <div class="orp-avatar orp-avatar--md">
                <span class="orp-avatar__fallback">DL</span>
                <span class="orp-avatar__status orp-avatar__status--online"></span>
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Daniel López</div>
              <div class="orp-list__subtitle">Editar perfil</div>
            </div>
            <div class="orp-list__trailing">
              <span class="orp-badge orp-badge--success">Activo</span>
            </div>
          </button>
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <i class="bi bi-gear orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Configuración</div>
              <div class="orp-list__subtitle">Preferencias</div>
            </div>
          </button>
          <button class="orp-list__item orp-list__item--interactive">
            <div class="orp-list__leading">
              <i class="bi bi-bell orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-list__content">
              <div class="orp-list__title">Notificaciones</div>
            </div>
            <div class="orp-list__trailing">
              <span class="orp-badge orp-badge--danger">5</span>
            </div>
          </button>
        </div>

        <nav class="orp-bottom-nav" aria-label="Navegación principal">
          <button class="orp-bottom-nav__item orp-bottom-nav__item--active" aria-current="page">
            <i class="bi bi-person orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Perfil</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-clipboard orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Citas</span>
          </button>
          <button class="orp-bottom-nav__item">
            <i class="bi bi-chat orp-icon orp-bottom-nav__icon" aria-hidden="true"></i>
            <span class="orp-bottom-nav__label">Chat</span>
          </button>
        </nav>
      </div>
    </section>

    <!-- Tabs Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Tabs</h2>

      <p class="orp-mb-3"><strong>Default</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpTabs v-model="activeTab" :items="tabs" />
          <div class="orp-p-4">
            <p v-if="activeTab === 'profile'">Contenido de Perfil</p>
            <p v-if="activeTab === 'contact'">Contenido de Contacto</p>
            <p v-if="activeTab === 'settings'">Contenido de Ajustes</p>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Pill</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpTabs v-model="activeTabPill" :items="tabs" variant="pill" />
          <div class="orp-p-4">
            <p v-if="activeTabPill === 'profile'">Contenido de Perfil</p>
            <p v-if="activeTabPill === 'contact'">Contenido de Contacto</p>
            <p v-if="activeTabPill === 'settings'">Contenido de Ajustes</p>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Underline</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpTabs v-model="activeTabUnderline" :items="tabs" variant="underline" />
          <div class="orp-p-4">
            <p v-if="activeTabUnderline === 'profile'">Contenido de Perfil</p>
            <p v-if="activeTabUnderline === 'contact'">Contenido de Contacto</p>
            <p v-if="activeTabUnderline === 'settings'">Contenido de Ajustes</p>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Overflow scroll</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpTabs v-model="activeTab2" :items="tabsOverflow" />
        </div>
      </div>
    </section>

    <!-- Modal Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Modal</h2>

      <div class="orp-alert orp-alert--info orp-mb-4">
        <strong>Keyboard:</strong> Try Tab / Shift+Tab to cycle focus within modal, Escape to close.
      </div>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-3 orp-flex-wrap">
            <button class="orp-btn orp-btn--primary" @click="showModalSm = true">Small</button>
            <button class="orp-btn orp-btn--primary" @click="showModalMd = true">Default</button>
            <button class="orp-btn orp-btn--primary" @click="showModalLg = true">Large</button>
          </div>
        </div>
      </div>
    </section>

    <OrpModal v-model="showModalSm" title="Small Modal" size="sm">
      <p>This is a small modal dialog.</p>
      <template #footer>
        <button class="orp-btn orp-btn--ghost" @click="showModalSm = false">Cancelar</button>
        <button class="orp-btn orp-btn--primary">Aceptar</button>
      </template>
    </OrpModal>

    <OrpModal v-model="showModalMd" title="Default Modal" size="md" description="This is an optional description text that provides additional context.">
      <p>This is a default modal dialog. It has medium width.</p>
      <p>你可以在这里放置任何内容。</p>
      <template #footer>
        <button class="orp-btn orp-btn--ghost" @click="showModalMd = false">Cancelar</button>
        <button class="orp-btn orp-btn--primary">Aceptar</button>
      </template>
    </OrpModal>

    <OrpModal v-model="showModalLg" title="Large Modal" size="lg">
      <p>This is a large modal dialog.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <template #footer>
        <button class="orp-btn orp-btn--ghost" @click="showModalLg = false">Cancelar</button>
        <button class="orp-btn orp-btn--primary">Aceptar</button>
      </template>
    </OrpModal>

    <!-- Sheet Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Sheet</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-3 orp-flex-wrap">
            <button class="orp-btn orp-btn--primary" @click="showSheetAuto = true">Auto</button>
            <button class="orp-btn orp-btn--primary" @click="showSheetHalf = true">Half</button>
            <button class="orp-btn orp-btn--primary" @click="showSheetLarge = true">Large</button>
          </div>
        </div>
      </div>
    </section>

    <OrpSheet v-model="showSheetAuto" title="Auto Sheet" height="auto">
      <div class="orp-d-flex orp-flex-column orp-gap-3">
        <button class="orp-btn orp-btn--primary orp-btn--block">WhatsApp</button>
        <button class="orp-btn orp-btn--secondary orp-btn--block">Llamar</button>
        <button class="orp-btn orp-btn--ghost orp-btn--block">Correo</button>
      </div>
    </OrpSheet>

    <OrpSheet v-model="showSheetHalf" title="Half Sheet" height="half">
      <div class="orp-d-flex orp-flex-column orp-gap-3">
        <p>Contenido adicional...</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
    </OrpSheet>

    <OrpSheet v-model="showSheetLarge" title="Large Sheet" height="large">
      <div class="orp-d-flex orp-flex-column orp-gap-3">
        <p>Contenido largo...</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
        <p>nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </OrpSheet>

    <!-- Switch Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Switch</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-column orp-gap-4">
            <div class="orp-d-flex orp-flex-row orp-align-center orp-gap-4">
              <OrpSwitch v-model="switchChecked" />
              <span>{{ switchChecked ? 'Encendido' : 'Apagado' }}</span>
            </div>

            <div class="orp-d-flex orp-flex-row orp-align-center orp-gap-4">
              <OrpSwitch v-model="switchLabel" label="Notificaciones" />
            </div>

            <div class="orp-d-flex orp-flex-row orp-align-center orp-gap-4">
              <OrpSwitch v-model="switchDisabled" disabled />
              <span>Deshabilitado</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Forms Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Forms</h2>

      <p class="orp-mb-3"><strong>Input</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-field orp-mb-4">
            <label class="orp-label" for="name">Nombre</label>
            <input id="name" class="orp-input" type="text" placeholder="Tu nombre">
          </div>

          <div class="orp-field orp-mb-4">
            <label class="orp-label" for="email">Correo</label>
            <input id="email" class="orp-input" type="email" placeholder="tu@email.com">
            <div class="orp-help">Nunca compartiremos tu correo.</div>
          </div>

          <div class="orp-field orp-mb-4">
            <label class="orp-label" for="disabled">Deshabilitado</label>
            <input id="disabled" class="orp-input" type="text" value="No editable" disabled>
          </div>

          <div class="orp-field orp-mb-4">
            <label class="orp-label" for="readonly">Solo lectura</label>
            <input id="readonly" class="orp-input" type="text" value="No editable" readonly>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Textarea</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-field orp-mb-4">
            <label class="orp-label" for="message">Mensaje</label>
            <textarea id="message" class="orp-textarea" placeholder="Escribe tu mensaje..."></textarea>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Select</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-field orp-mb-4">
            <label class="orp-label" for="country">País</label>
            <select id="country" class="orp-select">
              <option value="">Selecciona...</option>
              <option value="mx">México</option>
              <option value="co">Colombia</option>
              <option value="ar">Argentina</option>
              <option value="es">España</option>
            </select>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Error state</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-field orp-field--invalid orp-mb-4">
            <label class="orp-field__label" for="email-error">Correo electrónico</label>
            <input
              id="email-error"
              class="orp-input"
              type="email"
              value="correo-invalido"
              aria-invalid="true"
              aria-describedby="email-error-msg"
            >
            <div id="email-error-msg" class="orp-field__error">Ingresa un correo electrónico válido.</div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Required field</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-field orp-mb-4">
            <label class="orp-field__label" for="required-name">
              Nombre
              <span class="orp-field__required" aria-hidden="true">*</span>
            </label>
            <input id="required-name" class="orp-input" type="text" placeholder="Requerido" required>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Optional field</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-field orp-mb-4">
            <label class="orp-field__label" for="optional-name">
              Apodo
              <span class="orp-field__optional">(Opcional)</span>
            </label>
            <input id="optional-name" class="orp-input" type="text" placeholder="No requerido">
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Field Group (Checkbox)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <fieldset class="orp-field-group">
            <legend class="orp-field-group__legend">
              Preferencias de contacto
            </legend>
            <div class="orp-stack orp-stack--3">
              <label class="orp-checkbox">
                <input type="checkbox" class="orp-checkbox__input" value="email">
                <span class="orp-checkbox__control"></span>
                <span class="orp-checkbox__label">Correo electrónico</span>
              </label>
              <label class="orp-checkbox">
                <input type="checkbox" class="orp-checkbox__input" value="sms">
                <span class="orp-checkbox__control"></span>
                <span class="orp-checkbox__label">SMS</span>
              </label>
              <label class="orp-checkbox">
                <input type="checkbox" class="orp-checkbox__input" value="whatsapp">
                <span class="orp-checkbox__control"></span>
                <span class="orp-checkbox__label">WhatsApp</span>
              </label>
            </div>
          </fieldset>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Field Group (Radio)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <fieldset class="orp-field-group">
            <legend class="orp-field-group__legend">
              Método de envío
            </legend>
            <div class="orp-stack orp-stack--3">
              <label class="orp-radio">
                <input type="radio" class="orp-radio__input" name="shipping" value="standard">
                <span class="orp-radio__control"></span>
                <span class="orp-radio__label">Estándar (5-7 días)</span>
              </label>
              <label class="orp-radio">
                <input type="radio" class="orp-radio__input" name="shipping" value="express">
                <span class="orp-radio__control"></span>
                <span class="orp-radio__label">Expreso (2-3 días)</span>
              </label>
              <label class="orp-radio">
                <input type="radio" class="orp-radio__input" name="shipping" value="overnight">
                <span class="orp-radio__control"></span>
                <span class="orp-radio__label">Día siguiente</span>
              </label>
            </div>
          </fieldset>
        </div>
      </div>
    </section>

    <!-- Toast Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Toast</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-3 orp-flex-wrap">
            <button class="orp-btn orp-btn--primary" @click="showToast = true">Default</button>
            <button class="orp-btn orp-btn--primary" @click="showToastSuccess = true">Success</button>
            <button class="orp-btn orp-btn--primary" @click="showToastWarning = true">Warning</button>
            <button class="orp-btn orp-btn--primary" @click="showToastDanger = true">Danger</button>
          </div>
        </div>
      </div>
    </section>

    <OrpToast v-model="showToast" message="Notification message" position="bottom" />
    <OrpToast v-model="showToastSuccess" message="Cambios guardados" variant="success" position="bottom" />
    <OrpToast v-model="showToastWarning" message="Atención: Revisa los datos" variant="warning" position="top" />
    <OrpToast v-model="showToastDanger" message="Error: No se pudo guardar" variant="danger" position="bottom" :duration="0" closable />

    <!-- Alert Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Alert</h2>

      <p class="orp-mb-3"><strong>Info</strong></p>
      <div class="orp-alert orp-alert--info orp-mb-4">
        <div class="orp-alert__content">
          <div class="orp-alert__message">Información útil para el usuario.</div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Success</strong></p>
      <div class="orp-alert orp-alert--success orp-mb-4">
        <div class="orp-alert__content">
          <div class="orp-alert__title">Éxito</div>
          <div class="orp-alert__message">Los cambios se guardaron correctamente.</div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Warning</strong></p>
      <div class="orp-alert orp-alert--warning orp-mb-4">
        <div class="orp-alert__content">
          <div class="orp-alert__title">Atención</div>
          <div class="orp-alert__message">Algunos datos pueden estar incompletos.</div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Danger</strong></p>
      <div class="orp-alert orp-alert--danger orp-mb-4">
        <div class="orp-alert__content">
          <div class="orp-alert__title">Error</div>
          <div class="orp-alert__message">No se pudo procesar la solicitud.</div>
        </div>
      </div>
    </section>

    <!-- Accordion Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Accordion</h2>

      <p class="orp-mb-3"><strong>Single</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpAccordion v-model="accordionSingle" :items="accordionItems" />
        </div>
      </div>

      <p class="orp-mb-3"><strong>Multiple</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpAccordion v-model="accordionMultiple" :items="accordionItems" multiple />
        </div>
      </div>
    </section>

    <!-- Dropdown Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Dropdown</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-4 orp-flex-wrap">
            <OrpDropdown v-model="dropdownOpen" placement="bottom-start">
              <template #trigger>
                <button class="orp-btn orp-btn--primary">Menu</button>
              </template>
              <button class="orp-dropdown__item">Editar</button>
              <button class="orp-dropdown__item">Duplicar</button>
              <div class="orp-dropdown__divider"></div>
              <button class="orp-dropdown__item orp-dropdown__item--danger">Eliminar</button>
            </OrpDropdown>

            <OrpDropdown v-model="dropdownBottomEnd" placement="bottom-end">
              <template #trigger>
                <button class="orp-btn orp-btn--secondary">Alinear a derecha</button>
              </template>
              <button class="orp-dropdown__item">Opción 1</button>
              <button class="orp-dropdown__item">Opción 2</button>
            </OrpDropdown>
          </div>
        </div>
      </div>
    </section>

    <!-- Popover Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Popover</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpPopover v-model="popoverOpen" placement="bottom-start">
            <template #trigger>
              <button class="orp-btn orp-btn--secondary">Información</button>
            </template>
            <div class="orp-p-4">
              <p class="orp-mb-2"><strong>Detalles</strong></p>
              <p class="orp-text-muted">Este es contenido adicional que aparece en el popover.</p>
            </div>
          </OrpPopover>
        </div>
      </div>
    </section>

    <!-- Drawer Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Drawer</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-flex-row orp-gap-3 orp-flex-wrap">
            <button class="orp-btn orp-btn--primary" @click="showDrawerLeft = true">Left</button>
            <button class="orp-btn orp-btn--primary" @click="showDrawerRight = true">Right</button>
          </div>
        </div>
      </div>
    </section>

    <OrpDrawer v-model="showDrawerLeft" position="left" title="Menú">
      <div class="orp-list orp-list--divided">
        <button class="orp-list__item orp-list__item--interactive">Inicio</button>
        <button class="orp-list__item orp-list__item--interactive">Perfil</button>
        <button class="orp-list__item orp-list__item--interactive">Configuración</button>
        <button class="orp-list__item orp-list__item--interactive">Cerrar sesión</button>
      </div>
    </OrpDrawer>

    <OrpDrawer v-model="showDrawerRight" position="right" title="Notificaciones">
      <div class="orp-p-4">
        <p class="orp-text-muted">No hay notificaciones nuevas.</p>
      </div>
      <template #footer>
        <button class="orp-btn orp-btn--ghost" @click="showDrawerRight = false">Cerrar</button>
        <button class="orp-btn orp-btn--primary">Ver todo</button>
      </template>
    </OrpDrawer>

    <!-- IconButton Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">IconButton</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <p class="orp-mb-3"><strong>Variants</strong></p>
          <div class="orp-flex-row orp-gap-3 orp-mb-4">
            <OrpIconButton aria-label="Primary" variant="primary">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
              </svg>
            </OrpIconButton>
            <OrpIconButton aria-label="Ghost" variant="ghost">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
              </svg>
            </OrpIconButton>
            <OrpIconButton aria-label="Danger" variant="danger">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
              </svg>
            </OrpIconButton>
          </div>

          <p class="orp-mb-3"><strong>Sizes</strong></p>
          <div class="orp-flex-row orp-gap-3 orp-align-center orp-mb-4">
            <OrpIconButton aria-label="Small" size="sm" variant="ghost">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
              </svg>
            </OrpIconButton>
            <OrpIconButton aria-label="Medium" size="md" variant="ghost">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
              </svg>
            </OrpIconButton>
            <OrpIconButton aria-label="Large" size="lg" variant="ghost">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
              </svg>
            </OrpIconButton>
          </div>

          <p class="orp-mb-3"><strong>Disabled</strong></p>
          <div class="orp-flex-row orp-gap-3">
            <OrpIconButton aria-label="Disabled" disabled variant="ghost">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
              </svg>
            </OrpIconButton>
          </div>
        </div>
      </div>
    </section>

    <!-- Checkbox Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Checkbox</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-column orp-gap-4">
            <label class="orp-checkbox">
              <input type="checkbox" class="orp-checkbox__input">
              <span class="orp-checkbox__control"></span>
              <span class="orp-checkbox__label">Acepto los términos</span>
            </label>

            <label class="orp-checkbox">
              <input type="checkbox" class="orp-checkbox__input" checked>
              <span class="orp-checkbox__control"></span>
              <span class="orp-checkbox__label">Checked</span>
            </label>

            <label class="orp-checkbox">
              <input type="checkbox" class="orp-checkbox__input" disabled>
              <span class="orp-checkbox__control"></span>
              <span class="orp-checkbox__label">Disabled</span>
            </label>
          </div>
        </div>
      </div>
    </section>

    <!-- Radio Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Radio</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-column orp-gap-4">
            <label class="orp-radio">
              <input type="radio" name="plan" value="basic" class="orp-radio__input" checked>
              <span class="orp-radio__control"></span>
              <span class="orp-radio__label">Plan Básico</span>
            </label>

            <label class="orp-radio">
              <input type="radio" name="plan" value="pro" class="orp-radio__input">
              <span class="orp-radio__control"></span>
              <span class="orp-radio__label">Plan Pro</span>
            </label>

            <label class="orp-radio">
              <input type="radio" name="plan" value="disabled" class="orp-radio__input" disabled>
              <span class="orp-radio__control"></span>
              <span class="orp-radio__label">Disabled</span>
            </label>
          </div>
        </div>
      </div>
    </section>

    <!-- Segmented Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Segmented Control</h2>

      <p class="orp-mb-3"><strong>Default</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpSegmented v-model="segmentedView" :items="segmentedItems" />
          <div class="orp-p-4">
            <p>Selected: {{ segmentedView }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Search Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Search Input</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpSearchInput v-model="searchQuery" placeholder="Buscar..." clearable />
          <div class="orp-mt-3">
            <p class="orp-text-muted">Query: "{{ searchQuery }}"</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FileInput Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">File Input</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpFileInput label="Subir archivo" accept="image/*" :max-size="5" help="Máximo 5MB" />
        </div>
      </div>
    </section>

    <!-- Progress Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Progress</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <p class="orp-mb-3">25%</p>
          <div class="orp-progress orp-mb-4">
            <div class="orp-progress__bar orp-progress__bar--primary" style="width: 25%"></div>
          </div>

          <p class="orp-mb-3">Success 50%</p>
          <div class="orp-progress orp-mb-4">
            <div class="orp-progress__bar orp-progress__bar--success" style="width: 50%"></div>
          </div>

          <p class="orp-mb-3">Danger 75%</p>
          <div class="orp-progress orp-mb-4">
            <div class="orp-progress__bar orp-progress__bar--danger" style="width: 75%"></div>
          </div>

          <p class="orp-mb-3">Indeterminate</p>
          <div class="orp-progress orp-progress--indeterminate">
            <div class="orp-progress__bar orp-progress__bar--primary"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Spinner Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Spinner</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-align-center orp-gap-4">
            <span class="orp-spinner orp-spinner--sm"></span>
            <span class="orp-spinner orp-spinner--md"></span>
            <span class="orp-spinner orp-spinner--lg"></span>
          </div>

          <hr class="orp-my-4">

          <div class="orp-d-flex orp-align-center orp-gap-3">
            <button class="orp-btn orp-btn--primary">
              <span class="orp-spinner orp-spinner--sm"></span>
              Guardando
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Skeleton Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Skeleton</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-column orp-gap-3">
            <div class="orp-skeleton orp-skeleton--text" style="width: 60%"></div>
            <div class="orp-skeleton orp-skeleton--text"></div>
            <div class="orp-skeleton orp-skeleton--text" style="width: 80%"></div>
          </div>

          <hr class="orp-my-4">

          <div class="orp-d-flex orp-align-center orp-gap-3">
            <div class="orp-skeleton orp-skeleton--circle" style="width: 40px; height: 40px;"></div>
            <div class="orp-d-flex orp-flex-column orp-gap-2">
              <div class="orp-skeleton orp-skeleton--text" style="width: 120px"></div>
              <div class="orp-skeleton orp-skeleton--text" style="width: 80px"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Empty State Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Empty State</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-empty">
            <div class="orp-empty__media">
              <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/>
                <path d="M8 15s1.5 2 4 2 4-2 4-2"/>
                <line x1="9" y1="9" x2="9.01" y2="9"/>
                <line x1="15" y1="9" x2="15.01" y2="9"/>
              </svg>
            </div>
            <h3 class="orp-empty__title">No hay resultados</h3>
            <p class="orp-empty__description">Intenta cambiar los filtros para encontrar lo que buscas.</p>
            <div class="orp-empty__actions">
              <button class="orp-btn orp-btn--primary">Limpiar filtros</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAB Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">FAB</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4 orp-align-center">
            <button class="orp-fab" aria-label="Crear">
              <span class="orp-fab__icon">+</span>
            </button>

            <button class="orp-fab orp-fab--secondary" aria-label="Secondary">
              <span class="orp-fab__icon">⚡</span>
            </button>

            <button class="orp-fab orp-fab--extended" aria-label="Extended">
              <span class="orp-fab__icon">+</span>
              <span class="orp-fab__label">Crear</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ActionSheet Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">ActionSheet</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <button class="orp-btn orp-btn--primary" @click="showActionSheet = true">Open ActionSheet</button>
        </div>
      </div>
    </section>

    <OrpActionSheet
      v-model="showActionSheet"
      title="Acciones"
      :actions="actionSheetActions"
      cancel-label="Cancelar"
      show-cancel
      @select="(action) => console.log('Selected:', action.value)"
    />

    <!-- ============================================= -->
    <!-- Phase 7: Content & Layout Primitives -->
    <!-- ============================================= -->

    <!-- Page Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Page</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <main class="orp-page" style="margin: calc(-1 * var(--orp-space-4)); padding: var(--orp-space-4); background: var(--orp-surface-muted);">
            <div class="orp-page__content">
              <p class="orp-text-muted">Page primitive with content area</p>
            </div>
          </main>
        </div>
      </div>
    </section>

    <!-- Section Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Section</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <section class="orp-section">
            <header class="orp-section__header">
              <div>
                <h3 class="orp-section__title">Recomendados</h3>
                <p class="orp-section__subtitle">Selección para ti</p>
              </div>
              <a href="#" class="orp-section__action">Ver todos</a>
            </header>
            <div class="orp-section__body">
              <div class="orp-d-flex orp-flex-column orp-gap-2">
                <div class="orp-skeleton orp-skeleton--text" style="width: 80%"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 60%"></div>
              </div>
            </div>
          </section>

          <hr class="orp-divider orp-my-4">

          <section class="orp-section orp-section--compact">
            <header class="orp-section__header">
              <div>
                <h3 class="orp-section__title">Compact Section</h3>
              </div>
              <button class="orp-section__action">Action</button>
            </header>
          </section>
        </div>
      </div>
    </section>

    <!-- Stack Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Stack</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-stack orp-stack--1 orp-mb-4">
            <div class="orp-skeleton orp-skeleton--text" style="width: 40%"></div>
            <div class="orp-skeleton orp-skeleton--text" style="width: 60%"></div>
            <div class="orp-skeleton orp-skeleton--text" style="width: 30%"></div>
          </div>
          <div class="orp-stack orp-stack--4">
            <div class="orp-skeleton orp-skeleton--text" style="width: 40%"></div>
            <div class="orp-skeleton orp-skeleton--text" style="width: 60%"></div>
            <div class="orp-skeleton orp-skeleton--text" style="width: 30%"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Cluster Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Cluster</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-cluster orp-cluster--2">
            <span class="orp-chip">Nuevo</span>
            <span class="orp-chip">Popular</span>
            <span class="orp-chip"> trending</span>
            <span class="orp-chip orp-chip--outline">Destacado</span>
          </div>

          <hr class="orp-divider orp-my-4">

          <div class="orp-cluster orp-cluster--3">
            <span class="orp-badge orp-badge--primary">Primary</span>
            <span class="orp-badge orp-badge--success">Success</span>
            <span class="orp-badge orp-badge--warning">Warning</span>
            <span class="orp-badge orp-badge--danger">Danger</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Scroll X Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Horizontal Scroll</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-scroll-x orp-scroll-x--snap orp-scroll-x--peek">
            <article class="orp-scroll-x__item" style="width: 140px;">
              <div class="orp-card orp-card--outlined" style="padding: var(--orp-space-3); text-align: center;">
                <div class="orp-skeleton orp-skeleton--rect" style="width: 100%; aspect-ratio: 1; margin-bottom: 8px;"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 80%; margin: 0 auto;"></div>
              </div>
            </article>
            <article class="orp-scroll-x__item" style="width: 140px;">
              <div class="orp-card orp-card--outlined" style="padding: var(--orp-space-3); text-align: center;">
                <div class="orp-skeleton orp-skeleton--rect" style="width: 100%; aspect-ratio: 1; margin-bottom: 8px;"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 60%; margin: 0 auto;"></div>
              </div>
            </article>
            <article class="orp-scroll-x__item" style="width: 140px;">
              <div class="orp-card orp-card--outlined" style="padding: var(--orp-space-3); text-align: center;">
                <div class="orp-skeleton orp-skeleton--rect" style="width: 100%; aspect-ratio: 1; margin-bottom: 8px;"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 70%; margin: 0 auto;"></div>
              </div>
            </article>
            <article class="orp-scroll-x__item" style="width: 140px;">
              <div class="orp-card orp-card--outlined" style="padding: var(--orp-space-3); text-align: center;">
                <div class="orp-skeleton orp-skeleton--rect" style="width: 100%; aspect-ratio: 1; margin-bottom: 8px;"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 50%; margin: 0 auto;"></div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- Media Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Media</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4 orp-justify-center">
            <div style="width: 120px;">
              <p class="orp-text-muted orp-mb-2" style="font-size: 0.75rem;">Square</p>
              <div class="orp-media orp-media--square orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/200/200?random=1" alt="" loading="lazy">
              </div>
            </div>
            <div style="width: 120px;">
              <p class="orp-text-muted orp-mb-2" style="font-size: 0.75rem;">Portrait</p>
              <div class="orp-media orp-media--portrait orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/200/267?random=2" alt="" loading="lazy">
              </div>
            </div>
            <div style="width: 120px;">
              <p class="orp-text-muted orp-mb-2" style="font-size: 0.75rem;">Landscape</p>
              <div class="orp-media orp-media--landscape orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/267/200?random=3" alt="" loading="lazy">
              </div>
            </div>
            <div style="width: 160px;">
              <p class="orp-text-muted orp-mb-2" style="font-size: 0.75rem;">Wide (16:9)</p>
              <div class="orp-media orp-media--wide orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/320/180?random=4" alt="" loading="lazy">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Media Card Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Media Card</h2>

      <p class="orp-mb-3"><strong>Default</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <article class="orp-media-card" style="max-width: 320px;">
            <div class="orp-media-card__media">
              <div class="orp-media orp-media--landscape orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/320/180?random=10" alt="" loading="lazy">
              </div>
            </div>
            <div class="orp-media-card__body">
              <div class="orp-media-card__eyebrow">Destacado</div>
              <h3 class="orp-media-card__title">Título del contenido</h3>
              <p class="orp-media-card__description">Descripción breve del elemento.</p>
            </div>
          </article>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <article class="orp-media-card orp-media-card--compact" style="max-width: 200px;">
            <div class="orp-media-card__media">
              <div class="orp-media orp-media--square orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/200/200?random=11" alt="" loading="lazy">
              </div>
            </div>
            <div class="orp-media-card__body">
              <h3 class="orp-media-card__title">Categoría</h3>
            </div>
          </article>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Horizontal</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <article class="orp-media-card orp-media-card--horizontal">
            <div class="orp-media-card__media">
              <div class="orp-media orp-media--square">
                <img class="orp-media__content" src="https://picsum.photos/200/200?random=12" alt="" loading="lazy">
              </div>
            </div>
            <div class="orp-media-card__body">
              <h3 class="orp-media-card__title">Título horizontal</h3>
              <div class="orp-meta">
                <span class="orp-meta__item">5 min</span>
              </div>
            </div>
          </article>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Featured</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <article class="orp-media-card orp-media-card--featured">
            <div class="orp-media-card__media">
              <div class="orp-media orp-media--wide orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/640/360?random=13" alt="" loading="lazy">
              </div>
            </div>
            <div class="orp-media-card__body">
              <div class="orp-media-card__eyebrow">Featured</div>
              <h3 class="orp-media-card__title">Contenido destacado con título largo que puede truncate</h3>
              <p class="orp-media-card__description orp-media-card__description--clamp">Esta es una descripción más larga que debería truncarse después de dos líneas.</p>
            </div>
          </article>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Interactive</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <article class="orp-media-card orp-media-card--interactive" style="max-width: 320px;">
            <div class="orp-media-card__media">
              <div class="orp-media orp-media--landscape orp-media--rounded">
                <img class="orp-media__content" src="https://picsum.photos/320/180?random=14" alt="" loading="lazy">
              </div>
            </div>
            <div class="orp-media-card__body">
              <h3 class="orp-media-card__title">Card interactiva</h3>
              <p class="orp-media-card__description">Hover para ver el efecto</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Hero Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Hero</h2>

      <p class="orp-mb-3"><strong>Default</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4" style="overflow: hidden;">
        <div class="orp-hero orp-hero--default orp-hero--center">
          <div class="orp-hero__media">
            <img src="https://picsum.photos/640/280?random=20" alt="" loading="lazy">
          </div>
          <div class="orp-hero__overlay"></div>
          <div class="orp-hero__content">
            <div class="orp-hero__eyebrow">Nuevo</div>
            <h1 class="orp-hero__title">Título principal</h1>
            <p class="orp-hero__description">Texto promocional o descriptivo para el hero banner.</p>
            <div class="orp-hero__actions">
              <button class="orp-btn orp-btn--primary">Ver más</button>
              <button class="orp-btn orp-btn--ghost" style="color: white; border-color: rgba(255,255,255,0.5);">Secondary</button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4" style="overflow: hidden;">
        <div class="orp-hero orp-hero--compact orp-hero--start">
          <div class="orp-hero__media">
            <img src="https://picsum.photos/640/160?random=21" alt="" loading="lazy">
          </div>
          <div class="orp-hero__overlay"></div>
          <div class="orp-hero__content">
            <h2 class="orp-hero__title" style="font-size: var(--orp-font-size-lg);">Hero compacto</h2>
          </div>
        </div>
      </div>
    </section>

    <!-- Chip Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Chip</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-cluster orp-cluster--2 orp-mb-4">
            <span class="orp-chip orp-chip--default">Default</span>
            <span class="orp-chip orp-chip--primary">Primary</span>
            <span class="orp-chip orp-chip--outline">Outline</span>
            <span class="orp-chip orp-chip--selected">Selected</span>
          </div>

          <div class="orp-cluster orp-cluster--2 orp-mb-4">
            <span class="orp-chip">
              <span class="orp-chip__icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                  <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
              </span>
              <span class="orp-chip__label">Con icono</span>
            </span>
            <span class="orp-chip">
              <span class="orp-chip__label">Removible</span>
              <button class="orp-chip__remove" aria-label="Remove">×</button>
            </span>
          </div>
        </div>
      </div>
    </section>

    <!-- Meta Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Meta</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-meta orp-mb-4">
            <span class="orp-meta__item">
              <svg class="orp-meta__icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
              </svg>
              8 min
            </span>
            <span class="orp-meta__separator"></span>
            <span class="orp-meta__item">Hace 2 días</span>
          </div>

          <div class="orp-meta">
            <span class="orp-meta__item">
              <svg class="orp-meta__icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              Buenos Aires
            </span>
            <span class="orp-meta__separator"></span>
            <span class="orp-meta__item">Categoria</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Price Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Price</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-5 orp-align-center">
            <div class="orp-price">
              <span class="orp-price__currency">$</span>
              <span class="orp-price__value">249</span>
              <span class="orp-price__fraction">.00</span>
            </div>

            <div class="orp-price">
              <span class="orp-price__currency">$</span>
              <span class="orp-price__value">1,299</span>
              <span class="orp-price__previous">$1,599</span>
            </div>

            <div class="orp-price">
              <span class="orp-price__value">49</span>
              <span class="orp-price__suffix">/mes</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Rating Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Rating</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-5 orp-align-center">
            <div class="orp-rating" aria-label="4.8 de 5">
              <span class="orp-rating__icons">
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
              </span>
              <span class="orp-rating__value">4.8</span>
              <span class="orp-rating__count">(128)</span>
            </div>

            <div class="orp-rating" aria-label="4 de 5">
              <span class="orp-rating__icons">
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon">★</span>
                <span class="orp-rating__icon" style="opacity: 0.3;">★</span>
              </span>
              <span class="orp-rating__value">4.0</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Divider Section -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Divider</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-column orp-gap-4">
            <p>Antes del divider</p>
            <hr class="orp-divider">
            <p>Después del divider</p>
            <hr class="orp-divider orp-divider--inset">
            <p>Divider inset</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Rich UI -->
    <!-- ============================================= -->

    <!-- Toolbar -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Toolbar</h2>

      <p class="orp-mb-3"><strong>Basic Toolbar</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-toolbar">
          <div class="orp-toolbar__leading">
            <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Menu">
              <i class="bi bi-list orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-toolbar__title">Dashboard</div>
          <div class="orp-toolbar__actions">
            <button class="orp-btn orp-btn--primary orp-btn--sm">Action</button>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Toolbar with Search</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-toolbar">
          <div class="orp-toolbar__leading">
            <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Menu">
              <i class="bi bi-list orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-toolbar__content">
            <input type="search" class="orp-search-input orp-search-input--sm" placeholder="Search...">
          </div>
          <div class="orp-toolbar__actions">
            <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Filter">
              <i class="bi bi-funnel orp-icon" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Toolbar with Filters</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-toolbar">
          <div class="orp-toolbar__title">Settings</div>
          <div class="orp-toolbar__content">
            <span class="orp-chip orp-chip--selected">All</span>
            <span class="orp-chip">Active</span>
            <span class="orp-chip">Pending</span>
          </div>
          <div class="orp-toolbar__actions">
            <button class="orp-btn orp-btn--primary orp-btn--sm">Add</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Callout -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Callout</h2>

      <p class="orp-mb-3"><strong>Info</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-callout orp-callout--info">
            <div class="orp-callout__icon">
              <i class="bi bi-info-circle orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-callout__content">
              <div class="orp-callout__description">Your account is almost ready. Complete your profile to unlock all features.</div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Success</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-callout orp-callout--success">
            <div class="orp-callout__icon">
              <i class="bi bi-check-circle orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-callout__content">
              <div class="orp-callout__title">Success</div>
              <div class="orp-callout__description">Your changes have been saved successfully.</div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Warning</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-callout orp-callout--warning">
            <div class="orp-callout__icon">
              <i class="bi bi-exclamation-triangle orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-callout__content">
              <div class="orp-callout__title">Warning</div>
              <div class="orp-callout__description">Your session will expire in 5 minutes.</div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Danger</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-callout orp-callout--danger">
            <div class="orp-callout__icon">
              <i class="bi bi-x-circle orp-icon orp-icon--lg" aria-hidden="true"></i>
            </div>
            <div class="orp-callout__content">
              <div class="orp-callout__title">Error</div>
              <div class="orp-callout__description">Something went wrong. Please try again later.</div>
              <div class="orp-callout__actions">
                <button class="orp-btn orp-btn--danger orp-btn--sm">Retry</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Avatar Group -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Avatar Group</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-avatar-group">
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--md">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=1" alt="User 1">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--md">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=2" alt="User 2">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--md">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=3" alt="User 3">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--md">
                <span class="orp-avatar__fallback">+5</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Small</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-avatar-group orp-avatar-group--sm">
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--sm">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=4" alt="User">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--sm">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=5" alt="User">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--sm">
                <span class="orp-avatar__fallback">+3</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Large</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-avatar-group orp-avatar-group--lg">
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--lg">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=7" alt="User">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--lg">
                <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=8" alt="User">
              </div>
            </div>
            <div class="orp-avatar-group__item">
              <div class="orp-avatar orp-avatar--lg">
                <span class="orp-avatar__fallback">+2</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stat Card -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Stat Card</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4">
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Total Revenue</span>
                <div class="orp-stat-card__icon">
                  <i class="bi bi-currency-dollar orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">$12,450</div>
              <div class="orp-stat-card__trend orp-stat-card__trend--up">
                <i class="bi bi-arrow-up" aria-hidden="true"></i>
                <span>+12.5%</span>
              </div>
            </div>
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Users</span>
                <div class="orp-stat-card__icon">
                  <i class="bi bi-people orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">1,284</div>
              <div class="orp-stat-card__trend orp-stat-card__trend--up">
                <i class="bi bi-arrow-up" aria-hidden="true"></i>
                <span>+8.2%</span>
              </div>
            </div>
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Bounce Rate</span>
                <div class="orp-stat-card__icon">
                  <i class="bi bi-graph-up orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">24.8%</div>
              <div class="orp-stat-card__trend orp-stat-card__trend--down">
                <i class="bi bi-arrow-down" aria-hidden="true"></i>
                <span>-3.1%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4">
            <div class="orp-stat-card orp-stat-card--compact">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Views</span>
                <div class="orp-stat-card__icon" style="width:24px;height:24px;">
                  <i class="bi bi-eye orp-icon" style="font-size:12px;" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">8.4K</div>
            </div>
            <div class="orp-stat-card orp-stat-card--compact">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Conversions</span>
                <div class="orp-stat-card__icon" style="width:24px;height:24px;">
                  <i class="bi bi-check2 orp-icon" style="font-size:12px;" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">342</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Comment / Chat -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Comment / Chat</h2>

      <p class="orp-mb-3"><strong>Chat Bubbles</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-comments">
            <div class="orp-comment orp-comment--incoming">
              <div class="orp-comment__header">
                <div class="orp-comment__avatar">
                  <div class="orp-avatar orp-avatar--sm">
                    <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=11" alt="Sarah">
                  </div>
                </div>
                <div class="orp-comment__meta">
                  <span class="orp-comment__author">Sarah Chen</span>
                  <span class="orp-comment__time">2:34 PM</span>
                </div>
              </div>
              <div class="orp-comment__bubble">Hey! Did you see the new design specs?</div>
              <div class="orp-comment__actions">
                <button class="orp-comment__action">Reply</button>
              </div>
            </div>
            <div class="orp-comment orp-comment--outgoing">
              <div class="orp-comment__header">
                <div class="orp-comment__avatar">
                  <div class="orp-avatar orp-avatar--sm">
                    <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=3" alt="You">
                  </div>
                </div>
                <div class="orp-comment__meta">
                  <span class="orp-comment__author">You</span>
                  <span class="orp-comment__time">2:36 PM</span>
                </div>
              </div>
              <div class="orp-comment__bubble">Yes! The new toolbar looks great. Love the subtle shadows.</div>
              <div class="orp-comment__actions">
                <button class="orp-comment__action">Edit</button>
                <button class="orp-comment__action">Delete</button>
              </div>
            </div>
            <div class="orp-comment orp-comment--incoming orp-comment--reply">
              <div class="orp-comment__header">
                <div class="orp-comment__avatar">
                  <div class="orp-avatar orp-avatar--sm">
                    <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=11" alt="Sarah">
                  </div>
                </div>
                <div class="orp-comment__meta">
                  <span class="orp-comment__author">Sarah Chen</span>
                  <span class="orp-comment__time">2:38 PM</span>
                </div>
              </div>
              <div class="orp-comment__bubble">Agreed! Also the stat cards have a nice touch with the trend indicators.</div>
              <div class="orp-comment__actions">
                <button class="orp-comment__action">Reply</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Media & Files -->
    <!-- ============================================= -->

    <!-- File Input -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">File Input</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpFileInput label="Choose file" help="Max 5MB" />
        </div>
      </div>

      <p class="orp-mb-3"><strong>With accept</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpFileInput label="Choose image" accept="image/*" help="PNG, JPG, GIF" />
        </div>
      </div>

      <p class="orp-mb-3"><strong>Disabled</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpFileInput label="Choose file" disabled help="Not available" />
        </div>
      </div>
    </section>

    <!-- Dropzone -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Dropzone</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpDropzone label="Drop files here" subtitle="or click to browse" />
        </div>
      </div>

      <p class="orp-mb-3"><strong>Images only</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpDropzone
            label="Drop images here"
            subtitle="or click to select"
            accept="image/*"
            help="PNG, JPG, WEBP up to 10MB"
          />
        </div>
      </div>

      <p class="orp-mb-3"><strong>Multiple files</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpDropzone
            label="Drop files here"
            subtitle="select multiple files"
            multiple
            help="Up to 20 files"
          />
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpDropzone label="Upload" subtitle="drag & drop" class="orp-dropzone--compact" />
        </div>
      </div>
    </section>

    <!-- File Items -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">File Items</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-file-item">
            <div class="orp-file-item__preview">
              <i class="bi bi-file-earmark-pdf orp-icon" aria-hidden="true"></i>
            </div>
            <div class="orp-file-item__content">
              <div class="orp-file-item__name">documento-final-2026.pdf</div>
              <div class="orp-file-item__meta">PDF · 2.4 MB</div>
            </div>
            <div class="orp-file-item__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Download">
                <i class="bi bi-download orp-icon" aria-hidden="true"></i>
              </button>
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Eliminar archivo">
                <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Image</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-file-item orp-file-item--image">
            <div class="orp-file-item__preview">
              <img src="https://picsum.photos/seed/img1/200" alt="Hero image">
            </div>
            <div class="orp-file-item__content">
              <div class="orp-file-item__name">hero-banner.jpg</div>
              <div class="orp-file-item__meta">JPG · 850 KB · 1920×1080</div>
            </div>
            <div class="orp-file-item__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Preview">
                <i class="bi bi-eye orp-icon" aria-hidden="true"></i>
              </button>
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Eliminar archivo">
                <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>With Progress</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-file-item">
            <div class="orp-file-item__preview">
              <i class="bi bi-file-earmark-arrow-up orp-icon" aria-hidden="true"></i>
            </div>
            <div class="orp-file-item__content">
              <div class="orp-file-item__name">uploading-document.pdf</div>
              <div class="orp-file-item__meta">
                <span class="orp-file-item__status orp-file-item__status--uploading">Uploading...</span>
              </div>
              <div class="orp-file-item__progress">
                <div class="orp-progress orp-progress--sm">
                  <div class="orp-progress__bar orp-progress__bar--primary" style="width: 65%"></div>
                </div>
              </div>
            </div>
            <div class="orp-file-item__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Cancel upload">
                <i class="bi bi-x-lg orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Success</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-file-item orp-file-item--success">
            <div class="orp-file-item__preview">
              <i class="bi bi-file-earmark-check orp-icon" aria-hidden="true"></i>
            </div>
            <div class="orp-file-item__content">
              <div class="orp-file-item__name">completed-upload.pdf</div>
              <div class="orp-file-item__meta">
                <span class="orp-file-item__status orp-file-item__status--success">
                  <i class="bi bi-check-circle" aria-hidden="true"></i> Uploaded
                </span>
                <span>·</span>
                <span>PDF · 1.2 MB</span>
              </div>
            </div>
            <div class="orp-file-item__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Download">
                <i class="bi bi-download orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Error</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-file-item orp-file-item--error">
            <div class="orp-file-item__preview">
              <i class="bi bi-file-earmark-x orp-icon" aria-hidden="true"></i>
            </div>
            <div class="orp-file-item__content">
              <div class="orp-file-item__name">failed-upload.pdf</div>
              <div class="orp-file-item__meta">
                <span class="orp-file-item__status orp-file-item__status--error">
                  <i class="bi bi-exclamation-circle" aria-hidden="true"></i> Upload failed
                </span>
              </div>
            </div>
            <div class="orp-file-item__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Reintentar carga">
                <i class="bi bi-arrow-clockwise orp-icon" aria-hidden="true"></i>
              </button>
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Eliminar archivo">
                <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Long Filename</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-file-item">
            <div class="orp-file-item__preview">
              <i class="bi bi-file-earmark-text orp-icon" aria-hidden="true"></i>
            </div>
            <div class="orp-file-item__content">
              <div class="orp-file-item__name">documento-final-final-ahora-si-version-aprobada-2026.pdf</div>
              <div class="orp-file-item__meta">TXT · 4 KB</div>
            </div>
            <div class="orp-file-item__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Eliminar archivo">
                <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Gallery</h2>

      <p class="orp-mb-3"><strong>Basic Grid (2 cols)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-gallery">
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal1/400" alt="Gallery image 1">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal2/400" alt="Gallery image 2">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal3/400" alt="Gallery image 3">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal4/400" alt="Gallery image 4">
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>With Overlay Actions</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-gallery orp-gallery--cols-3">
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal5/400" alt="Gallery image">
              <div class="orp-gallery__overlay">
                <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="View">
                  <i class="bi bi-eye orp-icon" style="color:white" aria-hidden="true"></i>
                </button>
                <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Delete">
                  <i class="bi bi-trash orp-icon" style="color:white" aria-hidden="true"></i>
                </button>
              </div>
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal6/400" alt="Gallery image">
              <div class="orp-gallery__overlay">
                <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="View">
                  <i class="bi bi-eye orp-icon" style="color:white" aria-hidden="true"></i>
                </button>
                <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Delete">
                  <i class="bi bi-trash orp-icon" style="color:white" aria-hidden="true"></i>
                </button>
              </div>
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/gal7/400" alt="Gallery image">
              <div class="orp-gallery__overlay">
                <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="View">
                  <i class="bi bi-eye orp-icon" style="color:white" aria-hidden="true"></i>
                </button>
                <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Delete">
                  <i class="bi bi-trash orp-icon" style="color:white" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Mixed Ratios</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-gallery orp-gallery--cols-3">
            <div class="orp-gallery__item orp-gallery__item--portrait">
              <img src="https://picsum.photos/seed/port1/400/600" alt="Portrait image">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/sqr1/400" alt="Square image">
            </div>
            <div class="orp-gallery__item orp-gallery__item--wide">
              <img src="https://picsum.photos/seed/wide1/800/450" alt="Wide image">
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>No Gap</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body" style="padding:0;overflow:hidden;">
          <div class="orp-gallery orp-gallery--gap-none orp-gallery--cols-4">
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/ng1/400" alt="Gallery image">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/ng2/400" alt="Gallery image">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/ng3/400" alt="Gallery image">
            </div>
            <div class="orp-gallery__item orp-gallery__item--square">
              <img src="https://picsum.photos/seed/ng4/400" alt="Gallery image">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Avatar Upload -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Avatar Upload</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-avatar-upload">
            <div class="orp-avatar orp-avatar--xl">
              <img class="orp-avatar__image" src="https://i.pravatar.cc/200?img=5" alt="Profile photo">
            </div>
            <div class="orp-avatar-upload__actions">
              <button class="orp-btn orp-btn--primary orp-btn--sm">Change photo</button>
              <button class="orp-btn orp-btn--ghost orp-btn--sm">Remove</button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>With Progress</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-avatar-upload">
            <div class="orp-avatar orp-avatar--xl orp-avatar--loading">
              <div class="orp-avatar__spinner">
                <span class="orp-spinner orp-spinner--sm"></span>
              </div>
            </div>
            <div class="orp-avatar-upload__info">
              <span class="orp-avatar-upload__status">Uploading...</span>
              <div class="orp-progress orp-progress--sm" style="width:120px">
                <div class="orp-progress__bar orp-progress__bar--primary" style="width:45%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Cover Upload -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Cover Upload</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body" style="padding:0;overflow:hidden;">
          <div class="orp-cover-upload">
            <div class="orp-media orp-media--wide orp-media--rounded">
              <img class="orp-media__content" src="https://picsum.photos/seed/cover/1200/400" alt="Cover image">
              <div class="orp-cover-upload__overlay">
                <button class="orp-btn orp-btn--primary orp-btn--sm">Change cover</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Empty</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body" style="padding:0;overflow:hidden;">
          <div class="orp-cover-upload">
            <div class="orp-media orp-media--wide orp-media--rounded orp-cover-upload__empty">
              <div class="orp-cover-upload__empty-content">
                <i class="bi bi-image orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span>Add cover image</span>
                <button class="orp-btn orp-btn--primary orp-btn--sm">Upload</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Empty State -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Empty State (No Files)</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-empty">
            <div class="orp-empty__media">
              <i class="bi bi-folder2-open orp-icon orp-icon--2xl" aria-hidden="true"></i>
            </div>
            <h3 class="orp-empty__title">No files yet</h3>
            <p class="orp-empty__description">Upload your first file to get started</p>
            <div class="orp-empty__actions">
              <button class="orp-btn orp-btn--primary">Upload file</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Advanced Navigation -->
    <!-- ============================================= -->

    <!-- Keyboard Shortcuts -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Keyboard Shortcuts</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4 orp-align-center">
            <span class="orp-kbd">Ctrl</span>
            <span class="orp-kbd">K</span>
            <span class="orp-kbd">Enter</span>
            <span class="orp-kbd">Esc</span>
            <span class="orp-kbd">↑</span>
            <span class="orp-kbd">↓</span>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Shortcuts with Labels</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4 orp-align-center">
            <div class="orp-d-flex orp-align-center orp-gap-2">
              <span class="orp-kbd">Ctrl</span>
              <span class="orp-kbd">K</span>
              <span class="orp-text-muted">Command Menu</span>
            </div>
            <div class="orp-d-flex orp-align-center orp-gap-2">
              <span class="orp-kbd">G</span>
              <span class="orp-kbd">D</span>
              <span class="orp-text-muted">Go to Dashboard</span>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Sizes</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4 orp-align-center">
            <span class="orp-kbd orp-kbd--sm">Ctrl</span>
            <span class="orp-kbd">K</span>
            <span class="orp-kbd orp-kbd--lg">K</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Quick Actions -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Quick Actions</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-quick-actions">
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-plus orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Create</span>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-search orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Search</span>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-share orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Share</span>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-gear orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Settings</span>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>With Shortcuts</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-quick-actions">
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-plus orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">New</span>
              <div class="orp-quick-actions__shortcut">
                <span class="orp-kbd orp-kbd--sm">N</span>
              </div>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-pencil orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Edit</span>
              <div class="orp-quick-actions__shortcut">
                <span class="orp-kbd orp-kbd--sm">E</span>
              </div>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Delete</span>
              <div class="orp-quick-actions__shortcut">
                <span class="orp-kbd orp-kbd--sm">Del</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-quick-actions orp-quick-actions--compact">
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-plus orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Add</span>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-check2 orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Done</span>
            </div>
            <div class="orp-quick-actions__item">
              <div class="orp-quick-actions__icon">
                <i class="bi bi-x-lg orp-icon" aria-hidden="true"></i>
              </div>
              <span class="orp-quick-actions__label">Cancel</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Selection Bar -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Selection Bar</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-selection-bar">
            <div class="orp-selection-bar__count">
              <span class="orp-selection-bar__count-number">{{ selectedCount }}</span>
              <span>selected</span>
            </div>
            <div class="orp-selection-bar__actions">
              <button class="orp-btn orp-btn--sm orp-btn--ghost">
                <i class="bi bi-folder orp-icon" aria-hidden="true"></i> Move
              </button>
              <button class="orp-btn orp-btn--sm orp-btn--ghost">
                <i class="bi bi-copy orp-icon" aria-hidden="true"></i> Copy
              </button>
              <button class="orp-btn orp-btn--sm orp-btn--ghost orp-btn--danger">
                <i class="bi bi-trash orp-icon" aria-hidden="true"></i> Delete
              </button>
            </div>
            <div class="orp-selection-bar__dismiss">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Clear selection">
                <i class="bi bi-x-lg orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Elevated</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-selection-bar orp-selection-bar--elevated">
            <div class="orp-selection-bar__count">
              <span class="orp-selection-bar__count-number">7</span>
              <span>items selected</span>
            </div>
            <div class="orp-selection-bar__actions">
              <button class="orp-btn orp-btn--sm orp-btn--primary">
                <i class="bi bi-check-all orp-icon" aria-hidden="true"></i> Select All
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Command Menu -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Command Menu</h2>

      <p class="orp-mb-3"><strong>Trigger</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <button class="orp-btn orp-btn--primary" @click="showCommandMenu = true">
            <i class="bi bi-command orp-icon" aria-hidden="true"></i>
            Open Command Menu
            <span class="orp-kbd orp-kbd--sm">Ctrl K</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Context Menu -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Context Menu</h2>

      <p class="orp-mb-3"><strong>Right-click anywhere in the box</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <OrpContextMenu :items="contextMenuItems" @select="(item) => console.log('Context action:', item)">
            <div class="orp-context-demo">
              <i class="bi bi-box orp-icon orp-icon--lg" aria-hidden="true"></i>
              <p>Right-click on this area to open the context menu</p>
            </div>
          </OrpContextMenu>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Data Visualization -->
    <!-- ============================================= -->

    <!-- Chart Container -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Chart Container</h2>

      <p class="orp-mb-3"><strong>Basic Chart Card</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-chart">
          <div class="orp-chart__header">
            <div class="orp-chart__title-group">
              <h3 class="orp-chart__title">Revenue Overview</h3>
              <p class="orp-chart__description">Monthly revenue for the current year</p>
            </div>
            <div class="orp-chart__actions">
              <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="More options">
                <i class="bi bi-three-dots-vertical orp-icon" aria-hidden="true"></i>
              </button>
            </div>
          </div>
          <div class="orp-chart__body">
            <div style="width:100%;height:200px;background:var(--orp-surface-muted);border-radius:var(--orp-radius-md);display:flex;align-items:center;justify-content:center;color:var(--orp-muted-foreground);">
              Chart Area (SVG/Canvas)
            </div>
          </div>
          <div class="orp-chart__footer">
            <span>Updated 2 minutes ago</span>
            <span>Jan - Dec 2026</span>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact with Legend</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-chart orp-chart--compact">
          <div class="orp-chart__header">
            <div class="orp-chart__title-group">
              <h3 class="orp-chart__title">Traffic Sources</h3>
            </div>
          </div>
          <div class="orp-chart__body">
            <div style="width:100%;height:160px;background:var(--orp-surface-muted);border-radius:var(--orp-radius-md);display:flex;align-items:center;justify-content:center;color:var(--orp-muted-foreground);">
              Donut Chart Area
            </div>
          </div>
          <div class="orp-chart__legend">
            <div class="orp-chart-legend orp-chart-legend--horizontal orp-chart-legend--center">
              <div class="orp-chart-legend__item">
                <span class="orp-chart-legend__marker" style="background:var(--orp-data-1)"></span>
                <span class="orp-chart-legend__label">Direct</span>
                <span class="orp-chart-legend__value">45%</span>
              </div>
              <div class="orp-chart-legend__item">
                <span class="orp-chart-legend__marker" style="background:var(--orp-data-2)"></span>
                <span class="orp-chart-legend__label">Organic</span>
                <span class="orp-chart-legend__value">32%</span>
              </div>
              <div class="orp-chart-legend__item">
                <span class="orp-chart-legend__marker" style="background:var(--orp-data-3)"></span>
                <span class="orp-chart-legend__label">Referral</span>
                <span class="orp-chart-legend__value">23%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Chart Legend -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Chart Legend</h2>

      <p class="orp-mb-3"><strong>Horizontal</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-chart-legend orp-chart-legend--horizontal">
            <div class="orp-chart-legend__item">
              <span class="orp-chart-legend__marker" style="background:var(--orp-data-1)"></span>
              <span class="orp-chart-legend__label">Desktop</span>
              <span class="orp-chart-legend__value">62%</span>
            </div>
            <div class="orp-chart-legend__item">
              <span class="orp-chart-legend__marker" style="background:var(--orp-data-2)"></span>
              <span class="orp-chart-legend__label">Mobile</span>
              <span class="orp-chart-legend__value">38%</span>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Vertical</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-chart-legend orp-chart-legend--vertical" style="max-width:200px">
            <div class="orp-chart-legend__item">
              <span class="orp-chart-legend__marker" style="background:var(--orp-data-1)"></span>
              <span class="orp-chart-legend__label">Chrome</span>
              <span class="orp-chart-legend__value">42%</span>
            </div>
            <div class="orp-chart-legend__item">
              <span class="orp-chart-legend__marker" style="background:var(--orp-data-2)"></span>
              <span class="orp-chart-legend__label">Firefox</span>
              <span class="orp-chart-legend__value">28%</span>
            </div>
            <div class="orp-chart-legend__item">
              <span class="orp-chart-legend__marker" style="background:var(--orp-data-3)"></span>
              <span class="orp-chart-legend__label">Safari</span>
              <span class="orp-chart-legend__value">18%</span>
            </div>
            <div class="orp-chart-legend__item">
              <span class="orp-chart-legend__marker" style="background:var(--orp-data-4)"></span>
              <span class="orp-chart-legend__label">Edge</span>
              <span class="orp-chart-legend__value">12%</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Trends -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Trend Indicators</h2>

      <p class="orp-mb-3"><strong>Direction + Tone (Separated)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-6">
            <div class="orp-d-flex orp-flex-col orp-gap-2">
              <span class="orp-text-muted orp-text-sm">Up + Positive</span>
              <span class="orp-trend orp-trend--up orp-trend--positive">
                <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">12.4%</span>
              </span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-gap-2">
              <span class="orp-text-muted orp-text-sm">Up + Negative</span>
              <span class="orp-trend orp-trend--up orp-trend--negative">
                <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">8.2%</span>
              </span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-gap-2">
              <span class="orp-text-muted orp-text-sm">Down + Positive</span>
              <span class="orp-trend orp-trend--down orp-trend--positive">
                <i class="bi bi-arrow-down-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">3.1%</span>
              </span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-gap-2">
              <span class="orp-text-muted orp-text-sm">Down + Negative</span>
              <span class="orp-trend orp-trend--down orp-trend--negative">
                <i class="bi bi-arrow-down-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">5.7%</span>
              </span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-gap-2">
              <span class="orp-text-muted orp-text-sm">Flat + Neutral</span>
              <span class="orp-trend orp-trend--flat orp-trend--neutral">
                <i class="bi bi-dash orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">0.0%</span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Sizes</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-6 orp-align-center">
            <span class="orp-trend orp-trend--up orp-trend--positive orp-trend--sm">
              <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
              <span class="orp-trend__value">5%</span>
            </span>
            <span class="orp-trend orp-trend--up orp-trend--positive">
              <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
              <span class="orp-trend__value">12.4%</span>
            </span>
            <span class="orp-trend orp-trend--up orp-trend--positive orp-trend--lg">
              <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
              <span class="orp-trend__value">24.8%</span>
            </span>
          </div>
        </div>
      </div>
    </section>

    <!-- Meter -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Meter</h2>

      <p class="orp-mb-3"><strong>Storage Usage</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-meter__wrapper">
            <div class="orp-meter__header">
              <span class="orp-meter__label">Storage Used</span>
              <span class="orp-meter__value">65%</span>
            </div>
            <div class="orp-meter">
              <meter value="0.65" min="0" max="1"></meter>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Score</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-meter__wrapper">
            <div class="orp-meter__header">
              <span class="orp-meter__label">Performance Score</span>
              <span class="orp-meter__value">78 / 100</span>
            </div>
            <div class="orp-meter orp-meter--lg">
              <meter value="78" min="0" max="100"></meter>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Sizes</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-col orp-gap-4">
            <div class="orp-meter orp-meter--sm">
              <meter value="0.3" min="0" max="1"></meter>
            </div>
            <div class="orp-meter">
              <meter value="0.5" min="0" max="1"></meter>
            </div>
            <div class="orp-meter orp-meter--lg">
              <meter value="0.7" min="0" max="1"></meter>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Distribution -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Distribution Bar</h2>

      <p class="orp-mb-3"><strong>Basic (3 segments)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-distribution">
            <div class="orp-distribution__bar">
              <span class="orp-distribution__segment" style="width:60%;background:var(--orp-data-1)"></span>
              <span class="orp-distribution__segment" style="width:25%;background:var(--orp-data-2)"></span>
              <span class="orp-distribution__segment" style="width:15%;background:var(--orp-data-3)"></span>
            </div>
            <div class="orp-distribution__legend orp-chart-legend orp-chart-legend--horizontal">
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-1)"></span>
                <span class="orp-distribution__legend-label">Desktop</span>
                <span class="orp-distribution__legend-value">60%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-2)"></span>
                <span class="orp-distribution__legend-label">Mobile</span>
                <span class="orp-distribution__legend-value">25%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-3)"></span>
                <span class="orp-distribution__legend-label">Tablet</span>
                <span class="orp-distribution__legend-value">15%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>6 Segments</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-distribution">
            <div class="orp-distribution__bar">
              <span class="orp-distribution__segment" style="width:35%;background:var(--orp-data-1)"></span>
              <span class="orp-distribution__segment" style="width:22%;background:var(--orp-data-2)"></span>
              <span class="orp-distribution__segment" style="width:18%;background:var(--orp-data-3)"></span>
              <span class="orp-distribution__segment" style="width:12%;background:var(--orp-data-4)"></span>
              <span class="orp-distribution__segment" style="width:8%;background:var(--orp-data-5)"></span>
              <span class="orp-distribution__segment" style="width:5%;background:var(--orp-data-6)"></span>
            </div>
            <div class="orp-distribution__legend orp-chart-legend orp-chart-legend--horizontal">
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-1)"></span>
                <span class="orp-distribution__legend-value">35%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-2)"></span>
                <span class="orp-distribution__legend-value">22%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-3)"></span>
                <span class="orp-distribution__legend-value">18%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-4)"></span>
                <span class="orp-distribution__legend-value">12%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-5)"></span>
                <span class="orp-distribution__legend-value">8%</span>
              </div>
              <div class="orp-distribution__legend-item">
                <span class="orp-distribution__legend-marker" style="background:var(--orp-data-6)"></span>
                <span class="orp-distribution__legend-value">5%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Dashboard Composition -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Dashboard Composition</h2>

      <p class="orp-mb-3"><strong>Metrics Grid with Trends</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-grid orp-grid-cols-2 orp-grid-cols-4-md orp-gap-4">
            <!-- Stat Card -->
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Revenue</span>
                <div class="orp-stat-card__icon" style="background:var(--orp-data-1);color:white">
                  <i class="bi bi-currency-dollar orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">$12,450</div>
              <div class="orp-stat-card__trend orp-trend orp-trend--up orp-trend--positive orp-trend--sm">
                <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">12.5%</span>
              </div>
            </div>
            <!-- Stat Card -->
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Users</span>
                <div class="orp-stat-card__icon" style="background:var(--orp-data-2);color:white">
                  <i class="bi bi-people orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">1,284</div>
              <div class="orp-stat-card__trend orp-trend orp-trend--up orp-trend--positive orp-trend--sm">
                <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">8.2%</span>
              </div>
            </div>
            <!-- Stat Card -->
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Bounce Rate</span>
                <div class="orp-stat-card__icon" style="background:var(--orp-data-3);color:white">
                  <i class="bi bi-graph-up orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">24.8%</div>
              <div class="orp-stat-card__trend orp-trend orp-trend--down orp-trend--negative orp-trend--sm">
                <i class="bi bi-arrow-down-right orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">-3.1%</span>
              </div>
            </div>
            <!-- Stat Card -->
            <div class="orp-stat-card">
              <div class="orp-stat-card__header">
                <span class="orp-stat-card__label">Sessions</span>
                <div class="orp-stat-card__icon" style="background:var(--orp-data-4);color:white">
                  <i class="bi bi-display orp-icon" aria-hidden="true"></i>
                </div>
              </div>
              <div class="orp-stat-card__value">8,421</div>
              <div class="orp-stat-card__trend orp-trend orp-trend--flat orp-trend--neutral orp-trend--sm">
                <i class="bi bi-dash orp-trend__icon" aria-hidden="true"></i>
                <span class="orp-trend__value">0%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Data Colors Palette</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-3">
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-1)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-1</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-2)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-2</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-3)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-3</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-4)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-4</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-5)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-5</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-6)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-6</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-7)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-7</span>
            </div>
            <div class="orp-d-flex orp-flex-col orp-align-center orp-gap-2">
              <div style="width:48px;height:48px;border-radius:var(--orp-radius-md);background:var(--orp-data-8)"></div>
              <span class="orp-text-sm orp-text-muted">--orp-data-8</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Advanced Tables -->
    <!-- ============================================= -->

    <!-- Basic Table -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Table</h2>

      <p class="orp-mb-3"><strong>Basic</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Carol White</td>
                <td>carol@example.com</td>
                <td>Viewer</td>
                <td><span class="orp-badge">Inactive</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Striped</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table orp-table--striped">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Carol White</td>
                <td>carol@example.com</td>
                <td>Viewer</td>
                <td><span class="orp-badge">Inactive</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Bordered</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table orp-table--bordered">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Compact</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table orp-table--compact">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--sm">Active</span></td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--sm">Active</span></td>
              </tr>
              <tr>
                <td>Carol White</td>
                <td>carol@example.com</td>
                <td>Viewer</td>
                <td><span class="orp-badge orp-badge--sm">Inactive</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Sortable Table -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Table with Sorting</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table orp-table--hover">
            <thead>
              <tr>
                <th scope="col">
                  <button class="orp-table__sort orp-table__sort--active">
                    Name
                    <i class="bi bi-sort-up orp-table__sort-icon" aria-hidden="true"></i>
                  </button>
                </th>
                <th scope="col">
                  <button class="orp-table__sort">
                    Email
                    <i class="bi bi-arrow-down-up orp-table__sort-icon" aria-hidden="true"></i>
                  </button>
                </th>
                <th scope="col">
                  <button class="orp-table__sort">
                    Role
                    <i class="bi bi-arrow-down-up orp-table__sort-icon" aria-hidden="true"></i>
                  </button>
                </th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Carol White</td>
                <td>carol@example.com</td>
                <td>Viewer</td>
                <td><span class="orp-badge">Inactive</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Selection Table -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Table with Selection</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table orp-table--hover">
            <thead>
              <tr>
                <th class="orp-table__cell--checkbox" scope="col">
                  <input type="checkbox" class="orp-checkbox" aria-label="Select all">
                </th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="orp-table__row--selected">
                <td class="orp-table__cell--checkbox">
                  <input type="checkbox" class="orp-checkbox" checked aria-label="Select row">
                </td>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td class="orp-table__cell--checkbox">
                  <input type="checkbox" class="orp-checkbox" aria-label="Select row">
                </td>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td class="orp-table__cell--checkbox">
                  <input type="checkbox" class="orp-checkbox" aria-label="Select row">
                </td>
                <td>Carol White</td>
                <td>carol@example.com</td>
                <td>Viewer</td>
                <td><span class="orp-badge">Inactive</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="orp-selection-bar">
        <div class="orp-selection-bar__count">
          <span class="orp-selection-bar__count-number">1</span>
          <span>selected</span>
        </div>
        <div class="orp-selection-bar__actions">
          <button class="orp-btn orp-btn--sm orp-btn--ghost">
            <i class="bi bi-folder orp-icon" aria-hidden="true"></i> Move
          </button>
          <button class="orp-btn orp-btn--sm orp-btn--ghost">
            <i class="bi bi-copy orp-icon" aria-hidden="true"></i> Copy
          </button>
          <button class="orp-btn orp-btn--sm orp-btn--ghost orp-btn--danger">
            <i class="bi bi-trash orp-icon" aria-hidden="true"></i> Delete
          </button>
        </div>
        <div class="orp-selection-bar__dismiss">
          <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Clear selection">
            <i class="bi bi-x-lg orp-icon" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- Table with Actions -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Table with Actions</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table orp-table--hover">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
                <th class="orp-table__cell--actions" scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
                <td class="orp-table__cell--actions">
                  <div class="orp-d-flex orp-gap-1 orp-justify-end">
                    <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Edit">
                      <i class="bi bi-pencil orp-icon" aria-hidden="true"></i>
                    </button>
                    <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Delete">
                      <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
                <td class="orp-table__cell--actions">
                  <div class="orp-d-flex orp-gap-1 orp-justify-end">
                    <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Edit">
                      <i class="bi bi-pencil orp-icon" aria-hidden="true"></i>
                    </button>
                    <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="Delete">
                      <i class="bi bi-trash orp-icon" aria-hidden="true"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Table with Pagination -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Table with Pagination</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Alice Chen</td>
                <td>alice@example.com</td>
                <td>Admin</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Bob Smith</td>
                <td>bob@example.com</td>
                <td>Editor</td>
                <td><span class="orp-badge orp-badge--success">Active</span></td>
              </tr>
              <tr>
                <td>Carol White</td>
                <td>carol@example.com</td>
                <td>Viewer</td>
                <td><span class="orp-badge">Inactive</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="orp-table-pagination">
          <div class="orp-table-pagination__info">
            Showing 1–10 of 248
          </div>
          <div class="orp-table-pagination__controls">
            <button class="orp-btn orp-btn--sm orp-btn--ghost" disabled>
              <i class="bi bi-chevron-left orp-icon" aria-hidden="true"></i>
            </button>
            <button class="orp-btn orp-btn--sm orp-btn--primary">1</button>
            <button class="orp-btn orp-btn--sm orp-btn--ghost">2</button>
            <button class="orp-btn orp-btn--sm orp-btn--ghost">3</button>
            <span class="orp-text-muted">...</span>
            <button class="orp-btn orp-btn--sm orp-btn--ghost">25</button>
            <button class="orp-btn orp-btn--sm orp-btn--ghost">
              <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="orp-table-pagination__pagesize">
            <span>Per page:</span>
            <select class="orp-select orp-select--sm">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
          </div>
        </div>
      </div>
    </section>

    <!-- Empty Table -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Empty State</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4">
                  <div class="orp-empty" style="padding: var(--orp-space-8);">
                    <div class="orp-empty__media">
                      <i class="bi bi-inbox orp-icon orp-icon--2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="orp-empty__title">No records found</h3>
                    <p class="orp-empty__description">Try adjusting your search or filters</p>
                    <div class="orp-empty__actions">
                      <button class="orp-btn orp-btn--primary">Add Record</button>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Skeleton Loading -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Loading State</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="orp-table__skeleton">
                <td><div class="orp-table__skeleton-cell" style="width: 100px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 150px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 60px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 50px;"></div></td>
              </tr>
              <tr class="orp-table__skeleton">
                <td><div class="orp-table__skeleton-cell" style="width: 120px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 180px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 70px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 55px;"></div></td>
              </tr>
              <tr class="orp-table__skeleton">
                <td><div class="orp-table__skeleton-cell" style="width: 90px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 160px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 65px;"></div></td>
                <td><div class="orp-table__skeleton-cell" style="width: 48px;"></div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Rich Cells -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Rich Cells</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-table-wrap">
          <table class="orp-table">
            <thead>
              <tr>
                <th scope="col">User</th>
                <th scope="col">Metrics</th>
                <th scope="col">Status</th>
                <th scope="col">Trend</th>
                <th class="orp-table__cell--actions" scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="orp-d-flex orp-align-center orp-gap-3">
                    <div class="orp-avatar orp-avatar--sm">
                      <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=1" alt="">
                    </div>
                    <div>
                      <div class="orp-text-sm orp-text-semibold">Alice Chen</div>
                      <div class="orp-text-xs orp-text-muted">alice@example.com</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="orp-text-sm">1,284</div>
                  <div class="orp-text-xs orp-text-muted">visitors</div>
                </td>
                <td>
                  <span class="orp-badge orp-badge--success">Active</span>
                  <span class="orp-badge orp-badge--outline orp-ml-1">Pro</span>
                </td>
                <td>
                  <span class="orp-trend orp-trend--up orp-trend--positive orp-trend--sm">
                    <i class="bi bi-arrow-up-right orp-trend__icon" aria-hidden="true"></i>
                    <span class="orp-trend__value">12.5%</span>
                  </span>
                </td>
                <td class="orp-table__cell--actions">
                  <OrpDropdown :items="[{ label: 'Edit' }, { label: 'Delete', danger: true }]" align="end">
                    <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="More">
                      <i class="bi bi-three-dots-vertical orp-icon" aria-hidden="true"></i>
                    </button>
                  </OrpDropdown>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="orp-d-flex orp-align-center orp-gap-3">
                    <div class="orp-avatar orp-avatar--sm">
                      <img class="orp-avatar__image" src="https://i.pravatar.cc/100?img=2" alt="">
                    </div>
                    <div>
                      <div class="orp-text-sm orp-text-semibold">Bob Smith</div>
                      <div class="orp-text-xs orp-text-muted">bob@example.com</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="orp-text-sm">856</div>
                  <div class="orp-text-xs orp-text-muted">visitors</div>
                </td>
                <td>
                  <span class="orp-badge orp-badge--success">Active</span>
                </td>
                <td>
                  <span class="orp-trend orp-trend--down orp-trend--negative orp-trend--sm">
                    <i class="bi bi-arrow-down-right orp-trend__icon" aria-hidden="true"></i>
                    <span class="orp-trend__value">-3.1%</span>
                  </span>
                </td>
                <td class="orp-table__cell--actions">
                  <OrpDropdown :items="[{ label: 'Edit' }, { label: 'Delete', danger: true }]" align="end">
                    <button class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--sm" aria-label="More">
                      <i class="bi bi-three-dots-vertical orp-icon" aria-hidden="true"></i>
                    </button>
                  </OrpDropdown>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Rich Media -->
    <!-- ============================================= -->

    <!-- Video Player -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Video Player</h2>

      <p class="orp-mb-3"><strong>Basic Video Player</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <OrpVideoPlayer
          src="https://www.w3schools.com/html/mov_bbb.mp4"
          poster="https://www.w3schools.com/html/mov_bbb.mp4"
          title="Big Buck Bunny"
          preload="metadata"
        />
        <div class="orp-card__body">
          <p class="orp-text-sm orp-text-muted">Click to play/pause. Use controls or keyboard shortcuts (Space, K, arrows, M, F).</p>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Video with 16:9 aspect ratio</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4" style="max-width: 640px;">
        <OrpVideoPlayer
          src="https://www.w3schools.com/html/mov_bbb.mp4"
          title="Big Buck Bunny"
          aspect-ratio="16-9"
        />
      </div>

      <p class="orp-mb-3"><strong>Video with 4:3 aspect ratio</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4" style="max-width: 480px;">
        <OrpVideoPlayer
          src="https://www.w3schools.com/html/mov_bbb.mp4"
          title="Big Buck Bunny"
          aspect-ratio="4-3"
        />
      </div>

      <p class="orp-mb-3"><strong>Vertical Video (9:16)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4" style="max-width: 200px;">
        <OrpVideoPlayer
          src="https://www.w3schools.com/html/mov_bbb.mp4"
          title="Vertical Video"
          aspect-ratio="9-16"
        />
      </div>

      <p class="orp-mb-3"><strong>Square Video (1:1)</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4" style="max-width: 320px;">
        <OrpVideoPlayer
          src="https://www.w3schools.com/html/mov_bbb.mp4"
          title="Square Video"
          aspect-ratio="1-1"
        />
      </div>
    </section>

    <!-- Audio Player -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Audio Player</h2>

      <p class="orp-mb-3"><strong>Basic Audio Player</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <OrpAudioPlayer
          src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"
          title="SoundHelix Song 1"
          artist="SoundHelix"
          album="Free Music"
        />
      </div>

      <p class="orp-mb-3"><strong>Minimal Audio Player</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <OrpAudioPlayer
          src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"
          title="SoundHelix Song 1"
          artist="SoundHelix"
          variant="minimal"
        />
      </div>

      <p class="orp-mb-3"><strong>Playback Audio Player</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <OrpAudioPlayer
          src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"
          title="SoundHelix Song 1"
          artist="SoundHelix"
          album="Free Music"
          variant="playback"
        />
      </div>
    </section>

    <!-- Video Card -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Video Cards</h2>

      <p class="orp-mb-3"><strong>Video Card Composition</strong></p>
      <div class="orp-d-flex orp-flex-wrap orp-gap-4">
        <article class="orp-card orp-card--interactive" style="width: 280px;">
          <div class="orp-card__media">
            <img src="https://picsum.photos/seed/video1/320/180" alt="Video thumbnail">
            <div class="orp-card__media-overlay">
              <div class="orp-card__play-btn">
                <i class="bi bi-play-fill"></i>
              </div>
            </div>
            <span class="orp-card__duration">10:45</span>
          </div>
          <div class="orp-card__body">
            <h3 class="orp-text-sm orp-text-semibold orp-mb-1">Big Buck Bunny</h3>
            <p class="orp-text-xs orp-text-muted orp-mb-2">Blender Foundation • 1.2M views • 2 days ago</p>
          </div>
        </article>

        <article class="orp-card" style="width: 280px;">
          <div class="orp-card__media">
            <img src="https://picsum.photos/seed/video2/320/180" alt="Video thumbnail">
            <div class="orp-card__media-overlay">
              <div class="orp-card__play-btn">
                <i class="bi bi-play-fill"></i>
              </div>
            </div>
            <span class="orp-card__duration">5:30</span>
          </div>
          <div class="orp-card__body">
            <h3 class="orp-text-sm orp-text-semibold orp-mb-1">Sintel Trailer</h3>
            <p class="orp-text-xs orp-text-muted orp-mb-2">Blender Foundation • 500K views • 1 week ago</p>
          </div>
        </article>

        <article class="orp-card" style="width: 280px;">
          <div class="orp-card__media">
            <img src="https://picsum.photos/seed/video3/320/180" alt="Video thumbnail">
            <div class="orp-card__media-overlay">
              <div class="orp-card__play-btn">
                <i class="bi bi-play-fill"></i>
              </div>
            </div>
            <span class="orp-card__duration">8:20</span>
          </div>
          <div class="orp-card__body">
            <h3 class="orp-text-sm orp-text-semibold orp-mb-1">Tears of Steel</h3>
            <p class="orp-text-xs orp-text-muted orp-mb-2">Blender Foundation • 800K views • 3 weeks ago</p>
          </div>
        </article>
      </div>
    </section>

    <!-- Playlist -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Playlist</h2>

      <p class="orp-mb-3"><strong>Playlist Composition</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-list">
          <a href="#" class="orp-list__item orp-list__item--active" aria-current="true">
            <div class="orp-list__media">
              <img src="https://picsum.photos/seed/playlist1/56/56" alt="">
              <div class="orp-list__media-overlay">
                <i class="bi bi-play-fill"></i>
              </div>
            </div>
            <div class="orp-list__content">
              <div class="orp-text-sm orp-text-semibold">Big Buck Bunny</div>
              <div class="orp-text-xs orp-text-muted">Animation • 10:45</div>
            </div>
            <div class="orp-list__trailing">
              <div class="orp-badge orp-badge--success">Playing</div>
            </div>
          </a>
          <a href="#" class="orp-list__item">
            <div class="orp-list__media">
              <img src="https://picsum.photos/seed/playlist2/56/56" alt="">
            </div>
            <div class="orp-list__content">
              <div class="orp-text-sm">Sintel Trailer</div>
              <div class="orp-text-xs orp-text-muted">Animation • 8:20</div>
            </div>
          </a>
          <a href="#" class="orp-list__item">
            <div class="orp-list__media">
              <img src="https://picsum.photos/seed/playlist3/56/56" alt="">
            </div>
            <div class="orp-list__content">
              <div class="orp-text-sm">Tears of Steel</div>
              <div class="orp-text-xs orp-text-muted">Sci-Fi • 12:30</div>
            </div>
          </a>
          <a href="#" class="orp-list__item">
            <div class="orp-list__media">
              <img src="https://picsum.photos/seed/playlist4/56/56" alt="">
            </div>
            <div class="orp-list__content">
              <div class="orp-text-sm">Elephant's Dream</div>
              <div class="orp-text-xs orp-text-muted">Animation • 10:50</div>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- Range Input -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Range Input (Timeline)</h2>

      <p class="orp-mb-3"><strong>Time Range</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-align-center orp-gap-4">
            <span style="min-width: 40px; font-size: 12px; color: var(--orp-muted-foreground);">1:24</span>
            <input type="range" class="orp-range orp-range--time" min="0" max="100" value="25" style="flex: 1;">
            <span style="min-width: 40px; font-size: 12px; color: var(--orp-muted-foreground);">5:36</span>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Volume Range</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-align-center orp-gap-3">
            <i class="bi bi-volume-up-fill" style="color: var(--orp-muted-foreground);"></i>
            <input type="range" class="orp-range orp-range--volume" min="0" max="1" step="0.05" value="0.7" style="flex: 1;">
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Sizes</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body orp-d-flex orp-flex-col orp-gap-4">
          <input type="range" class="orp-range orp-range--sm" min="0" max="100" value="50" style="width: 100%;">
          <input type="range" class="orp-range" min="0" max="100" value="50" style="width: 100%;">
          <input type="range" class="orp-range orp-range--lg" min="0" max="100" value="50" style="width: 100%;">
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Dialogs -->
    <!-- ============================================= -->

    <!-- Alert Dialogs -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Dialogs</h2>

      <p class="orp-mb-3"><strong>Alert Dialogs</strong></p>
      <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-mb-4">
        <button class="orp-btn orp-btn--primary" @click="showAlertNeutral">
          Neutral Alert
        </button>
        <button class="orp-btn orp-btn--primary" @click="showAlertSuccess">
          Success Alert
        </button>
        <button class="orp-btn orp-btn--primary" @click="showAlertWarning">
          Warning Alert
        </button>
        <button class="orp-btn orp-btn--primary" @click="showAlertDanger">
          Danger Alert
        </button>
      </div>

      <p class="orp-mb-3"><strong>Confirm Dialogs</strong></p>
      <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-mb-4">
        <button class="orp-btn orp-btn--primary" @click="showConfirm">
          Confirm
        </button>
        <button class="orp-btn orp-btn--danger" @click="showConfirmDanger">
          Destructive Confirm
        </button>
      </div>

      <p class="orp-mb-3"><strong>Prompt Dialog</strong></p>
      <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-mb-4">
        <button class="orp-btn orp-btn--primary" @click="showPrompt">
          Prompt
        </button>
      </div>

      <p class="orp-mb-3"><strong>Vertical Actions</strong></p>
      <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-mb-4">
        <button class="orp-btn orp-btn--primary" @click="showConfirmVertical">
          Confirm Vertical
        </button>
      </div>

      <p class="orp-mb-3"><strong>Dialog Sizes</strong></p>
      <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-mb-4">
        <button class="orp-btn orp-btn--primary" @click="showDialogSm">
          Small
        </button>
        <button class="orp-btn orp-btn--primary" @click="showDialogMd">
          Medium
        </button>
        <button class="orp-btn orp-btn--primary" @click="showDialogLg">
          Large
        </button>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Utilities -->
    <!-- ============================================= -->

    <!-- Spacing Utilities -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Utilities: Spacing</h2>

      <p class="orp-mb-3"><strong>Padding</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-align-center">
            <div class="orp-utility-demo-box orp-p-1">orp-p-1</div>
            <div class="orp-utility-demo-box orp-p-2">orp-p-2</div>
            <div class="orp-utility-demo-box orp-p-3">orp-p-3</div>
            <div class="orp-utility-demo-box orp-p-4">orp-p-4</div>
            <div class="orp-utility-demo-box orp-p-5">orp-p-5</div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Margin Top</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4">
            <div class="orp-utility-demo-box orp-mt-1">mt-1</div>
            <div class="orp-utility-demo-box orp-mt-2">mt-2</div>
            <div class="orp-utility-demo-box orp-mt-3">mt-3</div>
            <div class="orp-utility-demo-box orp-mt-4">mt-4</div>
            <div class="orp-utility-demo-box orp-mt-5">mt-5</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gap Utilities -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Utilities: Gap</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-1 orp-mb-3">
            <div class="orp-utility-demo-box-sm">1</div>
            <div class="orp-utility-demo-box-sm">2</div>
            <div class="orp-utility-demo-box-sm">3</div>
          </div>
          <p class="orp-text-muted orp-mb-2">gap-1</p>

          <div class="orp-d-flex orp-flex-wrap orp-gap-3 orp-mb-3">
            <div class="orp-utility-demo-box-sm">1</div>
            <div class="orp-utility-demo-box-sm">2</div>
            <div class="orp-utility-demo-box-sm">3</div>
          </div>
          <p class="orp-text-muted orp-mb-2">gap-3</p>

          <div class="orp-d-flex orp-flex-wrap orp-gap-5">
            <div class="orp-utility-demo-box-sm">1</div>
            <div class="orp-utility-demo-box-sm">2</div>
            <div class="orp-utility-demo-box-sm">3</div>
          </div>
          <p class="orp-text-muted">gap-5</p>
        </div>
      </div>
    </section>

    <!-- Display & Flex Utilities -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Utilities: Display & Flex</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-align-center orp-justify-between orp-mb-4">
            <span>justify-between</span>
            <span>→</span>
          </div>
          <div class="orp-d-flex orp-align-center orp-justify-center orp-mb-4">
            <span>justify-center</span>
          </div>
          <div class="orp-d-flex orp-align-center orp-justify-end orp-mb-4">
            <span>justify-end</span>
          </div>
          <div class="orp-d-flex orp-flex-column orp-gap-2">
            <span>flex-column item 1</span>
            <span>flex-column item 2</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Integrations -->
    <!-- ============================================= -->

    <!-- Icon System -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Icon System</h2>

      <p class="orp-mb-3"><strong>Sizes</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-align-center orp-gap-5">
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-2">
              <i class="bi bi-house orp-icon orp-icon--sm" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">sm</span>
            </div>
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-2">
              <i class="bi bi-house orp-icon orp-icon--md" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">md</span>
            </div>
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-2">
              <i class="bi bi-house orp-icon orp-icon--lg" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">lg</span>
            </div>
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-2">
              <i class="bi bi-house orp-icon orp-icon--xl" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">xl</span>
            </div>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Icon + Button</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-3">
            <button class="orp-btn orp-btn--primary">
              <i class="bi bi-check-lg orp-icon" aria-hidden="true"></i>
              Guardar
            </button>
            <button class="orp-btn orp-btn--secondary">
              <i class="bi bi-x-lg orp-icon" aria-hidden="true"></i>
              Cancelar
            </button>
            <button class="orp-btn orp-btn--ghost">
              <i class="bi bi-arrow-left orp-icon" aria-hidden="true"></i>
              Volver
            </button>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>IconButton</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-align-center orp-gap-3">
            <button class="orp-icon-btn orp-icon-btn--primary" aria-label="Favorito">
              <i class="bi bi-heart orp-icon orp-icon--lg" aria-hidden="true"></i>
            </button>
            <button class="orp-icon-btn orp-icon-btn--ghost" aria-label="Compartir">
              <i class="bi bi-share orp-icon orp-icon--lg" aria-hidden="true"></i>
            </button>
            <button class="orp-icon-btn orp-icon-btn--danger" aria-label="Eliminar">
              <i class="bi bi-trash orp-icon orp-icon--lg" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Icon + Chip</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-cluster orp-cluster--2">
            <span class="orp-chip">
              <i class="bi bi-tag orp-icon" aria-hidden="true"></i>
              Etiqueta
            </span>
            <span class="orp-chip orp-chip--primary">
              <i class="bi bi-check-circle orp-icon" aria-hidden="true"></i>
              Completado
            </span>
          </div>
        </div>
      </div>

      <p class="orp-mb-3"><strong>Navigation Icons</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4">
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-1">
              <i class="bi bi-house orp-icon orp-icon--lg" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">Home</span>
            </div>
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-1">
              <i class="bi bi-search orp-icon orp-icon--lg" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">Search</span>
            </div>
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-1">
              <i class="bi bi-bell orp-icon orp-icon--lg" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">Notifications</span>
            </div>
            <div class="orp-d-flex orp-flex-column orp-align-center orp-gap-1">
              <i class="bi bi-person orp-icon orp-icon--lg" aria-hidden="true"></i>
              <span class="orp-text-muted" style="font-size: 0.75rem;">Profile</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Lightbox Demo -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">GLightbox Integration</h2>

      <p class="orp-mb-3"><strong>orp-lightbox convention</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-wrap orp-gap-4 orp-justify-center">
            <a href="https://picsum.photos/800/600?random=50" class="orp-lightbox orp-media orp-media--square orp-media--rounded">
              <img class="orp-media__content" src="https://picsum.photos/200/200?random=50" alt="Image 1" loading="lazy">
            </a>
            <a href="https://picsum.photos/800/600?random=51" class="orp-lightbox orp-media orp-media--square orp-media--rounded">
              <img class="orp-media__content" src="https://picsum.photos/200/200?random=51" alt="Image 2" loading="lazy">
            </a>
            <a href="https://picsum.photos/800/600?random=52" class="orp-lightbox orp-media orp-media--square orp-media--rounded">
              <img class="orp-media__content" src="https://picsum.photos/200/200?random=52" alt="Image 3" loading="lazy">
            </a>
          </div>
          <p class="orp-text-muted orp-mt-3" style="font-size: 0.875rem;">Click on images to open lightbox. Requires GLightbox JS initialization.</p>
        </div>
      </div>
    </section>

    <!-- Swiper Demo -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Swiper Integration</h2>

      <p class="orp-mb-3"><strong>orp-swiper wrapper</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-scroll-x orp-scroll-x--snap">
            <article class="orp-scroll-x__item" style="width: 200px;">
              <div class="orp-media-card orp-media-card--compact">
                <div class="orp-media-card__media">
                  <div class="orp-media orp-media--square">
                    <img class="orp-media__content" src="https://picsum.photos/200/200?random=60" alt="" loading="lazy">
                  </div>
                </div>
                <div class="orp-media-card__body">
                  <h3 class="orp-media-card__title">Slide 1</h3>
                </div>
              </div>
            </article>
            <article class="orp-scroll-x__item" style="width: 200px;">
              <div class="orp-media-card orp-media-card--compact">
                <div class="orp-media-card__media">
                  <div class="orp-media orp-media--square">
                    <img class="orp-media__content" src="https://picsum.photos/200/200?random=61" alt="" loading="lazy">
                  </div>
                </div>
                <div class="orp-media-card__body">
                  <h3 class="orp-media-card__title">Slide 2</h3>
                </div>
              </div>
            </article>
            <article class="orp-scroll-x__item" style="width: 200px;">
              <div class="orp-media-card orp-media-card--compact">
                <div class="orp-media-card__media">
                  <div class="orp-media orp-media--square">
                    <img class="orp-media__content" src="https://picsum.photos/200/200?random=62" alt="" loading="lazy">
                  </div>
                </div>
                <div class="orp-media-card__body">
                  <h3 class="orp-media-card__title">Slide 3</h3>
                </div>
              </div>
            </article>
          </div>
          <p class="orp-text-muted orp-mt-3" style="font-size: 0.875rem;">Horizontal scroll with snap. Use Swiper JS for full carousel functionality.</p>
        </div>
      </div>
    </section>

    <!-- ============================================= -->
    <!-- Application Layout -->
    <!-- ============================================= -->

    <!-- Basic App Shell -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">App Shell: Basic</h2>

      <p class="orp-mb-3"><strong>Mobile layout with Header + Main + BottomNav</strong></p>
      <div class="orp-demo-frame orp-demo-frame--mobile">
        <div class="orp-app-shell orp-app-shell--has-header orp-app-shell--has-fixed-bottom">
          <header class="orp-app-shell__header orp-app-shell__header--sticky">
            <div class="orp-app-bar">
              <div class="orp-app-bar__content">
                <h1 class="orp-app-bar__title">App Title</h1>
              </div>
            </div>
          </header>
          <main class="orp-app-shell__main">
            <div class="orp-page-content">
              <p class="orp-text-muted">Main content area with scroll</p>
              <div class="orp-stack orp-stack--3">
                <div class="orp-skeleton orp-skeleton--text" style="width: 80%"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 60%"></div>
                <div class="orp-skeleton orp-skeleton--text" style="width: 70%"></div>
              </div>
            </div>
          </main>
          <nav class="orp-app-shell__bottom orp-app-shell__bottom--fixed">
            <div class="orp-bottom-nav">
              <a href="#" class="orp-bottom-nav__item orp-bottom-nav__item--active">
                <i class="bi bi-house orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Home</span>
              </a>
              <a href="#" class="orp-bottom-nav__item">
                <i class="bi bi-search orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Search</span>
              </a>
              <a href="#" class="orp-bottom-nav__item">
                <i class="bi bi-bell orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Alerts</span>
              </a>
              <a href="#" class="orp-bottom-nav__item">
                <i class="bi bi-person orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Profile</span>
              </a>
            </div>
          </nav>
        </div>
      </div>
    </section>

    <!-- App Shell with FAB -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">App Shell: FAB + BottomNav</h2>

      <p class="orp-mb-3"><strong>FAB positioned above BottomNav with safe area</strong></p>
      <div class="orp-demo-frame orp-demo-frame--mobile">
        <div class="orp-app-shell orp-app-shell--has-fixed-bottom" style="padding-bottom: 0;">
          <main class="orp-app-shell__main">
            <div class="orp-page-content">
              <p class="orp-text-muted">FAB avoids BottomNav</p>
            </div>
          </main>
          <div class="orp-app-shell__fab">
            <button class="orp-fab" aria-label="Create">
              <i class="bi bi-plus-lg orp-icon orp-icon--lg" aria-hidden="true"></i>
            </button>
          </div>
          <nav class="orp-app-shell__bottom orp-app-shell__bottom--fixed">
            <div class="orp-bottom-nav">
              <a href="#" class="orp-bottom-nav__item orp-bottom-nav__item--active">
                <i class="bi bi-house orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Home</span>
              </a>
              <a href="#" class="orp-bottom-nav__item">
                <i class="bi bi-plus-lg orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Create</span>
              </a>
              <a href="#" class="orp-bottom-nav__item">
                <i class="bi bi-person orp-icon orp-icon--lg" aria-hidden="true"></i>
                <span class="orp-bottom-nav__label">Profile</span>
              </a>
            </div>
          </nav>
        </div>
      </div>
    </section>

    <!-- App Shell with Sidebar (Desktop) -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">App Shell: Sidebar (Desktop)</h2>

      <p class="orp-mb-3"><strong>Resize to see sidebar appear at lg breakpoint</strong></p>
      <div class="orp-demo-frame orp-demo-frame--tablet">
        <div class="orp-app-shell orp-app-shell--has-sidebar">
          <aside class="orp-app-shell__sidebar">
            <div class="orp-app-shell__sidebar-header">
              <h3>Sidebar</h3>
            </div>
            <div class="orp-app-shell__sidebar-body">
              <div class="orp-stack orp-stack--2">
                <span class="orp-chip orp-chip--selected">Dashboard</span>
                <span class="orp-chip">Analytics</span>
                <span class="orp-chip">Reports</span>
                <span class="orp-chip">Settings</span>
              </div>
            </div>
          </aside>
          <div class="orp-app-shell__body">
            <header class="orp-app-shell__header orp-app-shell__header--sticky">
              <div class="orp-app-bar">
                <div class="orp-app-bar__content">
                  <h1 class="orp-app-bar__title">Desktop Layout</h1>
                </div>
              </div>
            </header>
            <main class="orp-app-shell__main">
              <div class="orp-page-content orp-page-content--contained">
                <p class="orp-text-muted">Main content with sidebar on desktop</p>
                <div class="orp-stack orp-stack--3">
                  <div class="orp-skeleton orp-skeleton--text" style="width: 60%"></div>
                  <div class="orp-skeleton orp-skeleton--text" style="width: 80%"></div>
                  <div class="orp-skeleton orp-skeleton--text" style="width: 70%"></div>
                </div>
              </div>
            </main>
          </div>
        </div>
      </div>
    </section>

    <!-- Page Content Variants -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Page Content</h2>

      <p class="orp-mb-3"><strong>Contained vs Fluid</strong></p>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-d-flex orp-flex-column orp-gap-4">
            <div style="border: 1px dashed var(--orp-border); padding: var(--orp-space-3);">
              <p class="orp-text-muted orp-mb-2">orp-page-content (default)</p>
              <div class="orp-page-content" style="background: var(--orp-surface-muted);">
                Content with default padding
              </div>
            </div>
            <div style="border: 1px dashed var(--orp-border); padding: var(--orp-space-3);">
              <p class="orp-text-muted orp-mb-2">orp-page-content--contained</p>
              <div class="orp-page-content orp-page-content--contained" style="background: var(--orp-surface-muted);">
                Centered content with max-width
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Safe Area -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Safe Area Helpers</h2>

      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-stack orp-stack--3">
            <div class="orp-safe-top" style="background: var(--orp-surface-muted); padding: var(--orp-space-3);">
              <code class="orp-text-muted">.orp-safe-top</code>
            </div>
            <div class="orp-safe-bottom" style="background: var(--orp-surface-muted); padding: var(--orp-space-3);">
              <code class="orp-text-muted">.orp-safe-bottom</code>
            </div>
            <div class="orp-safe-all" style="background: var(--orp-surface-muted); padding: var(--orp-space-3);">
              <code class="orp-text-muted">.orp-safe-all</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Navigation Primitives -->
    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Navigation Primitives</h2>

      <!-- Breadcrumb -->
      <h3 class="orp-h3 orp-mb-3">Breadcrumb</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-breadcrumb orp-mb-4">
            <ol class="orp-breadcrumb__list">
              <li class="orp-breadcrumb__item">
                <a href="/" class="orp-breadcrumb__link">Inicio</a>
                <span class="orp-breadcrumb__separator">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </span>
              </li>
              <li class="orp-breadcrumb__item">
                <a href="/cuenta" class="orp-breadcrumb__link">Cuenta</a>
                <span class="orp-breadcrumb__separator">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </span>
              </li>
              <li class="orp-breadcrumb__item orp-breadcrumb__item--current" aria-current="page">
                <span class="orp-breadcrumb__link">Perfil</span>
              </li>
            </ol>
          </div>

          <div class="orp-divider orp-my-4"></div>

          <div class="orp-breadcrumb">
            <ol class="orp-breadcrumb__list">
              <li class="orp-breadcrumb__item">
                <a href="/" class="orp-breadcrumb__link">Inicio</a>
                <span class="orp-breadcrumb__separator">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </span>
              </li>
              <li class="orp-breadcrumb__item">
                <a href="/productos" class="orp-breadcrumb__link">Productos</a>
                <span class="orp-breadcrumb__separator">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </span>
              </li>
              <li class="orp-breadcrumb__item">
                <a href="/categoria" class="orp-breadcrumb__link">Categoría</a>
                <span class="orp-breadcrumb__separator">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </span>
              </li>
              <li class="orp-breadcrumb__item orp-breadcrumb__item--current" aria-current="page">
                <span class="orp-breadcrumb__link">Producto Actual con Nombre Muy Largo</span>
              </li>
            </ol>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <h3 class="orp-h3 orp-mb-3">Pagination</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <nav class="orp-pagination orp-mb-4" aria-label="Paginación">
            <ul class="orp-pagination__list">
              <li class="orp-pagination__item orp-pagination__item--disabled">
                <a href="?page=1" class="orp-pagination__link" aria-label="Página anterior">
                  <i class="bi bi-chevron-left orp-icon" aria-hidden="true"></i>
                </a>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=1" class="orp-pagination__link">1</a>
              </li>
              <li class="orp-pagination__item orp-pagination__item--active">
                <a href="?page=2" class="orp-pagination__link" aria-current="page">2</a>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=3" class="orp-pagination__link">3</a>
              </li>
              <li class="orp-pagination__item">
                <span class="orp-pagination__ellipsis">…</span>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=10" class="orp-pagination__link">10</a>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=2" class="orp-pagination__link" aria-label="Página siguiente">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </nav>

          <div class="orp-divider orp-my-4"></div>

          <nav class="orp-pagination orp-pagination--compact" aria-label="Paginación compact">
            <ul class="orp-pagination__list">
              <li class="orp-pagination__item orp-pagination__item--disabled">
                <a href="?page=1" class="orp-pagination__link">
                  <i class="bi bi-chevron-left orp-icon" aria-hidden="true"></i>
                </a>
              </li>
              <li class="orp-pagination__item orp-pagination__item--active">
                <a href="?page=1" class="orp-pagination__link" aria-current="page">1</a>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=2" class="orp-pagination__link">2</a>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=3" class="orp-pagination__link">3</a>
              </li>
              <li class="orp-pagination__item">
                <a href="?page=2" class="orp-pagination__link">
                  <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

      <!-- Navigation List -->
      <h3 class="orp-h3 orp-mb-3">Navigation List</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <nav class="orp-nav orp-mb-4" aria-label="Navegación principal">
            <div class="orp-nav__item orp-nav__item--active">
              <a href="/" class="orp-nav__link" aria-current="page">
                <span class="orp-nav__icon">
                  <i class="bi bi-house orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Inicio</span>
              </a>
            </div>
            <div class="orp-nav__item">
              <a href="/explorar" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-compass orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Explorar</span>
              </a>
            </div>
            <div class="orp-nav__item">
              <a href="/actividad" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-bell orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Actividad</span>
                <span class="orp-nav__badge">
                  <span class="orp-badge orp-badge--danger">3</span>
                </span>
              </a>
            </div>
            <div class="orp-nav__item">
              <a href="/perfil" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-person orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Perfil</span>
              </a>
            </div>
          </nav>

          <div class="orp-divider orp-my-4"></div>

          <div class="orp-nav__group">
            <div class="orp-nav__group-title">Cuenta</div>
            <div class="orp-nav__item">
              <a href="/configuracion" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-gear orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Configuración</span>
              </a>
            </div>
            <div class="orp-nav__item orp-nav__item--disabled">
              <a href="#" class="orp-nav__link" aria-disabled="true">
                <span class="orp-nav__icon">
                  <i class="bi bi-question-circle orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Ayuda</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Horizontal -->
      <h3 class="orp-h3 orp-mb-3">Navigation Horizontal</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <nav class="orp-nav orp-nav--horizontal" aria-label="Navegación horizontal">
            <div class="orp-nav__item orp-nav__item--active">
              <a href="/" class="orp-nav__link" aria-current="page">
                <span class="orp-nav__icon">
                  <i class="bi bi-house orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Inicio</span>
              </a>
            </div>
            <div class="orp-nav__item">
              <a href="/explorar" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-compass orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Explorar</span>
              </a>
            </div>
            <div class="orp-nav__item">
              <a href="/actividad" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-bell orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Actividad</span>
              </a>
            </div>
            <div class="orp-nav__item">
              <a href="/perfil" class="orp-nav__link">
                <span class="orp-nav__icon">
                  <i class="bi bi-person orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav__label">Perfil</span>
              </a>
            </div>
          </nav>
        </div>
      </div>

      <!-- Navigation Rail -->
      <h3 class="orp-h3 orp-mb-3">Navigation Rail</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-cluster orp-justify-center">
            <nav class="orp-nav-rail" aria-label="Navegación rail">
              <a href="/" class="orp-nav-rail__item orp-nav-rail__item--active" aria-current="page">
                <span class="orp-nav-rail__icon">
                  <i class="bi bi-house orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav-rail__label">Inicio</span>
              </a>
              <a href="/explorar" class="orp-nav-rail__item">
                <span class="orp-nav-rail__icon">
                  <i class="bi bi-compass orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav-rail__label">Explorar</span>
              </a>
              <a href="/actividad" class="orp-nav-rail__item">
                <span class="orp-nav-rail__icon">
                  <i class="bi bi-bell orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav-rail__label">Actividad</span>
              </a>
              <a href="/perfil" class="orp-nav-rail__item">
                <span class="orp-nav-rail__icon">
                  <i class="bi bi-person orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav-rail__label">Perfil</span>
              </a>
              <a href="/configuracion" class="orp-nav-rail__item">
                <span class="orp-nav-rail__icon">
                  <i class="bi bi-gear orp-icon" aria-hidden="true"></i>
                </span>
                <span class="orp-nav-rail__label">Ajustes</span>
              </a>
            </nav>
          </div>
        </div>
      </div>

      <!-- Stepper Horizontal -->
      <h3 class="orp-h3 orp-mb-3">Stepper Horizontal</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <ol class="orp-stepper orp-stepper--horizontal">
            <li class="orp-stepper__item orp-stepper__item--complete">
              <div class="orp-stepper__indicator">
                <i class="bi bi-check orp-icon" aria-hidden="true"></i>
              </div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Información</div>
              </div>
              <span class="orp-stepper__connector" aria-hidden="true"></span>
            </li>
            <li class="orp-stepper__item orp-stepper__item--active" aria-current="step">
              <div class="orp-stepper__indicator">2</div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Detalles</div>
              </div>
              <span class="orp-stepper__connector" aria-hidden="true"></span>
            </li>
            <li class="orp-stepper__item">
              <div class="orp-stepper__indicator">3</div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Confirmación</div>
              </div>
            </li>
          </ol>
        </div>
      </div>

      <!-- Stepper Vertical -->
      <h3 class="orp-h3 orp-mb-3">Stepper Vertical</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <ol class="orp-stepper">
            <li class="orp-stepper__item orp-stepper__item--complete">
              <div class="orp-stepper__indicator">
                <i class="bi bi-check orp-icon" aria-hidden="true"></i>
              </div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Información Personal</div>
                <div class="orp-stepper__description">Completa tus datos básicos</div>
              </div>
              <span class="orp-stepper__connector" aria-hidden="true"></span>
            </li>
            <li class="orp-stepper__item orp-stepper__item--complete">
              <div class="orp-stepper__indicator">
                <i class="bi bi-check orp-icon" aria-hidden="true"></i>
              </div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Datos de Contacto</div>
                <div class="orp-stepper__description">Teléfono y dirección de email</div>
              </div>
              <span class="orp-stepper__connector" aria-hidden="true"></span>
            </li>
            <li class="orp-stepper__item orp-stepper__item--active" aria-current="step">
              <div class="orp-stepper__indicator">3</div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Verificación</div>
                <div class="orp-stepper__description">Confirma tu identidad</div>
              </div>
              <span class="orp-stepper__connector" aria-hidden="true"></span>
            </li>
            <li class="orp-stepper__item orp-stepper__item--disabled">
              <div class="orp-stepper__indicator">4</div>
              <div class="orp-stepper__content">
                <div class="orp-stepper__title">Completado</div>
                <div class="orp-stepper__description">Todo listo</div>
              </div>
            </li>
          </ol>
        </div>
      </div>

      <!-- Back Action Pattern -->
      <h3 class="orp-h3 orp-mb-3">Back Action Pattern</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-cluster orp-gap-3">
            <button class="orp-icon-btn" aria-label="Volver">
              <i class="bi bi-arrow-left orp-icon" aria-hidden="true"></i>
            </button>
            <button class="orp-icon-btn" aria-label="Adelante">
              <i class="bi bi-arrow-right orp-icon" aria-hidden="true"></i>
            </button>
            <button class="orp-icon-btn" aria-label="Ir atrás">
              <i class="bi bi-chevron-left orp-icon" aria-hidden="true"></i>
            </button>
            <button class="orp-icon-btn" aria-label="Ir adelante">
              <i class="bi bi-chevron-right orp-icon" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- App Shell + Navigation Demo -->
      <h3 class="orp-h3 orp-mb-3">App Shell + Navigation Composition</h3>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <div class="orp-stack orp-stack-4">
            <!-- Desktop composition -->
            <div>
              <p class="orp-text-sm orp-text-muted orp-mb-2">Desktop: Sidebar + Nav Rail</p>
              <div class="orp-demo-frame orp-demo-frame--tablet" style="display: flex; height: 300px;">
                <aside class="orp-app-shell__sidebar" style="width: 280px; border-right: 1px solid var(--orp-border); padding: var(--orp-space-3);">
                  <nav class="orp-nav" aria-label="Sidebar nav">
                    <div class="orp-nav__item orp-nav__item--active">
                      <a href="/" class="orp-nav__link" aria-current="page">
                        <span class="orp-nav__icon"><i class="bi bi-house orp-icon" aria-hidden="true"></i></span>
                        <span class="orp-nav__label">Inicio</span>
                      </a>
                    </div>
                    <div class="orp-nav__item">
                      <a href="/productos" class="orp-nav__link">
                        <span class="orp-nav__icon"><i class="bi bi-box orp-icon" aria-hidden="true"></i></span>
                        <span class="orp-nav__label">Productos</span>
                      </a>
                    </div>
                    <div class="orp-nav__item">
                      <a href="/ventas" class="orp-nav__link">
                        <span class="orp-nav__icon"><i class="bi bi-graph-up orp-icon" aria-hidden="true"></i></span>
                        <span class="orp-nav__label">Ventas</span>
                      </a>
                    </div>
                  </nav>
                </aside>
                <main class="orp-app-shell__main" style="flex: 1; padding: var(--orp-space-4);">
                  <p class="orp-text-muted">Contenido principal</p>
                </main>
              </div>
            </div>

            <!-- Mobile composition -->
            <div>
              <p class="orp-text-sm orp-text-muted orp-mb-2">Mobile: Bottom Nav</p>
              <div class="orp-demo-frame orp-demo-frame--mobile" style="display: flex; flex-direction: column;">
                <main class="orp-app-shell__main" style="flex: 1; padding: var(--orp-space-4);">
                  <p class="orp-text-muted">Contenido principal</p>
                </main>
                <nav class="orp-bottom-nav" aria-label="Navegación inferior" style="position: relative;">
                  <a href="/" class="orp-bottom-nav__item orp-bottom-nav__item--active" aria-current="page">
                    <span class="orp-bottom-nav__icon"><i class="bi bi-house orp-icon" aria-hidden="true"></i></span>
                    <span class="orp-bottom-nav__label">Inicio</span>
                  </a>
                  <a href="/explorar" class="orp-bottom-nav__item">
                    <span class="orp-bottom-nav__icon"><i class="bi bi-compass orp-icon" aria-hidden="true"></i></span>
                    <span class="orp-bottom-nav__label">Explorar</span>
                  </a>
                  <a href="/actividad" class="orp-bottom-nav__item">
                    <span class="orp-bottom-nav__icon"><i class="bi bi-bell orp-icon" aria-hidden="true"></i></span>
                    <span class="orp-bottom-nav__label">Actividad</span>
                  </a>
                  <a href="/perfil" class="orp-bottom-nav__item">
                    <span class="orp-bottom-nav__icon"><i class="bi bi-person orp-icon" aria-hidden="true"></i></span>
                    <span class="orp-bottom-nav__label">Perfil</span>
                  </a>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="orp-playground__section">
      <h2 class="orp-h2 orp-mb-4">Responsive Preview</h2>
      <div class="orp-card orp-card--outlined orp-mb-4">
        <div class="orp-card__body">
          <p class="orp-text-muted orp-mb-3">Resize your browser to see responsive behavior. This container is mobile-first.</p>
          <div class="responsive-demo">
            <div class="orp-flex-row orp-align-center orp-gap-2 orp-text-center">
              <div class="demo-box orp-w-100 orp-p-3">
                <strong>320px</strong> - Full width
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Command Menu (uses Teleport) -->
    <OrpCommandMenu
      v-model="showCommandMenu"
      :items="commandMenuItems"
      placeholder="Search commands..."
      empty-text="No commands found"
      @select="(item) => console.log('Selected:', item)"
    />

    <!-- Dialog Host (uses Teleport) -->
    <OrpDialogHost />
  </div>
</template>

<style>
.orp-playground {
  padding: var(--orp-space-4);
  background: var(--orp-background);
  min-height: 100vh;
  padding-bottom: calc(var(--orp-space-4) + 64px + env(safe-area-inset-bottom, 0px));
}

.orp-playground__header {
  text-align: center;
  padding: var(--orp-space-5) 0;
  margin-bottom: var(--orp-space-5);
}

.orp-playground__section {
  margin-bottom: var(--orp-space-5);
}

.color-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: var(--orp-space-2);
}

.color-swatch {
  padding: var(--orp-space-3);
  border-radius: var(--orp-radius-sm);
  font-size: 0.75rem;
  font-weight: 500;
  color: white;
  text-align: center;
  text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.color-swatch:nth-child(6),
.color-swatch:nth-child(7) {
  color: var(--orp-text);
  text-shadow: none;
}

.demo-box {
  background: var(--orp-primary);
  color: white;
  padding: var(--orp-space-2) var(--orp-space-3);
  border-radius: var(--orp-radius-sm);
  font-size: 0.875rem;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 44px;
  min-height: 44px;
}

.responsive-demo {
  max-width: 320px;
  margin: 0 auto;
}

.orp-utility-demo-box {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 48px;
  min-height: 48px;
  background: var(--orp-surface-muted);
  border: 1px dashed var(--orp-border);
  border-radius: var(--orp-radius-sm);
  font-family: var(--orp-font-family);
  font-size: var(--orp-font-size-sm);
  color: var(--orp-muted-foreground);
}

.orp-utility-demo-box-sm {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background: var(--orp-primary);
  color: var(--orp-primary-foreground);
  border-radius: var(--orp-radius-sm);
  font-family: var(--orp-font-family);
  font-size: var(--orp-font-size-sm);
  font-weight: 500;
}

.orp-demo-frame {
  border: 1px solid var(--orp-border);
  border-radius: var(--orp-radius-md);
  overflow: hidden;
  background: var(--orp-background);
}

.orp-demo-frame--mobile {
  max-width: 375px;
  height: 667px;
}

.orp-demo-frame--tablet {
  max-width: 768px;
  height: 500px;
}

@media (min-width: 768px) {
  .orp-playground {
    max-width: 720px;
    margin: 0 auto;
    padding: var(--orp-space-5);
    padding-bottom: calc(var(--orp-space-5) + 64px + env(safe-area-inset-bottom, 0px));
  }

  .responsive-demo {
    max-width: 100%;
  }
}

.orp-context-demo {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: var(--orp-space-3);
  padding: var(--orp-space-8);
  background: var(--orp-surface-muted);
  border-radius: var(--orp-radius-md);
  text-align: center;
  color: var(--orp-muted-foreground);
  min-height: 200px;
}
</style>

<style>
@import '../../less/orp-ui/orp-ui.less';
@import 'bootstrap-icons/font/bootstrap-icons.css';
@import 'glightbox/dist/css/glightbox.min.css';
</style>
