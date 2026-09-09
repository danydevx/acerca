<template>
  <section class="hero-centered">
    <div v-if="cover" class="hero-centered__cover">
      <img :src="cover" :alt="name" class="hero-centered__cover-image">
      <HeroOverlay variant="gradient-bottom" />
    </div>
    <div class="hero-centered__body" :class="{ 'hero-centered__body--with-cover': !!cover }">
      <UiAvatar
        v-if="avatar"
        :src="avatar"
        :name="name"
        size="2xl"
      />
      <HeroLogo v-if="logo" :src="logo" :name="name" />
      <HeroIdentity
        :name="name"
        :title="title"
        :company="company"
        size="lg"
        :centered="true"
      />
      <HeroBadges v-if="badges?.length" :badges="badges" alignment="center" />
      <HeroDescription v-if="description" :text="description" :centered="true" />
      <UiSocialLinks
        v-if="socials?.length"
        :items="socials"
        :variant="socialsVariant"
        :color-scheme="socialsColorScheme"
        :layout="socialsLayout"
        :icon-only="socialsIconOnly"
        :text-only="socialsTextOnly"
      />
      <HeroActions v-if="actions?.length" :actions="actions" alignment="center" />
    </div>
  </section>
</template>

<script setup>
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiSocialLinks from '@/Components/Ui/social/SocialLinks.vue'
import HeroOverlay from './structure/HeroOverlay.vue'
import HeroIdentity from './structure/HeroIdentity.vue'
import HeroBadges from './structure/HeroBadges.vue'
import HeroDescription from './structure/HeroDescription.vue'
import HeroActions from './structure/HeroActions.vue'
import HeroLogo from './structure/HeroLogo.vue'

defineProps({
  cover: String,
  avatar: String,
  logo: String,
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
    default: '2xl',
  },
  socialsVariant: {
    type: String,
    default: 'rounded',
    validator: (v) => ['default', 'filled', 'outlined', 'rounded', 'pill', 'soft', 'gradient'].includes(v),
  },
  socialsColorScheme: {
    type: String,
    default: 'auto',
    validator: (v) => ['auto', 'brand', 'whatsapp', 'facebook', 'instagram', 'linkedin', 'youtube', 'twitter'].includes(v),
  },
  socialsLayout: {
    type: String,
    default: 'start',
    validator: (v) => ['start', 'end'].includes(v),
  },
  socialsIconOnly: {
    type: Boolean,
    default: true,
  },
  socialsTextOnly: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.hero-centered {
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  box-shadow: var(--dl-shadow-sm);

  &__cover {
    position: relative;
    height: 10rem;
    background: var(--bulma-scheme-main-bis);
  }

  &__cover-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &__body {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.5rem 1rem 2rem;
    gap: 0.75rem;

    &--with-cover {
      margin-top: -4rem;
    }
  }
}
</style>
