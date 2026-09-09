# ETAPA 7 — VISUAL PILOT

## Objetivo

Validar la identidad ORP 2026 en CatalogCard Collection antes de propagar cambios visuales.

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

1. Ejecutar el prompt CatalogCard Visual Pilot incluido.
2. Trabajar mobile-first 390px.
3. Capturar before/after.
4. Medir Bootstrap resemblance y cohesión.
5. Aprobar o iterar el piloto.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-VISUAL-PILOT-CATALOG-CARD.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No propagar a otros Patterns.
