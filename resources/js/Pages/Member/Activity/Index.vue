<template>
  <MemberLayout>
    <Head title="Actividad" />

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h4 mb-1">Actividad</h1>
        <p class="text-muted mb-0">Historial de eventos de tu cuenta.</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <Link href="/member/account" class="btn btn-secondary rounded-pill">Ver cuenta</Link>
      </div>
    </div>

    <MemberTable
      :items="activities"
      :columns="columns"
      empty-title="No hay actividad registrada"
      empty-text=""
    >
      <template #cell-created_at="{ row }">
        <span class="text-muted">{{ row.created_at }}</span>
      </template>
      <template #cell-type="{ row }">
        <strong>{{ row.type }}</strong>
      </template>
      <template #cell-description="{ row }">
        <span class="text-muted">{{ row.description || '-' }}</span>
      </template>
      <template #cell-entity="{ row }">
        <span class="text-muted">
          <span v-if="row.subject_type">{{ row.subject_type }} #{{ row.subject_id }}</span>
          <span v-else>-</span>
        </span>
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  activities: {
    type: Object,
    required: true,
  },
})

const columns = [
  { key: 'created_at', label: 'Fecha', sortable: false },
  { key: 'type', label: 'Tipo', sortable: false },
  { key: 'description', label: 'Descripción', sortable: false },
  { key: 'entity', label: 'Entidad', sortable: false },
]
</script>
