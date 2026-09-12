<template>
  <div class="unlock-page d-flex align-items-center justify-content-center min-vh-100" :style="pageStyle">
    <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%;">
      <div class="card-body p-4 text-center">
        <div class="mb-4">
          <img
            v-if="vcard.profile_photo || vcard.logo"
            :src="vcard.profile_photo ? `/storage/${vcard.profile_photo}` : `/storage/${vcard.logo}`"
            :alt="vcard.name"
            class="rounded-circle mb-3"
            style="width: 80px; height: 80px; object-fit: cover;"
          />
          <div v-else class="mb-3">
            <i class="bi bi-person-circle" style="font-size: 4rem;" :style="{ color: vcard.primary_color || '#2563EB' }"></i>
          </div>
          <h4 class="fw-bold mb-1">{{ vcard.name }}</h4>
          <p class="text-muted small mb-0">Esta tarjeta está protegida</p>
        </div>

        <form @submit.prevent="submitUnlock">
          <div class="mb-3">
            <input
              v-model="password"
              type="password"
              class="form-control form-control-lg text-center"
              placeholder="Ingresa la contraseña"
              :class="{ 'is-invalid': errorMessage }"
              autocomplete="current-password"
            />
            <div v-if="errorMessage" class="invalid-feedback d-block">
              {{ errorMessage }}
            </div>
          </div>
          <button
            type="submit"
            class="btn btn-primary btn-lg w-100"
            :disabled="loading"
          >
            <span v-if="loading">
              <i class="bi bi-arrow-repeat spin me-1"></i>
              Verificando...
            </span>
            <span v-else>
              <i class="bi bi-unlock me-1"></i>
              Desbloquear
            </span>
          </button>
        </form>

        <p class="text-muted small mt-3 mb-0">
          Solicita la contraseña al propietario de esta tarjeta.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const props = defineProps({
  vcard: {
    type: Object,
    required: true,
  },
})

const page = usePage()
const password = ref('')
const loading = ref(false)
const errorMessage = ref(page.props.errors?.password || '')

const pageStyle = {
  backgroundColor: '#f8f9fa',
}

const submitUnlock = () => {
  if (!password.value) {
    errorMessage.value = 'Por favor ingresa la contraseña'
    return
  }

  loading.value = true
  errorMessage.value = ''

  router.post(`/v/${props.vcard.slug}/unlock`, {
    password: password.value,
  }, {
    preserveScroll: true,
    onFinish: () => {
      loading.value = false
    },
  })
}
</script>

<style scoped>
.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>
