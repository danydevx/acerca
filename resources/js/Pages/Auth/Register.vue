<template>
  <div class="register-page">
    <Head title="Crear cuenta - Acerca.site">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    </Head>

    <div class="register-container">
      <div class="register-brand">
        <div class="brand-content">
          <div class="brand-logo">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="48" rx="12" fill="url(#gradient2)"/>
              <path d="M14 34V14h8c5.523 0 10 4.477 10 10s-4.477 10-10 10h-8z" fill="white" fill-opacity="0.9"/>
              <path d="M24 18h10v16H24V18z" fill="white"/>
              <defs>
                <linearGradient id="gradient2" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#2B6EEB"/>
                  <stop offset="1" stop-color="#3AA7F4"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <h1 class="brand-name">Acerca.site</h1>
          <p class="brand-headline">Tarjeta digital con IA para presentar todo acerca de usted</p>
          <p class="brand-tagline">Tu tarjeta de presentacion, ahora inteligente. Toda su informacion, redes, servicios y formas de contacto en un solo lugar.</p>

          <div class="brand-features">
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-x-circle"></i>
              </div>
              <div>
                <strong>Sin apps</strong>
                <p>No descargar ni actualizar nada. Su tarjeta vive en un link.</p>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-qr-code"></i>
              </div>
              <div>
                <strong>Comparte por link o QR</strong>
                <p>Lista para reuniones, eventos, ventas y networking.</p>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-arrow-repeat"></i>
              </div>
              <div>
                <strong>Siempre actualizada</strong>
                <p>Cambie una vez. Todos ven la version nueva.</p>
              </div>
            </div>
          </div>

          <div class="brand-footer">
            <p>acerca.site — Tarjetas digitales para compartir mejor, conectar mas rapido y mantener su informacion siempre actualizada.</p>
          </div>
        </div>
      </div>

      <div class="register-form-container">
        <div class="register-form-wrapper">
          <div class="form-header">
            <h2>Crea tu cuenta</h2>
            <p>Tu tarjeta digital lista en menos de 5 minutos.</p>
          </div>

          <div v-if="flashSuccess" class="alert alert-success">
            {{ flashSuccess }}
          </div>

          <div v-if="registerError" class="alert alert-danger">
            {{ registerError }}
          </div>

          <form @submit.prevent="submit">
            <div class="form-group">
              <label>Nombre completo</label>
              <div class="input-wrapper">
                <i class="bi bi-person"></i>
                <input
                  v-model="form.name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.name }"
                  placeholder="Tu nombre"
                  autocomplete="name"
                  required
                />
              </div>
              <div v-if="form.errors.name" class="error-text">
                {{ form.errors.name }}
              </div>
            </div>

            <div class="form-group">
              <label>Correo electronico</label>
              <div class="input-wrapper">
                <i class="bi bi-envelope"></i>
                <input
                  v-model="form.email"
                  type="email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.email }"
                  placeholder="tu@email.com"
                  autocomplete="email"
                  required
                />
              </div>
              <div v-if="form.errors.email" class="error-text">
                {{ form.errors.email }}
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Contrasena</label>
                <div class="input-wrapper">
                  <i class="bi bi-lock"></i>
                  <input
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password }"
                    placeholder="Minimo 8 caracteres"
                    autocomplete="new-password"
                    required
                  />
                </div>
                <div v-if="form.errors.password" class="error-text">
                  {{ form.errors.password }}
                </div>
              </div>

              <div class="form-group">
                <label>Confirmar contrasena</label>
                <div class="input-wrapper">
                  <i class="bi bi-lock-fill"></i>
                  <input
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.password_confirmation }"
                    placeholder="Repite tu contrasena"
                    autocomplete="new-password"
                    required
                  />
                </div>
                <div v-if="form.errors.password_confirmation" class="error-text">
                  {{ form.errors.password_confirmation }}
                </div>
              </div>
            </div>

            <div class="terms-text">
              Al crear tu cuenta aceptas nuestros <a href="/terminos" target="_blank" rel="noopener">Terminos de servicio</a> y <a href="/privacidad" target="_blank" rel="noopener">Politica de privacidad</a>.
            </div>

            <button type="submit" class="btn-submit" :disabled="form.processing">
              <span v-if="form.processing">
                <i class="bi bi-arrow-repeat spin"></i>
                Creando cuenta...
              </span>
              <span v-else>
                Crear cuenta
                <i class="bi bi-arrow-right"></i>
              </span>
            </button>
          </form>

          <div class="form-footer">
            <p>Ya tienes cuenta? <Link href="/login">Inicia sesion aqui</Link></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  invite: '',
  company: '',
  form_started_at: 0,
})

const prefill = computed(() => page.props.prefill || {})
const registerError = computed(() => form.errors.register || page.props.flash?.error)
const flashSuccess = computed(() => page.props.flash?.success)

onMounted(() => {
  form.form_started_at = Math.floor(Date.now() / 1000)
  if (prefill.value.email) {
    form.email = prefill.value.email
  }
  if (prefill.value.invite) {
    form.invite = prefill.value.invite
  }
})

const submit = () => {
  form.post('/register', {
    preserveScroll: true,
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<style scoped>
.register-page {
  min-height: 100vh;
  background: #F8FBFF;
  font-family: 'Manrope', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.register-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
}

.register-brand {
  background: linear-gradient(135deg, #2B6EEB 0%, #3AA7F4 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem;
  position: relative;
  overflow: hidden;
}

.register-brand::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
  animation: pulse 15s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 0.3; }
}

.brand-content {
  position: relative;
  z-index: 1;
  max-width: 400px;
}

.brand-logo {
  margin-bottom: 1.5rem;
}

.brand-name {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
}

.brand-headline {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  opacity: 0.95;
}

.brand-tagline {
  font-size: 1rem;
  opacity: 0.85;
  margin-bottom: 2.5rem;
  line-height: 1.6;
}

.brand-features {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.feature-item {
  display: flex;
  gap: 1rem;
  align-items: flex-start;
}

.feature-icon {
  width: 40px;
  height: 40px;
  background: rgba(255,255,255,0.2);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  flex-shrink: 0;
}

.feature-item strong {
  display: block;
  margin-bottom: 0.25rem;
}

.feature-item p {
  margin: 0;
  opacity: 0.8;
  font-size: 0.875rem;
}

.brand-footer {
  margin-top: 3rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(255,255,255,0.2);
}

.brand-footer p {
  margin: 0;
  opacity: 0.7;
  font-size: 0.875rem;
}

.register-form-container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  overflow-y: auto;
}

.register-form-wrapper {
  width: 100%;
  max-width: 450px;
  padding: 2rem 0;
}

.form-header {
  margin-bottom: 2rem;
  text-align: center;
}

.form-header h2 {
  font-size: 1.75rem;
  font-weight: 700;
  color: #1E293B;
  margin-bottom: 0.5rem;
}

.form-header p {
  color: #64748B;
  margin: 0;
}

.form-group {
  margin-bottom: 1.25rem;
}

.form-group label {
  display: block;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.input-wrapper {
  position: relative;
}

.input-wrapper i {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #94A3B8;
  font-size: 1.125rem;
}

.input-wrapper .form-control {
  padding: 0.875rem 1rem 0.875rem 3rem;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.2s;
}

.input-wrapper .form-control:focus {
  border-color: #2B6EEB;
  box-shadow: 0 0 0 3px rgba(43, 110, 235, 0.1);
  outline: none;
}

.input-wrapper .form-control.is-invalid {
  border-color: #EF4444;
}

.error-text {
  color: #EF4444;
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

.terms-text {
  font-size: 0.8rem;
  color: #64748B;
  text-align: center;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

.terms-text a {
  color: #2B6EEB;
  text-decoration: none;
}

.terms-text a:hover {
  text-decoration: underline;
}

.btn-submit {
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #2B6EEB 0%, #3AA7F4 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(43, 110, 235, 0.35);
}

.btn-submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.form-footer {
  margin-top: 2rem;
  text-align: center;
  color: #64748B;
  font-size: 0.875rem;
}

.form-footer a {
  color: #2B6EEB;
  text-decoration: none;
  font-weight: 500;
}

.form-footer a:hover {
  text-decoration: underline;
}

.alert {
  padding: 1rem;
  border-radius: 12px;
  margin-bottom: 1.5rem;
  font-size: 0.875rem;
}

.alert-success {
  background: #D1FAE5;
  color: #065F46;
  border: 1px solid #A7F3D0;
}

.alert-danger {
  background: #FEE2E2;
  color: #991B1B;
  border: 1px solid #FECACA;
}

@media (max-width: 1024px) {
  .register-container {
    grid-template-columns: 1fr;
  }

  .register-brand {
    display: none;
  }

  .register-form-container {
    min-height: 100vh;
  }

  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>
