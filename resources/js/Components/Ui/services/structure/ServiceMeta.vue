<template>
  <div class="service-meta">
    <div v-if="durationMinutes" class="service-meta__item">
      <i class="bi bi-clock"></i>
      <span>{{ durationMinutes }} min</span>
    </div>
    <div v-if="depositRequired" class="service-meta__item service-meta__item--warning">
      <i class="bi bi-currency-dollar"></i>
      <span v-if="depositAmount">{{ formattedDepositAmount }} anticipo</span>
      <span v-else>Anticipo</span>
    </div>
    <div v-if="allowsOnlineBooking" class="service-meta__item service-meta__item--success">
      <i class="bi bi-check-circle-fill"></i>
      <span>Reserva online</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  durationMinutes: {
    type: Number,
    default: null,
  },
  depositRequired: {
    type: Boolean,
    default: false,
  },
  depositAmount: {
    type: [String, Number],
    default: null,
  },
  allowsOnlineBooking: {
    type: Boolean,
    default: false,
  },
})

const formatCurrency = (value) => {
  if (value === null || value === undefined) return ''
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
    minimumFractionDigits: 0,
    maximumFractionDigits: 2,
  }).format(value)
}

const formattedDepositAmount = computed(() => formatCurrency(props.depositAmount))
</script>

<style lang="scss" scoped>
.service-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  padding: 1rem 0;
  border-top: 1px solid var(--bulma-border);
  border-bottom: 1px solid var(--bulma-border);
}

.service-meta__item {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  font-size: 0.875rem;
  color: var(--bulma-text);

  i {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
  }

  &--warning {
    color: var(--bulma-warning);

    i {
      color: var(--bulma-warning);
    }
  }

  &--success {
    color: var(--bulma-success);

    i {
      color: var(--bulma-success);
    }
  }
}
</style>
