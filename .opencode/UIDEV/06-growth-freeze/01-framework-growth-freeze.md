# ETAPA 6 — FRAMEWORK GROWTH FREEZE

## Objetivo

Congelar crecimiento especulativo de ORP antes de la consolidación visual.

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

1. Crear inventario oficial Foundation/Primitives/Components/Patterns.
2. Marcar cada API como stable, experimental, deprecated o internal.
3. Definir regla de admisión: 2+ contextos genéricos, responsabilidad clara, API pequeña, no duplicación.
4. Registrar backlog de ideas sin implementarlas.
5. Definir que nuevos gaps deben venir de dogfooding o auditorías específicas.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-FRAMEWORK-GROWTH-FREEZE.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No crear componentes. Resultado esperado: FRAMEWORK GROWTH FROZEN FOR VISUAL CONSOLIDATION.
