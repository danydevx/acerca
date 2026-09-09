# 04 - Theme API y Variables `--dl-*`

## Sistema de variables propuesto

### Variables de Theme (admin/config)

```css
:root {
  /* Brand */
  --dl-primary: #3B82F6;
  --dl-secondary: #6B7280;
  --dl-accent: #10B981;
  --dl-background: #FFFFFF;
  --dl-foreground: #111827;

  /* Cards */
  --dl-card-radius: 12px;
  --dl-card-shadow: 0 1px 3px rgba(0,0,0,0.1);
  --dl-card-bg: #FFFFFF;

  /* Buttons */
  --dl-button-radius: 8px;
  --dl-button-padding: 0.75rem 1.5rem;
}
```

### Variables de Section Scheme

```css
/* Light scheme */
.section--light {
  --dl-section-bg: #FFFFFF;
  --dl-section-text: #111827;
  --dl-section-muted: #6B7280;
  --dl-section-heading: #111827;
  --dl-section-link: #3B82F6;
  --dl-section-border: #E5E7EB;
}

/* Dark scheme */
.section--dark {
  --dl-section-bg: #111827;
  --dl-section-text: #FFFFFF;
  --dl-section-muted: #9CA3AF;
  --dl-section-heading: #FFFFFF;
  --dl-section-link: #FFFFFF;
  --dl-section-border: #374151;
}

/* Primary scheme */
.section--primary {
  --dl-section-bg: #3B82F6;
  --dl-section-text: #FFFFFF;
  --dl-section-muted: rgba(255,255,255,0.8);
  --dl-section-heading: #FFFFFF;
  --dl-section-link: #FFFFFF;
  --dl-section-border: rgba(255,255,255,0.2);
}

/* Neutral scheme */
.section--neutral {
  --dl-section-bg: #F9FAFB;
  --dl-section-text: #111827;
  --dl-section-muted: #6B7280;
  --dl-section-heading: #111827;
  --dl-section-link: #3B82F6;
  --dl-section-border: #E5E7EB;
}

/* Gradient scheme */
.section--gradient {
  --dl-section-bg: linear-gradient(135deg, var(--dl-primary) 0%, var(--dl-secondary) 100%);
  --dl-section-text: #FFFFFF;
  --dl-section-muted: rgba(255,255,255,0.8);
  --dl-section-heading: #FFFFFF;
  --dl-section-link: #FFFFFF;
  --dl-section-border: rgba(255,255,255,0.2);
}
```

## Transición desde sistemas actuales

### De `--brand-*` a `--dl-*`

| brand-* | dl-* | Notas |
|----------|-------|-------|
| --brand-primary | --dl-primary | - |
| --brand-secondary | --dl-secondary | - |
| --brand-accent | --dl-accent | - |
| --brand-background | --dl-background | Renamed |
| --brand-text | --dl-foreground | Renamed |
| --brand-card-radius | --dl-card-radius | Movido a card vars |
| --brand-button-radius | --dl-button-radius | Movido a button vars |

### De `--orp-*` a `--dl-*`

| orp-* | dl-* | Notas |
|-------|-------|-------|
| --orp-foreground | --dl-section-text | Por section |
| --orp-muted-foreground | --dl-section-muted | Por section |
| --orp-surface | --dl-section-bg | Por section |
| --orp-border | --dl-section-border | Por section |
| --orp-space-* | Mantener | Bulma spacing |
| --orp-font-size-* | Mantener | Bulma typography |

## Regla de decisión

```
1. ¿Variable de admin/theme (color primario, radius)?
   → --dl-*
   
2. ¿Variable de sección (bg, text, border)?
   → --dl-section-* (aplicada via .section--{scheme})

3. ¿Variable de componente individual (card-shadow)?
   → --dl-{component}-{property}

4. ¿Bulma ya lo resuelve (spacing, typography)?
   → No crear variable propia
```

## Siguiente paso

Ver `05-SECTION-SCHEMES-ALIGNMENT.md` para conectar schemes con componentes.