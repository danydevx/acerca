# ORP UI — FORM SYSTEM AUDIT

## Objetivo

Auditar el sistema completo de formularios para eliminar apariencia Bootstrap y detectar gaps estructurales antes de crear controles.

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

1. Inventariar Input, Textarea, Select, Label, Field/FormGroup, help, error, Checkbox, Radio, Switch, Search, File input e Input Group.
2. Separar control visual de Field composition.
3. Auditar default/hover/focus/disabled/error/success/read-only/loading cuando aplique.
4. Revisar focus ring, alturas, radius, borders, placeholders y labels contra Default Theme 2026.
5. Identificar qué controles faltan en 2+ contextos.
6. Clasificar CREATE/EXTEND/REUSE/DEFER/REJECT.
7. Crear una página Playground Forms que muestre composición real, no controles aislados solamente.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-FORM-SYSTEM-AUDIT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No implementar todos los gaps. Seleccionar un solo follow-up bloqueante.
