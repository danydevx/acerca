<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Modal</h3>
      <div class="buttons">
        <button class="button is-primary" @click="showModal = true">Open Modal</button>
        <button class="button is-info" @click="showModalInfo = true">Info Modal</button>
        <button class="button is-success" @click="showModalSuccess = true">Success Modal</button>
        <button class="button is-danger" @click="showModalDanger = true">Danger Modal</button>
      </div>

      <UiModal v-model="showModal" title="Basic Modal">
        <p>This is a modal dialog. You can close it by clicking the X button, the backdrop, or the Cancel button.</p>
        <p class="mt-3">Modals are great for:</p>
        <ul>
          <li>Confirming actions</li>
          <li>Showing important information</li>
          <li>Form inputs</li>
        </ul>
        <template #footer>
          <button class="button" @click="showModal = false">Cancel</button>
          <button class="button is-primary" @click="showModal = false">Confirm</button>
        </template>
      </UiModal>

      <UiModal v-model="showModalInfo" title="Information" size="sm">
        <p>Here is some important information for you.</p>
      </UiModal>

      <UiModal v-model="showModalSuccess" title="Success!" size="sm">
        <div class="has-text-centered">
          <i class="bi bi-check-circle has-text-success" style="font-size: 3rem;"></i>
          <p class="mt-3">Your changes have been saved successfully!</p>
        </div>
      </UiModal>

      <UiModal v-model="showModalDanger" title="Confirm Deletion" size="sm">
        <div class="has-text-centered">
          <i class="bi bi-exclamation-triangle has-text-danger" style="font-size: 3rem;"></i>
          <p class="mt-3">Are you sure you want to delete this item? This action cannot be undone.</p>
        </div>
        <template #footer>
          <button class="button" @click="showModalDanger = false">Cancel</button>
          <button class="button is-danger" @click="showModalDanger = false">Delete</button>
        </template>
      </UiModal>
    </div>

    <div class="box">
      <h3 class="title is-4">Drawer</h3>
      <div class="buttons">
        <button class="button is-primary" @click="showDrawerLeft = true">Left Drawer</button>
        <button class="button is-info" @click="showDrawerRight = true">Right Drawer</button>
      </div>

      <UiDrawer v-model="showDrawerLeft" title="Left Drawer" placement="left">
        <div class="drawer-content">
          <aside class="menu">
            <p class="menu-label">General</p>
            <ul class="menu-list">
              <li><a class="is-active">Dashboard</a></li>
              <li><a>Customers</a></li>
              <li><a>Orders</a></li>
              <li><a>Products</a></li>
            </ul>
            <p class="menu-label">Settings</p>
            <ul class="menu-list">
              <li><a>Profile</a></li>
              <li><a>Preferences</a></li>
              <li><a>Security</a></li>
            </ul>
          </aside>
        </div>
      </UiDrawer>

      <UiDrawer v-model="showDrawerRight" title="Right Drawer" placement="right">
        <div class="drawer-content">
          <p class="mb-4">This drawer slides in from the right side.</p>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" placeholder="Your name">
            </div>
          </div>
          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input class="input" type="email" placeholder="your@email.com">
            </div>
          </div>
          <div class="field mt-4">
            <button class="button is-primary is-fullwidth">Submit</button>
          </div>
        </div>
      </UiDrawer>
    </div>

    <div class="box">
      <h3 class="title is-4">Sheet</h3>
      <div class="buttons">
        <button class="button is-primary" @click="showSheet = true">Open Sheet</button>
        <button class="button is-info" @click="showSheetHalf = true">Half Height</button>
      </div>

      <UiSheet v-model="showSheet" title="Action Sheet">
        <div class="sheet-options">
          <a class="sheet-option">
            <span class="icon"><i class="bi bi-share"></i></span>
            <span>Share</span>
          </a>
          <a class="sheet-option">
            <span class="icon"><i class="bi bi-link"></i></span>
            <span>Copy Link</span>
          </a>
          <a class="sheet-option">
            <span class="icon"><i class="bi bi-pencil"></i></span>
            <span>Edit</span>
          </a>
          <a class="sheet-option is-danger">
            <span class="icon"><i class="bi bi-trash"></i></span>
            <span>Delete</span>
          </a>
        </div>
      </UiSheet>

      <UiSheet v-model="showSheetHalf" title="Half Height Sheet" height="half">
        <p>This sheet only covers half of the screen.</p>
        <p>Great for quick actions without fully covering the content.</p>
      </UiSheet>
    </div>

    <div class="box">
      <h3 class="title is-4">Dropdown</h3>
      <div class="columns">
        <div class="column is-3">
          <UiDropdown v-model="showDropdown1">
            <template #trigger>
              <button class="button is-primary">
                <span>Click to open</span>
                <span class="icon is-small"><i class="bi bi-chevron-down"></i></span>
              </button>
            </template>
            <a class="dropdown-item">Option 1</a>
            <a class="dropdown-item">Option 2</a>
            <a class="dropdown-item">Option 3</a>
            <hr class="dropdown-divider">
            <a class="dropdown-item">Other option</a>
          </UiDropdown>
        </div>
        <div class="column is-3">
          <UiDropdown v-model="showDropdown2">
            <template #trigger>
              <button class="button is-info">
                <span class="icon"><i class="bi bi-gear"></i></span>
                <span>Settings</span>
              </button>
            </template>
            <a class="dropdown-item">
              <span class="icon"><i class="bi bi-person"></i></span>
              <span>Profile</span>
            </a>
            <a class="dropdown-item">
              <span class="icon"><i class="bi bi-bell"></i></span>
              <span>Notifications</span>
            </a>
            <hr class="dropdown-divider">
            <a class="dropdown-item">
              <span class="icon"><i class="bi bi-box-arrow-right"></i></span>
              <span>Logout</span>
            </a>
          </UiDropdown>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Popover</h3>
      <div class="columns">
        <div class="column is-3">
          <UiPopover v-model="showPopover1" placement="top">
            <template #trigger>
              <button class="button">Popover Top</button>
            </template>
            <p>This popover appears at the top!</p>
          </UiPopover>
        </div>
        <div class="column is-3">
          <UiPopover v-model="showPopover2" placement="bottom">
            <template #trigger>
              <button class="button">Popover Bottom</button>
            </template>
            <p>This popover appears at the bottom!</p>
          </UiPopover>
        </div>
        <div class="column is-3">
          <UiPopover v-model="showPopover3" placement="left">
            <template #trigger>
              <button class="button">Popover Left</button>
            </template>
            <p>This popover appears on the left!</p>
          </UiPopover>
        </div>
        <div class="column is-3">
          <UiPopover v-model="showPopover4" placement="right">
            <template #trigger>
              <button class="button">Popover Right</button>
            </template>
            <p>This popover appears on the right!</p>
          </UiPopover>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Accordion</h3>
      <UiAccordion :items="accordionItems" />
    </div>

    <div class="box">
      <h3 class="title is-4">ActionSheet</h3>
      <div class="buttons">
        <button class="button is-primary" @click="showActionSheet = true">Open ActionSheet</button>
      </div>

      <UiActionSheet v-model="showActionSheet" title="Actions">
        <a class="action-sheet-item">
          <span class="icon"><i class="bi bi-edit"></i></span>
          <span>Edit</span>
        </a>
        <a class="action-sheet-item">
          <span class="icon"><i class="bi bi-share"></i></span>
          <span>Share</span>
        </a>
        <a class="action-sheet-item">
          <span class="icon"><i class="bi bi-link"></i></span>
          <span>Copy Link</span>
        </a>
        <a class="action-sheet-item">
          <span class="icon"><i class="bi bi-download"></i></span>
          <span>Download</span>
        </a>
        <hr>
        <a class="action-sheet-item is-danger" @click="showActionSheet = false">
          <span class="icon"><i class="bi bi-trash"></i></span>
          <span>Delete</span>
        </a>
      </UiActionSheet>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiModal from '@/Components/Ui/Modal.vue'
import UiDrawer from '@/Components/Ui/Drawer.vue'
import UiSheet from '@/Components/Ui/UiSheet.vue'
import UiDropdown from '@/Components/Ui/Dropdown.vue'
import UiPopover from '@/Components/Ui/Popover.vue'
import UiAccordion from '@/Components/Ui/Accordion.vue'
import UiActionSheet from '@/Components/Ui/ActionSheet.vue'

const showModal = ref(false)
const showModalInfo = ref(false)
const showModalSuccess = ref(false)
const showModalDanger = ref(false)
const showDrawerLeft = ref(false)
const showDrawerRight = ref(false)
const showSheet = ref(false)
const showSheetHalf = ref(false)
const showDropdown1 = ref(false)
const showDropdown2 = ref(false)
const showPopover1 = ref(false)
const showPopover2 = ref(false)
const showPopover3 = ref(false)
const showPopover4 = ref(false)
const showActionSheet = ref(false)

const accordionItems = ref([
  {
    value: 'intro',
    title: 'Introduction',
    content: 'Welcome to our component library! This accordion demonstrates the component features.'
  },
  {
    value: 'features',
    title: 'Features',
    content: '<ul><li>Modals with different sizes</li><li>Drawers from left/right</li><li>Sheets from bottom</li><li>Dropdowns and Popovers</li><li>Accordions</li></ul>'
  },
  {
    value: 'usage',
    title: 'Usage',
    content: 'Simply import the component and use v-model to control visibility. All components support slots for custom content.'
  },
  {
    value: 'api',
    title: 'API Reference',
    content: '<p><strong>Props:</strong> modelValue, title, size, placement, etc.</p><p><strong>Events:</strong> update:modelValue, close, open</p><p><strong>Slots:</strong> default, trigger, footer</p>'
  }
])
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mt-3 {
  margin-top: 1rem;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.drawer-content {
  padding: 1rem;
}

.sheet-options {
  .sheet-option {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1rem;
    color: var(--bulma-text);
    cursor: pointer;
    transition: background 0.2s;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    &.is-danger {
      color: var(--bulma-danger);
    }

    .icon {
      font-size: 1.25rem;
    }
  }
}

.action-sheet-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 0.75rem 1rem;
  color: var(--bulma-text);
  cursor: pointer;
  transition: background 0.2s;

  &:hover {
    background: var(--bulma-scheme-main-bis);
  }

  &.is-danger {
    color: var(--bulma-danger);
  }

  .icon {
    font-size: 1.25rem;
  }
}
</style>
