# ETAPA 9 — ORP COMPOSITION GUIDELINES

## Objetivo

Definir cómo combinar ORP para crear páginas modernas sin caer en card-grid/admin-template.

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

1. Auditar Playground y composiciones reales de Acerca read-only.
2. Identificar patrones de page flow, chapter rhythm, full-bleed + constrained content, dominant media, split layouts y collections.
3. Definir ownership: Container→Section→Grid/Stack/Cluster→Surface/Card.
4. Documentar cuándo usar spacing/divider/surface/card.
5. Definir anti-patterns: card-everything, nested containers, equal-grid everywhere, excessive pills/shadows.
6. Crear demos de composición en Playground sin convertirlas automáticamente en nuevos public Patterns.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-COMPOSITION-GUIDELINES.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No crear nuevos Patterns salvo auditoría independiente posterior.
