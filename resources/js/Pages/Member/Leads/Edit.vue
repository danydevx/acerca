<template>
  <MemberLayout>
    <Head :title="`Editar Contacto - ${listing.name}`" />

    <PageHeader
      title="Editar Contacto"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing.id}/leads`"
    />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Editar contacto
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="lead-active" v-model="form.is_active">
            <label class="form-check-label" for="lead-active">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <FieldText
                id="name"
                label="Nombre"
                v-model="form.name"
                :formError="errors.name"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldEmail
                id="email"
                label="Email"
                v-model="form.email"
                :formError="errors.email"
                required
              />
            </div>

            <div class="col-md-6">
              <FieldPhone
                id="phone"
                label="Telefono"
                v-model="form.phone"
              />
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="business_location_id"
                label="Ubicacion"
                v-model="form.business_location_id"
              >
                <option :value="null">Sin ubicacion</option>
                <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}</option>
              </FieldSelect>
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="source"
                label="Fuente"
                v-model="form.source"
              >
                <option value="">Seleccionar...</option>
                <option value="manual">Manual</option>
                <option value="website">Website</option>
                <option value="phone">Telefono</option>
                <option value="walk_in">Visita directa</option>
                <option value="referral">Referido</option>
                <option value="social_media">Redes sociales</option>
                <option value="other">Otro</option>
              </FieldSelect>
            </div>

            <div class="col-md-6">
              <FieldSelect
                id="status"
                label="Estado"
                v-model="form.status"
                required
              >
                <option value="new">Nuevo</option>
                <option value="contacted">Contactado</option>
                <option value="qualified">Calificado</option>
                <option value="converted">Convertido</option>
                <option value="lost">Perdido</option>
              </FieldSelect>
            </div>

            <div class="col-12">
              <FieldTextarea
                id="notes"
                label="Notas"
                v-model="form.notes"
                :rows="3"
                placeholder="Notas adicionales..."
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3 d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-danger rounded-pill py-2" @click="deleteLead">
            <i class="bi bi-trash me-1"></i>Eliminar
          </button>
          <FormActions
            :submitText="'Guardar'"
            :submittingText="'Guardando...'"
            :cancelHref="`/member/listings/${listing.id}/leads`"
            :sending="sending"
          />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldPhone from '@/Components/Fields/FieldPhone.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FormActions from '@/Components/FormActions.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const lead = computed(() => page.props.lead)
const locations = computed(() => page.props.locations || [])
const errors = computed(() => page.props.errors || {})
const businessMenu = computed(() => page.props.businessMenu || [])

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Leads', href: `/member/listings/${listing.value.id}/leads` },
  { label: lead.value?.name || 'Editar' },
])

const sending = ref(false)

const form = reactive({
  name: lead.value.name,
  email: lead.value.email,
  phone: lead.value.phone || '',
  notes: lead.value.notes || '',
  business_location_id: lead.value.business_location_id,
  source: lead.value.source,
  status: lead.value.status,
  is_active: lead.value.is_active ?? true,
})

const submit = () => {
  sending.value = true
  router.put(`/member/listings/${listing.value.id}/leads/${lead.value.id}`, form, {
    preserveScroll: true,
    onFinish: () => {
      sending.value = false
    },
  })
}

const deleteLead = () => {
  if (!confirm(`Eliminar el lead "${lead.value?.name}"?`)) return
  router.delete(`/member/listings/${listing.value.id}/leads/${lead.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      window.location.href = `/member/listings/${listing.value.id}/leads`
    },
  })
}
</script>
