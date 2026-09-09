# ETAPA 3 — NAVIGATION SYSTEM

## Objetivo

Construir navegación ORP sólo a partir del Navigation Discovery Audit; cada capability aprobada debe tener su propia fase.

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

1. Ejecutar Navigation Discovery.
2. Clasificar Nav, Tabs, Breadcrumb, Pagination, Menu/Dropdown, Navbar/AppBar, Sidebar y Bottom Navigation.
3. Elegir UNA capability prioritaria.
4. Implementarla con semántica, teclado y ARIA correctos.
5. Repetir únicamente para gaps aprobados.
6. Crear una matriz final de Navigation y detener crecimiento.

## Entregable

Generar:

```text
.opencode/ORPUI/ORP-NAVIGATION-SYSTEM-REPORT.md
```

El reporte debe incluir: estado inicial, hallazgos, decisiones, archivos modificados, pruebas, build, QA responsive, accesibilidad, resultado final y una sola recomendación para la siguiente fase.

## STOP

No crear toda la familia en una sola pasada.
