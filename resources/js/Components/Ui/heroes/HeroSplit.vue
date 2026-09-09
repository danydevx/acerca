<template>
  <section class="hero-split" :class="{ 'hero-split--reversed': reversed }">
    <div class="hero-split__media">
      <img v-if="cover" :src="cover" :alt="name" class="hero-split__image">
      <div v-else class="hero-split__placeholder">
        <i class="bi bi-image"></i>
      </div>
    </div>
    <div class="hero-split__content">
      <UiAvatar
        v-if="avatar"
        :src="avatar"
        :name="name"
        size="lg"
      />
      <HeroIdentity
        :name="name"
        :title="title"
        :company="company"
        :size="nameSize"
      />
      <HeroBadges v-if="badges?.length" :badges="badges" />
      <HeroDescription v-if="description" :text="description" />
      <div v-if="contacts?.length" class="hero-split__contacts">
        <UiContactAction
          v-for="(contact, index) in contacts"
          :key="index"
          :type="contact.type"
          :value="contact.value"
          :label="contact.label"
        />
      </div>
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
  </section>
</template>

<script setup>
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiSocialLinks from '@/Components/Ui/social/SocialLinks.vue'
import UiContactAction from '@/Components/Ui/contact/ContactAction.vue'
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
  contacts: Array,
  actions: Array,
  socials: Array,
  verified: Boolean,
  reversed: Boolean,
  avatarSize: {
    type: String,
    default: 'lg',
  },
  nameSize: {
    type: String,
    default: 'md',
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
    validator: (v) => ['start', 'end', 'top', 'bottom'].includes(v),
  },
  socialsIconOnly: {
    type: Boolean,
    default: false,
  },
  socialsTextOnly: {
    type: Boolean,
    default: false,
  },
})
</script>

<style lang="scss" scoped>
.hero-split {
  display: flex;
  flex-direction: column;
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  box-shadow: var(--dl-shadow-sm);

  @media (min-width: 768px) {
    flex-direction: row;
    align-items: stretch;

    &--reversed {
      flex-direction: row-reverse;
    }
  }

  &__media {
    flex: 0 0 40%;
    min-height: 12.5rem;
    background: var(--bulma-scheme-main-bis);

    @media (min-width: 768px) {
      min-height: auto;
    }
  }

  &__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  &__placeholder {
    width: 100%;
    height: 100%;
    min-height: 12.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);

    i {
      font-size: 4rem;
    }
  }

  &__content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1.5rem;
  }

  &__contacts {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
}
</style>
