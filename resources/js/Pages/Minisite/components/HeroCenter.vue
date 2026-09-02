<template>
  <div class="hero hero--center" :style="backgroundStyle">
    <div class="hero__inner orp-text-center">
      <div v-if="business.logo" class="orp-avatar orp-avatar--xl hero__avatar orp-mx-auto">
        <img :src="business.logo" :alt="business.name" class="orp-avatar__image" />
      </div>
      <h1 class="hero__title">{{ title || business.name }}</h1>
      <p v-if="subtitle" class="hero__subtitle">{{ subtitle }}</p>
    </div>
    <div v-if="showSocial && socialNetworks && socialNetworks.length" class="hero__social orp-cluster orp-cluster--4">
      <a
        v-for="(network, idx) in socialNetworks"
        :key="idx"
        :href="network.url"
        target="_blank"
        class="orp-icon-btn orp-icon-btn--md hero-social-btn"
        :title="network.platform"
      >
        <i :class="getSocialIcon(network.platform)"></i>
      </a>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  business: Object,
  title: String,
  subtitle: String,
  backgroundImage: String,
  showSocial: {
    type: Boolean,
    default: false,
  },
  socialNetworks: {
    type: Array,
    default: () => [],
  },
})

const backgroundStyle = computed(() => {
  if (props.backgroundImage) {
    return {
      '--hero-bg': `url(${props.backgroundImage})`,
    }
  }
  return {}
})

const getSocialIcon = (platform) => {
  const icons = {
    facebook: 'bi bi-facebook',
    instagram: 'bi bi-instagram',
    twitter: 'bi bi-twitter-x',
    linkedin: 'bi bi-linkedin',
    youtube: 'bi bi-youtube',
    tiktok: 'bi bi-tiktok',
    whatsapp: 'bi bi-whatsapp',
    telegram: 'bi bi-telegram',
    default: 'bi bi-globe',
  }
  return icons[platform?.toLowerCase()] || icons.default
}
</script>

<style lang="less">
.hero {
  background-color: var(--orp-surface-muted);
  background-image: var(--hero-bg, none);
  background-size: cover;
  background-position: center;

  &--center {
    .hero__inner {
      padding: var(--orp-space-5) var(--orp-space-2);
      max-width: 600px;
      margin: 0 auto;
    }

    .hero__title {
      font-size: var(--orp-font-size-xl);
      font-weight: 700;
      margin: var(--orp-space-3) 0 var(--orp-space-1);
      color: var(--orp-foreground);
      line-height: 1.2;
    }

    .hero__subtitle {
      font-size: var(--orp-font-size-md);
      margin: 0;
      color: var(--orp-muted-foreground);
      line-height: 1.4;
    }
  }

  &__social {
    padding: var(--orp-space-3);

    @media (max-width: 480px) {
      padding: var(--orp-space-2);
    }
  }
}

.hero-social-btn {
  background: var(--orp-primary);
  color: var(--orp-primary-foreground);
  border-radius: 50%;
  font-size: 1.25rem;
  transition: all 0.3s ease;
  text-decoration: none;

  &:hover {
    background: color-mix(in srgb, var(--orp-primary) 85%, black);
    transform: translateY(-2px);
    color: var(--orp-primary-foreground);
  }
}
</style>
