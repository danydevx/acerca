<template>
  <section class="hero-floating">
    <HeroCoverMedia :src="cover" height="medium" />
    <div class="hero-floating__card">
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
        :size="nameSize"
      />
      <HeroBadges v-if="badges?.length" :badges="badges" />
      <HeroDescription v-if="description" :text="description" />
      <HeroActions v-if="actions?.length" :actions="actions" />
      <UiSocialLinks v-if="socials?.length" :items="socials" />
    </div>
  </section>
</template>

<script setup>
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiSocialLinks from '@/Components/Ui/social/SocialLinks.vue'
import HeroCoverMedia from './structure/HeroCoverMedia.vue'
import HeroIdentity from './structure/HeroIdentity.vue'
import HeroBadges from './structure/HeroBadges.vue'
import HeroDescription from './structure/HeroDescription.vue'
import HeroActions from './structure/HeroActions.vue'

defineProps({
  cover: String,
  avatar: String,
  name: String,
  title: String,
  company: String,
  description: String,
  badges: Array,
  actions: Array,
  socials: Array,
  verified: Boolean,
  avatarSize: {
    type: String,
    default: 'xl',
  },
  nameSize: {
    type: String,
    default: 'lg',
  },
})
</script>

<style lang="scss" scoped>
.hero-floating {
  position: relative;
  border-radius: var(--bulma-radius-large);
  overflow: visible;

  &__card {
    position: relative;
    margin: -3rem auto 0;
    max-width: 320px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.5rem 1.25rem 2rem;
    background: var(--bulma-scheme-main);
    border-radius: var(--bulma-radius-large);
    box-shadow: 0 8px 32px oklch(0 0 0 / 0.12);
    gap: 0.75rem;
    z-index: 1;
  }
}
</style>
