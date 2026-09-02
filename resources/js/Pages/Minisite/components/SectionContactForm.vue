<template>
  <section class="section-contact">
    <div class="section-contact__inner">
      <h2 v-if="title" class="section-contact__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-contact__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-contact__description-text">{{ description }}</p>

      <div v-if="!form" class="orp-text-muted orp-text-center orp-p-4">
        Formulario no disponible.
      </div>

      <form v-else @submit.prevent="submitForm" class="section-contact__form">
        <div v-for="field in form.fields" :key="field.name" class="section-contact__field">
          <label :for="field.name" class="section-contact__label">
            {{ field.label }}
            <span v-if="field.required" class="section-contact__required">*</span>
          </label>

          <input
            v-if="field.type === 'text' || field.type === 'email' || field.type === 'tel'"
            :id="field.name"
            :type="field.type"
            :name="field.name"
            :placeholder="field.placeholder"
            :required="field.required"
            class="orp-input"
            v-model="formData[field.name]"
          />

          <textarea
            v-else-if="field.type === 'textarea'"
            :id="field.name"
            :name="field.name"
            :placeholder="field.placeholder"
            :required="field.required"
            class="orp-textarea"
            rows="3"
            v-model="formData[field.name]"
          ></textarea>

          <select
            v-else-if="field.type === 'select'"
            :id="field.name"
            :name="field.name"
            :required="field.required"
            class="orp-select"
            v-model="formData[field.name]"
          >
            <option value="">{{ field.placeholder || 'Selecciona...' }}</option>
            <option v-for="opt in field.options" :key="opt" :value="opt">{{ opt }}</option>
          </select>
        </div>

        <button type="submit" class="orp-btn orp-btn--primary orp-btn--block" :disabled="sending">
          {{ sending ? 'Enviando...' : 'Enviar' }}
        </button>

        <div v-if="successMessage" class="section-contact__success orp-alert orp-alert--success">
          {{ successMessage }}
        </div>
      </form>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'

const props = defineProps({
  title: String,
  subtitle: String,
  form: Object,
  config: Object,
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
})

const sending = ref(false)
const successMessage = ref('')
const formData = reactive({})

const submitForm = async () => {
  if (!props.form) return

  sending.value = true
  successMessage.value = ''

  try {
    // TODO: implement form submission
    await new Promise(resolve => setTimeout(resolve, 1000))
    successMessage.value = 'Mensaje enviado correctamente.'
    Object.keys(formData).forEach(key => formData[key] = '')
  } catch (error) {
    console.error('Form submission error:', error)
  } finally {
    sending.value = false
  }
}
</script>

<style lang="less">
.section-contact {
  padding: var(--orp-space-6) var(--orp-space-2);
  background: var(--orp-background);

  &__inner {
    max-width: 1024px;
    margin: 0 auto;
  }

  &__title {
    font-weight: 700;
    margin: 0 0 var(--orp-space-1);
    text-align: center;
    color: var(--orp-foreground);
  }

  &__subtitle {
    font-weight: 600;
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__description-text {
    font-size: var(--orp-font-size-md);
    color: var(--orp-muted-foreground);
    text-align: center;
    margin: 0 0 var(--orp-space-3);
  }

  &__form {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-3);
  }

  &__field {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-1);
  }

  &__label {
    font-size: var(--orp-font-size-sm);
    font-weight: 500;
    color: var(--orp-foreground);
  }

  &__required {
    color: var(--orp-danger);
  }

  &__success {
    margin-top: var(--orp-space-3);
  }
}
</style>
