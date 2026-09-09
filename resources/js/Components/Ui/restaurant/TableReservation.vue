<template>
  <div class="table-reservation">
    <header class="table-reservation__header">
      <h3 class="table-reservation__title">{{ title }}</h3>
      <p v-if="subtitle" class="table-reservation__subtitle">{{ subtitle }}</p>
    </header>

    <form class="table-reservation__form" @submit.prevent="handleSubmit">
      <div class="table-reservation__field">
        <label for="reservation-name" class="table-reservation__label">Nombre</label>
        <input
          id="reservation-name"
          v-model="form.name"
          type="text"
          class="table-reservation__input"
          placeholder="Tu nombre"
          required
        >
      </div>

      <div class="table-reservation__field">
        <label for="reservation-phone" class="table-reservation__label">Teléfono</label>
        <input
          id="reservation-phone"
          v-model="form.phone"
          type="tel"
          class="table-reservation__input"
          placeholder="+52 123 456 7890"
          required
        >
      </div>

      <div class="table-reservation__row">
        <div class="table-reservation__field">
          <label for="reservation-date" class="table-reservation__label">Fecha</label>
          <input
            id="reservation-date"
            v-model="form.date"
            type="date"
            class="table-reservation__input"
            :min="minDate"
            required
          >
        </div>

        <div class="table-reservation__field">
          <label for="reservation-time" class="table-reservation__label">Hora</label>
          <select
            id="reservation-time"
            v-model="form.time"
            class="table-reservation__input"
            required
          >
            <option value="" disabled>Selecciona</option>
            <option v-for="slot in timeSlots" :key="slot" :value="slot">
              {{ slot }}
            </option>
          </select>
        </div>
      </div>

      <div class="table-reservation__field">
        <label for="reservation-guests" class="table-reservation__label">Comensales</label>
        <select
          id="reservation-guests"
          v-model="form.guests"
          class="table-reservation__input"
          required
        >
          <option value="" disabled>Selecciona</option>
          <option v-for="n in maxGuests" :key="n" :value="n">
            {{ n }} {{ n === 1 ? 'persona' : 'personas' }}
          </option>
        </select>
      </div>

      <div v-if="showNotes" class="table-reservation__field">
        <label for="reservation-notes" class="table-reservation__label">Notas (opcional)</label>
        <textarea
          id="reservation-notes"
          v-model="form.notes"
          class="table-reservation__input table-reservation__input--textarea"
          placeholder="Alergias, ocasión especial, etc."
          rows="3"
        ></textarea>
      </div>

      <button type="submit" class="table-reservation__submit" :disabled="loading">
        <span v-if="loading">
          <i class="bi bi-hourglass-split"></i> Procesando...
        </span>
        <span v-else>
          <i class="bi bi-calendar-check"></i> Reservar mesa
        </span>
      </button>
    </form>

    <div v-if="success" class="table-reservation__success">
      <i class="bi bi-check-circle-fill"></i>
      <p>{{ successMessage }}</p>
    </div>

    <div v-if="error" class="table-reservation__error">
      <i class="bi bi-exclamation-triangle-fill"></i>
      <p>{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: 'Reservar mesa',
  },
  subtitle: {
    type: String,
    default: '',
  },
  timeSlots: {
    type: Array,
    default: () => [
      '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
      '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00',
    ],
  },
  maxGuests: {
    type: Number,
    default: 12,
  },
  showNotes: {
    type: Boolean,
    default: true,
  },
  successMessage: {
    type: String,
    default: '¡Reserva confirmada! Te enviamos un mensaje de confirmación.',
  },
})

const emit = defineEmits(['submit'])

const form = ref({
  name: '',
  phone: '',
  date: '',
  time: '',
  guests: '',
  notes: '',
})

const loading = ref(false)
const success = ref(false)
const error = ref('')

const minDate = computed(() => {
  const today = new Date()
  return today.toISOString().split('T')[0]
})

const handleSubmit = async () => {
  loading.value = true
  error.value = ''

  try {
    emit('submit', { ...form.value })

    await new Promise(resolve => setTimeout(resolve, 1000))

    success.value = true
    form.value = {
      name: '',
      phone: '',
      date: '',
      time: '',
      guests: '',
      notes: '',
    }

    setTimeout(() => {
      success.value = false
    }, 5000)
  } catch (e) {
    error.value = 'Hubo un error. Por favor intenta de nuevo.'
  } finally {
    loading.value = false
  }
}
</script>

<style lang="scss" scoped>
.table-reservation {
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  padding: 1.5rem;

  &__header {
    margin-bottom: 1.5rem;
    text-align: center;
  }

  &__title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__subtitle {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  &__row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  &__field {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  &__label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--bulma-text);
  }

  &__input {
    padding: 0.625rem 0.875rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main);
    color: var(--bulma-text);
    font-size: 0.9375rem;
    transition: border-color 0.2s, box-shadow 0.2s;

    &:focus {
      outline: none;
      border-color: var(--bulma-link);
      box-shadow: 0 0 0 3px color-mix(in oklch, var(--bulma-link) 20%, transparent);
    }

    &::placeholder {
      color: var(--bulma-text-weak);
    }

    &--textarea {
      resize: vertical;
      min-height: 80px;
    }
  }

  &__submit {
    margin-top: 0.5rem;
    padding: 0.875rem 1.5rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.15s;

    &:hover:not(:disabled) {
      background: var(--bulma-link-hover);
      transform: translateY(-1px);
    }

    &:active:not(:disabled) {
      transform: translateY(0);
    }

    &:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }
  }

  &__success {
    margin-top: 1rem;
    padding: 1rem;
    background: oklch(60% 0.2 145);
    color: oklch(20% 0.2 145);
    border-radius: var(--bulma-radius);
    display: flex;
    align-items: center;
    gap: 0.75rem;

    i {
      font-size: 1.5rem;
    }

    p {
      margin: 0;
      font-size: 0.9375rem;
      font-weight: 500;
    }
  }

  &__error {
    margin-top: 1rem;
    padding: 1rem;
    background: oklch(65% 0.2 25);
    color: oklch(20% 0.2 25);
    border-radius: var(--bulma-radius);
    display: flex;
    align-items: center;
    gap: 0.75rem;

    i {
      font-size: 1.5rem;
    }

    p {
      margin: 0;
      font-size: 0.9375rem;
      font-weight: 500;
    }
  }
}
</style>
