<template>
  <section class="hero-fullbleed" :style="backgroundStyle">
    <HeroOverlay :variant="overlayVariant" />
    <div class="hero-fullbleed__content">
      <slot>
        <HeroLogo v-if="logo" :src="logo" :name="name" size="lg" />
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
      </slot>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import UiSocialLinks from '@/Components/Ui/social/SocialLinks.vue'
import HeroOverlay from './structure/HeroOverlay.vue'
import HeroLogo from './structure/HeroLogo.vue'
import HeroIdentity from './structure/HeroIdentity.vue'
import HeroBadges from './structure/HeroBadges.vue'
import HeroDescription from './structure/HeroDescription.vue'
import HeroActions from './structure/HeroActions.vue'

const props = defineProps({
  cover: String,
  logo: String,
  name: String,
  title: String,
  company: String,
  description: String,
  badges: Array,
  actions: Array,
  socials: Array,
  overlayVariant: {
    type: String,
    default: 'gradient-bottom',
  },
  nameSize: {
    type: String,
    default: 'xl',
  },
})

const backgroundStyle = computed(() => {
  if (props.cover) {
    return {
      backgroundImage: `url(${props.cover})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
    }
  }
  return {
    background: `linear-gradient(135deg, var(--bulma-primary) 0%, var(--bulma-link) 100%)`,
  }
})
</script>

<style lang="scss" scoped>
.hero-fullbleed {
  position: relative;
  min-height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &__content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 1rem;
    padding: 2rem 1.5rem;
    max-width: 600px;
    color: white;

    :deep(.hero-identity__name) {
      color: white;
    }

    :deep(.hero-identity__title),
    :deep(.hero-identity__company) {
      color: oklch(100% 0 0 / 0.9);
    }

    :deep(.hero-description) {
      color: oklch(100% 0 0 / 0.9);
    }

    :deep(.hero-badge--default) {
      background: oklch(100% 0 0 / 0.2);
      color: white;
    }

    :deep(.hero-actions__btn--primary) {
      background: white;
      color: var(--bulma-link);

      &:hover {
        background: oklch(100% 0 0 / 0.9);
      }
    }

    :deep(.social-links) {
      gap: 0.5rem;
    }

    :deep(.social-links__link) {
      background: oklch(100% 0 0 / 0.15);
      color: white;

      &:hover {
        background: white;
        color: var(--bulma-link);
      }
    }
  }
}
</style>
