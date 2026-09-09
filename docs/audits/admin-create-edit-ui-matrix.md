# Admin Create/Edit UI Matrix

## Overview

| Form | Layout | Cards | Fieldsets | Sidebar | Grid | Actions | Status |
|------|--------|-------|----------|---------|------|---------|--------|
| Products/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions bottom | GOOD |
| Products/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions bottom | GOOD |
| Services/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | GOOD |
| Services/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | GOOD |
| Locations/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | inline custom | MINOR |
| Locations/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 | inline custom | MINOR |
| Packages/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 (nested) | FormActions bottom | MINOR |
| Packages/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 (nested) | FormActions bottom | MINOR |
| Reviews/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions inside row | MINOR |
| Reviews/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions inside row | MINOR |
| Faqs/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | inline custom | MINOR |
| Faqs/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 | inline custom | MINOR |
| OfficeHours/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | GOOD |
| OfficeHours/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | GOOD |
| TeamMembers/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 + mt-3 | FormActions bottom | INCONSISTENT |
| TeamMembers/Edit | SINGLE_CARD | 1 | 0 | NO | mb-3 mt-3 mixed | FormActions bottom | INCONSISTENT |
| Promotions/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions bottom | GOOD |
| Promotions/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | split (FormActions + Delete) | MINOR |
| Properties/Create | MULTI_CARD | 2 | YES | NO | row g-3 | FormActions bottom | REFERENCE |
| Properties/Edit | SINGLE_CARD | 1 | YES | NO | row g-3 | FormActions bottom | GOOD |
| MenuProducts/Create | MAIN_SIDEBAR | 2 | 0 | YES col-lg-8/4 | container-fluid + row | FormActions bottom | GOOD |
| MenuProducts/Edit | MAIN_SIDEBAR | 2 | 0 | YES col-lg-8/4 | container-fluid + row | split (FormActions + Delete) | MINOR |
| Clients/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | GOOD |
| Clients/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | GOOD |
| Galleries/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | FormActions bottom | MINOR |
| Galleries/Edit | SINGLE_CARD | 1 | 0 | NO | NO GRID (mb-3 only) | inline custom | LEGACY |
| ContactForm/Create | SINGLE_CARD | 1 | 0 | NO | NO GRID (mb-3 only) | FormActions bottom | MINOR |
| ContactForm/Edit | MULTI_CARD | 2 | 0 | YES col-lg-6/6 | NO GRID | NO FormActions (builder) | INCONSISTENT |
| Leads/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions inside row | GOOD |
| Leads/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions inside row | GOOD |
| ClientFidelity/Rewards/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 | inline custom | MINOR |
| ClientFidelity/Rewards/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 | inline custom | MINOR |
| Appointments/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions inside row | GOOD |
| Appointments/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions inside row | GOOD |
| Projects/Create | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions bottom | GOOD |
| Projects/Edit | SINGLE_CARD | 1 | 0 | NO | row g-3 mb-3 | FormActions bottom | GOOD |

## Status Legend

| Status | Count | Description |
|--------|-------|-------------|
| REFERENCE | 1 | Best practice, use as reference |
| GOOD | 15 | Follows standard patterns closely |
| MINOR | 14 | Has minor issues, mostly acceptable |
| INCONSISTENT | 3 | Has inconsistencies that need fixing |
| LEGACY | 1 | Uses old patterns, needs update |

## Layout Distribution

| Layout Type | Count | Forms |
|-------------|-------|-------|
| SINGLE_CARD | 29 | Products, Services, Locations, Packages, Reviews, Faqs, OfficeHours, TeamMembers, Promotions, Clients, Galleries, Leads, Appointments, Projects, ClientFidelity/Rewards |
| MULTI_CARD | 2 | Properties/Create, ContactForm/Edit |
| MAIN_SIDEBAR | 2 | MenuProducts/Create, MenuProducts/Edit |

## Actions Pattern Distribution

| Pattern | Count | Forms |
|---------|-------|-------|
| FormActions bottom | 22 | Products, Services, OfficeHours, Promotions, Clients, Leads, Appointments, Projects, Packages, Reviews |
| FormActions inside row | 4 | Leads, Appointments, Reviews |
| FormActions bottom + Delete | 2 | Promotions/Edit, MenuProducts/Edit |
| inline custom buttons | 7 | Locations, Faqs, ClientFidelity/Rewards, Galleries/Edit |
| NO FormActions | 1 | ContactForm/Edit (uses custom builder) |

## Grid Pattern Distribution

| Pattern | Count | Forms |
|---------|-------|-------|
| row g-3 mb-3 | 13 | Products, Promotions, Appointments, Leads, Projects |
| row g-3 | 9 | Services, Locations, Faqs, OfficeHours, Clients, TeamMembers |
| row g-3 + nested mb-3 | 2 | Packages (redundant) |
| NO GRID (mb-3 only) | 2 | ContactForm/Create, Galleries/Edit |
| container-fluid + row | 2 | MenuProducts |
| row g-3 + mt-3 mixed | 1 | TeamMembers (inconsistent) |

## Inconsistencies Between Create/Edit

| Module | Create/Edit Difference |
|--------|----------------------|
| TeamMembers | Different spacing patterns, different form approaches |
| Galleries | Create uses FormActions, Edit uses inline custom |
| ContactForm | Different layouts entirely (single vs multi-card with sidebar) |
| Promotions | Edit adds Delete button |
| MenuProducts | Edit adds Delete button |

## Recommended Priority for Normalization

1. **HIGH** - TeamMembers (spacing inconsistencies)
2. **HIGH** - ContactForm (completely different layouts)
3. **MEDIUM** - Galleries/Edit (no grid, custom buttons)
4. **MEDIUM** - Packages (redundant mb-3 wrappers)
5. **LOW** - Promotions/MenuProducts Edit (Delete button vs not)
