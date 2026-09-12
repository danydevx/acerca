<template>
  <MemberLayout>
    <Head title="Invitados" />

    <PageHeader
      title="Invitados"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/modules`"
    >
      <template #actions>
        <Link :href="`/member/listings/${listing?.id}/checkin`" class="btn btn-secondary rounded-pill">
          <i class="bi bi-qr-code-scan me-1"></i>Check-in
        </Link>
      </template>
    </PageHeader>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-body-bg">
        <h5 class="mb-0">Agregar invitado</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitGuest" class="row g-3">
          <div class="col-md-4">
            <input
              v-model="guestForm.name"
              type="text"
              class="form-control"
              placeholder="Nombre completo"
              required
            />
          </div>
          <div class="col-md-3">
            <input
              v-model="guestForm.email"
              type="email"
              class="form-control"
              placeholder="Correo electrónico"
            />
          </div>
          <div class="col-md-3">
            <input
              v-model="guestForm.phone"
              type="text"
              class="form-control"
              placeholder="Teléfono"
            />
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary rounded-pill w-100" :disabled="sending">
              <i class="bi bi-plus-lg me-1"></i>Agregar
            </button>
          </div>
        </form>
      </div>
    </div>

    <MemberTable
      :items="guests"
      :columns="columns"
      :get-row-actions="getRowActions"
      empty-title="No hay invitados registrados"
      empty-text="Agrega invitados para que puedan registrar su llegada."
    >
      <template #cell-name="{ row }">
        <strong>{{ row.name }}</strong>
      </template>
      <template #cell-email="{ row }">
        {{ row.email || '-' }}
      </template>
      <template #cell-phone="{ row }">
        {{ row.phone || '-' }}
      </template>
      <template #cell-plus_ones="{ row }">
        {{ row.plus_ones ?? 0 }}
      </template>
      <template #cell-notes="{ row }">
        {{ row.notes || '-' }}
      </template>
    </MemberTable>
  </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import MemberTable from '@/Components/Member/MemberTable.vue'

const props = defineProps({
  listing: Object,
  guests: Object,
})

const page = usePage()
const listing = computed(() => page.props.listing)
const sending = ref(false)

const guestForm = reactive({
  name: '',
  email: '',
  phone: '',
  plus_ones: 0,
  notes: '',
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Invitados', active: true },
])

const columns = [
  { key: 'name', label: 'Nombre', sortable: false },
  { key: 'email', label: 'Correo', sortable: false },
  { key: 'phone', label: 'Teléfono', sortable: false },
  { key: 'plus_ones', label: 'Plus Ones', sortable: false },
  { key: 'notes', label: 'Notas', sortable: false },
  { key: 'actions', label: '', sortable: false },
]

const getRowActions = (guest) => {
  return [
    { label: 'Eliminar', icon: 'bi bi-trash', danger: true, onClick: () => deleteGuest(guest) },
  ]
}

const submitGuest = () => {
  if (!guestForm.name) return
  sending.value = true
  router.post(`/member/listings/${listing.value.id}/guests`, guestForm, {
    preserveScroll: true,
    onFinish: () => {
      sending.value = false
      guestForm.name = ''
      guestForm.email = ''
      guestForm.phone = ''
      guestForm.plus_ones = 0
      guestForm.notes = ''
    },
  })
}

const deleteGuest = (guest) => {
  if (confirm(`¿Eliminar a ${guest.name}?`)) {
    router.delete(`/member/listings/${listing.value.id}/guests/${guest.id}`, {
      preserveScroll: true,
    })
  }
}
</script>
