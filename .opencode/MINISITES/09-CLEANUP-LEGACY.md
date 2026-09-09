# 09 - Cleanup de Legacy

## Legacy identificado

### 1. Variables `--orp-*` huérfanas

Después de migrar a `--dl-*`, las variables `--orp-*` en SectionAbout y otros componentes deben ser removidas.

```less
/* ANTES (SectionAbout.vue) */
.section-about {
  padding: var(--orp-space-6) var(--orp-space-2);
  &__title { color: var(--orp-foreground); }
}

 /* DESPUÉS */
.section-about {
  padding: var(--dl-section-padding-y, 3rem) var(--dl-section-padding-x, 1rem);
  &__title { color: var(--dl-section-heading); }
}
```

### 2. LESS migrado a SCSS

Después de migrar componentes de LESS a SCSS, los bloques `<style lang="less">` deben convertirse.

### 3. Clases `.orp-*` huérfanas

```vue
<!-- ANTES -->
<div class="orp-text-muted orp-text-center orp-p-4">...</div>

<!-- DESPUÉS -->
<div class="section-about__empty">...</div>
```

### 4. `minisite.less` legacy

El archivo `minisite.less` debe ser migrado a SCSS y dividido en módulos.

### 5. `themes/base/` sin usar

Si las páginas en `themes/base/` no se usan para routing, pueden moverse o eliminarse.

## Checklist de cleanup

- [ ] Remover `var(--orp-*)` de componentes migrados
- [ ] Convertir `<style lang="less">` a `<style lang="scss">`
- [ ] Remover clases `.orp-*` en componentes migrados
- [ ] Migrar `minisite.less` a SCSS modular
- [ ] Auditar uso de `themes/base/` antes de eliminar

## Criterios para eliminar código

1. No referenced from any route
2. No importado por ningún componente
3. No expuesto via props/emit
4. Funcionalidad replicada en nueva estructura

## Siguiente paso

Ver `10-VALIDATION-REPORT.md` para el reporte final.