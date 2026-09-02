<template>
  <footer class="minisite-footer">
    <div class="minisite-footer__inner">
      <div v-if="showSocial && socialNetworks.length" class="minisite-footer__social orp-cluster orp-cluster--4">
        <a
          v-for="network in socialNetworks"
          :key="network.platform"
          :href="network.url"
          target="_blank"
          rel="noopener noreferrer"
          class="orp-icon-btn orp-icon-btn--ghost orp-icon-btn--md"
          :aria-label="network.platform"
        >
          <i :class="getIcon(network.platform)"></i>
        </a>
      </div>
      <p v-if="text" class="minisite-footer__text">{{ text }}</p>
      <p class="minisite-footer__copyright">{{ business.name }}</p>
    </div>
  </footer>
</template>

<script setup>
defineProps({
  business: Object,
  text: String,
  showSocial: Boolean,
  socialNetworks: {
    type: Array,
    default: () => [],
  },
})

const getIcon = (platform) => {
  const icons = {
    facebook: 'bi bi-facebook',
    instagram: 'bi bi-instagram',
    twitter: 'bi bi-twitter-x',
    tiktok: 'bi bi-tiktok',
    youtube: 'bi bi-youtube',
    linkedin: 'bi bi-linkedin',
    whatsapp: 'bi bi-whatsapp',
  }
  return icons[platform?.toLowerCase()] || 'bi bi-share'
}
</script>

<style lang="less">
.minisite-footer {
  background: var(--orp-foreground);
  color: var(--orp-background);
  padding: var(--orp-space-5) var(--orp-space-2);
  margin-top: auto;

  &__inner {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
  }

  &__social {
    margin-bottom: var(--orp-space-3);
  }

  &__text {
    font-size: var(--orp-font-size-sm);
    color: var(--orp-background);
    opacity: 0.7;
    margin-bottom: var(--orp-space-1);
  }

  &__copyright {
    font-size: var(--orp-font-size-xs);
    color: var(--orp-background);
    opacity: 0.5;
    margin: 0;
  }
}
</style>
