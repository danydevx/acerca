# 03 - BEM y HTML Semántico

## Auditoría de HTML

### Componentes que necesitan refactorización BEM

#### 1. HeroLeft.vue
```vue
<!-- ACTUAL (Bulma classes) -->
<section class="hero is-primary is-bold">
  <div class="hero-body">
    <div class="container">
      <div class="is-flex is-align-items-center gap-4">
        <figure class="image is-96x96">...</figure>
        <div class="content">
          <h1 class="title is-4">...</h1>
          <p class="subtitle is-6">...</p>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-footer">...</div>
</section>

<!-- OBJETIVO (BEM) -->
<section class="hero">
  <div class="hero__body">
    <div class="hero__content">
      <figure class="hero__logo">...</figure>
      <div class="hero__info">
        <h1 class="hero__title">...</h1>
        <p class="hero__subtitle">...</p>
      </div>
    </div>
  </div>
  <div v-if="showSocial" class="hero__footer">
    <nav class="hero__social">...</nav>
  </div>
</section>
```

#### 2. SectionServices.vue
```vue
<!-- ACTUAL (mezcla Bulma + BEM) -->
<section class="section-services py-6">
  <div class="section-services__inner container px-4">
    <header class="has-text-centered mb-5">
      <h2 class="title is-4 mb-2">{{ title }}</h2>
      <p class="subtitle is-6 has-text-grey">{{ subtitle }}</p>
    </header>
    <div class="columns is-multiline">...</div>
  </div>
</section>

<!-- OBJETIVO (BEM puro + CSS vars) -->
<section class="section-services" :class="schemeClass">
  <div class="section-services__inner container">
    <header v-if="title || subtitle" class="section-services__header">
      <h2 v-if="title" class="section-services__title">{{ title }}</h2>
      <p v-if="subtitle" class="section-services__subtitle">{{ subtitle }}</p>
    </header>
    <div class="section-services__grid">...</div>
  </div>
</section>
```

#### 3. SectionAbout.vue
```vue
<!-- ACTUAL (LESS + orp-*) -->
<section class="section-about">
  <div class="section-about__inner">
    <h2 class="section-about__title">{{ title }}</h2>
    <h3 class="section-about__subtitle">{{ subtitle }}</h3>
    <p class="section-about__description-text">{{ description }}</p>
    <div class="section-about__content">...</div>
  </div>
</section>

<!-- OBJETIVO (SCSS + --dl-*) -->
<section class="section-about" :class="schemeClass">
  <div class="section-about__inner">
    <h2 v-if="title" class="section-about__title">{{ title }}</h2>
    <p v-if="subtitle" class="section-about__subtitle">{{ subtitle }}</p>
    <p v-if="description" class="section-about__description">{{ description }}</p>
    <div v-if="content" class="section-about__content">...</div>
  </div>
</section>
```

## Plan de migración BEM

### Fase 1: Heroes
- [ ] HeroLeft.vue → BEM + CSS vars
- [ ] HeroCenter.vue → BEM + CSS vars
- [ ] HeroRight.vue → BEM + CSS vars
- [ ] HeroSimple.vue → BEM + CSS vars

### Fase 2: Sections base
- [ ] SectionServices.vue → BEM + CSS vars + scheme
- [ ] SectionGallery.vue → BEM + CSS vars + scheme
- [ ] SectionFeatures.vue → BEM + CSS vars + scheme
- [ ] SectionAbout.vue → BEM + CSS vars + scheme

### Fase 3: Sections restantes
- [ ] SectionPromotions.vue
- [ ] SectionContactForm.vue
- [ ] SectionAppointments.vue
- [ ] SectionAvailability.vue
- [ ] SectionLocations.vue
- [ ] SectionFaqs.vue
- [ ] SectionProducts.vue
- [ ] SectionReviews.vue
- [ ] SectionRestaurantMenu.vue
- [ ] SectionProperties.vue
- [ ] SectionPackages.vue

## Reglas HTML semántico

1. `<header>` solo para cabecera de sección, no de página
2. `<nav>` para navegación, no para social links (usar `<ul>` + `<a>`)
3. `<section>` solo si hay heading (h1-h6)
4. `<article>` para cards/items independientes
5. `<footer>` solo para pie de página, no de sección

## Siguiente paso

Ver `04-THEME-API-DL-VARIABLES.md` para definir el Theme API.