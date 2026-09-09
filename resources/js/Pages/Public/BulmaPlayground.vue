<template>
  <div class="bulma-playground">
    <UiDialogHost />
    <header class="bulma-playground__header">
      <div class="container is-flex is-justify-content-space-between is-align-items-center">
        <div>
          <h1 class="bulma-playground__title">Bulma Component Playground</h1>
          <p class="bulma-playground__subtitle">Componentes base construidos con Bulma CSS</p>
        </div>
        <button class="button is-small" @click="toggleTheme">
          {{ theme === 'light' ? '🌙' : '☀️' }} {{ theme === 'light' ? 'Dark' : 'Light' }}
        </button>
      </div>
    </header>

    <div class="container p-5">
      <div class="tabs">
        <ul>
          <li v-for="tab in tabs" :key="tab.id" :class="{ 'is-active': activeTab === tab.id }">
            <a @click="activeTab = tab.id">{{ tab.label }}</a>
          </li>
        </ul>
      </div>

      <KeepAlive>
        <component :is="activeTabComponent" :key="activeTab" />
      </KeepAlive>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, defineAsyncComponent, onMounted } from 'vue'
import UiDialogHost from '@/Components/Ui/UiDialogHost.vue'

const PrimitivesTab = defineAsyncComponent(() => import('./tabs/PrimitivesTab.vue'))
const FormsTab = defineAsyncComponent(() => import('./tabs/FormsTab.vue'))
const LayoutTab = defineAsyncComponent(() => import('./tabs/LayoutTab.vue'))
const NavigationTab = defineAsyncComponent(() => import('./tabs/NavigationTab.vue'))
const OverlaysTab = defineAsyncComponent(() => import('./tabs/OverlaysTab.vue'))
const MediaTab = defineAsyncComponent(() => import('./tabs/MediaTab.vue'))
const DataTab = defineAsyncComponent(() => import('./tabs/DataTab.vue'))
const CardsTab = defineAsyncComponent(() => import('./tabs/CardsTab.vue'))
const FeedbackTab = defineAsyncComponent(() => import('./tabs/FeedbackTab.vue'))
const SpecialTab = defineAsyncComponent(() => import('./tabs/SpecialTab.vue'))
const AdvancedTab = defineAsyncComponent(() => import('./tabs/AdvancedTab.vue'))
const SlidersTab = defineAsyncComponent(() => import('./tabs/SlidersTab.vue'))
const BusinessTab = defineAsyncComponent(() => import('./tabs/BusinessTab.vue'))
const HeroesTab = defineAsyncComponent(() => import('./tabs/HeroesTab.vue'))

const tabs = [
  { id: 'primitives', label: 'Primitives', component: PrimitivesTab },
  { id: 'forms', label: 'Forms', component: FormsTab },
  { id: 'layout', label: 'Layout', component: LayoutTab },
  { id: 'navigation', label: 'Navigation', component: NavigationTab },
  { id: 'overlays', label: 'Overlays', component: OverlaysTab },
  { id: 'media', label: 'Media', component: MediaTab },
  { id: 'data', label: 'Data Display', component: DataTab },
  { id: 'cards', label: 'Cards', component: CardsTab },
  { id: 'feedback', label: 'Feedback', component: FeedbackTab },
  { id: 'special', label: 'Special Cards', component: SpecialTab },
  { id: 'advanced', label: 'Advanced', component: AdvancedTab },
  { id: 'sliders', label: 'Sliders', component: SlidersTab },
  { id: 'business', label: 'Business', component: BusinessTab },
  { id: 'heroes', label: 'Heroes', component: HeroesTab },
]

const activeTab = ref('primitives')

const activeTabComponent = computed(() => {
  const tab = tabs.find(t => t.id === activeTab.value)
  return tab?.component || PrimitivesTab
})

const theme = ref('light')

onMounted(() => {
  const savedTheme = localStorage.getItem('bulma-playground-theme')
  if (savedTheme) {
    theme.value = savedTheme
    document.documentElement.setAttribute('data-theme', savedTheme)
  }
})

const toggleTheme = () => {
  theme.value = theme.value === 'light' ? 'dark' : 'light'
  document.documentElement.setAttribute('data-theme', theme.value)
  localStorage.setItem('bulma-playground-theme', theme.value)
}
</script>

<style lang="scss">
.bulma-playground {
  min-height: 100vh;
}

.playground-section {
  padding: 1rem 0;
}

.box {
  background-color: var(--bulma-scheme-main);
}
</style>
