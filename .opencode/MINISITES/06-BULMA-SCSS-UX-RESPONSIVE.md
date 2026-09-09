# 06 - Bulma, SCSS y UX Responsive

## Estado actual

- Bulma CSS importado via CDN/npm
- Componentes mezclan Bulma classes con estilos propios
- Preprocessors mezclados: SCSS y LESS
- No hay sistema unificado de overrides

## Decisiones

### 1. Mantener Bulma como framework base

Bulma se mantiene. No se reemplaza. Override solo donde sea necesario.

### 2. SCSS como preprocessor único

Todos los componentes nuevos usan SCSS. Migration gradual de LESS → SCSS.

### 3. No duplicar utilities de Bulma

Bulma ya tiene:
- `.is-primary`, `.is-secondary`, etc. → usar en vez de colores hardcoded
- `.has-text-*`, `.has-background-*` → usar en vez de vars
- `.py-6`, `.px-4`, `.mb-5` → spacing de Bulma, no crear vars propias

### 4. Override mínimo vía CSS custom properties

Cuando Bulma no satisface, usar `--dl-*` vars en vez de crear nuevas classes.

## Estructura de estilos propuesta

```
resources/less/minisite/
├── _variables.scss        # Variables --dl-* (reemplaza _variables.less)
├── _schemes.scss          # Section schemes (reemplaza parte de minisite.less)
├── _bulma-overrides.scss  # Overrides de Bulma
├── _components.scss       # Componentes compartidos (ServiceCard, etc)
└── app.scss               # Import principal
```

## Migración de LESS a SCSS

### `minisite.less` → `minisite.scss`

```scss
// Sección schemes migrados a SCSS
.section {
  &--light {
    --dl-section-bg: #ffffff;
    --dl-section-text: #111827;
    --dl-section-muted: #6B7280;
    background: var(--dl-section-bg);
    color: var(--dl-section-text);
  }

  &--dark {
    --dl-section-bg: #111827;
    --dl-section-text: #ffffff;
    --dl-section-muted: #9CA3AF;
    background: var(--dl-section-bg);
    color: var(--dl-section-text);
  }

  // ... otros schemes
}
```

### Cards dentro de sections

```scss
.section {
  &--light {
    .service-card,
    .product-card {
      background: var(--dl-card-bg, #ffffff);
      border: 1px solid var(--dl-section-border);
      border-radius: var(--dl-card-radius);
    }
  }

  &--dark {
    .service-card,
    .product-card {
      background: rgba(255,255,255,0.1);
      border-color: rgba(255,255,255,0.2);
    }
  }
}
```

## Responsive

### Estrategia mobile-first

```scss
.section-services {
  padding: 1.5rem 1rem; // mobile

  @include tablet {
    padding: 3rem 2rem;
  }

  @include desktop {
    padding: 4rem 2rem;
  }

  &__grid {
    grid-template-columns: 1fr; // mobile

    @include tablet {
      grid-template-columns: repeat(2, 1fr);
    }

    @include desktop {
      grid-template-columns: repeat(3, 1fr);
    }
  }
}
```

## Mixins útiles

```scss
// _mixins.scss
@mixin section-padding {
  padding: 1.5rem 1rem;

  @include tablet {
    padding: 2.5rem 1.5rem;
  }

  @include desktop {
    padding: 4rem 2rem;
  }
}

@mixin container {
  max-width: 1024px;
  margin: 0 auto;
  padding: 0 1rem;

  @include tablet {
    padding: 0 1.5rem;
  }
}
```

## Plan de implementación

1. [ ] Crear `resources/less/minisite/_variables.scss`
2. [ ] Crear `resources/less/minisite/_schemes.scss`
3. [ ] Crear `resources/less/minisite/_mixins.scss`
4. [ ] Migrar estilos de `minisite.less` a SCSS
5. [ ] Actualizar import en build
6. [ ] Migrar componentes Vue de LESS a SCSS gradualmente

## Siguiente paso

Ver `07-THEME-RESOLVER-OVERRIDES.md` para implementar Theme Resolver.