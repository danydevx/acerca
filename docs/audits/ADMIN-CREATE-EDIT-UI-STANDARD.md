# Admin Create/Edit UI Standard

## Purpose

This document defines the visual grammar for all Create and Edit forms in the Admin Dashboard. The goal is visual consistency so all forms feel like part of the same system.

---

## 1. Form Container

All forms wrap in a single `<form>` element. No extra wrappers.

```vue
<form @submit.prevent="submit">

  <!-- Form content -->

</form>
```

---

## 2. Main Layout Options

### 2.1 Single Card (Default)

For simple to medium complexity forms (1-10 fields).

```vue
<form>
  <div class="card">
    <div class="card-body">
      <div class="row g-3 mb-3">
        <!-- Fields -->
      </div>
    </div>
  </div>
  <FormActions />
</form>
```

### 2.2 Main + Sidebar

For complex forms with publication/settings sidebar.

```vue
<form>
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Main Content Title</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <!-- Fields -->
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Publication</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <!-- Sidebar fields -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex flex-wrap justify-content-between gap-2">
    <!-- Actions -->
  </div>
</form>
```

**When to use sidebar**:
- Products (price, images, status in sidebar)
- Packages (configuration in sidebar)
- MenuProducts (stock, status in sidebar)
- Complex resources with "publish" controls

**When NOT to use sidebar**:
- Simple forms with < 8 fields
- Forms without publication concept
- Settings-only forms

### 2.3 Multi-Card Sections

For complex forms needing visual separation into distinct sections.

```vue
<form>
  <!-- Section 1: General Data -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0">Datos generales</h5>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <!-- Fields -->
      </div>
    </div>
  </div>

  <!-- Section 2: Multimedia -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0">Multimedia</h5>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <!-- Fields -->
      </div>
    </div>
  </div>

  <!-- Section 3: SEO -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0">SEO</h5>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <!-- Fields -->
      </div>
    </div>
  </div>

  <FormActions />
</form>
```

---

## 3. Grid System

### 3.1 Standard Grid

Always use Bootstrap grid inside card-body.

```vue
<div class="row g-3">
  <div class="col-12">
    <!-- Full width -->
  </div>
  <div class="col-md-6">
    <!-- Half width on md+ -->
  </div>
  <div class="col-md-6">
    <!-- Half width on md+ -->
  </div>
  <div class="col-md-4">
    <!-- Third width -->
  </div>
  <div class="col-md-4">
    <!-- Third width -->
  </div>
  <div class="col-md-4">
    <!-- Third width -->
  </div>
</div>
```

### 3.2 Spacing Rule

- Outer container row: `row g-3 mb-3`
- NO inner `mb-3` wrappers inside grid columns (g-3 handles spacing)
- Section gaps: `mb-4` between logical groups

```vue
<!-- WRONG: Redundant wrappers -->
<div class="row g-3 mb-3">
  <div class="col-md-6">
    <div class="mb-3">
      <FieldText />
    </div>
  </div>
</div>

<!-- CORRECT: No inner wrappers -->
<div class="row g-3 mb-3">
  <div class="col-md-6">
    <FieldText />
  </div>
</div>
```

### 3.3 Column Widths

| Field Count | Recommended Grid |
|-------------|-----------------|
| 1-2 | `col-12` or `col-md-6` |
| 3 | `col-12 col-md-4` |
| 4 | `col-md-6` pairs |
| 5+ | Use section cards |

---

## 4. Card Usage

### 4.1 Card Structure

```vue
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0">Section Title</h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <!-- Fields -->
    </div>
  </div>
</div>
```

### 4.2 Card Headers

Use `h5` with `mb-0` inside `card-header`:

```vue
<div class="card-header">
  <h5 class="mb-0">Section Title</h5>
</div>
```

**Standard section titles**:
- Datos generales
- Descripción
- Precio
- Multimedia
- Configuración
- Publicación
- Horarios
- Contacto
- SEO

---

## 5. Fieldsets (Optional)

Use fieldsets for semantic grouping of related controls within a card.

```vue
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0">Reservas</h5>
  </div>
  <div class="card-body">
    <fieldset class="mb-3">
      <legend class="h6">Depósito</legend>
      <div class="row g-3">
        <div class="col-md-6">
          <FieldSwitch />
        </div>
        <div class="col-md-6">
          <FieldNumber />
        </div>
      </div>
    </fieldset>
  </div>
</div>
```

**When to use fieldsets**:
- When controls are semantically related
- When a legend improves understanding
- NOT for visual separation (use cards instead)

---

## 6. Actions

### 6.1 Standard Actions Layout

Actions ALWAYS at bottom, outside of cards:

```vue
<form>
  <div class="card">
    <div class="card-body">
      <div class="row g-3 mb-3">
        <!-- Fields -->
      </div>
    </div>
  </div>

  <div class="d-flex flex-wrap justify-content-between gap-2 mt-4">
    <div class="d-flex flex-wrap gap-2">
      <button type="submit" class="btn btn-gradient rounded-pill" :disabled="sending">
        {{ sending ? 'Guardando...' : 'Guardar' }}
      </button>
      <Link :href="cancelUrl" class="btn btn-outline-dark rounded-pill">
        Cancelar
      </Link>
    </div>
    <button type="button" class="btn btn-outline-danger rounded-pill">
      Eliminar
    </button>
  </div>
</form>
```

### 6.2 FormActions Component

If using FormActions component:

```vue
<FormActions
  :submit-text="isEditing ? 'Actualizar' : 'Crear'"
  :submitting-text="sending ? 'Guardando...' : 'Guardando...'"
  :cancel-href="cancelUrl"
  :sending="sending"
  :show-delete="isEditing"
  @delete="confirmDelete"
/>
```

### 6.3 Delete Button Rules

- Delete button ALWAYS separate from save/cancel
- Use `btn-outline-danger` style
- Position to the right (or bottom on mobile)
- Only show on Edit forms, not Create

---

## 7. Common Section Patterns

### 7.1 Publication Sidebar

For sidebar in MAIN_SIDEBAR layout:

```vue
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0">Publicación</h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-12">
        <FieldSwitch label="Activo" />
      </div>
      <div class="col-12">
        <FieldNumber label="Orden" />
      </div>
      <div class="col-12">
        <FieldImage label="Imagen" />
      </div>
    </div>
  </div>
</div>
```

### 7.2 Simple Form (No Sidebar)

```vue
<div class="card">
  <div class="card-body">
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-6">
        <FieldText label="Nombre" required />
      </div>
      <div class="col-12 col-md-6">
        <FieldSelect label="Categoría" />
      </div>
      <div class="col-12">
        <FieldTextarea label="Descripción" />
      </div>
    </div>
  </div>
</div>

<div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
  <Link href="..." class="btn btn-outline-dark rounded-pill">Cancelar</Link>
  <button type="submit" class="btn btn-gradient rounded-pill">Guardar</button>
</div>
```

---

## 8. Responsive Behavior

### 8.1 Grid Responsive

All grids naturally collapse to `col-12` on mobile.

```vue
<!-- Desktop: 3 columns, Mobile: 1 column -->
<div class="col-12 col-md-4">
```

### 8.2 Actions Responsive

```vue
<!-- Desktop: Save left, Delete right -->
<!-- Mobile: Stack vertically, Delete at bottom -->
<div class="d-flex flex-wrap justify-content-between gap-2">
```

### 8.3 Sidebar Responsive

Sidebar stacks below main content on mobile:

```vue
<div class="col-lg-8">
  <!-- Main content -->
</div>
<div class="col-lg-4">
  <!-- Sidebar -->
</div>
```

---

## 9. Spacing Scale

| Token | Use Case |
|-------|----------|
| `g-3` | Grid gutter (standard) |
| `mb-3` | Between grid items and next element |
| `mb-4` | Between card sections |
| `mt-4` | Above action buttons |
| `my-4` | Vertical margins for hr/separators |

---

## 10. Title Hierarchy

| Level | Element | Use |
|-------|---------|-----|
| Page Title | `PageHeader` component | Page-level title |
| Card Title | `h5.mb-0` in `card-header` | Section within page |
| Fieldset Legend | `legend.h6` | Group within card |

**Never use**:
- `h4` for card titles
- `legend` for card titles
- Multiple `h5` at same level without card wrapper

---

## 11. Do's and Don'ts

### DO

- Use `row g-3 mb-3` for all single-card forms
- Wrap in `card` and `card-body`
- Use `card-header` with `h5.mb-0` for section titles
- Use `col-lg-8` + `col-lg-4` for sidebar layouts
- Put actions outside cards at bottom
- Use `FormActions` component when available
- Keep `mb-3` spacing between grid and next element

### DON'T

- Use `row g-3` without `mb-3` on outer container
- Add inner `mb-3` wrappers inside grid columns
- Put actions inside cards (except in special cases)
- Use `mt-3` between sections (use `mb-4` on previous card instead)
- Mix `mt-3` and `mb-3` inconsistently
- Use `col-md-6 col-md-6` when `row g-3` is sufficient
- Create nested grids unnecessarily

---

## 12. Template Reference

### Single Card Basic
```vue
<form @submit.prevent="submit">
  <div class="card">
    <div class="card-body">
      <div class="row g-3 mb-3">
        <div class="col-12">
          <FieldText id="field1" label="Field 1" v-model="form.field1" />
        </div>
        <div class="col-md-6">
          <FieldSelect id="field2" label="Field 2" v-model="form.field2" />
        </div>
        <div class="col-md-6">
          <FieldText id="field3" label="Field 3" v-model="form.field3" />
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
    <Link :href="cancelUrl" class="btn btn-outline-dark rounded-pill">Cancelar</Link>
    <button type="submit" class="btn btn-gradient rounded-pill">{{ saving ? 'Guardando...' : 'Guardar' }}</button>
  </div>
</form>
```

### Main + Sidebar
```vue
<form @submit.prevent="submit">
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Datos generales</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <FieldText id="name" label="Nombre" v-model="form.name" />
            </div>
            <div class="col-md-6">
              <FieldTextarea id="description" label="Descripción" v-model="form.description" />
            </div>
            <div class="col-md-6">
              <FieldNumber id="price" label="Precio" v-model="form.price" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Publicación</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <FieldSwitch id="active" label="Activo" v-model="form.is_active" />
            </div>
            <div class="col-12">
              <FieldNumber id="order" label="Orden" v-model="form.sort_order" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
    <Link :href="cancelUrl" class="btn btn-outline-dark rounded-pill">Cancelar</Link>
    <button type="submit" class="btn btn-gradient rounded-pill">{{ saving ? 'Guardando...' : 'Guardar' }}</button>
  </div>
</form>
```
