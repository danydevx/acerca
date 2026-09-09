# ORP UI — FOCUSED FEEDBACK/OVERLAY GAP

## Objetivo

Implementar exactamente el gap prioritario aprobado por el audit anterior.

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

1. Leer el reporte anterior.
2. Definir responsabilidad y límites.
3. Reutilizar Modal/Drawer/Alert/Button/etc. antes de crear algo.
4. Diseñar API mínima y accesible.
5. Implementar Playground y casos keyboard/mobile.
6. Ejecutar tests/build/console.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-FOCUSED-FEEDBACK-OVERLAY-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

Una capability por ejecución.
