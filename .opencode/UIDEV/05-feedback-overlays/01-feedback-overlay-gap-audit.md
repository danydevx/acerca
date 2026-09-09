# ETAPA 5 — FEEDBACK & OVERLAY GAP AUDIT

## Objetivo

Determinar qué feedback/overlay reusable falta después de Alert, Empty, Skeleton, Progress, Meter, Modal, Drawer y Accordion.

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

1. Inventariar Toast/Notification, Tooltip, Popover, Dropdown/Menu, Spinner y Confirm/Dialog en ORP y Acerca read-only.
2. Comparar cada candidato con componentes existentes.
3. Auditar HTML/ARIA nativo y necesidades de focus management/portal/positioning.
4. Aplicar regla 2+ contextos.
5. Clasificar CREATE/EXTEND/COMPOSE/DEFER/REJECT.
6. Elegir máximo un gap bloqueante para siguiente fase.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-FEEDBACK-OVERLAY-GAP-AUDIT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No crear todos los candidatos.
