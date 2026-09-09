# ETAPA 8 — VISUAL DIRECTION ROLLOUT PLAN

## Objetivo

Después de aprobar CatalogCard Pilot, convertir sus aprendizajes en un plan de propagación controlado.

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

1. Leer Visual Direction Audit y CatalogCard Pilot Report.
2. Separar decisiones sistémicas de decisiones exclusivas de CatalogCard.
3. Priorizar Foundation/controls antes de Patterns cuando el problema sea compartido.
4. Definir orden de rollout: controls, structural primitives, components, patterns.
5. Definir before/after QA y rollback criteria.
6. No implementar todavía.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-VISUAL-DIRECTION-ROLLOUT-PLAN.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

Entregar plan y seleccionar un solo lote de rollout.
