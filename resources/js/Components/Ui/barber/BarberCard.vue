<template>
  <article
    class="barber-card"
    :class="{ 'barber-card--available': available }"
    role="button"
    tabindex="0"
    @click="available && $emit('select', barber)"
    @keydown.enter="available && $emit('select', barber)"
    @keydown.space.prevent="available && $emit('select', barber)"
  >
    <div class="barber-card__avatar">
      <img v-if="barber.avatar" :src="barber.avatar" :alt="barber.name">
      <div v-else class="barber-card__placeholder">
        <i class="bi bi-person"></i>
      </div>
      <span v-if="available" class="barber-card__status barber-card__status--available"></span>
      <span v-else class="barber-card__status barber-card__status--busy"></span>
    </div>

    <div class="barber-card__content">
      <h4 class="barber-card__name">{{ barber.name }}</h4>
      <p v-if="barber.specialty" class="barber-card__specialty">{{ barber.specialty }}</p>
      <div class="barber-card__rating">
        <i class="bi bi-star-fill"></i>
        <span>{{ barber.rating || '5.0' }}</span>
        <span class="barber-card__reviews">({{ barber.reviews || 0 }})</span>
      </div>
    </div>

    <button
      v-if="available"
      class="barber-card__book"
      type="button"
      @click.stop="$emit('book', barber)"
    >
      Reservar
    </button>
    <span v-else class="barber-card__unavailable">Ocupado</span>
  </article>
</template>

<script setup>
defineProps({
  barber: {
    type: Object,
    required: true,
    default: () => ({ name: '', avatar: '', specialty: '', rating: null, reviews: null }),
  },
  available: {
    type: Boolean,
    default: true,
  },
})

defineEmits(['select', 'book'])
</script>

<style lang="scss" scoped>
.barber-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 1rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);
  gap: 0.75rem;
  transition: all 0.2s;

  &:hover:not(&--available) {
    cursor: not-allowed;
  }

  &--available:hover {
    border-color: var(--bulma-link);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px oklch(0 0 0 / 0.1);
  }

  &__avatar {
    position: relative;
    width: 4.5rem;
    height: 4.5rem;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    i {
      font-size: 2rem;
      color: var(--bulma-text-weak);
    }
  }

  &__status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 0.875rem;
    height: 0.875rem;
    border-radius: 50%;
    border: 2px solid var(--bulma-scheme-main);

    &--available {
      background: var(--bulma-success);
    }

    &--busy {
      background: var(--bulma-grey);
    }
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__specialty {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__rating {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    font-size: 0.8125rem;
    color: var(--bulma-text);

    i {
      color: var(--bulma-warning);
      font-size: 0.75rem;
    }
  }

  &__reviews {
    color: var(--bulma-text-weak);
  }

  &__book {
    padding: 0.5rem 1.25rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border: none;
    border-radius: var(--bulma-radius);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;

    &:hover {
      background: var(--bulma-link-hover);
      transform: scale(1.05);
    }
  }

  &__unavailable {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    font-style: italic;
  }
}
</style>
