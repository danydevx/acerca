<template>
  <div class="business-status">
    <AvailabilityStatus
      :is-open="isOpen"
      :opens-at="opensAt"
      :closes-at="closesAt"
      :show-time="showTime"
    />
    <div v-if="showSchedule" class="business-status__schedule">
      <button
        type="button"
        class="business-status__toggle"
        @click="toggleSchedule"
      >
        <span>{{ showFullSchedule ? 'Ocultar' : 'Ver' }} horario</span>
        <i :class="showFullSchedule ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"></i>
      </button>
      <div v-if="showFullSchedule" class="business-status__hours">
        <OpeningHours
          :schedule="schedule"
          :highlight-today="true"
          :compact="true"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import AvailabilityStatus from '@/Components/Ui/availability/AvailabilityStatus.vue'
import OpeningHours from '@/Components/Ui/availability/OpeningHours.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  opensAt: {
    type: String,
    default: '',
  },
  closesAt: {
    type: String,
    default: '',
  },
  schedule: {
    type: Object,
    default: () => ({}),
  },
  showTime: {
    type: Boolean,
    default: true,
  },
  showSchedule: {
    type: Boolean,
    default: true,
  },
})

const showFullSchedule = ref(false)

const toggleSchedule = () => {
  showFullSchedule.value = !showFullSchedule.value
}
</script>

<style lang="scss" scoped>
.business-status {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  &__schedule {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  &__toggle {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0;
    border: none;
    background: transparent;
    color: var(--bulma-link);
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;

    &:hover {
      text-decoration: underline;
    }

    i {
      font-size: 0.75rem;
    }
  }

  &__hours {
    padding: 0.75rem;
    background: var(--bulma-scheme-main-bis);
    border-radius: var(--bulma-radius);
  }
}
</style>
