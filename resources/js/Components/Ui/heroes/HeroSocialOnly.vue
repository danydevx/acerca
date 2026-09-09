<template>
  <section
    class="hero-social-only"
    :class="[`hero-social-only--${variant}`]"
    :style="backgroundStyle"
  >
    <HeroOverlay :variant="overlayVariant" />
    <div class="hero-social-only__content" :class="[`hero-social-only__content--${align}`]">
      <h2 v-if="title" class="hero-social-only__title">{{ title }}</h2>
      <h1 v-if="name" class="hero-social-only__name">{{ name }}</h1>
      <p v-if="subtitle" class="hero-social-only__subtitle">{{ subtitle }}</p>
      <div v-if="socials?.length" class="hero-social-only__socials">
        <a
          v-for="(social, index) in socials"
          :key="index"
          :href="social.url"
          :aria-label="social.label"
          class="hero-social-only__social-link"
          :class="[`hero-social-only__social-link--${social.network || 'default'}`]"
          target="_blank"
          rel="noopener noreferrer"
        >
          <i :class="getSocialIcon(social.network)"></i>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import HeroOverlay from './structure/HeroOverlay.vue'

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  name: {
    type: String,
    default: '',
  },
  subtitle: {
    type: String,
    default: '',
  },
  socials: {
    type: Array,
    default: () => [],
  },
  cover: {
    type: String,
    default: '',
  },
  overlayVariant: {
    type: String,
    default: 'gradient-bottom',
    validator: (v) => ['dark', 'gradient-bottom', 'gradient-top', 'gradient-center', 'brand', 'soft'].includes(v),
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'minimal', 'centered'].includes(v),
  },
  align: {
    type: String,
    default: 'center',
    validator: (v) => ['left', 'center', 'right'].includes(v),
  },
})

const backgroundStyle = () => {
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
}

const getSocialIcon = (network) => {
  const icons = {
    instagram: 'bi bi-instagram',
    facebook: 'bi bi-facebook',
    twitter: 'bi bi-twitter-x',
    linkedin: 'bi bi-linkedin',
    github: 'bi bi-github',
    youtube: 'bi bi-youtube',
    tiktok: 'bi bi-tiktok',
    whatsapp: 'bi bi-whatsapp',
    email: 'bi bi-envelope',
    website: 'bi bi-globe',
    default: 'bi bi-share',
  }
  return icons[network] || icons.default
}
</script>

<style lang="scss" scoped>
.hero-social-only {
  position: relative;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  min-height: 12rem;
  display: flex;
  align-items: center;
  justify-content: center;

  &--minimal {
    min-height: 6rem;
    border-radius: var(--bulma-radius);
  }

  &--centered {
    min-height: 15rem;
  }

  &__content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.5rem;
    padding: 2rem 1.5rem;
    color: var(--bulma-scheme-main);

    &--left {
      align-items: flex-start;
      text-align: left;
      margin-right: auto;
      margin-left: 5%;
    }

    &--right {
      align-items: flex-end;
      text-align: right;
      margin-left: auto;
      margin-right: 5%;
    }

    &--center {
      align-items: center;
      text-align: center;
    }
  }

  &__title {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    opacity: 0.8;
    margin: 0;
  }

  &__name {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
    text-shadow: 0 1px 3px oklch(0 0 0 / 0.2);
  }

  &__subtitle {
    font-size: 0.875rem;
    opacity: 0.9;
    margin: 0;
  }

  &__socials {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.5rem;
  }

  &__social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 50%;
    background: oklch(100% 0 0 / 0.15);
    color: var(--bulma-scheme-main);
    transition: all 0.2s ease;

    i {
      font-size: 1rem;
    }

    &:hover {
      background: var(--bulma-scheme-main);
      color: var(--bulma-link);
      transform: translateY(-2px);
    }

    &--instagram:hover {
      color: #e4405f;
    }

    &--facebook:hover {
      color: #1877f2;
    }

    &--twitter:hover,
    &--twitter-x:hover {
      color: #000;
    }

    &--linkedin:hover {
      color: #0a66c2;
    }

    &--github:hover {
      color: #333;
    }

    &--youtube:hover {
      color: #ff0000;
    }

    &--whatsapp:hover {
      color: #25d366;
    }

    &--tiktok:hover {
      color: #fff;
      background: oklch(0 0 0 / 0.8);
    }

    &--email:hover {
      color: var(--bulma-warning);
    }

    &--website:hover {
      color: var(--bulma-info);
    }
  }

  :deep(.hero-overlay--brand) {
    opacity: 0.6;
  }

  :deep(.hero-overlay--soft) {
    opacity: 0.4;
  }

  :deep(.hero-overlay--gradient-bottom) {
    opacity: 0.7;
  }

  :deep(.hero-overlay--gradient-center) {
    opacity: 0.5;
  }
}
</style>
