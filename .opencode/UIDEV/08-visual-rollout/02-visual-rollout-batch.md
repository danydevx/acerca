# ORP UI — VISUAL ROLLOUT BATCH

## Objetivo

Aplicar exactamente un lote aprobado del Visual Direction Rollout Plan.

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

1. Leer el plan.
2. Modificar sólo el lote seleccionado.
3. Preservar APIs.
4. Capturar before/after en 390 y 1440 cuando sea posible.
5. Comparar Bootstrap resemblance y cohesión.
6. QA estados, accesibilidad y responsive.
7. Actualizar Playground/docs.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-VISUAL-ROLLOUT-BATCH-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No avanzar al siguiente lote automáticamente.
