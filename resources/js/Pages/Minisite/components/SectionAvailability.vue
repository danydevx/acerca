<template>
  <section class="section-availability">
    <div class="section-availability__inner">
      <h2 v-if="title" class="section-availability__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-availability__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-availability__description-text">{{ description }}</p>

      <AvailabilityCalendar
        v-if="schedule && schedule.length"
        :schedule="schedule"
        :exceptions="exceptions || []"
        :appointment-counts="{}"
      />

      <div v-else class="section-availability__empty orp-text-muted orp-text-center">
        <i class="bi bi-info-circle"></i>
        Horarios de atención no disponibles.
      </div>
    </div>
  </section>
</template>

<script setup>
import AvailabilityCalendar from '@/Components/Availability/AvailabilityCalendar.vue'

const props = defineProps({
  title: {
    type: String,
    default: 'Horario de Atención',
  },
  subtitle: String,
  availability: {
    type: Object,
    required: true,
  },
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
})

const schedule = props.availability?.schedule || []
const exceptions = props.availability?.exceptions || []
</script>

<style lang="less" scoped>
.section-availability {
  padding: var(--orp-space-6) 0;
  background: var(--orp-surface-muted);

  &__inner {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 var(--orp-space-4);
  }

  &__title {
    text-align: center;
    margin-bottom: var(--orp-space-1);
    font-weight: 700;
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

  &__empty {
    padding: var(--orp-space-4);
  }
}
</style>
