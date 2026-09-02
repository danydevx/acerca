<template>
  <section class="section-locations">
    <div class="section-locations__inner">
      <h2 v-if="title" class="section-locations__title">{{ title }}</h2>
      <h3 v-if="subtitle" class="section-locations__subtitle">{{ subtitle }}</h3>
      <p v-if="description" class="section-locations__description-text">{{ description }}</p>

      <div v-if="items.length === 0" class="orp-text-muted orp-text-center orp-p-4">
        No hay ubicaciones disponibles.
      </div>

      <div v-else class="section-locations__list">
        <div
          v-for="item in items"
          :key="item.id"
          class="section-locations__item orp-card"
        >
          <div class="section-locations__main">
            <div class="section-locations__icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="section-locations__content">
              <h3 class="section-locations__name">{{ item.name }}</h3>
              <p v-if="showAddress && item.full_address" class="section-locations__address">
                {{ item.full_address }}
              </p>
              <div class="section-locations__contact">
                <a v-if="showPhone && item.phone" :href="'tel:' + item.phone" class="section-locations__contact-item">
                  <i class="bi bi-telephone"></i> {{ item.phone }}
                </a>
                <a v-if="showEmail && item.email" :href="'mailto:' + item.email" class="section-locations__contact-item">
                  <i class="bi bi-envelope"></i> {{ item.email }}
                </a>
                <a v-if="item.directions_url" :href="item.directions_url" target="_blank" class="section-locations__contact-item">
                  <i class="bi bi-signpost"></i> Cómo llegar
                </a>
                <a v-if="!item.directions_url && (item.latitude && item.longitude)" :href="`https://www.google.com/maps/search/?api=1&query=${item.latitude},${item.longitude}`" target="_blank" class="section-locations__contact-item">
                  <i class="bi bi-signpost"></i> Cómo llegar
                </a>
              </div>
              <div v-if="showHours && item.schedules && item.schedules.length" class="section-locations__schedules">
                <div v-for="schedule in item.schedules" :key="schedule.id" class="section-locations__schedule">
                  <strong>{{ schedule.name }}:</strong> {{ schedule.days_display }} {{ schedule.time_display }}
                </div>
              </div>
            </div>
          </div>
          <LocationMap
            v-if="item.latitude && item.longitude"
            :lat="item.latitude"
            :lng="item.longitude"
            :address="item.full_address"
          />
        </div>
      </div>

      <div v-if="buttons && buttons.length" class="section-locations__buttons">
        <a
          v-for="(btn, index) in buttons"
          :key="index"
          :href="btn.url"
          class="orp-btn"
          :class="'orp-btn--' + (btn.style || 'primary')"
        >
          {{ btn.text }}
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import LocationMap from '@/Components/Minisite/LocationMap.vue'

const props = defineProps({
  title: String,
  subtitle: String,
  items: {
    type: Array,
    default: () => [],
  },
  config: {
    type: Object,
    default: () => ({}),
  },
  description: String,
  buttons: {
    type: Array,
    default: () => [],
  },
})

const showAddress = computed(() => props.config?.show_address !== false)
const showPhone = computed(() => props.config?.show_phone !== false)
const showEmail = computed(() => props.config?.show_email !== false)
const showHours = computed(() => props.config?.show_hours !== false)
</script>

<script>
import { defineComponent } from 'vue'
export default defineComponent({ name: 'SectionLocations' })
</script>

<style lang="less">
.section-locations {
  padding: var(--orp-space-6) var(--orp-space-2);

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

  &__list {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-3);
  }

  &__item {
    padding: var(--orp-space-4);
  }

  &__main {
    display: flex;
    gap: var(--orp-space-3);
  }

  &__icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: color-mix(in srgb, var(--orp-primary) 15%, transparent);
    border-radius: 50%;
    color: var(--orp-primary);
    font-size: 1.25rem;
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__name {
    font-size: var(--orp-font-size-lg);
    font-weight: 600;
    margin: 0 0 var(--orp-space-2);
    color: var(--orp-surface-foreground);
  }

  &__address {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin: 0 0 var(--orp-space-3);
  }

  &__contact {
    display: flex;
    flex-direction: column;
    gap: var(--orp-space-1);
  }

  &__contact-item {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-primary);
    text-decoration: none;

    &:hover {
      text-decoration: underline;
    }

    i {
      margin-right: var(--orp-space-2);
    }
  }

  &__schedules {
    margin-top: var(--orp-space-3);
    padding-top: var(--orp-space-3);
    border-top: 1px solid var(--orp-border);
  }

  &__schedule {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-muted-foreground);
    margin-bottom: var(--orp-space-1);

    &:last-child {
      margin-bottom: 0;
    }
  }

  &__buttons {
    display: flex;
    justify-content: center;
    gap: var(--orp-space-2);
    margin-top: var(--orp-space-4);
  }
}
</style>
