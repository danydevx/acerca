<template>
  <section class="hero-classic">
    <HeroCoverMedia :src="cover" :height="coverHeight" />
    <div class="hero-classic__body">
      <UiAvatar
        :src="avatar"
        :name="name"
        size="xl"
        :status="status"
      />
      <div class="hero-classic__content">
        <HeroIdentity
          :name="name"
          :title="title"
          :company="company"
          :size="nameSize"
        />
        <HeroBadges v-if="badges?.length" :badges="badges" />
        <HeroDescription v-if="description" :text="description" />
        <HeroActions v-if="actions?.length" :actions="actions" />
        <UiSocialLinks
          v-if="socials?.length"
          :items="socials"
          :variant="socialsVariant"
          :color-scheme="socialsColorScheme"
          :layout="socialsLayout"
          :icon-only="socialsIconOnly"
          :text-only="socialsTextOnly"
        />
      </div>
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
  status: String,
  coverHeight: {
    type: String,
    default: 'medium',
  },
  nameSize: {
    type: String,
    default: 'lg',
  },
  socialsVariant: {
    type: String,
    default: 'default',
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
.hero-classic {
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  box-shadow: var(--dl-shadow-sm);

  &__body {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.5rem 1rem 2rem;
    gap: 1rem;
    margin-top: -3rem;
  }

  &__content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    max-width: 400px;
  }
}
</style>
