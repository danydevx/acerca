<template>
  <section class="hero-business">
    <HeroCoverMedia v-if="cover" :src="cover" height="small" />
    <div class="hero-business__body">
      <div class="hero-business__header">
        <HeroLogo v-if="logo" :src="logo" :name="name" size="lg" />
        <UiAvatar
          v-if="avatar"
          :src="avatar"
          :name="name"
          size="lg"
        />
      </div>
      <div class="hero-business__info">
        <div class="hero-business__identity">
          <h1 class="hero-business__name">{{ name }}</h1>
          <p v-if="category" class="hero-business__category">{{ category }}</p>
        </div>
        <div v-if="showRating && rating" class="hero-business__rating">
          <UiRating :value="rating" :count="reviewCount" :show-value="true" />
        </div>
      </div>
      <AvailabilityStatus
        v-if="isOpen !== null"
        :is-open="isOpen"
        :opens-at="opensAt"
        :closes-at="closesAt"
        :show-time="true"
      />
      <HeroBadges v-if="badges?.length" :badges="badges" />
      <HeroDescription v-if="description" :text="description" />
      <div v-if="contacts?.length" class="hero-business__contacts">
        <UiContactAction
          v-for="(contact, index) in contacts"
          :key="index"
          :type="contact.type"
          :value="contact.value"
          :label="contact.label"
        />
      </div>
      <HeroActions v-if="actions?.length" :actions="actions" />
    </div>
  </section>
</template>

<script setup>
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiRating from '@/Components/Ui/reviews/Rating.vue'
import UiContactAction from '@/Components/Ui/contact/ContactAction.vue'
import AvailabilityStatus from '@/Components/Ui/availability/AvailabilityStatus.vue'
import HeroLogo from './structure/HeroLogo.vue'
import HeroCoverMedia from './structure/HeroCoverMedia.vue'
import HeroBadges from './structure/HeroBadges.vue'
import HeroDescription from './structure/HeroDescription.vue'
import HeroActions from './structure/HeroActions.vue'

defineProps({
  cover: String,
  avatar: String,
  logo: String,
  name: String,
  category: String,
  description: String,
  badges: Array,
  contacts: Array,
  actions: Array,
  verified: Boolean,
  rating: Number,
  reviewCount: Number,
  showRating: Boolean,
  isOpen: Boolean,
  opensAt: String,
  closesAt: String,
})
</script>

<style lang="scss" scoped>
.hero-business {
  background: var(--bulma-scheme-main);
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  box-shadow: var(--dl-shadow-sm);

  &__body {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1.25rem;
  }

  &__header {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-top: -3rem;
    position: relative;
    z-index: 1;
  }

  &__info {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
  }

  &__name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0;
    line-height: 1.2;
  }

  &__category {
    font-size: 0.875rem;
    color: var(--bulma-link);
    margin: 0.125rem 0 0;
  }

  &__contacts {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
}
</style>
