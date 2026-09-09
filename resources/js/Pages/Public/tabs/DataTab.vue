<script setup>
import { ref } from 'vue'
import UiTable from '@/Components/Ui/Table.vue'
import UiPanelFilter from '@/Components/Ui/PanelFilter.vue'
import UiPanelTabs from '@/Components/Ui/PanelTabs.vue'
import UiPanelBlock from '@/Components/Ui/PanelBlock.vue'

const tableColumns = [
    { key: 'name', label: 'Name' },
    { key: 'email', label: 'Email' },
    { key: 'role', label: 'Role' },
    { key: 'status', label: 'Status' },
]

const tableData = [
    { id: 1, name: 'John Doe', email: 'john@example.com', role: 'Admin', status: 'Active' },
    { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'Member', status: 'Active' },
    { id: 3, name: 'Bob Wilson', email: 'bob@example.com', role: 'Member', status: 'Inactive' },
    { id: 4, name: 'Alice Brown', email: 'alice@example.com', role: 'Guest', status: 'Active' },
]

const filterItems = [
    { id: 1, label: 'Dashboard', meta: '5 new notifications', filter: 'main' },
    { id: 2, label: 'Profile', meta: 'Update your info', filter: 'main' },
    { id: 3, label: 'Settings', meta: 'Preferences', filter: 'config' },
    { id: 4, label: 'Security', meta: 'Password & auth', filter: 'config' },
    { id: 5, label: 'Billing', meta: 'Plans & payments', filter: 'finance' },
]

const filterOptions = [
    { label: 'All', value: '' },
    { label: 'Main', value: 'main' },
    { label: 'Config', value: 'config' },
    { label: 'Finance', value: 'finance' },
]

const tabs = [
    { label: 'Overview', value: 'overview' },
    { label: 'Activity', value: 'activity' },
    { label: 'Settings', value: 'settings' },
]

const activeTab = ref('overview')
</script>

<template>
    <div class="playground-section">
        <div class="box">
            <h4 class="title is-5">Table</h4>
            <UiTable
                :data="tableData"
                :columns="tableColumns"
                :sortable="true"
                :sortable-columns="['name', 'email']"
                :searchable="true"
                search-placeholder="Search users..."
                striped
                hoverable
            />
        </div>

        <div class="box">
            <h4 class="title is-5">Panel Filter</h4>
            <UiPanelFilter
                title="Navigation"
                :items="filterItems"
                label-key="label"
                meta-key="meta"
                track-by="id"
                item-icon="bi bi-house"
                :filter-options="filterOptions"
                :searchable="true"
                :show-checkbox="true"
                :show-select-all="true"
            />
        </div>

        <div class="box">
            <h4 class="title is-5">Panel Tabs</h4>
            <UiPanelTabs
                title="Account"
                :tabs="tabs"
                v-model="activeTab"
                :searchable="true"
                search-placeholder="Search..."
            >
                <template #default="{ activeTab: currentTab, searchQuery }">
                    <div class="panel-block">
                        <p v-if="currentTab === 'overview'" class="is-medium">
                            Overview content - showing dashboard summary and recent activity.
                        </p>
                        <p v-else-if="currentTab === 'activity'" class="is-medium">
                            Activity content - showing user actions and events log.
                        </p>
                        <p v-else-if="currentTab === 'settings'" class="is-medium">
                            Settings content - configuration options and preferences.
                        </p>
                    </div>
                </template>
            </UiPanelTabs>
        </div>

        <div class="box">
            <h4 class="title is-5">Panel Block</h4>
            <UiPanelBlock
                label="General Settings"
                icon="bi bi-gear"
                badge="New"
                badge-type="success"
                :default-open="true"
            >
                <p class="is-small has-text-grey">
                    This is the expanded content for general settings. You can put any content here.
                </p>
            </UiPanelBlock>
            <UiPanelBlock
                label="Privacy & Security"
                icon="bi bi-shield-lock"
                badge="2"
                badge-type="info"
            >
                <p class="is-small has-text-grey">
                    Privacy and security settings content goes here.
                </p>
            </UiPanelBlock>
            <UiPanelBlock
                label="Notifications"
                icon="bi bi-bell"
                badge="5"
                badge-type="warning"
            >
                <p class="is-small has-text-grey">
                    Notification preferences and settings.
                </p>
            </UiPanelBlock>
            <UiPanelBlock
                label="Danger Zone"
                icon="bi bi-exclamation-triangle"
                badge-type="danger"
            >
                <p class="is-small has-text-grey">
                    Critical actions and dangerous operations.
                </p>
            </UiPanelBlock>
        </div>
    </div>
</template>
