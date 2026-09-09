<template>
  <div class="profile-card" :class="[`profile-card--${variant}`, { 'profile-card--horizontal': horizontal }]">
    <ProfileAvatar
      :src="src"
      :name="name"
      :initials="initials"
      :status="status"
      class="profile-card__avatar"
    />
    <div class="profile-card__content">
      <div v-if="eyebrow" class="profile-card__eyebrow">{{ eyebrow }}</div>
      <h3 class="profile-card__name">{{ name }}</h3>
      <p v-if="role" class="profile-card__role">{{ role }}</p>
      <p v-if="location" class="profile-card__location">
        <i class="bi bi-geo-alt"></i> {{ location }}
      </p>
      <div v-if="$slots.meta || meta.length" class="profile-card__meta">
        <slot name="meta">
          <span v-for="(item, i) in meta" :key="i" class="profile-card__meta-item">
            {{ item }}{{ i < meta.length - 1 ? ' · ' : '' }}
          </span>
        </slot>
      </div>
      <div v-if="$slots.actions || actions.length" class="profile-card__actions">
        <slot name="actions">
          <button v-for="(action, i) in actions" :key="i" class="button is-small" :class="action.class">{{ action.label }}</button>
        </slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import ProfileAvatar from './structure/ProfileAvatar.vue'

defineProps({
  variant: { type: String, default: 'default' },
  src: { type: String, default: '' },
  name: { type: String, required: true },
  role: { type: String, default: '' },
  eyebrow: { type: String, default: '' },
  location: { type: String, default: '' },
  meta: { type: Array, default: () => [] },
  status: { type: String, default: '' },
  initials: { type: String, default: '' },
  horizontal: { type: Boolean, default: false },
  actions: { type: Array, default: () => [] },
})
</script>

<style lang="scss" scoped>
.profile-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 1.5rem 1rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);

  &--horizontal {
    flex-direction: row;
    text-align: left;
    gap: 1rem;
    padding: 1rem;

    .profile-card__avatar {
      margin: 0;
    }
  }

  &__avatar {
    margin-bottom: 1rem;
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__eyebrow {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bulma-text-weak);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
  }

  &__name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__role {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0 0 0.5rem;
  }

  &__location {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0;

    i {
      margin-right: 0.25rem;
    }
  }

  &__meta {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin-top: 0.5rem;

    &-item {
      display: inline;
    }
  }

  &__actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-top: 1rem;
    flex-wrap: wrap;
  }

  &--horizontal &__actions {
    justify-content: flex-start;
  }
}
</style>
