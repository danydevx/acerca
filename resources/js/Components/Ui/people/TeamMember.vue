<template>
  <article class="team-member" :class="{ 'team-member--compact': compact }">
    <div class="team-member__avatar">
      <img v-if="image" :src="image" :alt="name" loading="lazy">
      <i v-else class="bi bi-person"></i>
    </div>
    <div class="team-member__info">
      <h4 class="team-member__name">{{ name }}</h4>
      <span v-if="role" class="team-member__role">{{ role }}</span>
      <p v-if="!compact && bio" class="team-member__bio">{{ bio }}</p>
      <div v-if="!compact && hasSocial" class="team-member__social">
        <a
          v-for="(item, index) in social"
          :key="index"
          :href="item.url"
          target="_blank"
          rel="noopener noreferrer"
          class="team-member__social-link"
          :aria-label="item.network"
        >
          <i :class="getSocialIcon(item.network)"></i>
        </a>
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  role: {
    type: String,
    default: '',
  },
  bio: {
    type: String,
    default: '',
  },
  image: {
    type: String,
    default: '',
  },
  social: {
    type: Array,
    default: () => [],
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

const hasSocial = computed(() => props.social.length > 0)

const socialIcons = {
  instagram: 'bi bi-instagram',
  facebook: 'bi bi-facebook',
  twitter: 'bi bi-twitter-x',
  linkedin: 'bi bi-linkedin',
  github: 'bi bi-github',
  email: 'bi bi-envelope',
}

const getSocialIcon = (network) => socialIcons[network] || 'bi bi-globe'
</script>

<style lang="scss" scoped>
.team-member {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 0.75rem;
  padding: 1.25rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);

  &__avatar {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bulma-text-weak);
    flex-shrink: 0;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    i {
      font-size: 1.5rem;
    }
  }

  &__info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 0;
  }

  &__name {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
  }

  &__role {
    font-size: 0.8125rem;
    color: var(--bulma-link);
    font-weight: 500;
  }

  &__bio {
    font-size: 0.8125rem;
    color: var(--bulma-text-weak);
    margin: 0.375rem 0 0;
    line-height: 1.4;
  }

  &__social {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
  }

  &__social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    border-radius: var(--bulma-radius);
    background: var(--bulma-scheme-main-bis);
    color: var(--bulma-text-weak);
    text-decoration: none;
    transition: background-color 0.15s, color 0.15s;

    &:hover {
      background: var(--bulma-scheme-main-ter);
      color: var(--bulma-text);
    }

    i {
      font-size: 0.875rem;
    }
  }

  &--compact {
    padding: 0.75rem;
    flex-direction: row;
    text-align: left;

    .team-member__avatar {
      width: 3rem;
      height: 3rem;
    }

    .team-member__info {
      flex: 1;
    }

    .team-member__social {
      justify-content: flex-start;
    }
  }
}
</style>
