<template>
  <MemberLayout>
    <Head title="Nuevo ticket" />

    <PageHeader title="Nuevo ticket" :breadcrumbs="breadcrumbs" backHref="/member/support" />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-plus-circle me-1"></i>Crear ticket
          </h6>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12">
              <FieldText
                id="ticket-subject"
                label="Asunto"
                v-model="form.subject"
                :formError="form.errors.subject"
                required
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="ticket-department"
                label="Categoria"
                v-model="form.department_id"
                :options="departmentOptions"
                :formError="form.errors.department_id"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="ticket-priority"
                label="Prioridad"
                v-model="form.priority"
                :options="priorityOptions"
                :formError="form.errors.priority"
              />
            </div>

            <div class="col-12">
              <FieldTextarea
                id="ticket-message"
                label="Mensaje"
                v-model="form.message"
                :formError="form.errors.message"
                required
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
            <FormActions
              :submitText="'Crear ticket'"
              :submittingText="'Enviando...'"
              :cancelHref="'/member/support'"
              :sending="form.processing"
            />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldTextarea from '@/Components/Fields/FieldTextarea.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FormActions from '@/Components/FormActions.vue'

const form = useForm({
  subject: '',
  department_id: '',
  priority: '',
  message: '',
})

const props = defineProps({
  departments: {
    type: Array,
    default: () => [],
  },
})

const breadcrumbs = [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Soporte', href: '/member/support' },
  { label: 'Nuevo' },
]

const departmentOptions = [
  { value: '', label: 'Sin categoria' },
  ...props.departments,
]

const priorityOptions = [
  { value: '', label: 'Sin prioridad' },
  { value: 'low', label: 'low' },
  { value: 'medium', label: 'medium' },
  { value: 'high', label: 'high' },
]

const submit = () => {
  form.post('/member/support')
}
</script>
