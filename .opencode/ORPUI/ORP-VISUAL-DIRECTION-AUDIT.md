# ORP UI Visual Direction Audit

## Executive Summary

ORP UI is **largely cohesive** with a solid Default Theme 2026 foundation. Token system is well-implemented with Electric Indigo primary and neutral surfaces. However, several Bootstrap-like signals remain that reduce ORP's visual identity distinctiveness.

**Key Findings:**
- No P0 issues (accessibility/broken behavior)
- Two P1 issues: Badge pill uniformity, Card visual weight
- Several P2 issues: Form input genericness, button proportions, interactive card hover
- Build: ✓ PASS

**Selected Pilot:** CatalogCard Collection

---

## Audit Scope

Visual direction audit of ORP UI framework focusing on Bootstrap resemblance, cohesion, and Default Theme 2026 alignment.

---

## Architecture Baseline

```
Foundation: Tokens, Typography, Visual Helpers ✓
Primitives: Stack, Cluster, Grid, Container, Section, Divider, Card, Media ✓
Components: Button, Input, Badge, Modal, Drawer, Accordion, Skeleton, Progress, Meter ✓
Patterns: CatalogCard, PricingCard, ProfileCard, ContentCard, StatCard, ContactCard ✓
```

---

## Default Theme 2026 Baseline

| Element | Token | Status |
|---------|-------|--------|
| Primary | `--orp-primary: #635bff` (Electric Indigo) | ✓ Implemented |
| Surfaces | near-white/neutral | ✓ Implemented |
| Borders | `--orp-border: #e4e4e7` | ✓ Implemented |
| Radius | sm(6px), md(8px), lg(12px), pill(999px) | ✓ Implemented |
| Shadows | sm, md, lg, dropdown, popover | ✓ Implemented |
| Typography | Inter, 8px scale | ✓ Implemented |

---

## Bootstrap Resemblance Assessment

### Score Key
- 0 = no meaningful resemblance
- 1 = minor generic similarity
- 2 = noticeable Bootstrap/template resemblance
- 3 = strong Bootstrap/template resemblance

### Bootstrap Resemblance Scores

| Area | Score | Finding |
|------|-------|---------|
| Buttons | 2 | Bootstrap-like radius (md) and proportions; primary color gives own identity |
| Forms | 2 | Generic 1px gray input border; Bootstrap-like focus glow with color-mix ring |
| Cards | 2 | All cards use border + shadow + radius; heavy Bootstrap DNA |
| Badges | 3 | ALL badges use pill shape (rounded-full); very Bootstrap-like |
| Modal | 2 | Dialog appearance similar to Bootstrap modals |
| Accordion | 2 | Row-based dividers, similar to Bootstrap accordions |
| Tables | 2 | Border-based rows, similar to Bootstrap tables |
| Patterns | 2 | Card patterns share heavy Bootstrap card DNA |
| **Overall Playground** | **2** | **Noticeable Bootstrap signals in controls and cards** |

### Bootstrap Signals Identified

1. **Badge pill uniformity**: Every badge variant uses `border-radius: var(--orp-radius-pill)` - creates strong Bootstrap badge resemblance
2. **Card visual weight**: Cards combine `border: 1px solid` + `border-radius: lg` + `shadow` simultaneously - classic Bootstrap card look
3. **Form input genericness**: `border: 1px solid var(--orp-input)` with gray color - Bootstrap input DNA
4. **Interactive card hover**: `transform: translateY(-2px)` + `box-shadow: var(--orp-shadow-lg)` - common dashboard template pattern

---

## Cohesion Scores (1-5)

| Area | Score | Finding |
|------|-------|---------|
| Typography cohesion | 4 | Inter font, consistent sizing hierarchy |
| Spacing cohesion | 4 | Token-based (8px rhythm), consistent |
| Control cohesion | 3 | Buttons/inputs share radius (md), but some generic Bootstrap signals |
| Surface cohesion | 4 | Neutral surfaces well-implemented |
| Pattern cohesion | 3 | Cards share similar DNA; distinguishes by purpose appropriately |
| Mobile cohesion | 4 | Mobile-first spacing, adequate responsive behavior |
| Brand cohesion | 4 | Electric Indigo primary used intentionally |
| **Overall visual identity** | **3.5** | **Generally cohesive with room for improvement** |

---

## Page Flow

**Finding**: Playground shows reasonable page flow with Section separations. Typography headings create natural chapters.

**Assessment**: ADEQUATE

---

## Hierarchy

**Finding**: Typography hierarchy uses 4-5 size levels. Weight hierarchy (600 for titles, 500 for body, 400 for meta) is clear.

**Assessment**: ADEQUATE

---

## Grouping

**Finding**: Stack and Cluster primitives handle most grouping. Card overuse is the primary grouping concern.

**Assessment**: NEEDS ATTENTION (P2 - Card overuse in some contexts)

---

## Card Audit

### Current Behavior
- Default Card: `border-radius: lg` + `background: surface` + `overflow: hidden`
- Outlined variant: adds `border: 1px solid var(--orp-border)`
- Raised variant: adds `box-shadow: md` (no border)
- Interactive variant: hover lift with `translateY(-2px)` + `shadow-lg`

### Bootstrap Signal
**Score: 2** - Border + shadow + radius combination is classic Bootstrap card appearance.

### Assessment
```
CARD JUSTIFIED: When content needs clear containment and visual separation from page
SURFACE WOULD BE BETTER: For grouping related content without strong visual separation
PLAIN LAYOUT WOULD BE BETTER: For content with natural visual hierarchy
```

---

## Badge Audit

### Current Behavior
ALL badges use `border-radius: var(--orp-radius-pill)` (full pill shape)

### Bootstrap Signal
**Score: 3** - Strong Bootstrap resemblance. Bootstrap badges are historically pill-shaped.

### P1 Issue: Badge Uniformity
All 8 badge variants (primary, secondary, success, warning, danger, info, outline, solid) use the same pill shape. This reduces flexibility for contexts where a less rounded badge is appropriate.

### Assessment
```
SEMANTICALLY APPROPRIATE: Badge pill shape for category labels
INTERACTION APPROPRIATE: Tags and small labels
DECORATIVE/UNNECESSARY: When badge is used for status rather than category
```

---

## Buttons

### Current Behavior
- Primary: Filled Electric Indigo, `border-radius: md`, 48px height
- Secondary: Gray fill, hover brightens border
- Ghost: Transparent with border
- Danger: Red fill

### Bootstrap Signal
**Score: 2** - Bootstrap-like proportions and radius, but Electric Indigo primary provides own identity.

### Assessment: ADEQUATE (P3 minor polish possible)

---

## Forms

### Current Behavior
- Input: 1px solid gray border, `border-radius: md`, 48px height
- Focus: Primary color ring with `color-mix()` transparency
- Placeholder: Muted foreground color

### Bootstrap Signal
**Score: 2** - Generic gray 1px border similar to Bootstrap forms.

### P2 Issue: Form Input Genericness
The `border: 1px solid var(--orp-input)` uses a neutral gray that lacks visual distinction. Focus ring is good (primary color), but default state is generic.

### Assessment: NEEDS ATTENTION

---

## Typography

### Current Behavior
- Font: Inter (via `--orp-font-family`)
- Sizes: xs(12px), sm(14px), md(16px), lg(18px), xl(24px)
- Weights: 400 (normal), 500 (medium), 600 (semibold), 700 (bold)

### Assessment: GOOD

---

## Spacing

### Current Behavior
Token-based 8px system: space-1(4px) through space-8(48px)

### Assessment: GOOD - Consistent rhythm

---

## Elevation / Shadows

### Current Behavior
- sm: `0 1px 2px 0 rgba(0,0,0,0.04)` - subtle
- md: `0 2px 4px 0 rgba(0,0,0,0.06)` - raised
- lg: `0 4px 12px 0 rgba(0,0,0,0.08)` - overlay
- dropdown/popover: progressively larger

### Assessment: GOOD - Restrained, purposeful

---

## Color / Brand

### Current Behavior
- Primary: Electric Indigo `#635bff` - used for main actions, focus, links
- Semantic: Success (green), Warning (amber), Danger (red), Info (blue)
- Neutral: Near-white surfaces, zinc-like text hierarchy

### Assessment: GOOD - Brand is recognizable, restrained appropriately

---

## Motion

### Current Behavior
- Duration: fast(150ms), normal(200ms), slow(300ms)
- Easing: `cubic-bezier(.2, .8, .2, 1)` (standard)
- Reduced motion: Respected via `prefers-reduced-motion`

### Assessment: GOOD

---

## Accessibility

### Current Behavior
- Focus visible: 2px primary ring with offset
- Color contrast: Muted foreground uses `#71717a` on white
- Touch targets: 48px minimum for controls
- Reduced motion: Respected

### Assessment: GOOD - No P0 accessibility issues

---

## Mobile

### Current Behavior
- Viewport gutters: `--orp-page-padding: 16px`
- Control height: 48px minimum
- Stack/Cluster for responsive composition
- Media queries at standard breakpoints

### Assessment: GOOD

---

## Patterns

### CatalogCard
- Media dominant with 4 aspect ratios
- Title clamp, description clamp
- Actions slot, value slot
- Interactive variant with hover lift

### PricingCard
- Border-based separation (not shadow)
- Centered value hierarchy
- Feature list with check icons
- Emphasized variant with primary border + shadow

### ContentCard
- Border-based (not shadow) - different from CatalogCard
- Eyebrow + title + excerpt + byline
- Horizontal variant

### ProfileCard
- Avatar-based identity
- Status slot
- Compact information layout

### Assessment: ADEQUATE differentiation

---

## Pattern Family Comparison

| Pattern | Surface | Border | Shadow | Radius | Distinction |
|---------|---------|--------|--------|--------|-------------|
| CatalogCard | surface | none | sm | lg | Media dominant |
| PricingCard | surface | 1px | none/md | lg | Value centered |
| ContentCard | surface | 1px | none | lg | Editorial |
| ProfileCard | surface | none | none | varies | Identity |
| StatCard | surface | varies | varies | varies | Metric |

---

## Audit Matrix

| Area | Current behavior | Problem | Bootstrap signal | Severity | Scope |
|------|-----------------|---------|-----------------|----------|-------|
| Badges | All pill-shaped | Limited visual variety | Yes (3) | P1 | Component |
| Cards | Border+shadow+radius | Heavy visual weight | Yes (2) | P1 | Pattern |
| Form inputs | 1px gray border | Generic appearance | Yes (2) | P2 | Component |
| Button proportions | md radius, 48px | Bootstrap-like | Yes (2) | P3 | Component |
| Interactive cards | translateY(-2px) hover | Dashboard template pattern | Yes (2) | P2 | Pattern |
| Play button | `color: #000` hardcoded | Not theme-aware | No | P3 | Component |

---

## P0 Issues

**None** - No accessibility or broken visual behavior found.

---

## P1 Issues

### 1. Badge Uniformity
**Category**: COMPONENT
**Problem**: All badge variants use identical pill shape (rounded-full), reducing flexibility for non-category use cases
**Impact**: Strong Bootstrap badge resemblance (score 3)
**Recommendation**: Consider adding non-pill badge variants (sm, md radius) for status/label contexts

### 2. Card Visual Weight
**Category**: PATTERN
**Problem**: Cards combine border + shadow + radius simultaneously, creating heavy Bootstrap card appearance
**Impact**: Noticeable Bootstrap resemblance across all card patterns
**Recommendation**: Evaluate border-only or shadow-only alternatives for lighter card treatments

---

## P2 Issues

### 3. Form Input Genericness
**Category**: COMPONENT
**Problem**: 1px gray input border lacks visual distinction from Bootstrap
**Recommendation**: Evaluate slightly stronger border or subtle background differentiation

### 4. Interactive Card Hover
**Category**: PATTERN
**Problem**: `translateY(-2px)` + shadow-lg hover is common dashboard template pattern
**Recommendation**: Consider subtler hover treatment (shadow-md only, or subtle background shift)

---

## P3 Issues

### 5. Hardcoded Play Button Color
**Category**: COMPONENT
**Problem**: `color: #000` in `.orp-card__play-btn`
**Recommendation**: Use token-based color

### 6. Button Primary Dependence
**Category**: CONTROL
**Problem**: Some screens have multiple equally loud filled primary buttons
**Recommendation**: Ensure button hierarchy (primary vs secondary vs ghost) is clearly communicated

---

## System-Level Recommendations

1. **Radius Token Policy**: Document when to use pill vs md vs lg radius to prevent uniform pill usage
2. **Card Composition Guide**: Provide guidance on border-only vs shadow-only vs border+shadow treatments
3. **Form Visual Distinction**: Ensure inputs have sufficient visual weight to not look generic

---

## Component-Level Recommendations

1. **Badge**: Add non-pill radius variants (sm, md) for status contexts
2. **Card**: Review interactive hover treatment for less dashboard-template appearance
3. **Input**: Evaluate subtle background or border differentiation

---

## Pattern-Level Recommendations

1. **CatalogCard**: Consider border-only option alongside shadow treatment
2. **PricingCard**: Already uses border-only appropriately
3. **ContentCard**: Already uses border-only appropriately

---

## Recommended Remediation Order

```
1. FLOW/HIERARCHY - No major issues found
2. LAYOUT - Adequate
3. SPACING - Adequate
4. TYPOGRAPHY - Adequate
5. TOKENS: Radius policy - Document badge radius usage
6. TOKENS: Card composition - Guide border/shadow usage
7. CONTROLS: Badge - Add non-pill variants
8. CONTROLS: Input - Subtle visual differentiation
```

---

## Selected Visual Pilot

**CatalogCard Collection**

### Why This Pilot

1. **Exposes multiple ORP primitives**: Stack, Grid, Media, Badge, Button
2. **Visibly suffers from current issues**: Heavy shadow treatment, pill badges on media overlays
3. **Representative**: Other cards would benefit similarly from visual refresh
4. **Low risk**: Playground-only change, no application impact yet
5. **Mobile + desktop**: Shows grid behavior at multiple breakpoints
6. **Demonstrates direction**: Would show whether reducing shadow/border improves or worsens appearance

### Pilot Success Criteria

- [ ] Less Bootstrap card resemblance (score should drop from 2 to 1)
- [ ] Clearer hierarchy without heavy shadow
- [ ] Better mobile composition at 320-430px
- [ ] Consistent with PricingCard and ContentCard visual approach
- [ ] Badge pill usage only where semantically appropriate
- [ ] Existing ORP API preserved
- [ ] Accessibility preserved (focus, contrast)

---

## Build

**Result**: ✓ PASS

---

## Tests

No test failures recorded.

---

## Console

Not inspected (Playground code review only).

---

## Final Verdict

```
VISUAL DIRECTION READY FOR PILOT
```

---

## Next Phase

```
NEXT PHASE:
ORP VISUAL PILOT REDESIGN — CatalogCard Collection
```

The P1 issues (Badge uniformity, Card visual weight) and P2 issues (Form genericness, Interactive hover) should be addressed in the pilot redesign. The pilot will validate whether the recommended direction improves ORP's visual distinctiveness while maintaining Default Theme 2026 principles.

---

**Report**: `.opencode/ORPUI/ORP-VISUAL-DIRECTION-AUDIT.md`