# Admin Create/Edit UI Audit

## Audit Objective

Analyze and document all Create/Edit form layouts in `/member/` to identify inconsistencies and propose a unified visual grammar.

**Scope**: Layout patterns, card usage, grid systems, spacing, section organization, and action positioning.

**Out of Scope**: Field components internal implementation (FieldText, FieldSelect, etc.)

---

## Create/Edit Files Found: 36

| Category | Count | Files |
|----------|-------|-------|
| Create forms | 18 | Products, Services, Locations, Packages, Reviews, Faqs, OfficeHours, TeamMembers, Promotions, Properties, MenuProducts, Clients, Galleries, ContactForm, Leads, ClientFidelity/Rewards, Appointments, Projects |
| Edit forms | 18 | Same modules as Create |

---

## Layout Patterns Found

### 1. FLAT / SINGLE_CARD (29 forms)

Basic structure:
```vue
<form>
  <div class="card">
    <div class="card-body">
      <div class="row g-3">
        <!-- Fields -->
      </div>
    </div>
  </div>
  <FormActions />
</form>
```

**Examples**: Products, Services, Locations, Packages, Reviews, Faqs, OfficeHours, TeamMembers, Promotions, Clients, Galleries, Leads, Appointments, Projects, ClientFidelity/Rewards

### 2. MULTI_CARD (2 forms)

Structure with multiple cards:
```vue
<form>
  <div class="card">Section 1</div>
  <div class="card">Section 2</div>
  <FormActions />
</form>
```

**Examples**: Properties/Create, ContactForm/Edit

### 3. MAIN_SIDEBAR (2 forms)

Two-column layout:
```vue
<form>
  <div class="row">
    <div class="col-lg-8">
      <div class="card">Main content</div>
    </div>
    <div class="col-lg-4">
      <div class="card">Sidebar</div>
    </div>
  </div>
</form>
```

**Examples**: MenuProducts/Create, MenuProducts/Edit

### 4. FIELDSETS (1 form)

Uses semantic fieldset/legend:
```vue
<form>
  <fieldset>
    <legend>Section Name</legend>
    <div class="row g-3">
      <!-- Fields -->
    </div>
  </fieldset>
</form>
```

**Example**: Properties (Create + Edit)

---

## Visual Problems Identified

### Problem 1: Inconsistent Spacing Within Rows

**Issue**: Some forms use `row g-3` without additional spacing, others add `mb-3` to the row.

**Affected**:
- `row g-3 mb-3`: Products, Promotions, Appointments, Leads, Projects (13 forms)
- `row g-3`: Services, Locations, Faqs, OfficeHours, Clients (9 forms)
- `row g-3` + nested `mb-3`: Packages (redundant wrappers)

**Recommendation**: Standardize on `row g-3 mb-3` for outer container.

### Problem 2: Mixed mt-3 and mb-3 in TeamMembers

**Issue**: TeamMembers uses both `mt-3` and `mb-3` inconsistently between sections.

**Current (Create)**:
```vue
<div class="row g-3">
  <!-- section 1 fields -->
</div>
<div class="mb-3 mt-3">
  <!-- section 2 fields -->
</div>
```

**Recommendation**: Use consistent spacing pattern with `mb-4` between logical sections.

### Problem 3: Packages Redundant Wrappers

**Issue**: Packages wraps each field in `mb-3` inside a `row g-3`, which is redundant.

**Current**:
```vue
<div class="row g-3 mb-3">
  <div class="col-md-6">
    <div class="mb-3">
      <FieldText />
    </div>
  </div>
</div>
```

**Recommendation**: Remove inner `mb-3` wrappers since `g-3` handles spacing.

### Problem 4: Galleries/Edit No Grid

**Issue**: Galleries/Edit places fields directly without using the grid system.

**Current**:
```vue
<div class="mb-3">
  <FieldText />
</div>
<div class="mb-3">
  <FieldText />
</div>
```

**Recommendation**: Wrap in `row g-3` grid.

### Problem 5: ContactForm Create vs Edit完全不同

**Issue**: ContactForm/Create is SINGLE_CARD, ContactForm/Edit is MULTI_CARD with sidebar.

**Create**:
```vue
<div class="card">
  <div class="card-body">
    <div class="mb-3"><FieldTextarea /></div>
  </div>
</div>
```

**Edit**:
```vue
<div class="row">
  <div class="col-lg-6"><!-- fields --></div>
  <div class="col-lg-6"><!-- preview --></div>
</div>
```

**Recommendation**: Use consistent layout for both.

### Problem 6: Inconsistent Action Patterns

| Pattern | Forms |
|---------|-------|
| FormActions bottom (standard) | Most forms |
| FormActions inside row | Leads, Appointments, Reviews |
| FormActions + Delete split | Promotions/Edit, MenuProducts/Edit |
| inline custom buttons | Locations, Faqs, ClientFidelity/Rewards |

**Issue**: Actions appear in different positions and styles.

**Recommendation**: Standardize to:
```vue
<div class="d-flex flex-wrap justify-content-between gap-2 mt-4">
  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-gradient">Guardar</button>
    <Link class="btn btn-outline-dark">Cancelar</Link>
  </div>
  <button type="button" class="btn btn-outline-danger">Eliminar</button>
</div>
```

### Problem 7: No Visual Section Grouping in Most Forms

**Issue**: Forms with 10+ fields dump all fields sequentially without visual breaks.

**Example**: Services has ~15 fields in a single row g-3 without section breaks.

**Recommendation**: For forms with 8+ fields, group into logical sections with card headers:
```vue
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
```

---

## Reference Candidates

### Best Single-Card Pattern: Products

**Why**: Clean `row g-3 mb-3`, consistent spacing, FormActions at bottom, no redundant wrappers.

```vue
<form @submit.prevent="submit">
  <div class="card">
    <div class="card-body">
      <div class="row g-3 mb-3">
        <div class="col-12 col-md-8">
          <FieldText />
        </div>
        <div class="col-12 col-md-4">
          <FieldSelect />
        </div>
      </div>
    </div>
  </div>
  <FormActions submit-text="Crear" submitting-text="Guardando..." />
</form>
```

### Best with Sections: Packages

**Why**: Uses `hr my-4` and `h5` to visually separate logical sections (WhatsApp, Características).

### Most Complex (Needs Sidebar): MenuProducts

**Why**: Clear main/sidebar separation with `col-lg-8` for main content and `col-lg-4` for publication controls.

---

## Create/Edit Consistency Issues

| Module | Issue |
|--------|-------|
| TeamMembers | Different spacing between Create/Edit |
| Galleries | Create uses FormActions, Edit uses inline buttons |
| ContactForm | Completely different layouts |
| Promotions | Edit adds Delete button (should be consistent) |
| MenuProducts | Edit adds Delete button (should be consistent) |

---

## Summary Statistics

| Metric | Value |
|--------|-------|
| Total Create/Edit forms | 36 |
| SINGLE_CARD layout | 29 (80%) |
| MULTI_CARD layout | 2 (6%) |
| MAIN_SIDEBAR layout | 2 (6%) |
| Uses Fieldset | 1 (3%) |
| Uses FormActions component | 31 (86%) |
| Uses custom inline buttons | 7 (19%) |
| Has spacing inconsistencies | 5 (14%) |
| Create/Edit are inconsistent | 5 (14%) |

---

## Key Recommendations

1. **Standardize on `row g-3 mb-3`** for single-card forms
2. **Remove redundant `mb-3` wrappers** inside grid columns
3. **TeamMembers needs refactoring** to fix spacing
4. **ContactForm needs unified layout** for Create and Edit
5. **Galleries/Edit needs grid system**
6. **Actions should follow standard pattern** with FormActions or consistent custom layout
7. **Forms with 8+ fields should use section cards** with headers
