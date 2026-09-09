# ETAPA 1 — DOCUMENTATION SHELL

## Objetivo

Convertir ORP Playground en documentación navegable de framework antes de continuar auditorías visuales profundas.

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

1. Ejecutar el prompt de Documentation Shell incluido en esta carpeta.
2. Verificar navegación desktop y Drawer mobile.
3. Preservar demos y crear páginas enfocadas.
4. Validar deep-linking si la arquitectura lo permite.
5. Ejecutar responsive/a11y/build QA.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-PLAYGROUND-DOCUMENTATION-SHELL-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No rediseñar primitives durante esta etapa.
