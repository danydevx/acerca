# Admin Create/Edit UI Normalization

## Summary of Changes Applied

This document records the normalization changes made to align Create/Edit forms with the UI standard.

---

## Forms Normalized

### 1. TeamMembers/Create.vue ✅
**Issue**: Mixed spacing patterns (`row g-3` + `row g-3 mt-3` + `mb-3 mt-3`)
**Fix Applied**:
- Combined all fields into single `row g-3 mb-3` grid
- Removed redundant `mt-3` and extra `mb-3` wrappers
- Added `col-12` to maintain responsive behavior

**Before**:
```vue
<div class="row g-3">
  <!-- fields -->
</div>
<div class="row g-3 mt-3">
  <!-- more fields -->
</div>
<div class="mb-3 mt-3">
  <!-- textarea -->
</div>
```

**After**:
```vue
<div class="row g-3 mb-3">
  <!-- all fields in grid -->
</div>
```

---

### 2. TeamMembers/Edit.vue ✅
**Issue**: Same as Create - inconsistent spacing between sections
**Fix Applied**: Same pattern as Create

---

### 3. Galleries/Edit.vue ✅
**Issue**: Actions inside grid row, no `mb-3` on outer container
**Fix Applied**:
- Added `mb-3` to outer grid container
- Moved actions outside grid row
- Used standard `d-flex justify-content-end gap-2` pattern

**Before**:
```vue
<form class="row g-3" @submit.prevent="submit">
  <!-- fields -->
  <div class="col-12 d-flex gap-2">
    <!-- actions inside row -->
  </div>
</form>
```

**After**:
```vue
<form @submit.prevent="submit">
  <div class="row g-3 mb-3">
    <!-- fields -->
  </div>
  <div class="d-flex flex-wrap justify-content-end gap-2">
    <!-- actions outside -->
  </div>
</form>
```

---

### 4. Packages/Create.vue ✅
**Issue**: Individual `mb-3` wrappers for each field (not using grid), `hr` + `h5` section separators
**Fix Applied**:
- Converted to `row g-3 mb-3` grid with fields in columns
- Replaced `hr my-4` + `h5` with card sections (`card-header` + `card-body`)
- Reorganized into logical sections: General, WhatsApp, Características

**Before**:
```vue
<div class="mb-3">
  <FieldText />
</div>
<div class="mb-3">
  <FieldText />
</div>
<hr class="my-4">
<h5 class="mb-3">Section</h5>
```

**After**:
```vue
<div class="row g-3 mb-3">
  <div class="col-12"><FieldText /></div>
  <div class="col-12"><FieldText /></div>
</div>
<div class="card mb-4">
  <div class="card-header"><h5 class="mb-0">Section</h5></div>
  <div class="card-body">
    <div class="row g-3 mb-3">
      <!-- fields -->
    </div>
  </div>
</div>
```

---

### 5. Packages/Edit.vue ✅
**Issue**: Same as Create
**Fix Applied**: Same pattern as Create

---

## Forms NOT Normalized (Special Cases)

### ContactForm
- **Reason**: Edit page is a form builder (drag-drop fields, field modal, live preview) - completely different UX from Create
- **Decision**: Skip - these are intentionally different interfaces

### Promotions/MenuProducts
- **Reason**: Already have acceptable action patterns with FormActions + Delete button
- **Decision**: Skip - current pattern is acceptable

---

## Standard Patterns Applied

### Grid Spacing
```vue
<div class="row g-3 mb-3">
  <!-- fields in columns -->
</div>
```

### Card Sections (for complex forms)
```vue
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0">Section Title</h5>
  </div>
  <div class="card-body">
    <div class="row g-3 mb-3">
      <!-- fields -->
    </div>
  </div>
</div>
```

### Actions Layout
```vue
<div class="d-flex flex-wrap justify-content-end gap-2">
  <Link href="..." class="btn btn-outline-dark rounded-pill">Cancelar</Link>
  <button type="submit" class="btn btn-gradient rounded-pill">Guardar</button>
</div>
```

---

## Files Modified

| File | Status | Changes |
|------|--------|---------|
| TeamMembers/Create.vue | ✅ Normalized | Grid spacing |
| TeamMembers/Edit.vue | ✅ Normalized | Grid spacing |
| Galleries/Edit.vue | ✅ Normalized | Grid + actions |
| Packages/Create.vue | ✅ Normalized | Grid + card sections |
| Packages/Edit.vue | ✅ Normalized | Grid + card sections |

## Files Not Modified (Special Cases)

| File | Reason |
|------|--------|
| ContactForm/Create.vue | Simple form, acceptable pattern |
| ContactForm/Edit.vue | Form builder UX, intentionally different |
| Promotions/Edit.vue | Already has acceptable action pattern |
| MenuProducts/Edit.vue | MAIN_SIDEBAR pattern is correct reference |

---

## Verification

All normalized forms pass build verification:
```
npm run build
✓ built in 25.45s
```

---

## Next Steps

If additional normalization is needed:
1. Review other SINGLE_CARD forms for consistent spacing
2. Ensure all forms use `FormActions` component where appropriate
3. Consider adding section cards to forms with 8+ fields
