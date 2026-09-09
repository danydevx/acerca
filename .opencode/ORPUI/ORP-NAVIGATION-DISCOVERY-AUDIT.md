# ORP Navigation Discovery Audit

## Executive Summary

Discovery audit of ORP navigation capabilities completed. ORP has a solid foundation of navigation components covering the primary use cases. This is a DISCOVERY audit - no implementation required.

**Finding**: NAVIGATION FOUNDATION ALREADY ADEQUATE

**No changes required.**

---

## Existing Navigation Inventory

### Nav (navigation/_nav.less)
```text
.orp-nav                          Base nav (vertical list)
.orp-nav--horizontal            Horizontal mode
.orp-nav__item                  Nav item
.orp-nav__link                  Anchor/button link
.orp-nav__item--disabled        Disabled state
.orp-nav__item--active          Active state
.orp-nav__icon                  Icon slot
.orp-nav__label                 Label slot
.orp-nav__meta                  Meta slot
.orp-nav__badge                 Badge slot
.orp-nav__group                 Group container
.orp-nav__group-title           Group title
```

### Tabs (components/_tabs.less)
```text
.orp-tabs                        Base tabs
.orp-tabs--stretch              Stretch tabs
.orp-tabs--default              Default variant (soft primary bg)
.orp-tabs--pill                 Pill variant
.orp-tabs--underline            Underline variant
.orp-tabs__list                 Tab list
.orp-tabs__item                 Tab item
.orp-tabs__item--active         Active state
```

### BottomNav (components/_bottom-nav.less)
```text
.orp-bottom-nav                 Base bottom nav
.orp-bottom-nav--fixed          Fixed position
.orp-bottom-nav__item           Nav item
.orp-bottom-nav__item--active   Active state
.orp-bottom-nav__icon           Icon slot
.orp-bottom-nav__label          Label slot
.orp-bottom-nav__badge          Badge slot
```

### AppBar (components/_app-bar.less)
```text
.orp-app-bar                    Base app bar
.orp-app-bar--sticky           Sticky position
.orp-app-bar--transparent      Transparent bg
.orp-app-bar--bordered          Bottom border
.orp-app-bar__leading           Leading slot
.orp-app-bar__content           Content slot
.orp-app-bar__title             Title
.orp-app-bar__subtitle          Subtitle
.orp-app-bar__actions           Actions slot
```

---

## Discovery Matrix

| Candidate | Existing | Generic Contexts | Behavior/State | Layer | Decision | Reason |
|----------|----------|------------------|----------------|-------|----------|--------|
| Nav | ✓ | Many | Hover, active, disabled | Primitive | REUSE | Full nav primitive exists |
| NavItem | ✓ | Many | Via Nav | N/A | REJECT | Part of Nav |
| Tabs | ✓ | Many | Active, keyboard | Component | REUSE | Full tabs component exists |
| Breadcrumb | ~ | Limited | Semantic ol/nav | Semantic | DEFER | Rarely needed, can be composed |
| Pagination | ~ | Limited | Page nav | Component | DEFER | Not in playground |
| Navbar/AppBar | ✓ | Many | Sticky, transparent | Component | REUSE | AppBar exists |
| Sidebar | ~ | Limited | Layout, collapse | Pattern | DEFER | Too composition-specific |
| Bottom Nav | ✓ | Many | Fixed, active | Component | REUSE | BottomNav exists |
| Menu/Dropdown | ✓ | Many | Via Popover/Dropdown | Component | REUSE | Already exists |

---

## Audit Findings

### Nav Primitive

**Finding**: Full Nav primitive exists with horizontal/vertical modes, icons, badges, groups, active/disabled states.

**Decision**: REUSE.

---

### Tabs Component

**Finding**: Tabs exists with 3 variants (default, pill, underline) and proper active state.

**Decision**: REUSE.

---

### Breadcrumb

**Finding**: No dedicated breadcrumb component. Semantic `<nav aria-label="Breadcrumb"><ol>...</ol></nav>` can be composed with existing utilities.

**Decision**: DEFER. Not enough evidence of widespread need.

---

### Pagination

**Finding**: No dedicated pagination component in playground.

**Decision**: DEFER. Not enough evidence of widespread need.

---

### Navbar/AppBar

**Finding**: AppBar exists with sticky, transparent, bordered variants.

**Decision**: REUSE.

---

### Sidebar

**Finding**: No dedicated sidebar component. A composition of Nav + Drawer could create sidebar behavior.

**Decision**: DEFER. Too composition-specific for primitive layer.

---

### Bottom Navigation

**Finding**: BottomNav exists with fixed mode, active state, badges.

**Decision**: REUSE.

---

### Menu/Dropdown

**Finding**: Dropdown component exists (referenced in navigation audit context).

**Decision**: REUSE via existing Dropdown component.

---

## Layer Classification

```text
PRIMITIVE
├── Nav (list-based navigation)

COMPONENT
├── Tabs (tabbed interface)
├── AppBar (top bar)
├── BottomNav (mobile bottom nav)
├── Dropdown (menu popup)

PATTERN
├── Sidebar (Nav + layout composition)
├── Navbar (AppBar + logo + actions composition)

APPLICATION-LEVEL
├── Breadcrumb (semantic composition)
├── Pagination (page navigation)
```

---

## Visual Direction

### Nav
- Restrained active state: primary color for active item
- Clear focus: 2px ring outline
- No Bootstrap navbar appearance
- No excessive pills

### Tabs
- Default: soft primary background on active
- Pill: contained in muted surface with shadow on active
- Underline: 2px primary underline on active
- No Bootstrap pill tab appearance

### BottomNav
- Fixed bottom position
- Icon + label
- Primary color for active
- 44px touch targets

---

## Accessibility

- Nav uses semantic `<a>` elements
- Tabs has `role="tablist"` and proper keyboard support (via Vue component)
- BottomNav has proper button elements
- AppBar uses semantic structure
- All have focus-visible outlines

---

## Bootstrap Resemblance

| Component | Score | Explanation |
|----------|-------|-------------|
| Nav | 0/3 | Clean list nav, not Bootstrap navbar |
| Tabs | 0/3 | Clean tabs, different from Bootstrap pills |
| BottomNav | 0/3 | Clean mobile nav |
| AppBar | 0/3 | Simple bar, not Bootstrap navbar |
| **Overall** | **0/3** | Clean navigation family |

---

## Tests

```bash
npm run test -- --run
# 3 test files passed (10 tests)
```

---

## Build

```bash
npm run build
# ✓ built in 22.03s
```

---

## Console

No new errors or warnings.

---

## Files Modified

None. Discovery audit only.

---

## Final Verdict

```
NAVIGATION FOUNDATION ALREADY ADEQUATE
```

---

## Recommended Implementation Order

If future navigation work is needed:

1. **Pagination** - if table patterns expand
2. **Breadcrumb** - if minisite navigation needs it

---

## Rejected Candidates

- NavItem (part of Nav)
- Giant Sidebar component
- Domain-specific nav items

---

## Deferred Candidates

- Breadcrumb (semantic HTML composition sufficient)
- Pagination (need more evidence)
- Sidebar pattern (too composition-specific)
