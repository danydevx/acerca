<template>
  <div class="forgot-page">
    <Head title="Recuperar acceso - Acerca.site">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    </Head>

    <div class="forgot-container">
      <div class="forgot-brand">
        <div class="brand-content">
          <div class="brand-logo">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="48" rx="12" fill="url(#gradient)"/>
              <path d="M14 34V14h8c5.523 0 10 4.477 10 10s-4.477 10-10 10h-8z" fill="white" fill-opacity="0.9"/>
              <path d="M24 18h10v16H24V18z" fill="white"/>
              <defs>
                <linearGradient id="gradient" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#2B6EEB"/>
                  <stop offset="1" stop-color="#3AA7F4"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <h1 class="brand-name">Acerca.site</h1>
          <p class="brand-headline">Recupera tu acceso en minutos</p>
          <p class="brand-tagline">Te enviamos un enlace seguro para que vuelvas a tu tarjeta digital y a tu panel sin perder nada.</p>

          <div class="brand-features">
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
              <div>
                <strong>Enlace seguro</strong>
                <p>Cifrado y de un solo uso para proteger tu cuenta.</p>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-clock-history"></i>
              </div>
              <div>
                <strong>Vigencia limitada</strong>
                <p>Caduca en pocos minutos para evitar usos indebidos.</p>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-life-preserver"></i>
              </div>
              <div>
                <strong>Soporte inmediato</strong>
                <p>Si no llega, te ayudamos a entrar otra vez.</p>
              </div>
            </div>
          </div>

          <div class="brand-footer">
            <p>acerca.site — Tarjetas digitales para compartir mejor, conectar mas rapido y mantener su informacion siempre actualizada.</p>
          </div>
        </div>
      </div>

      <div class="forgot-form-container">
        <div class="forgot-form-wrapper">
          <div class="form-header">
            <div class="form-icon">
              <i class="bi bi-envelope-paper"></i>
            </div>
            <h2>Recuperar acceso</h2>
            <p>Te enviaremos un enlace para restablecer tu contrasena.</p>
          </div>

          <div v-if="flashSuccess" class="alert alert-success">
            {{ flashSuccess }}
          </div>

          <div v-if="flashError" class="alert alert-danger">
            {{ flashError }}
          </div>

          <div v-if="submitted" class="alert alert-info">
            Si la direccion existe en nuestros registros, recibiras un correo con instrucciones en los proximos minutos.
          </div>

          <form v-if="!submitted" @submit.prevent="submit">
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

            <button type="submit" class="btn-submit" :disabled="form.processing">
              <span v-if="form.processing">
                <i class="bi bi-arrow-repeat spin"></i>
                Enviando...
              </span>
              <span v-else>
                Enviar enlace de recuperacion
                <i class="bi bi-arrow-right"></i>
              </span>
            </button>
          </form>

          <div v-else class="resend-block">
            <button type="button" class="btn-submit btn-submit-secondary" @click="resetFlow">
              <i class="bi bi-arrow-counterclockwise me-2"></i>
              Usar otro correo
            </button>
          </div>

          <div class="form-footer">
            <p><Link href="/login" class="back-link"><i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesion</Link></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
  email: '',
})

const submitted = ref(false)

const submit = () => {
  form.post('/forgot-password', {
    preserveScroll: true,
    onSuccess: () => {
      submitted.value = true
      form.reset('email')
    },
  })
}

const resetFlow = () => {
  submitted.value = false
}

const flashSuccess = computed(() => page.props.flash?.success)
const flashError = computed(() => page.props.flash?.error)
</script>

<style scoped>
.forgot-page {
  min-height: 100vh;
  background: #F8FBFF;
  font-family: 'Manrope', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.forgot-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
}

.forgot-brand {
  background: linear-gradient(135deg, #2B6EEB 0%, #3AA7F4 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem;
  position: relative;
  overflow: hidden;
}

.forgot-brand::before {
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

.forgot-form-container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

.forgot-form-wrapper {
  width: 100%;
  max-width: 400px;
}

.form-header {
  margin-bottom: 2rem;
  text-align: center;
}

.form-icon {
  width: 64px;
  height: 64px;
  margin: 0 auto 1rem;
  background: rgba(43, 110, 235, 0.1);
  color: #2B6EEB;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.75rem;
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
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
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

.btn-submit-secondary {
  background: transparent;
  color: #2B6EEB;
  border: 1px solid #2B6EEB;
}

.btn-submit-secondary:hover:not(:disabled) {
  background: rgba(43, 110, 235, 0.08);
  box-shadow: none;
  transform: none;
}

.resend-block {
  margin-top: 0.5rem;
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

.back-link {
  color: #2B6EEB;
  text-decoration: none;
  font-weight: 500;
}

.back-link:hover {
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

.alert-info {
  background: #E0F2FE;
  color: #075985;
  border: 1px solid #BAE6FD;
}

@media (max-width: 1024px) {
  .forgot-container {
    grid-template-columns: 1fr;
  }

  .forgot-brand {
    display: none;
  }

  .forgot-form-container {
    min-height: 100vh;
  }
}
</style>