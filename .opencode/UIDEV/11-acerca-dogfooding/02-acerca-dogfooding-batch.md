# ACERCA — ORP DOGFOODING BATCH

## Objetivo

Migrar una sola sección/lote de Acerca al ORP consolidado.

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

1. Preservar business logic/API/data.
2. Reutilizar ORP public API.
3. Eliminar CSS local sólo cuando ORP lo sustituya realmente.
4. No meter reglas de Acerca en ORP.
5. QA mobile-first y desktop.
6. Medir gaps encontrados.
7. Clasificar cada gap: app-local, ORP candidate, rejected.

## Entregable

Generar:

```text
.opencode/ORPUI/ACERCA-DOGFOODING-BATCH-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No migrar la siguiente sección automáticamente.
