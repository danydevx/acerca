# Admin Form Standard Proposal

**Audit Date:** September 9, 2026  
**Purpose:** Establish consistent form patterns across all member area Vue forms

---

## 1. Card Wrapper (MANDATORY)

```html
<div class="card border-0 shadow-sm">
  <div class="card-body">
    <form @submit.prevent="submit">
      <!-- form content -->
    </form>
  </div>
</div>
```

**Rationale:** 95% of forms already use this pattern. Standardize it as required.

---

## 2. Row Gutter Spacing (MANDATORY)

Use `row g-3` for all forms:
```html
<div class="row g-3">
  <div class="col-md-6">
    <!-- field -->
  </div>
</div>
```

**Rationale:** g-3 is used in ~70% of forms. g-4 in ~20%. Standardize on g-3.

---

## 3. Field Components (MANDATORY)

Use FieldText component:
```vue
<FieldText
  id="field-id"
  label="Field Label"
  placeholder="Example placeholder"
  v-model="form.field"
  :formError="form.errors.field"
  required
/>
```

Use FieldTextarea for multi-line:
```vue
<FieldTextarea
  id="field-id"
  label="Field Label"
  placeholder="Example placeholder"
  v-model="form.field"
  :formError="form.errors.field"
  :rows="3"
/>
```

Use FieldSelect for dropdowns:
```vue
<FieldSelect
  id="field-id"
  label="Field Label"
  v-model="form.field"
  :options="fieldOptions"
  :formError="form.errors.field"
/>
```

Use FieldSwitch for toggles:
```vue
<FieldSwitch
  id="field-id"
  label="Field Label"
  v-model="form.field"
  :formError="form.errors.field"
/>
```

**Rationale:** Field components provide consistent validation display and accessibility.

---

## 4. Section Headers (RECOMMENDED)

For grouping related fields:
```html
<h5 class="border-bottom pb-2 mb-3">Section Title</h5>
```

Or with fieldset (best for accessibility):
```html
<fieldset>
  <legend class="h5 border-bottom pb-2 mb-3">Section Title</legend>
  <!-- fields -->
</fieldset>
```

**Rationale:** Properties/Edit.vue uses fieldset/legend which is the most accessible pattern.

---

## 5. Form-Floating Pattern (OPTIONAL)

For modern floating labels:
```html
<div class="form-floating mb-3">
  <input
    type="text"
    class="form-control"
    id="field-id"
    placeholder=" "
    v-model="form.field"
  />
  <label for="field-id">Field Label</label>
</div>
```

**Note:** Only Locations/Create, Locations/Edit, OfficeHours/Create, OfficeHours/Edit, Password/Edit use this pattern. Only use if consistent across all fields in a form.

---

## 6. Required Field Indicators (MANDATORY)

Choose ONE of these patterns:

**Pattern A - Attribute (RECOMMENDED):**
```vue
<FieldText ... required />
```

**Pattern B - Visual Indicator:**
```html
<span class="text-danger">*</span>
```

**Rationale:** Required attribute is the most accessible. Visual asterisk is clear but should be consistent.

---

## 7. Form Error Display (MANDATORY)

Field components handle this automatically when `:formError` prop is passed.

For raw Bootstrap inputs:
```html
<input
  class="form-control"
  :class="{ 'is-invalid': form.errors.field }"
  v-model="form.field"
/>
<div v-if="form.errors.field" class="invalid-feedback">
  {{ form.errors.field }}
</div>
```

---

## 8. Button Styles (MANDATORY)

**Primary Button:**
```html
<button type="submit" class="btn btn-gradient rounded-pill" :disabled="form.processing">
  {{ form.processing ? 'Guardando...' : 'Guardar' }}
</button>
```

**Secondary Button:**
```html
<Link :href="cancelUrl" class="btn btn-outline-dark rounded-pill">
  Cancelar
</Link>
```

**Button Grouping:**
```html
<div class="d-flex gap-2 mt-4">
  <!-- buttons here -->
</div>
```

**Rationale:** ~90% of forms already use this pattern.

---

## 9. FormActions Component (RECOMMENDED)

Instead of manual buttons, use:
```vue
<FormActions
  :submitText="'Guardar'"
  :submittingText="'Guardando...'"
  :cancelHref="cancelUrl"
  :sending="form.processing"
/>
```

**Note:** FormActions does NOT include a form-text helper. The component handles button spacing internally.

---

## 10. PageHeader Component (MANDATORY)

```vue
<PageHeader
  title="Page Title"
  :breadcrumbs="breadcrumbs"
  :backHref="'/member/listings/' + listing.id"
/>
```

**Breadcrumbs format:**
```js
const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Module Name', href: '/member/module-route' },
  { label: 'Page Title', active: true },
])
```

---

## 11. Head Component (MANDATORY)

```vue
<Head :title="`Page Title - ${listing?.name || ''}`" />
```

**Rationale:** 100% of forms use Head component. Ensure title is localized.

---

## 12. Form Layout Pattern

**STANDARD LAYOUT:**
```vue
<template>
  <MemberLayout>
    <Head :title="`Page Title - ${listing?.name || ''}`" />

    <PageHeader
      title="Page Title"
      :breadcrumbs="breadcrumbs"
      :backHref="backUrl"
    />

    <div class="row">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="row g-3">
                <!-- Fields here -->
              </div>

              <FormActions
                :submitText="'Guardar'"
                :submittingText="'Guardando...'"
                :cancelHref="cancelUrl"
                :sending="form.processing"
              />
            </form>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>
```

---

## 13. Responsive Column Pattern

```html
<!-- 2 columns on md+, 1 column on mobile -->
<div class="col-md-6">

<!-- 3 columns on md+, 1 column on mobile -->
<div class="col-md-4">

<!-- Full width -->
<div class="col-12">
```

---

## 14. Switch/Checkbox Pattern

**FieldSwitch Component (RECOMMENDED):**
```vue
<FieldSwitch
  id="toggle-field"
  label="Toggle Label"
  v-model="form.is_active"
/>
<div class="form-text">Helper text here</div>
```

**Raw Bootstrap (if needed):**
```html
<div class="form-check form-switch">
  <input
    class="form-check-input"
    type="checkbox"
    id="toggle-field"
    v-model="form.is_active"
    role="switch"
  />
  <label class="form-check-label" for="toggle-field">
    Toggle Label
  </label>
</div>
```

---

## 15. File Upload Pattern

```html
<div class="mb-3">
  <label class="form-label">Upload Label</label>
  <input
    type="file"
    class="form-control"
    accept="image/jpeg,image/png"
    @change="handleFileChange"
  />
  <div v-if="form.errors.file" class="text-danger small mt-1">
    {{ form.errors.file }}
  </div>
  <div v-if="preview" class="mt-2">
    <img :src="preview" class="img-thumbnail" style="max-height: 200px;" />
  </div>
</div>
```

---

## 16. Form Text / Helper Text

```html
<div class="form-text">Helper text explaining the field</div>
```

**Rationale:** Only ~30% of forms use this consistently. Should be standardized.

---

## 17. Alert Patterns

**Warning Alert:**
```html
<div class="alert alert-warning">
  <strong>Warning:</strong> Alert message here.
</div>
```

**Info Alert:**
```html
<div class="alert alert-info">
  <strong>Info:</strong> Alert message here.
</div>
```

**With Dismiss:**
```html
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  Message here
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
```

---

## 18. Inline Validation Summary

When multiple errors exist:
```html
<div v-if="hasErrors" class="alert alert-danger">
  <strong>Por favor corrige los siguientes errores:</strong>
  <ul class="mb-0">
    <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
  </ul>
</div>
```

---

## 19. Loading States

**Submit Button:**
```html
<button type="submit" class="btn btn-gradient rounded-pill" :disabled="form.processing">
  <span v-if="form.processing">
    <span class="spinner-border spinner-border-sm me-1"></span>
    Guardando...
  </span>
  <span v-else>Guardar</span>
</button>
```

---

## 20. Accessibility Checklist

- [ ] All inputs have unique `id` attributes
- [ ] All labels have `for` attribute matching input `id`
- [ ] Required fields marked with `required` attribute
- [ ] Switches use `role="switch"`
- [ ] Error messages use `.invalid-feedback` class
- [ ] Page has proper `<Head>` title
- [ ] Color is not the only indicator of state (invalid uses border + icon)

---

## Reference Form Candidates

Based on audit, these forms best exemplify the standard:

### BEST OVERALL:
**Properties/Edit.vue** - Uses fieldset/legend, proper section headers, FieldText components, consistent spacing

### GOOD EXAMPLES:
- **TeamMembers/Edit.vue** - Good component usage, proper form structure
- **About/Index.vue** - Good section headers, consistent component usage
- **Services/Create.vue** - Clean form layout, proper Field components

### FORMS NEEDING REFACTORING:
- **AiChatbot/ConfigTab.vue** - Raw Bootstrap only, no card, no PageHeader
- **ClientFidelity/Rewards/Create.vue** - All raw inputs, inconsistent with other forms
- **Webhooks/Index.vue** - No PageHeader, no FormActions, raw inputs

---

## Migration Priority

### HIGH PRIORITY (Inconsistent patterns):
1. AiChatbot/ConfigTab.vue
2. ClientFidelity/Rewards/*.vue
3. Webhooks/Index.vue

### MEDIUM PRIORITY (Minor inconsistencies):
1. Add section headers where missing
2. Standardize button grouping
3. Add form-text helpers

### LOW PRIORITY (Already good):
1. Properties/Edit.vue (reference)
2. TeamMembers/Edit.vue
3. About/Index.vue
