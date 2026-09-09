# ORP UI — Stage 6: Framework Growth Freeze

## Objective

Freeze speculative growth. From this point forward, new components require real evidence in 2+ contexts.

## Golden Rule

```
DISCOVER
→ CLASSIFY
→ REUSE
→ EXTEND
→ CREATE ONLY IF JUSTIFIED
→ VERIFY
→ DOCUMENT
→ STOP
```

## Component Creation Policy

### When to Create a New Component

A new component should only be created when ALL of these are true:

1. **Real Use Case**: The need is demonstrated by actual product requirements, not speculation
2. **2+ Contexts**: The pattern appears in at least 2 different places in the codebase
3. **Token-Driven**: The component uses existing design tokens, not custom values
4. **Accessible**: The component meets WCAG 2.1 AA requirements
5. **Mobile-First**: Works on mobile screens first, enhanced for desktop

### When NOT to Create a New Component

Do NOT create a new component:

- For parity with other frameworks (Bootstrap, Material, etc.)
- For speculative future needs
- For one-off custom implementations
- When existing components can be composed to achieve the same result

### Component Classification

Before creating, determine the component type:

| Type | Description | Examples |
|------|-------------|----------|
| **Primitive** | Low-level, reusable, no business logic | Button, Input, Badge |
| **Composite** | Built from primitives | Card, Dialog, Dropdown |
| **Pattern** | Business-specific composition | CatalogCard, PricingCard |
| **Page** | Full page sections | Hero, Footer |

### Discovery Process

1. **Search First**: Check if the pattern already exists in:
   - ORP UI components
   - ORP UI primitives
   - Existing compositions in the codebase

2. **Evaluate Existing**:
   - Can the existing component be extended?
   - Can primitives be composed to achieve the same?
   - Is this a variant of an existing pattern?

3. **Document the Decision**:
   - If creating: Document the 2+ contexts that justify it
   - If reusing: Document why existing component is sufficient

## Existing Component Inventory

### Primitives (Stable)
- Button, IconButton
- Input, Textarea, Select
- Checkbox, Radio, Switch
- Badge, Avatar
- Divider
- Stack, Cluster, Grid
- Spinner, Progress, Skeleton

### Composites (Stable)
- Card, Surface
- Modal, Dialog, Sheet, ActionSheet
- Dropdown, Popover, Tooltip
- Toast, Notification
- Tabs, AppBar, BottomNav, Drawer
- Table, DataTable

### Patterns (Stable)
- CatalogCard, PricingCard, ProfileCard
- ContentCard, StatCard, ContactCard
- Alert, EmptyState

### Pages/Sections (Review as Needed)
- Hero, Section, Page
- Media, MediaCard
- Gallery, Map

## Bootstrap Resemblance Rule

All components must maintain **0/3 Bootstrap resemblance**:

1. **Visual**: Different visual treatment (spacing, radius, shadows)
2. **Structural**: Different HTML structure
3. **Behavioral**: Different interaction patterns

## Audit Trail

All component creation decisions must be documented in:

`.opencode/ORPUI/`

Format:
```
COMPONENT-NAME-CREATION.md
```

Content:
- Justification (2+ contexts)
- Alternatives considered
- Token usage
- Accessibility considerations

## Growth Metrics

Track ORP UI growth:

| Metric | Limit |
|--------|-------|
| New Primitives/Quarter | ≤ 2 |
| New Composites/Quarter | ≤ 3 |
| New Patterns/Quarter | ≤ 4 |
| Total Components | No hard limit, justify each |

## Enforcement

Before any new component is added:

1. Create `.opencode/ORPUI/COMPONENT-CREATION.md`
2. Document 2+ real contexts
3. Get approval from ORP maintainer
4. Implement with full tests
5. Add to documentation

## Final Verdict

**FRAMEWORK GROWTH FREEZE ENACTED**

This policy is effective immediately. All new component proposals must demonstrate 2+ real use contexts before implementation.
