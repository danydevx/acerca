# ETAPA 11 — ACERCA DOGFOODING PLAN

## Objetivo

Planear adopción de ORP maduro en Acerca sin refactor masivo.

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

1. Inventariar minisite/admin/vCards por secciones.
2. Mapear CSS local repetido a ORP existente.
3. Priorizar una sección representativa.
4. Definir métricas: CSS local reducido, consistencia, responsive, accesibilidad, cero regresión de negocio.
5. Registrar gaps reales sin promoverlos automáticamente a ORP.

## Entregable

Generar:

```text
.opencode/ORPUI/ACERCA-DOGFOODING-PLAN.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

Seleccionar una sola sección piloto.
