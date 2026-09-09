<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Breadcrumb</h3>
      <div class="mb-4">
        <UiBreadcrumb :items="breadcrumbItems" separator="arrow" />
      </div>
      <div class="mb-4">
        <UiBreadcrumb :items="breadcrumbItems" separator="separator" />
      </div>
      <div>
        <UiBreadcrumb :items="breadcrumbItemsWithIcons" separator="arrow" />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Tabs - Default</h3>
      <UiTabs v-model="activeTab" :items="tabItems" variant="default" />
      <p class="mt-3">Active tab: <strong>{{ activeTab }}</strong></p>
    </div>

    <div class="box">
      <h3 class="title is-4">Tabs - Pills</h3>
      <UiTabs v-model="activeTabPill" :items="tabItems" variant="pill" />
      <p class="mt-3">Active tab: <strong>{{ activeTabPill }}</strong></p>
    </div>

    <div class="box">
      <h3 class="title is-4">Tabs - Underline</h3>
      <UiTabs v-model="activeTabUnderline" :items="tabItems" variant="underline" />
      <p class="mt-3">Active tab: <strong>{{ activeTabUnderline }}</strong></p>
    </div>

    <div class="box">
      <h3 class="title is-4">Tabs - Stretch</h3>
      <UiTabs v-model="activeTabStretch" :items="tabItemsStretch" variant="default" stretch />
    </div>

    <div class="box">
      <h3 class="title is-4">Pagination</h3>
      <UiPagination v-model="currentPage" :total-pages="totalPages" />
      <p class="mt-3">Current page: <strong>{{ currentPage }}</strong></p>
    </div>

    <div class="box">
      <h3 class="title is-4">Pagination Sizes</h3>
      <div class="mb-4">
        <UiPagination v-model="currentPageSmall" :total-pages="totalPages" size="small" />
        <p class="is-size-7 mt-2">Small</p>
      </div>
      <div class="mb-4">
        <UiPagination v-model="currentPageMedium" :total-pages="totalPages" />
        <p class="is-size-7 mt-2">Medium (default)</p>
      </div>
      <div>
        <UiPagination v-model="currentPageLarge" :total-pages="totalPages" size="large" />
        <p class="is-size-7 mt-2">Large</p>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Pagination - Rounded</h3>
      <UiPagination v-model="currentPageRounded" :total-pages="totalPages" rounded />
    </div>

    <div class="box">
      <h3 class="title is-4">Stepper - Horizontal</h3>
      <UiStepper v-model="currentStep" :steps="stepperSteps" />
      <p class="mt-3">Current step: <strong>{{ currentStep }}</strong></p>
    </div>

    <div class="box">
      <h3 class="title is-4">Stepper - Clickable</h3>
      <UiStepper v-model="currentStepClickable" :steps="stepperSteps" clickable />
      <p class="mt-3">Selected step: <strong>{{ currentStepClickable }}</strong></p>
    </div>

    <div class="box">
      <h3 class="title is-4">Stepper - Vertical</h3>
      <UiStepper v-model="currentStepVertical" :steps="stepperStepsVertical" orientation="vertical" />
    </div>

    <div class="box">
      <h3 class="title is-4">Stepper - Sizes</h3>
      <div class="mb-4">
        <UiStepper v-model="currentStepSmall" :steps="stepperStepsSimple" size="small" />
        <p class="is-size-7 mt-2">Small</p>
      </div>
      <div class="mb-4">
        <UiStepper v-model="currentStepMedium" :steps="stepperStepsSimple" size="medium" />
        <p class="is-size-7 mt-2">Medium</p>
      </div>
      <div>
        <UiStepper v-model="currentStepLarge" :steps="stepperStepsSimple" size="large" />
        <p class="is-size-7 mt-2">Large</p>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Bottom Navigation</h3>
      <UiBottomNav>
        <a class="bottom-nav__item is-active">
          <i class="bi bi-house-door"></i>
          <span>Home</span>
        </a>
        <a class="bottom-nav__item">
          <i class="bi bi-search"></i>
          <span>Search</span>
        </a>
        <a class="bottom-nav__item">
          <i class="bi bi-bell"></i>
          <span>Notifications</span>
        </a>
        <a class="bottom-nav__item">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </UiBottomNav>
    </div>

    <div class="box">
      <h3 class="title is-4">Bottom Navigation - Labeled</h3>
      <UiBottomNav variant="labeled">
        <a class="bottom-nav__item">
          <i class="bi bi-house-door"></i>
          <span>Home</span>
        </a>
        <a class="bottom-nav__item is-active">
          <i class="bi bi-search"></i>
          <span>Search</span>
        </a>
        <a class="bottom-nav__item">
          <i class="bi bi-bell"></i>
          <span>Notifications</span>
        </a>
        <a class="bottom-nav__item">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </UiBottomNav>
    </div>

    <div class="box">
      <h3 class="title is-4">Navigation Rail</h3>
      <div class="columns">
        <div class="column is-2">
          <UiNavigationRail
            :items="railItems"
            :active-index="activeRailIndex"
            @click="onRailClick"
          />
        </div>
        <div class="column is-10">
          <p>Selected: <strong>{{ railItems[activeRailIndex]?.label }}</strong></p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Navigation Rail - Extended</h3>
      <div class="columns">
        <div class="column is-3">
          <UiNavigationRail
            :items="railItems"
            :active-index="activeRailIndexExtended"
            extended
            @click="onRailClickExtended"
          />
        </div>
        <div class="column is-9">
          <p>Selected: <strong>{{ railItems[activeRailIndexExtended]?.label }}</strong></p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Navigation List</h3>
      <div class="columns">
        <div class="column is-4">
          <UiNavigationList
            :items="navListItems"
            :active-index="activeNavListIndex"
            @click="onNavListClick"
          />
        </div>
        <div class="column is-8">
          <p>Selected: <strong>{{ navListItems[activeNavListIndex]?.label }}</strong></p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Navigation List - Horizontal</h3>
      <UiNavigationList
        :items="navListItems"
        :active-index="activeNavListHorizontalIndex"
        variant="horizontal"
        @click="onNavListHorizontalClick"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Navigation List - Pills</h3>
      <UiNavigationList
        :items="navListItems"
        :active-index="activeNavListPillsIndex"
        variant="pills"
        @click="onNavListPillsClick"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Navigation List - With Badges</h3>
      <UiNavigationList
        :items="navListItemsWithBadges"
        :active-index="activeNavListBadgesIndex"
        @click="onNavListBadgesClick"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiBreadcrumb from '@/Components/Ui/Breadcrumb.vue'
import UiTabs from '@/Components/Ui/UiTabs.vue'
import UiPagination from '@/Components/Ui/Pagination.vue'
import UiStepper from '@/Components/Ui/Stepper.vue'
import UiBottomNav from '@/Components/Ui/BottomNav.vue'
import UiNavigationRail from '@/Components/Ui/NavigationRail.vue'
import UiNavigationList from '@/Components/Ui/NavigationList.vue'

const breadcrumbItems = [
  { label: 'Home', href: '#' },
  { label: 'Products', href: '#' },
  { label: 'Category', href: '#' },
  { label: 'Current Page' }
]

const breadcrumbItemsWithIcons = [
  { label: 'Home', href: '#', icon: 'bi bi-house' },
  { label: 'Products', href: '#', icon: 'bi bi-box' },
  { label: 'Category', href: '#', icon: 'bi bi-folder' },
  { label: 'Current Page' }
]

const activeTab = ref('tab1')
const activeTabPill = ref('tab1')
const activeTabUnderline = ref('tab1')
const activeTabStretch = ref('overview')

const tabItems = [
  { label: 'Tab 1', value: 'tab1' },
  { label: 'Tab 2', value: 'tab2' },
  { label: 'Tab 3', value: 'tab3' },
  { label: 'Tab 4', value: 'tab4' }
]

const tabItemsStretch = [
  { label: 'Overview', value: 'overview' },
  { label: 'Details', value: 'details' },
  { label: 'Settings', value: 'settings' }
]

const currentPage = ref(3)
const currentPageSmall = ref(2)
const currentPageMedium = ref(3)
const currentPageLarge = ref(5)
const currentPageRounded = ref(4)
const totalPages = 10

const stepperSteps = [
  { label: 'Step 1', description: 'Personal Info' },
  { label: 'Step 2', description: 'Contact' },
  { label: 'Step 3', description: 'Payment' },
  { label: 'Step 4', description: 'Confirm' }
]

const stepperStepsVertical = [
  { label: 'Requirements', description: 'Define your needs' },
  { label: 'Design', description: 'Create mockups' },
  { label: 'Development', description: 'Build the app' },
  { label: 'Testing', description: 'Quality assurance' }
]

const stepperStepsSimple = [
  { label: 'Start', description: 'Begin' },
  { label: 'Continue', description: 'Proceed' },
  { label: 'Finish', description: 'Complete' }
]

const currentStep = ref(2)
const currentStepClickable = ref(1)
const currentStepVertical = ref(2)
const currentStepSmall = ref(2)
const currentStepMedium = ref(2)
const currentStepLarge = ref(2)

const railItems = [
  { label: 'Inbox', icon: 'bi bi-inbox' },
  { label: 'Starred', icon: 'bi bi-star' },
  { label: 'Sent', icon: 'bi bi-send' },
  { label: 'Drafts', icon: 'bi bi-file-earmark' },
  { label: 'Trash', icon: 'bi bi-trash' }
]

const activeRailIndex = ref(0)
const activeRailIndexExtended = ref(1)

const onRailClick = (item, index) => {
  activeRailIndex.value = index
}

const onRailClickExtended = (item, index) => {
  activeRailIndexExtended.value = index
}

const navListItems = [
  { label: 'Dashboard', icon: 'bi bi-speedometer2' },
  { label: 'Analytics', icon: 'bi bi-graph-up' },
  { label: 'Reports', icon: 'bi bi-file-earmark-bar-graph' },
  { label: 'Settings', icon: 'bi bi-gear' }
]

const navListItemsWithBadges = [
  { label: 'Inbox', icon: 'bi bi-envelope', badge: '12', badgeType: 'primary' },
  { label: 'Messages', icon: 'bi bi-chat-dots', badge: '3', badgeType: 'info' },
  { label: 'Warnings', icon: 'bi bi-exclamation-triangle', badge: '5', badgeType: 'danger' },
  { label: 'Completed', icon: 'bi bi-check-circle' }
]

const activeNavListIndex = ref(0)
const activeNavListHorizontalIndex = ref(1)
const activeNavListPillsIndex = ref(2)
const activeNavListBadgesIndex = ref(0)

const onNavListClick = (item, index) => {
  activeNavListIndex.value = index
}

const onNavListHorizontalClick = (item, index) => {
  activeNavListHorizontalIndex.value = index
}

const onNavListPillsClick = (item, index) => {
  activeNavListPillsIndex.value = index
}

const onNavListBadgesClick = (item, index) => {
  activeNavListBadgesIndex.value = index
}
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1.5rem;
}
</style>
