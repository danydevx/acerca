<template>
  <div class="contact-card" :class="[`contact-card--${variant}`]">
    <div v-if="title || eyebrow" class="contact-card__header">
      <div v-if="eyebrow" class="contact-card__eyebrow">{{ eyebrow }}</div>
      <h3 v-if="title" class="contact-card__title">{{ title }}</h3>
      <p v-if="subtitle" class="contact-card__subtitle">{{ subtitle }}</p>
    </div>

    <div class="contact-card__body">
      <div v-if="$slots.icon || icon" class="contact-card__icon">
        <slot name="icon">
          <i :class="icon"></i>
        </slot>
      </div>

      <ContactDetails
        :address="address"
        :phone="phone"
        :email="email"
        :website="website"
        :hours="hours"
      />
    </div>

    <div v-if="status || $slots.actions || actions.length" class="contact-card__footer">
      <ContactStatus
        v-if="status"
        :status="status"
        :type="statusType"
      />
      <div class="contact-card__actions">
        <slot name="actions">
          <button v-if="showDirections" class="button is-small is-outlined" @click="$emit('directions')">
            <i class="bi bi-directions mr-1"></i> Cómo llegar
          </button>
          <button v-if="showContact" class="button is-small is-primary" @click="$emit('contact')">
            <i class="bi bi-chat mr-1"></i> Contactar
          </button>
          <button v-if="showVisit" class="button is-small is-outlined" @click="$emit('visit')">
            <i class="bi bi-globe mr-1"></i> Visitar sitio
          </button>
        </slot>
      </div>
    </div>

    <div v-if="$slots.map" class="contact-card__map">
      <slot name="map"></slot>
    </div>
  </div>
</template>

<script setup>
import ContactDetails from './structure/ContactDetails.vue'
import ContactStatus from './structure/ContactStatus.vue'

defineProps({
  variant: { type: String, default: 'default' },
  eyebrow: { type: String, default: '' },
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  icon: { type: String, default: '' },
  address: { type: String, default: '' },
  phone: { type: String, default: '' },
  email: { type: String, default: '' },
  website: { type: String, default: '' },
  hours: { type: String, default: '' },
  status: { type: String, default: '' },
  statusType: { type: String, default: 'success', validator: (v) => ['success', 'warning', 'danger', 'info'].includes(v) },
  showDirections: { type: Boolean, default: false },
  showContact: { type: Boolean, default: false },
  showVisit: { type: Boolean, default: false },
  actions: { type: Array, default: () => [] },
})

defineEmits(['directions', 'contact', 'visit'])
</script>

<style lang="scss" scoped>
.contact-card {
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &__header {
    padding: 1rem;
    border-bottom: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main-bis);
  }

  &__eyebrow {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__subtitle {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0.25rem 0 0;
  }

  &__body {
    display: flex;
    gap: 1rem;
    padding: 1rem;
  }

  &__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    flex-shrink: 0;

    i {
      font-size: 1.5rem;
    }
  }

  &__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    border-top: 1px solid var(--bulma-border);
    background: var(--bulma-scheme-main-bis);
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
  }

  &__map {
    border-top: 1px solid var(--bulma-border);
  }
}
</style>
