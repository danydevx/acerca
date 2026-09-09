<template>
  <a
    :href="url"
    target="_blank"
    rel="noopener noreferrer"
    class="social-button"
    :aria-label="`${networkLabel} (se abre en nueva pestaña)`"
    @click.stop
  >
    <i :class="iconClass"></i>
    <span v-if="!iconOnly && showLabel" class="social-button__label">{{ networkLabel }}</span>
  </a>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  network: {
    type: String,
    required: true,
  },
  url: {
    type: String,
    required: true,
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
  showLabel: {
    type: Boolean,
    default: true,
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v),
  },
})

const networkIcons = {
  instagram: 'bi-instagram',
  facebook: 'bi-facebook',
  twitter: 'bi-twitter-x',
  x: 'bi-twitter-x',
  tiktok: 'bi-tiktok',
  youtube: 'bi-youtube',
  linkedin: 'bi-linkedin',
  pinterest: 'bi-pinterest',
  snapchat: 'bi-snapchat',
  whatsapp: 'bi-whatsapp',
  telegram: 'bi-telegram',
  threads: 'bi-threads',
  mastodon: 'bi-mastodon',
  reddit: 'bi-reddit',
  tumblr: 'bi-tumblr',
  flickr: 'bi-flickr',
  foursquare: 'bi-foursquare',
  github: 'bi-github',
  gitlab: 'bi-gitlab',
  bitbucket: 'bi-bitbucket',
  discord: 'bi-discord',
  slack: 'bi-slack',
  spotify: 'bi-spotify',
  soundcloud: 'bi-soundcloud',
  twitch: 'bi-twitch',
  vimeo: 'bi-vimeo',
  web: 'bi-globe',
  website: 'bi-globe',
  email: 'bi-envelope',
  phone: 'bi-telephone',
}

const networkLabels = {
  instagram: 'Instagram',
  facebook: 'Facebook',
  twitter: 'Twitter',
  x: 'X',
  tiktok: 'TikTok',
  youtube: 'YouTube',
  linkedin: 'LinkedIn',
  pinterest: 'Pinterest',
  snapchat: 'Snapchat',
  whatsapp: 'WhatsApp',
  telegram: 'Telegram',
  threads: 'Threads',
  mastodon: 'Mastodon',
  reddit: 'Reddit',
  tumblr: 'Tumblr',
  flickr: 'Flickr',
  foursquare: 'Foursquare',
  github: 'GitHub',
  gitlab: 'GitLab',
  bitbucket: 'Bitbucket',
  discord: 'Discord',
  slack: 'Slack',
  spotify: 'Spotify',
  soundcloud: 'SoundCloud',
  twitch: 'Twitch',
  vimeo: 'Vimeo',
  web: 'Web',
  website: 'Sitio web',
  email: 'Email',
  phone: 'Teléfono',
}

const iconClass = computed(() => networkIcons[props.network] || 'bi-globe')
const networkLabel = computed(() => networkLabels[props.network] || props.network)
</script>

<style lang="scss" scoped>
.social-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.5rem 0.75rem;
  border-radius: var(--bulma-radius);
  background: var(--bulma-scheme-main-bis);
  color: var(--bulma-text);
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  transition: background-color 0.15s, color 0.15s, transform 0.15s;
  cursor: pointer;

  &:hover {
    background: var(--bulma-scheme-main-ter);
    transform: translateY(-1px);
  }

  &:active {
    transform: translateY(0);
  }

  &:focus-visible {
    outline: 2px solid var(--bulma-link);
    outline-offset: 2px;
  }

  i {
    font-size: 1.125rem;
  }

  &__label {
    line-height: 1;
  }
}
</style>
