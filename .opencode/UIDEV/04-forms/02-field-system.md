# ORP UI — FIELD COMPOSITION FOLLOW-UP

## Objetivo

Resolver la composición Field si el Form System Audit confirma que Label + Control + Help + Error se repite y merece abstracción.

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

1. Validar evidencia 2+ contextos.
2. Decidir CSS primitive/composition vs Vue component.
3. Preservar `label for`, ids, describedby y mensajes de error.
4. No acoplar Field a un Input específico.
5. Probar Input/Textarea/Select y contenido largo.
6. Documentar cuándo usar y cuándo no.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-FIELD-SYSTEM-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

Si Field no está justificado, reportarlo y no crearlo.
