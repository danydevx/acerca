# 01 - Auditoría Minisite

## Inventario de archivos

### Componentes Vue (`resources/js/Pages/Minisite/components/`)

| Componente | Tipo | Estilo CSS | Preprocessor | BEM |
|------------|------|------------|--------------|-----|
| MinisiteLayout.vue | Layout | BEM (`minisite__content`) | SCSS | Sí |
| SectionHero.vue | Wrapper | Ninguno | - | N/A |
| HeroLeft.vue | Hero | Bulma classes | - | No |
| HeroCenter.vue | Hero | Bulma classes | - | No |
| HeroRight.vue | Hero | Bulma classes | - | No |
| HeroSimple.vue | Hero | Bulma classes | - | No |
| SectionServices.vue | Section | BEM (`section-services__inner`) | SCSS | Parcial |
| SectionGallery.vue | Section | BEM (`section-gallery__inner`) | SCSS | Sí |
| SectionAbout.vue | Section | BEM + `orp-*` vars | LESS | Sí |
| SectionFeatures.vue | Section | BEM + `brand-*` vars | SCSS | Sí |
| SectionPromotions.vue | Section | - | - | - |
| SectionContactForm.vue | Section | - | - | - |
| SectionAppointments.vue | Section | - | - | - |
| SectionAvailability.vue | Section | - | - | - |
| SectionLocations.vue | Section | - | - | - |
| SectionFaqs.vue | Section | - | - | - |
| SectionProducts.vue | Section | - | - | - |
| SectionReviews.vue | Section | - | - | - |
| SectionRestaurantMenu.vue | Section | - | - | - |
| SectionProperties.vue | Section | - | - | - |
| SectionPackages.vue | Section | - | - | - |
| SectionFooter.vue | Section | - | - | - |
| NavigationMenu.vue | Nav | - | - | - |
| Footer.vue | Footer | BEM (`minisite-footer`) + `brand-*` vars | SCSS | Sí |
| ServiceCard.vue | Card | - | - | - |
| ServiceListItem.vue | List item | - | - | - |
| ServiceDetailModal.vue | Modal | - | - | - |
| ProductCard.vue | Card | - | - | - |
| ProductListItem.vue | List item | - | - | - |
| ProductDetailModal.vue | Modal | - | - | - |

### Themes (`resources/js/Pages/Minisite/themes/base/`)

Solo existe theme `base/` con páginas alternativas:
- Show.vue, Services.vue, Gallery.vue, Products.vue, Menu.vue
- Appointments.vue, Locations.vue, Contact.vue, Reviews.vue
- Faqs.vue, Promotions.vue, Properties.vue, ProductDetail.vue
- ServiceDetail.vue, PromotionDetail.vue, PropertyDetail.vue

**Hallazgo**: No hay sistema de themes. La carpeta `themes/base/` contiene páginas detalle específicas, no variants de theming.

### LESS files (`resources/less/`)

| Archivo | Variables | Propósito |
|---------|-----------|-----------|
| `minisite.less` | `var(--brand-*)` | Estilos públicos minisite |
| `orp-ui/_*.less` | `var(--orp-*)` | Sistema UI components |
| `abstracts/_variables.less` | `@color-*`, `@space-*` | LESS variables (no usadas en minisite) |
| `app.less` | `var(--primary)`, `var(--bg)` | Layout admin + public |
| `directory.less` | - | Directorio público |

### Controlador

`app/Http/Controllers/Public/BusinessController.php`:
- Define `sectionSchemes` hardcoded: `hero=gradient`, `about=light`, `services=neutral`, etc.
- Pasa `theme_css_variables` (JSON) a Inertia
- Lee `brandingSetting->generated_css`

---

## Hallazgos críticos

### 1. Sistemas de variables CSS duplicados

```
--brand-*    (minisite.less)
--orp-*      (orp-ui components)
--orp-space-*, --orp-font-size-* (spacing/tipografía)
```

**Impacto**: Tres escalas paralelas de custom properties. No hay unificación.

### 2. Preprocessors mezclados en Vue SFCs

- `MinisiteLayout.vue`: SCSS
- `Show.vue`: LESS
- `SectionServices.vue`: SCSS
- `SectionAbout.vue`: LESS con `orp-*`
- `Footer.vue`: SCSS con `brand-*`

**Impacto**: Imposible compartir mixins/utils entre componentes del mismo módulo.

### 3. Clases Bulma mezcladas con BEM

HeroLeft usa `hero is-primary is-bold` (Bulma puro).
SectionServices usa `section-services__inner` (BEM).

**Impacto**: Inconsistencia en abstracción. Bulma es framework pero no se sigue consistentemente.

### 4. Section schemes no están conectados

`minisite.less` define `.section--light`, `.section--dark`, etc.
Los componentes Section no leen ni aplican estas clases según `config.scheme`.

**Impacto**: Los schemes existen en CSS pero no se utilizan desde los componentes.

### 5. Themes/base no son realmente themes

La carpeta `themes/base/` contiene páginas detalle (Services.vue, ProductDetail.vue).
No hay `ThemeResolver` ni lógica de selección de theme por negocio.

**Impacto**: El roadmap menciona Theme API `--dl-*` pero no existe aún.

### 6. Branding genera CSS dinámico

`BrandingSetting::generated_css` parece contener CSS generado dinámicamente.
No está claro cómo se inyecta ni qué variables define.

---

## Patrones detectados

### BEM correcto
```vue
<!-- Footer.vue -->
<style lang="scss" scoped>
.minisite-footer {
  background: var(--brand-text, #374151);
  a { ... }
}
</style>
```

### BEM + CSS vars
```vue
<!-- SectionServices.vue -->
<style lang="scss" scoped>
.section-services {
  &__inner { max-width: 1024px; }
  &__carousel { display: flex; gap: 1rem; }
}
</style>
```

### LESS + orp-* vars (fuera de Bulma)
```vue
<!-- SectionAbout.vue -->
<style lang="less">
.section-about {
  padding: var(--orp-space-6) var(--orp-space-2);
  &__title { color: var(--orp-foreground); }
}
</style>
```

### Bulma classes directas
```vue
<!-- HeroLeft.vue -->
<section class="hero is-primary is-bold">...</section>
```

---

## Dependencias externas

| Dependencia | Uso |
|-------------|-----|
| Bulma CSS | Framework CSS principal |
| GLightbox | Galería lightbox |
| Bootstrap Icons | Iconos (`bi bi-*`) |

---

## Configuración actual del theme (BusinessController)

```php
'sectionSchemes' => [
    'hero' => 'gradient',
    'about' => 'light',
    'services' => 'neutral',
    'products' => 'light',
    'gallery' => 'dark',
    'menu' => 'neutral',
    'appointments' => 'primary',
    'reviews' => 'light',
    'locations' => 'neutral',
    'contact' => 'dark',
    'promotions' => 'accent',
],
```

---

## Issues prioritarios para resolver en pasos posteriores

1. **Unificar variable system** → Entscheid: `brand-*` o `orp-*` o nuevo `--dl-*`
2. **Estandarizar preprocessor** → SCSS para todo minisite
3. **Conectar section schemes** → Componentes deben leer `config.scheme` y aplicar clase
4. **Implementar Theme API** → `--dl-*` según roadmap
5. **Alinear `themes/base/`** → O eliminar si no se usa

---

## Siguiente paso

Ver `02-STRUCTURE-COMPONENTS.md` para definir estructura objetivo y контракт de componentes.