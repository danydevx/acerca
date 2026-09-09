# ORP UI — FOCUSED NAVIGATION CAPABILITY

## Objetivo

Implementar exactamente UNA capability aprobada por ORP-NAVIGATION-DISCOVERY-AUDIT.md.

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

1. Leer el discovery y tomar la capability prioritaria exacta.
2. Definir su capa: Primitive, Component o Pattern.
3. Auditar HTML nativo antes de Vue.
4. Definir API mínima, semántica, estados, teclado y ARIA.
5. Implementar sin props de dominio.
6. Crear Playground dedicado y casos edge/mobile.
7. Probar integración con Drawer/Container/Stack/Cluster cuando aplique.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-NAVIGATION-CAPABILITY-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No implementar una segunda capability. Recomendarla solamente.
