<template>
  <div class="contact-details">
    <div v-if="address" class="contact-details__item">
      <i class="bi bi-geo-alt"></i>
      <span>{{ address }}</span>
    </div>
    <div v-if="phone" class="contact-details__item">
      <i class="bi bi-telephone"></i>
      <a :href="`tel:${phone}`">{{ phone }}</a>
    </div>
    <div v-if="email" class="contact-details__item">
      <i class="bi bi-envelope"></i>
      <a :href="`mailto:${email}`">{{ email }}</a>
    </div>
    <div v-if="website" class="contact-details__item">
      <i class="bi bi-globe"></i>
      <a :href="website" target="_blank">{{ website }}</a>
    </div>
    <div v-if="hours" class="contact-details__item">
      <i class="bi bi-clock"></i>
      <span>{{ hours }}</span>
    </div>
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  address: { type: String, default: '' },
  phone: { type: String, default: '' },
  email: { type: String, default: '' },
  website: { type: String, default: '' },
  hours: { type: String, default: '' },
})
</script>

<style lang="scss" scoped>
.contact-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.contact-details__item {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--bulma-text);

  i {
    color: var(--bulma-text-weak);
    margin-top: 0.125rem;
    flex-shrink: 0;
  }

  a {
    color: var(--bulma-link);
    text-decoration: none;

    &:hover {
      text-decoration: underline;
    }
  }
}
</style>
