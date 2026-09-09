<template>
  <a
    :href="url"
    target="_blank"
    rel="noopener noreferrer"
    class="social-button"
    :class="[
      `social-button--${variant}`,
      `social-button--${size}`,
      `social-button--${network}`,
      `social-button--${layout}`,
      { 'social-button--icon-only': iconOnly },
      { 'social-button--text-only': textOnly },
      { 'social-button--colored': colorScheme !== 'auto' },
    ]"
    :aria-label="`${networkLabel} (se abre en nueva pestaña)`"
    @click.stop
  >
    <i v-if="!textOnly" :class="iconClass"></i>
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
  textOnly: {
    type: Boolean,
    default: false,
  },
  layout: {
    type: String,
    default: 'start',
    validator: (v) => ['start', 'end', 'top', 'bottom'].includes(v),
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
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'filled', 'outlined', 'rounded', 'pill', 'soft', 'gradient'].includes(v),
  },
  colorScheme: {
    type: String,
    default: 'auto',
    validator: (v) => ['auto', 'brand', 'whatsapp', 'facebook', 'instagram', 'linkedin', 'youtube', 'twitter'].includes(v),
  },
})

const networkIcons = {
  instagram: 'bi-instagram',
  facebook: 'bi-facebook',
  messenger: 'bi-messenger',
  wechat: 'bi-wechat',
  line: 'bi-line',
  vk: 'bi-vk',
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
  address: 'bi-geo-alt',
  map: 'bi-map',
  location: 'bi-geo-alt-fill',
  calendar: 'bi-calendar',
  clock: 'bi-clock',
  event: 'bi-calendar-event',
  store: 'bi-shop',
  shop: 'bi-bag',
  cart: 'bi-cart',
  pay: 'bi-credit-card',
  payment: 'bi-wallet2',
  delivery: 'bi-truck',
  rating: 'bi-star',
  star: 'bi-star-fill',
  review: 'bi-chat-quote',
  share: 'bi-share',
  link: 'bi-link-45deg',
  qr: 'bi-qr-code',
  wifi: 'bi-wifi',
  printer: 'bi-printer',
  download: 'bi-download',
  upload: 'bi-upload',
}

const networkLabels = {
  instagram: 'Instagram',
  facebook: 'Facebook',
  messenger: 'Messenger',
  wechat: 'WeChat',
  line: 'LINE',
  vk: 'VK',
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
  address: 'Dirección',
  map: 'Mapa',
  location: 'Ubicación',
  calendar: 'Calendario',
  clock: 'Horario',
  event: 'Evento',
  store: 'Tienda',
  shop: 'Compras',
  cart: 'Carrito',
  pay: 'Pago',
  payment: 'Pagos',
  delivery: 'Delivery',
  rating: 'Calificación',
  star: 'Favorito',
  review: 'Reseña',
  share: 'Compartir',
  link: 'Enlace',
  qr: 'Código QR',
  wifi: 'WiFi',
  printer: 'Imprimir',
  download: 'Descargar',
  upload: 'Subir',
}

const iconClass = computed(() => networkIcons[props.network] || 'bi-globe')
const networkLabel = computed(() => networkLabels[props.network] || props.network)
</script>

<style lang="scss" scoped>
@mixin brand-colors($network) {
  @if $network == 'instagram' {
    background: #e4405f;
    color: #fff;
  } @else if $network == 'facebook' {
    background: #1877f2;
    color: #fff;
  } @else if $network == 'whatsapp' {
    background: #25d366;
    color: #fff;
  } @else if $network == 'linkedin' {
    background: #0a66c2;
    color: #fff;
  } @else if $network == 'youtube' {
    background: #ff0000;
    color: #fff;
  } @else if $network == 'twitter' or $network == 'x' {
    background: #000;
    color: #fff;
  } @else if $network == 'tiktok' {
    background: #000;
    color: #fff;
  } @else if $network == 'messenger' {
    background: #006aff;
    color: #fff;
  } @else if $network == 'wechat' {
    background: #07c160;
    color: #fff;
  } @else if $network == 'line' {
    background: #00b900;
    color: #fff;
  } @else if $network == 'vk' {
    background: #4a76a8;
    color: #fff;
  } @else if $network == 'github' {
    background: #333;
    color: #fff;
  } @else if $network == 'discord' {
    background: #5865f2;
    color: #fff;
  } @else if $network == 'telegram' {
    background: #26a5e4;
    color: #fff;
  } @else if $network == 'spotify' {
    background: #1db954;
    color: #fff;
  } @else if $network == 'email' {
    background: var(--bulma-warning);
    color: #fff;
  } @else if $network == 'phone' {
    background: var(--bulma-success);
    color: #fff;
  } @else if $network == 'website' or $network == 'web' {
    background: var(--bulma-info);
    color: #fff;
  } @else {
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
  }
}

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
  transition: background-color 0.15s, color 0.15s, transform 0.15s, box-shadow 0.15s;
  cursor: pointer;
  border: 1px solid transparent;

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

  &--sm {
    padding: 0.375rem 0.5rem;
    font-size: 0.75rem;

    i {
      font-size: 0.875rem;
    }
  }

  &--lg {
    padding: 0.625rem 1rem;
    font-size: 1rem;

    i {
      font-size: 1.25rem;
    }
  }

  &--icon-only {
    padding: 0.5rem;
    width: 2.25rem;
    height: 2.25rem;

    &.social-button--sm {
      width: 1.75rem;
      height: 1.75rem;
      padding: 0.375rem;
    }

    &.social-button--lg {
      width: 2.75rem;
      height: 2.75rem;
      padding: 0.625rem;
    }
  }

  &--text-only {
    padding: 0.5rem 0.75rem;
    background: transparent;
    border: none;

    i {
      display: none;
    }

    .social-button__label {
      margin-left: 0;
    }

    &:hover {
      background: oklch(0 0 0 / 0.05);
    }
  }

  &--end {
    flex-direction: row-reverse;

    i {
      margin-left: 0.5rem;
      margin-right: 0;
    }
  }

  &--top {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0.75rem 0.5rem;
    min-width: 4rem;

    i {
      margin-bottom: 0.375rem;
    }

    .social-button__label {
      margin-left: 0;
    }
  }

  &--bottom {
    flex-direction: column-reverse;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0.75rem 0.5rem;
    min-width: 4rem;

    i {
      margin-top: 0.375rem;
    }

    .social-button__label {
      margin-left: 0;
    }
  }

  &--filled {
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    border-color: var(--bulma-link);

    &:hover {
      background: var(--bulma-link-hover);
      border-color: var(--bulma-link-hover);
    }
  }

  &--outlined {
    background: transparent;
    border-color: var(--bulma-border);
    color: var(--bulma-text);

    &:hover {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }
  }

  &--rounded {
    border-radius: 50%;
    padding: 0.5rem;
    width: 2.25rem;
    height: 2.25rem;

    .social-button__label {
      display: none;
    }

    &.social-button--sm {
      width: 1.75rem;
      height: 1.75rem;
    }

    &.social-button--lg {
      width: 2.75rem;
      height: 2.75rem;
    }
  }

  &--pill {
    border-radius: 9999px;
    padding: 0.5rem 1rem;
  }

  &--soft {
    background: oklch(0 0 0 / 0.05);
    color: var(--bulma-text);

    &:hover {
      background: oklch(0 0 0 / 0.1);
    }
  }

  &--gradient {
    background: linear-gradient(135deg, var(--bulma-primary) 0%, var(--bulma-link) 100%);
    color: var(--bulma-link-invert);
    border: none;

    &:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }
  }

  &--colored {
    border: none;
    background: transparent;

    &:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px oklch(0 0 0 / 0.15);
    }

    &.social-button--default {
      background: var(--bulma-scheme-main-bis);
    }

    &.social-button--soft {
      background: oklch(0 0 0 / 0.08);
    }

    &.social-button--outlined {
      border: 1px solid currentColor;
      background: transparent;
    }

    &.social-button--rounded {
      background: transparent;
    }
  }

  &--instagram {
    background: #e4405f;
    color: #fff;
    &:hover { background: darken(#e4405f, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--facebook {
    background: #1877f2;
    color: #fff;
    &:hover { background: darken(#1877f2, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--whatsapp {
    background: #25d366;
    color: #fff;
    &:hover { background: darken(#25d366, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--linkedin {
    background: #0a66c2;
    color: #fff;
    &:hover { background: darken(#0a66c2, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--youtube {
    background: #ff0000;
    color: #fff;
    &:hover { background: darken(#ff0000, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--twitter,
  &--x {
    background: #000;
    color: #fff;
    &:hover { background: #333; transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--tiktok {
    background: #000;
    color: #fff;
    &:hover { background: #1a1a1a; transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--github {
    background: #333;
    color: #fff;
    &:hover { background: #1a1a1a; transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--discord {
    background: #5865f2;
    color: #fff;
    &:hover { background: darken(#5865f2, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--telegram {
    background: #26a5e4;
    color: #fff;
    &:hover { background: darken(#26a5e4, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--spotify {
    background: #1db954;
    color: #fff;
    &:hover { background: darken(#1db954, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--email {
    background: var(--bulma-warning);
    color: #fff;
    &:hover { transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--phone {
    background: var(--bulma-success);
    color: #fff;
    &:hover { transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--messenger {
    background: #006aff;
    color: #fff;
    &:hover { background: darken(#006aff, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--wechat {
    background: #07c160;
    color: #fff;
    &:hover { background: darken(#07c160, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--line {
    background: #00b900;
    color: #fff;
    &:hover { background: darken(#00b900, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  &--vk {
    background: #4a76a8;
    color: #fff;
    &:hover { background: darken(#4a76a8, 8%); transform: translateY(-2px); box-shadow: 0 4px 12px oklch(0 0 0 / 0.2); }
  }

  i {
    font-size: 1.125rem;
  }

  &__label {
    line-height: 1;
  }
}
</style>
