<template>
  <MemberLayout>
    <Head title="Perfil" />

    <PageHeader :title="'Perfil'" :breadcrumbs="breadcrumbs" backHref="/member" />

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-pencil-square me-1"></i>Editar perfil
          </h6>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <FieldText
                id="profile-name"
                label="Nombre"
                placeholder="Tu nombre"
                v-model="form.name"
                :formError="form.errors.name"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldSelect
                id="profile-country"
                label="Pais"
                v-model="form.country"
                :options="countryOptions"
                :formError="form.errors.country"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldText
                id="profile-phone"
                label="Telefono"
                placeholder="+52 555 000 0000"
                v-model="form.phone"
                :formError="form.errors.phone"
              />
            </div>

            <div class="col-12 col-md-6">
              <FieldWhatsapp
                id="profile-whatsapp"
                label="WhatsApp"
                placeholder="555 000 0000"
                v-model="form.whatsapp"
                :countryValue="form.whatsapp_country"
                :formError="form.errors.whatsapp"
                @update:countryValue="form.whatsapp_country = $event"
              />
            </div>

            <div class="col-12">
              <FieldEmail
                id="profile-personal-email"
                label="E-Mail personal"
                placeholder="tu@email.com"
                v-model="form.personal_email"
                :formError="form.errors.personal_email"
              />
            </div>

            <div class="col-12">
              <hr />
              <h6 class="mb-3">Foto de perfil</h6>
            </div>

            <div class="col-12">
              <div class="d-flex align-items-center gap-3">
                <div class="avatar-preview">
                  <img
                    v-if="avatarPreview || form.avatar"
                    :src="avatarPreview || `/storage/${form.avatar}`"
                    alt="Avatar"
                    class="rounded-circle"
                    style="width: 80px; height: 80px; object-fit: cover;"
                  />
                  <div v-else class="avatar-placeholder rounded-circle">
                    <i class="bi bi-person fs-4"></i>
                  </div>
                </div>
                <div>
                  <input
                    ref="avatarInput"
                    type="file"
                    accept="image/jpeg,image/png"
                    class="d-none"
                    @change="handleAvatarChange"
                  />
                  <button
                    type="button"
                    class="btn btn-secondary rounded-pill"
                    @click="$refs.avatarInput.click()"
                  >
                    <i class="bi bi-upload me-1"></i>
                    {{ form.avatar || avatarPreview ? 'Cambiar' : 'Subir' }}
                  </button>
                  <button
                    v-if="form.avatar || avatarPreview"
                    type="button"
                    class="btn btn-danger rounded-pill ms-2"
                    @click="removeAvatar"
                  >
                    <i class="bi bi-trash"></i>
                  </button>
                  <div v-if="form.errors.avatar" class="text-danger small mt-2">
                    {{ form.errors.avatar }}
                  </div>
                  <div class="text-muted small mt-2">
                    JPG o PNG, max 2MB
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
          <FormActions
            :submitText="'Guardar cambios'"
            :submittingText="'Guardando...'"
            :cancelHref="null"
            :sending="form.processing"
          />
        </div>
      </div>
    </form>
  </MemberLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldText from '@/Components/Fields/FieldText.vue'
import FieldEmail from '@/Components/Fields/FieldEmail.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldWhatsapp from '@/Components/Fields/FieldWhatsapp.vue'
import FormActions from '@/Components/FormActions.vue'

const props = defineProps({
  profile: {
    type: Object,
    required: true,
  },
})

const avatarPreview = ref(null)

const breadcrumbs = [
  { label: 'Perfil' },
]

const countryOptions = [
  { value: 'MX', label: 'Mexico' },
  { value: 'US', label: 'Estados Unidos' },
  { value: 'CA', label: 'Canada' },
  { value: 'CU', label: 'Cuba' },
  { value: 'AR', label: 'Argentina' },
  { value: 'BR', label: 'Brasil' },
  { value: 'CL', label: 'Chile' },
  { value: 'CO', label: 'Colombia' },
  { value: 'VE', label: 'Venezuela' },
  { value: 'BO', label: 'Bolivia' },
  { value: 'EC', label: 'Ecuador' },
  { value: 'PY', label: 'Paraguay' },
  { value: 'UY', label: 'Uruguay' },
  { value: 'PE', label: 'Peru' },
  { value: 'BZ', label: 'Belice' },
  { value: 'GT', label: 'Guatemala' },
  { value: 'SV', label: 'El Salvador' },
  { value: 'HN', label: 'Honduras' },
  { value: 'NI', label: 'Nicaragua' },
  { value: 'CR', label: 'Costa Rica' },
  { value: 'PA', label: 'Panama' },
  { value: 'HT', label: 'Haiti' },
  { value: 'PR', label: 'Puerto Rico' },
  { value: 'DO', label: 'Republica Dominicana' },
  { value: 'JM', label: 'Jamaica' },
  { value: 'TT', label: 'Trinidad y Tobago' },
  { value: 'BS', label: 'Bahamas' },
  { value: 'BB', label: 'Barbados' },
  { value: 'GY', label: 'Guyana' },
]

const form = useForm({
  name: props.profile.name || '',
  phone: props.profile.phone || '',
  whatsapp: props.profile.whatsapp || '',
  whatsapp_country: props.profile.whatsapp_country || '+52',
  personal_email: props.profile.personal_email || '',
  country: props.profile.country || 'MX',
  avatar: props.profile.avatar || '',
})

const handleAvatarChange = (e) => {
  const file = e.target.files[0]
  if (file) {
    form.avatar = file
    avatarPreview.value = URL.createObjectURL(file)
  }
}

const removeAvatar = () => {
  form.avatar = ''
  avatarPreview.value = null
}

const submit = () => {
  form.post('/profile', {
    preserveScroll: true,
  })
}
</script>

<style scoped>
.avatar-placeholder {
  width: 120px;
  height: 120px;
  background-color: #e9ecef;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #adb5bd;
  margin: 0 auto;
}
</style>
