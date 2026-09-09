<template>
  <section class="hero-overlay-variant">
    <div class="hero-overlay-variant__background">
      <img v-if="cover" :src="cover" :alt="name" class="hero-overlay-variant__image">
      <div v-else class="hero-overlay-variant__placeholder"></div>
      <HeroOverlay :variant="overlayVariant" />
    </div>
    <div class="hero-overlay-variant__content">
      <UiAvatar
        v-if="avatar"
        :src="avatar"
        :name="name"
        size="xl"
      />
      <HeroIdentity
        :name="name"
        :title="title"
        :company="company"
        size="lg"
      />
      <HeroBadges v-if="badges?.length" :badges="badges" />
      <div v-if="contacts?.length" class="hero-overlay-variant__contacts">
        <UiContactAction
          v-for="(contact, index) in contacts"
          :key="index"
          :type="contact.type"
          :value="contact.value"
          :label="contact.label"
        />
      </div>
      <HeroActions v-if="actions?.length" :actions="actions" />
    </div>
  </section>
</template>

<script setup>
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiContactAction from '@/Components/Ui/contact/ContactAction.vue'
import HeroOverlay from './structure/HeroOverlay.vue'
import HeroIdentity from './structure/HeroIdentity.vue'
import HeroBadges from './structure/HeroBadges.vue'
import HeroActions from './structure/HeroActions.vue'

defineProps({
  cover: String,
  avatar: String,
  name: String,
  title: String,
  company: String,
  badges: Array,
  contacts: Array,
  actions: Array,
  verified: Boolean,
  overlayVariant: {
    type: String,
    default: 'gradient-bottom',
    validator: (v) => ['dark', 'gradient-bottom', 'gradient-top', 'gradient-center', 'brand', 'soft'].includes(v),
  },
  avatarSize: {
    type: String,
    default: 'xl',
  },
})
</script>

<style lang="scss" scoped>
.hero-overlay-variant {
  position: relative;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  min-height: 17.5rem;
  display: flex;
  align-items: flex-end;

  &__background {
    position: absolute;
    inset: 0;
  }

  &__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--bulma-primary) 0%, var(--bulma-link) 100%);
  }

  &__content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1.5rem 1rem;
    width: 100%;
    color: var(--bulma-scheme-main);

    :deep(.hero-identity__name) {
      color: var(--bulma-scheme-main);
    }

    :deep(.hero-identity__title),
    :deep(.hero-identity__company) {
      color: var(--bulma-scheme-main);
      opacity: 0.9;
    }

    :deep(.hero-badge--default) {
      background: oklch(100% 0 0 / 0.2);
      color: var(--bulma-scheme-main);
    }
  }

  &__contacts {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
}
</style>
