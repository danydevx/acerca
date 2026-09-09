# ORP UI — Roadmap por etapas

Este paquete convierte el trabajo pendiente de ORP UI en fases independientes y ejecutables.

## Orden

### Etapa 1 — Documentation Shell
Transformar Playground en documentación navegable de framework.

### Etapa 2 — Primary Primitive Closure
Cerrar Divider, Card, Button, IconButton, Badge, Avatar, List y Price. Surface ya fue confirmado como Foundation tokens, no Primitive. Media ya fue auditado y sólo requiere revisión visual si existe evidencia.

### Etapa 3 — Navigation System
Descubrir primero. Implementar después sólo las piezas justificadas: Nav, Tabs, Breadcrumb, Pagination, Menu/Dropdown, etc.

### Etapa 4 — Form System
Auditar y completar Field, Input, Textarea, Select, Checkbox, Radio, Switch, validación y controles auxiliares.

### Etapa 5 — Feedback & Overlay Gaps
Cerrar Toast/Notification, Tooltip, Popover, Dropdown/Menu, Spinner y Confirm/Dialog sólo cuando exista un gap real.

### Etapa 6 — Framework Growth Freeze
Congelar crecimiento especulativo. A partir de aquí, un componente nuevo requiere evidencia real en 2+ contextos.

### Etapa 7 — CatalogCard Visual Pilot
Probar la identidad ORP 2026 en una composición real antes de propagarla.

### Etapa 8 — Visual Direction Rollout
Propagar únicamente decisiones visuales validadas por el piloto.

### Etapa 9 — Composition Guidelines
Definir cómo construir páginas sin caer en card-grid/admin-template.

### Etapa 10 — Global Responsive & Accessibility QA
QA sistemático de ORP completo.

### Etapa 11 — Acerca Dogfooding
Aplicar ORP maduro en minisites/vCards/admin y registrar gaps reales.

### Etapa 12 — ORP v1 Readiness
Cerrar API, documentación, deprecaciones, pruebas y criterios de versión estable.

## Regla de oro

```text
DISCOVER
→ CLASSIFY
→ REUSE
→ EXTEND
→ CREATE ONLY IF JUSTIFIED
→ VERIFY
→ DOCUMENT
→ STOP
```

No perseguir paridad de componentes con otros frameworks.
