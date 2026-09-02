<script setup>
import { ref } from 'vue'
import {
    OrpTabs, OrpModal, OrpSheet, OrpSwitch,
    OrpToast, OrpAccordion, OrpDropdown, OrpPopover,
    OrpDrawer, OrpIconButton,
    OrpSegmented, OrpSearchInput, OrpFileInput, OrpActionSheet
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
</style>

<style>
@import '../../less/orp-ui/orp-ui.less';
@import 'bootstrap-icons/font/bootstrap-icons.css';
@import 'glightbox/dist/css/glightbox.min.css';
</style>
