<template>
  <section class="hero-minimal" :class="{ 'hero-minimal--centered': centered }">
    <UiAvatar
      v-if="avatar"
      :src="avatar"
      :name="name"
      size="lg"
    />
    <div class="hero-minimal__content">
      <HeroIdentity
        :name="name"
        :title="title"
        :company="company"
        :size="nameSize"
        :centered="centered"
      />
      <HeroDescription v-if="description" :text="description" :centered="centered" />
      <HeroActions v-if="actions?.length" :actions="actions" :alignment="centered ? 'center' : 'left'" />
      <UiSocialLinks v-if="socials?.length" :items="socials" />
    </div>
  </section>
</template>

<script setup>
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiSocialLinks from '@/Components/Ui/social/SocialLinks.vue'
import HeroIdentity from './structure/HeroIdentity.vue'
import HeroDescription from './structure/HeroDescription.vue'
import HeroActions from './structure/HeroActions.vue'

defineProps({
  avatar: String,
  name: String,
  title: String,
  company: String,
  description: String,
  badges: Array,
  actions: Array,
  socials: Array,
  verified: Boolean,
  centered: Boolean,
  avatarSize: {
    type: String,
    default: 'lg',
  },
  nameSize: {
    type: String,
    default: 'md',
  },
})
</script>

<style lang="scss" scoped>
.hero-minimal {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.5rem;
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius-large);
  box-shadow: 0 4px 12px oklch(0 0 0 / 0.08);

  &--centered {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }
}
</style>
