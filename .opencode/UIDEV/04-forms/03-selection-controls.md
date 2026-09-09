# ORP UI — SELECTION CONTROLS FOLLOW-UP

## Objetivo

Auditar/implementar Checkbox, Radio y Switch únicamente según gaps confirmados.

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

1. Auditar elementos nativos y estilos actuales.
2. Mantener Checkbox/Radio para selección; Switch sólo para booleano inmediato cuando sea semánticamente apropiado.
3. Definir checked, indeterminate si aplica, disabled, focus, error y label.
4. No crear toggle-button system accidentalmente.
5. QA táctil y teclado.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-SELECTION-CONTROLS-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No expandir hacia datepicker/autocomplete/combobox sin una auditoría independiente.
