# ORP UI — Stage 9: Composition Guidelines

## Objective

Define how to build pages without falling into card-grid/admin-template patterns.

## Anti-Patterns to Avoid

### 1. Card Grid Syndrome

**Problem**: Rows of identical cards with no visual hierarchy or breathing room.

**Bad Example:**
```
┌─────┐ ┌─────┐ ┌─────┐
│     │ │     │ │     │
│ Card│ │ Card│ │ Card│
│     │ │     │ │     │
└─────┘ └─────┘ └─────┘
┌─────┐ ┌─────┐ ┌─────┐
│     │ │     │ │     │
│ Card│ │ Card│ │ Card│
│     │ │     │ │     │
└─────┘ └─────┘ └─────┘
```

**ORP Way**: Use **Stack** for vertical sections, **Cluster** for related groupings, **Grid** sparingly with meaningful gaps.

### 2. Admin Template Syndrome

**Problem**: Sidebar + header + content boxes = generic admin dashboard.

**Bad Example:**
```
┌──────────────────────────────────┐
│ Header with many action buttons  │
├────────┬─────────────────────────┤
│        │ ┌─────────────────────┐│
│ Sidebar│ │ Data Table/Form     ││
│        │ │ in bordered box      ││
│        │ └─────────────────────┘│
└────────┴─────────────────────────┘
```

**ORP Way**: Use **AppBar** for navigation, **Page** for structure, avoid boxes unless they convey meaning.

## Composition Principles

### 1. Stack-Based Layout

Use **Stack** (`orp-stack`) for vertical page structure:

```html
<div class="orp-stack orp-stack--4">
  <header>...</header>
  <section>...</section>
  <section>...</section>
  <footer>...</footer>
</div>
```

### 2. Section-Based Hierarchy

Use **Section** for meaningful content divisions:

```html
<section class="orp-section">
  <header class="orp-section__header">
    <h2>Section Title</h2>
    <p>Description</p>
  </header>
  <div class="orp-section__content">
    <!-- Content -->
  </div>
</section>
```

### 3. Content Over Container

Prefer content-driven layouts over container-driven:

**Instead of:**
```html
<div class="card">
  <div class="card-body">
    <h3>Title</h3>
    <p>Content</p>
  </div>
</div>
```

**Prefer:**
```html
<div class="orp-stack orp-stack--2">
  <h3 class="orp-h3">Title</h3>
  <p class="orp-text">Content</p>
</div>
```

### 4. Semantic Structure

Use semantic HTML first:
- `<header>` for page/section headers
- `<nav>` for navigation
- `<main>` for primary content
- `<aside>` for secondary content
- `<section>` for thematic groupings
- `<footer>` for footer content

### 5. Breathing Room

Let content breathe. Use spacing tokens:
- `--orp-space-2`: Tight groupings
- `--orp-space-4`: Default element spacing
- `--orp-space-6`: Section separation
- `--orp-space-8`: Major section breaks

### 6. Cluster for Related Items

Use **Cluster** for groups of related items that might wrap:

```html
<div class="orp-cluster orp-cluster--2">
  <Badge>Tag 1</Badge>
  <Badge>Tag 2</Badge>
  <Badge>Tag 3</Badge>
</div>
```

## Page Building Blocks

### Landing/Marketing Pages

```
Hero → Section (USP) → Section (Features) → Section (Testimonials) → CTA
```

### Dashboard Pages

```
AppBar → Page Header → [Cards/Stats] → [Data/Table] → [Actions]
```

### Detail Pages

```
Hero/Media → Title + Meta → Description → Related Content → Actions
```

### Form Pages

```
Page Header → Form (vertical stack) → Actions (sticky footer on mobile)
```

## Layout Primitives

| Primitive | Use When |
|-----------|----------|
| **Stack** | Vertical structure, form layout, page sections |
| **Cluster** | Inline groups that wrap (tags, badges, buttons) |
| **Grid** | 2D layouts with consistent columns (gallery, product grid) |
| **Section** | Thematic content grouping with optional header |
| **Page** | Top-level page wrapper with safe areas |

## Accessibility in Composition

1. **Heading Hierarchy**: Never skip h2 → h4
2. **Focus Order**: Logical tab order through composition
3. **Landmarks**: Use semantic HTML landmarks
4. **Contrast**: Ensure text over all backgrounds
5. **Touch Targets**: Minimum 44px for interactive elements

## Responsive Behavior

### Mobile-First
- Stack by default
- Grid only for explicit 2D data
- Sheet instead of Modal on mobile
- BottomNav instead of Sidebar

### Desktop Enhancement
- Add Sidebar navigation
- Use Grid for data tables
- Consider Modal for complex forms
- Horizontal navigation options

## Example: ORP Landing Page Composition

```html
<div class="orp-stack orp-stack--0">
  <!-- Hero -->
  <section class="orp-hero orp-hero--centered">
    <h1 class="orp-h1">Build faster with ORP</h1>
    <p class="orp-text-lg">Mobile-first UI kit for SaaS</p>
    <div class="orp-cluster orp-cluster--3">
      <button class="orp-btn orp-btn--primary">Get Started</button>
      <button class="orp-btn orp-btn--outline">Documentation</button>
    </div>
  </section>

  <!-- Features -->
  <section class="orp-section">
    <header class="orp-section__header">
      <h2 class="orp-h2">Features</h2>
    </header>
    <div class="orp-grid orp-grid--3">
      <FeatureCard v-for="f in features" :key="f.id" :feature="f" />
    </div>
  </section>

  <!-- CTA -->
  <section class="orp-section orp-section--muted">
    <h2 class="orp-h2">Ready to start?</h2>
    <button class="orp-btn orp-btn--primary">Get Started</button>
  </section>
</div>
```

## Bootstrap Resemblance

**Score: 0/3**

ORP composition patterns do not resemble Bootstrap:
- No card-grid (uses Stack/Cluster)
- No admin-template (uses AppBar + semantic sections)
- No bordered boxes for content grouping

## Final Verdict

**COMPOSITION GUIDELINES ESTABLISHED**

These guidelines ensure ORP pages are:
- Mobile-first
- Semantically structured
- Accessible
- Distinct from Bootstrap/admin-template patterns
