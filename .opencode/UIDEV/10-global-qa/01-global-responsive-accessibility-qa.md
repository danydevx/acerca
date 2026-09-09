# ETAPA 10 — GLOBAL RESPONSIVE & ACCESSIBILITY QA

## Objetivo

Validar ORP completo como sistema antes del dogfooding amplio.

## Reglas generales

- Auditar el repositorio real antes de modificar.
- Reutilizar ORP antes de crear nuevas abstracciones.
- No copiar Bootstrap, Vuestic, Material, Quasar, Tailwind o cualquier framework literalmente.
- Mantener Default Theme 2026, tokens ORP, accesibilidad y mobile-first.
- No introducir lógica de negocio en ORP.
- No hacer crecimiento lateral fuera del alcance de esta etapa.
- Ejecutar tests relevantes, `npm run build` y revisar consola.
- Documentar decisiones rechazadas/deferidas, no solamente lo implementado.

## Pasos

1. Construir matriz de Foundation/Primitives/Components/Patterns.
2. QA 320/375/390/430/768/1024/1200/1440.
3. Revisar overflow, touch targets, focus, contrast, keyboard, reduced motion y long Spanish content.
4. Revisar estados default/hover/focus/active/disabled/loading/error donde apliquen.
5. Revisar Leaflet/GLightbox boundaries.
6. Ejecutar tests/build/console.
7. Clasificar P0-P3 y corregir sólo P0/P1 blockers.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-GLOBAL-RESPONSIVE-A11Y-QA.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No abrir nuevas familias de componentes.
