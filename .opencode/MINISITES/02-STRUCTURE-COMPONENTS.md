# 02 - Estructura de Componentes

## Estructura objetivo

```
resources/js/Pages/Minisite/
├── components/
│   ├── layout/
│   │   ├── MinisiteLayout.vue      # Layout wrapper (BEM: minisite)
│   │   ├── NavigationMenu.vue      # Navegación
│   │   └── Footer.vue              # Footer
│   ├── sections/
│   │   ├── SectionServices.vue     # BEM: section-services
│   │   ├── SectionGallery.vue      # BEM: section-gallery
│   │   ├── SectionAbout.vue        # BEM: section-about
│   │   ├── SectionFeatures.vue     # BEM: section-features
│   │   ├── SectionPromotions.vue   # BEM: section-promotions
│   │   ├── SectionContactForm.vue  # BEM: section-contact-form
│   │   ├── SectionAppointments.vue # BEM: section-appointments
│   │   ├── SectionAvailability.vue # BEM: section-availability
│   │   ├── SectionLocations.vue    # BEM: section-locations
│   │   ├── SectionFaqs.vue         # BEM: section-faqs
│   │   ├── SectionProducts.vue     # BEM: section-products
│   │   ├── SectionReviews.vue      # BEM: section-reviews
│   │   ├── SectionPackages.vue     # BEM: section-packages
│   │   └── SectionHero.vue         # Wrapper que elige hero variant
│   ├── heroes/
│   │   ├── HeroLeft.vue
│   │   ├── HeroCenter.vue
│   │   ├── HeroRight.vue
│   │   └── HeroSimple.vue
│   ├── cards/
│   │   ├── ServiceCard.vue
│   │   ├── ServiceListItem.vue
│   │   ├── ProductCard.vue
│   │   ├── ProductListItem.vue
│   │   └── ...
│   └── modals/
│       ├── ServiceDetailModal.vue
│       └── ProductDetailModal.vue
├── themes/
│   └── base/                        # Theme base
│       └── (páginas detalle)
└── composables/
    ├── useThemeScheme.js            # Hook para leer section scheme
    └── useMinisiteSettings.js       # Settings del negocio
```

## Reglas de estructura

1. **BEM obligatorio** para todos los componentes de sección
2. **Un preprocessor por componente**: SCSS solamente
3. ** Props representando datos, no estilos**: `config.scheme`, no `backgroundColor`
4. **Slots para extensible**: Solo cuando hay variant real de markup

## Contrato de sección

```vue
<template>
  <section class="section-services" :class="schemeClass">
    <div class="section-services__inner container">
      <!-- Header -->
      <header v-if="title || subtitle" class="section-services__header">
        <h2 v-if="title" class="section-services__title">{{ title }}</h2>
        <p v-if="subtitle" class="section-services__subtitle">{{ subtitle }}</p>
      </header>

      <!-- Content -->
      <slot />

      <!-- Footer actions -->
      <div v-if="buttons?.length" class="section-services__actions">
        <a v-for="btn in buttons" :key="btn.text" :href="btn.url">
          {{ btn.text }}
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
// Props: title, subtitle, description, items, config, buttons
// config.scheme: 'light' | 'dark' | 'primary' | 'secondary' | 'accent' | 'neutral'
</script>

<style lang="scss" scoped>
.section-services {
  // Scheme vars via CSS custom properties
  background: var(--dl-section-bg, #fff);
  color: var(--dl-section-text, #374151);

  &__inner { max-width: 1024px; margin: 0 auto; }
  &__header { text-align: center; margin-bottom: 2rem; }
  &__title { font-size: 2rem; font-weight: 700; }
  &__subtitle { color: var(--dl-section-muted, #6B7280); }
  &__actions { display: flex; justify-content: center; gap: 1rem; margin-top: 2rem; }
}
</style>
```

## Siguiente paso

Ver `03-BEM-SEMANTIC-HTML.md` para auditoría HTML y plan de migración BEM.