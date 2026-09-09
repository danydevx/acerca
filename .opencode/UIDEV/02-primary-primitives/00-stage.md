# ETAPA 2 — PRIMARY PRIMITIVE CLOSURE

## Objetivo

Declarar completa la capa Primary sólo después de revisar sus APIs y riqueza visual, sin crear variantes por completitud.

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

1. Ejecutar Divider Audit.
2. Ejecutar Card Audit.
3. Ejecutar Button Audit.
4. Ejecutar IconButton Audit.
5. Ejecutar Badge/Status Audit.
6. Ejecutar Avatar Audit.
7. Ejecutar List Audit.
8. Ejecutar Price Audit.
9. Consolidar conclusiones y marcar Primary Primitives COMPLETE sólo si no quedan blockers.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-PRIMARY-PRIMITIVE-CLOSURE.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No iniciar Navigation automáticamente.
