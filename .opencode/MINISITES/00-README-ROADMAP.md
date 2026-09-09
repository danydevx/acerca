# ACERCA Minisite — Roadmap de refactor UI

## Objetivo

Reorganizar `resources/js/Pages/Minisite` sobre una arquitectura simple y mantenible:

**Bulma SCSS → Theme API `--dl-*` → BEM → SCSS UX/específico → Vue**

Este trabajo es una migración arquitectónica. **No rediseñar el minisite durante estas tareas.**

## Principio rector

> Este proyecto no está construyendo un nuevo framework CSS. Bulma es el framework. Acerca agrega identidad visual, configuración, themes, componentes de dominio y comportamiento.

## Orden de ejecución

1. `01-AUDIT-MINISITE.md`
2. `02-STRUCTURE-COMPONENTS.md`
3. `03-BEM-SEMANTIC-HTML.md`
4. `04-THEME-API-DL-VARIABLES.md`
5. `05-SECTION-SCHEMES-ALIGNMENT.md`
6. `06-BULMA-SCSS-UX-RESPONSIVE.md`
7. `07-THEME-RESOLVER-OVERRIDES.md`
8. `08-SHARED-DEPENDENCIES.md`
9. `09-CLEANUP-LEGACY.md`
10. `10-VALIDATION-REPORT.md`

No saltar directamente a mover archivos. Primero auditar.

## Reglas globales

- Bulma primero.
- Todo CSS propio sigue BEM.
- HTML semántico obligatorio.
- No duplicar primitives de Bulma.
- No crear componentes cosméticos sin valor funcional.
- Props representan datos, comportamiento, estado o variantes semánticas; no CSS arbitrario.
- Configuración visual del Admin se expresa mediante CSS Custom Properties `--dl-*`.
- No hardcodear valores que pertenezcan a la Theme API.
- No crear escalas paralelas de tipografía, spacing, breakpoints, etc. si Bulma ya las resuelve.
- Los themes no duplican componentes por defecto.
- Diferencia puramente visual → SCSS.
- Diferencia real de markup/composición → override Vue del theme.
- Mantener comportamiento, props, emits, slots y APIs existentes durante la migración.
- Build/tests deben pasar antes de declarar la tarea terminada.

## Regla de decisión CSS

Antes de escribir CSS nuevo:

1. ¿Bulma ya lo resuelve? → usar Bulma.
2. ¿Es configuración visual del Admin/theme? → usar `--dl-*`.
3. ¿Es contexto visual de una Section? → usar contrato `--dl-section-*`.
4. ¿Es un efecto UX reutilizable no cubierto por Bulma? → SCSS compartido.
5. ¿Es exclusivo del componente? → SCSS BEM del componente.
6. ¿Requiere markup diferente por theme? → override Vue.

No crear un sistema paralelo a Bulma.
