<template>
  <div class="team-grid" :class="gridClass">
    <slot>
      <TeamMember
        v-for="(member, index) in members"
        :key="index"
        :name="member.name"
        :role="member.role"
        :bio="member.bio"
        :image="member.image"
        :social="member.social"
        :compact="compact"
      />
    </slot>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import TeamMember from './TeamMember.vue'

const props = defineProps({
  members: {
    type: Array,
    default: () => [],
  },
  columns: {
    type: [Number, String],
    default: 4,
  },
  compact: {
    type: Boolean,
    default: false,
  },
})

const gridClass = computed(() => {
  const cols = props.columns
  if (cols === 2) return 'team-grid--2'
  if (cols === 3) return 'team-grid--3'
  if (cols === 5) return 'team-grid--5'
  return 'team-grid--4'
})
</script>

<style lang="scss" scoped>
.team-grid {
  display: grid;
  gap: 1rem;

  &--2 {
    grid-template-columns: repeat(2, 1fr);
  }

  &--3 {
    grid-template-columns: repeat(3, 1fr);
  }

  &--4 {
    grid-template-columns: repeat(4, 1fr);
  }

  &--5 {
    grid-template-columns: repeat(5, 1fr);
  }

  @media (max-width: 768px) {
    grid-template-columns: repeat(2, 1fr) !important;
  }

  @media (max-width: 480px) {
    grid-template-columns: 1fr !important;
  }
}
</style>
