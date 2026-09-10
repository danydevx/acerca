<template>
  <div class="page-header">
    <div class="page-header__row1">
      <div class="page-header__left">
        <h1 class="page-header__title">{{ title }}</h1>
        <nav v-if="breadcrumbs && breadcrumbs.length" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li v-for="(crumb, index) in breadcrumbs" :key="index" class="breadcrumb-item" :class="{ active: crumb.active }">
              <Link v-if="!crumb.active && crumb.href" :href="crumb.href">{{ crumb.label || crumb.title }}</Link>
              <span v-else>{{ crumb.label || crumb.title }}</span>
            </li>
          </ol>
        </nav>
      </div>
      <div v-if="backHref" class="page-header__right">
        <Link :href="backHref" class="btn btn-secondary rounded-pill">
          <i class="bi bi-arrow-left me-1"></i>
          {{ backLabel }}
        </Link>
      </div>
    </div>

    <div v-if="$slots.actions || $slots.tabs" class="page-header__row2">
      <div class="page-header__left">
        <slot name="filters" />
      </div>
      <div class="page-header__right gap-2 d-flex">
        <slot name="tabs" />
        <slot name="actions" />
      </div>
    </div>

    <div v-if="$slots.description" class="page-header__description">
      <slot name="description" />
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  title: {
    type: String,
    required: true,
  },
  breadcrumbs: {
    type: Array,
    default: () => [],
  },
  backHref: {
    type: String,
    default: '',
  },
  backLabel: {
    type: String,
    default: 'Regresar',
  },
})
</script>

<style scoped>
.page-header {
  margin-bottom: 1rem;
}

.page-header__row1 {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 0.75rem;
}

.page-header__row2 {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.page-header__left {
  
  align-items: center;
  gap: 1rem;
}

.page-header__right {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.page-header__title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
  margin-right: 0.5rem;
}

.page-header__description {
  margin-top: 0.75rem;
  color: #6c757d;
}

.page-header__description p {
  margin-bottom: 0;
}

@media (max-width: 768px) {
  .page-header__row1,
  .page-header__row2 {
    flex-direction: column;
    align-items: stretch;
  }

  .page-header__right {
    justify-content: flex-end;
  }
}
</style>
