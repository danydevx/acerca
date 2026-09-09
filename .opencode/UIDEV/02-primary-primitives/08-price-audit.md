# ORP UI — PRICE PRIMITIVE AUDIT

## Objetivo

Auditar Price como representación genérica de valor monetario/numérico sin convertirlo en lógica de comercio.

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

1. Inventariar `.orp-price`, value, currency, period, old/new value y consumidores.
2. Separar presentación de formateo; el consumidor/composable mantiene currency formatting.
3. Revisar jerarquía numérica, tabular numbers, decimales, moneda y periodos.
4. Auditar tamaños/variantes existentes; rechazar matrices innecesarias.
5. Probar valores largos, cero, decimales, monedas y contenido en español.
6. Actualizar Playground únicamente con capacidades reales.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-PRICE-PRIMITIVE-AUDIT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

Terminar con PRICE ALREADY ADEQUATE / PRICE REFINED / PRICE NEEDS FOLLOW-UP.
