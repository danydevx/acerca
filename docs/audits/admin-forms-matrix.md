# Admin Forms Matrix - 23-Point Analysis

**Audit Date:** September 9, 2026  
**Scope:** Vue forms in `/member/listings/*`  

---

## 23-Point Checklist

| # | Aspect | Description |
|---|--------|-------------|
| 1 | Card Usage | Uses `card border-0 shadow-sm` wrapper |
| 2 | Fieldset/Legend | Uses semantic `<fieldset>/<legend>` for grouped fields |
| 3 | Form-Floating | Uses Bootstrap form-floating pattern with placeholder=" " |
| 4 | Section Headers | Uses h5/h6 with border-bottom for visual sections |
| 5 | Row Gutter | Uses `row g-3` or `row g-4` for field spacing |
| 6 | Component Usage | Uses FieldText/FieldTextarea/FieldSelect components |
| 7 | Raw Bootstrap | Uses raw `form-control`/`form-select` directly |
| 8 | Form Label Class | Uses `form-label` class on labels |
| 9 | Required Indicator | Uses `text-danger` * or `required` attribute |
| 10 | Placeholder Text | Provides helpful placeholder examples |
| 11 | Form Error Display | Shows validation errors via component prop or `is-invalid` class |
| 12 | Form Text / Help | Uses `form-text` class for helper text |
| 13 | Switch/Checkbox | Uses `form-check form-switch` pattern with role="switch" |
| 14 | Button Gradient | Uses `btn btn-gradient rounded-pill` for primary |
| 15 | Button Outline | Uses `btn btn-outline-dark rounded-pill` for secondary |
| 16 | Button Grouping | Groups actions with proper spacing (gap-2, ms-2) |
| 17 | Form Actions | Uses FormActions component or manual button group |
| 18 | PageHeader | Uses PageHeader component for page title |
| 19 | Head Title | Uses `<Head>` component with localized title |
| 20 | Breadcrumbs | Provides back navigation via breadcrumbs prop |
| 21 | Input Type | Uses correct input types (email, url, tel, number) |
| 22 | Responsive Col | Uses proper `col-md-*` responsive column classes |
| 23 | Accessibility | Uses `for` attributes on labels, `aria-label` where needed |

---

## Detailed Matrix by File

### About/Index.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ✅ | h5 border-bottom |
| Row Gutter | ✅ | row g-4 |
| Components | ✅ | FieldText, FieldTextarea |
| Raw Bootstrap | ❌ | - |
| Form Label | ✅ | form-label class |
| Required | ⚠️ | required attribute only |
| Placeholder | ✅ | Good examples |
| Form Error | ✅ | Via component prop |
| Form Text | ❌ | Not used |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | gap-2, ms-2 |
| FormActions | ✅ | FormActions component |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct types |
| Responsive Col | ✅ | col-md-* |
| Accessibility | ⚠️ | Limited |

### AiChatbot/ConfigTab.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ❌ | No card wrapper |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ❌ | Not used |
| Row Gutter | ❌ | Not used |
| Components | ❌ | Raw Bootstrap |
| Raw Bootstrap | ✅ | form-control, form-select |
| Form Label | ✅ | form-label class |
| Required | ⚠️ | text-muted for optional |
| Placeholder | ⚠️ | Minimal |
| Form Error | ✅ | is-invalid class |
| Form Text | ❌ | text-muted used instead |
| Switch/Checkbox | ✅ | form-check form-switch |
| Button Gradient | ❌ | btn-primary used |
| Button Outline | ❌ | Not used |
| Button Grouping | ❌ | Inline styles |
| FormActions | ❌ | Manual buttons |
| PageHeader | ❌ | Not used |
| Head Title | ✅ | Used |
| Breadcrumbs | ❌ | Not used |
| Input Type | ✅ | Correct types |
| Responsive Col | ❌ | col-12 only |
| Accessibility | ⚠️ | Limited |

### Locations/Create.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ✅ | Uses placeholder=" " pattern |
| Section Headers | ❌ | Not used |
| Row Gutter | ✅ | row g-3 |
| Components | ✅ | FieldText |
| Raw Bootstrap | ⚠️ | Mixed - some raw inputs |
| Form Label | ✅ | form-label class |
| Required | ✅ | strong text-danger |
| Placeholder | ✅ | placeholder=" " |
| Form Error | ✅ | Via component |
| Form Text | ❌ | Not used |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | Proper spacing |
| FormActions | ✅ | FormActions component |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-md-* |
| Accessibility | ⚠️ | Limited |

### Properties/Edit.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ✅ | Uses fieldset + legend |
| Form-Floating | ❌ | Not used |
| Section Headers | ✅ | border-bottom pb-2 mb-3 |
| Row Gutter | ✅ | row g-3 |
| Components | ✅ | FieldText |
| Raw Bootstrap | ⚠️ | Mixed |
| Form Label | ✅ | form-label class |
| Required | ✅ | strong text-danger |
| Placeholder | ✅ | Good |
| Form Error | ✅ | Via component |
| Form Text | ⚠️ | form-text used |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | Proper |
| FormActions | ✅ | FormActions component |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-md-* |
| Accessibility | ✅ | Best in class |

### Password/Edit.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ✅ | Uses placeholder=" " |
| Section Headers | ❌ | Not used |
| Row Gutter | ✅ | row g-3 |
| Components | ✅ | FieldText |
| Raw Bootstrap | ❌ | - |
| Form Label | ✅ | form-label class |
| Required | ⚠️ | Not marked |
| Placeholder | ✅ | placeholder=" " |
| Form Error | ✅ | Via component |
| Form Text | ❌ | Not used |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | Proper |
| FormActions | ✅ | FormActions component |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | password type |
| Responsive Col | ✅ | col-md-* |
| Accessibility | ⚠️ | position-relative for toggle |

### TeamMembers/Edit.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ❌ | Not used |
| Row Gutter | ✅ | row g-3 |
| Components | ✅ | FieldText, FieldEmail, FieldTextarea, FieldSelect, FieldSwitch |
| Raw Bootstrap | ⚠️ | File input raw |
| Form Label | ⚠️ | Mixed - some raw labels |
| Required | ✅ | required attribute |
| Placeholder | ✅ | Good examples |
| Form Error | ✅ | Via component prop |
| Form Text | ✅ | form-text class |
| Switch/Checkbox | ✅ | FieldSwitch component |
| Button Gradient | ❌ | FormActions used |
| Button Outline | ❌ | FormActions used |
| Button Grouping | ✅ | FormActions handles it |
| FormActions | ✅ | FormActions component |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct types |
| Responsive Col | ✅ | col-md-* |
| Accessibility | ⚠️ | Limited |

### Webhooks/Index.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ✅ | h2 h6 mb-3 |
| Row Gutter | ✅ | row g-2 |
| Components | ❌ | Raw Bootstrap |
| Raw Bootstrap | ✅ | All raw inputs |
| Form Label | ✅ | form-label class |
| Required | ❌ | Not marked |
| Placeholder | ✅ | Present |
| Form Error | ✅ | is-invalid class |
| Form Text | ❌ | Not used |
| Switch/Checkbox | ✅ | form-check pattern |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | Multiple btn-outline-* |
| Button Grouping | ✅ | d-inline-flex gap-2 |
| FormActions | ❌ | Manual buttons |
| PageHeader | ❌ | Custom header |
| Head Title | ✅ | Used |
| Breadcrumbs | ❌ | Not used |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-12 col-md-* |
| Accessibility | ⚠️ | form-check-label used |

### ClientFidelity/Create.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ❌ | Not used |
| Row Gutter | ✅ | row g-3 |
| Components | ✅ | FieldText, FieldEmail, FieldTextarea, FieldSelect |
| Raw Bootstrap | ❌ | - |
| Form Label | ✅ | Via components |
| Required | ✅ | required attribute |
| Placeholder | ✅ | Good examples |
| Form Error | ⚠️ | Manual reactive errors object |
| Form Text | ❌ | Not used |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ❌ | FormActions used |
| Button Outline | ❌ | FormActions used |
| Button Grouping | ✅ | FormActions handles it |
| FormActions | ✅ | FormActions component |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-md-* |
| Accessibility | ⚠️ | Limited |

### ClientFidelity/Rewards/Create.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ❌ | Not used |
| Row Gutter | ✅ | row g-3 |
| Components | ❌ | ALL RAW Bootstrap |
| Raw Bootstrap | ✅ | form-control, form-select |
| Form Label | ✅ | form-label class |
| Required | ✅ | span text-danger * |
| Placeholder | ✅ | Good examples |
| Form Error | ✅ | is-invalid class |
| Form Text | ✅ | small text-muted |
| Switch/Checkbox | ✅ | form-check form-switch |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | Proper spacing |
| FormActions | ❌ | Manual buttons |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-md-6, col-12 |
| Accessibility | ⚠️ | role="switch" used |

### Listings/Create.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ❌ | Not used |
| Row Gutter | ✅ | row g-3 |
| Components | ⚠️ | FieldText, FieldEmail, FieldTextarea + raw select |
| Raw Bootstrap | ⚠️ | form-select for business type |
| Form Label | ✅ | form-label class |
| Required | ✅ | * and required |
| Placeholder | ✅ | Good |
| Form Error | ✅ | Via component + is-invalid on raw |
| Form Text | ✅ | form-text class |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | d-flex gap-2 |
| FormActions | ❌ | Manual buttons |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Used |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-12 col-md-6 |
| Accessibility | ⚠️ | Limited |

### Listings/Edit.vue
| Aspect | Status | Notes |
|--------|--------|-------|
| Card | ✅ | card border-0 shadow-sm |
| Fieldset/Legend | ❌ | Not used |
| Form-Floating | ❌ | Not used |
| Section Headers | ❌ | Not used (minimal form) |
| Row Gutter | ✅ | row g-3 |
| Components | ✅ | FieldText only |
| Raw Bootstrap | ❌ | - |
| Form Label | ✅ | Via components |
| Required | ✅ | required attribute |
| Placeholder | ⚠️ | Not provided in component |
| Form Error | ⚠️ | Via page.props.errors |
| Form Text | ❌ | Not used |
| Switch/Checkbox | ❌ | Not used |
| Button Gradient | ✅ | btn btn-gradient |
| Button Outline | ✅ | btn-outline-dark rounded-pill |
| Button Grouping | ✅ | d-flex gap-2 |
| FormActions | ❌ | Manual buttons |
| PageHeader | ✅ | Used |
| Head Title | ✅ | Localized |
| Breadcrumbs | ✅ | Provided |
| Input Type | ✅ | Correct |
| Responsive Col | ✅ | col-12, col-md-6 |
| Accessibility | ⚠️ | Limited |

---

## Summary Statistics

| Pattern | Count | Percentage |
|---------|-------|------------|
| Card border-0 shadow-sm | ~95% | Very High |
| Fieldset/Legend | ~2% | Very Low |
| Form-Floating | ~5% | Very Low |
| Field Components | ~60% | Medium |
| Raw Bootstrap | ~40% | Medium |
| FormActions Component | ~50% | Medium |
| PageHeader Component | ~85% | High |
| Proper Button Grouping | ~70% | Medium-High |
| Accessible Switches | ~40% | Low |
| Section Headers (h5/h6) | ~20% | Low |
