# ORP Minisite Asset Isolation Plan

**Date:** 2026-09-02  
**Status:** IN PROGRESS

---

## Root Cause

The public minisite Blade template uses `app.js` which imports Bootstrap CSS:

```php
<!-- resources/views/minisite.blade.php -->
@vite(['resources/less/minisite.less', 'resources/js/app.js'])
```

```js
// resources/js/app.js (line 1)
import 'bootstrap/dist/css/bootstrap.min.css'
```

Additionally, `minisite.js` exists but ALSO imports Bootstrap:

```js
// resources/js/minisite.js (lines 1-3)
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap'
```

---

## Current Asset Graph

### Public Minisite Route: `/b/{slug}`
- Route handled by: `HandleInertiaRequests::rootView()` returns `minisite.minisite`
- Blade: `resources/views/minisite.blade.php`
- Current Vite entry: `app.js` ❌ PROBLEM
- Imports: Bootstrap CSS, Bootstrap Icons, Bootstrap JS

### Admin/Member Routes: `/member/*`, `/admin/*`
- Blade: `resources/views/app.blade.php`
- Current Vite entry: `app.js`
- Imports: Bootstrap CSS, Bootstrap Icons, Bootstrap JS

---

## Required Fix

### 1. Create Clean Minisite Entry

Create `resources/js/minisite-orp.js` WITHOUT Bootstrap:

```js
// NO Bootstrap imports
import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import Toastify from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

import './@core/vee-validate'
import { formatPriceDirective } from './@core/directives'

createInertiaApp({
    resolve: async (name) => {
        const pagePath = name.replace(/\./g, '/')
        const pages = import.meta.glob('./Pages/**/*.vue')
        if (pages[`./Pages/${pagePath}.vue`]) {
            return await pages[`./Pages/${pagePath}.vue`]()
        }
        return await pages[`./Pages/${pagePath}.vue`]()
    },
    setup({ el, App, props, plugin }) {
        const pinia = createPinia()
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(formatPriceDirective)
            .use(Toastify, { position: 'top-right', duration: 4000, theme: 'colored' })
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
    defaults: { prefetch: { hoverDelay: 75 } },
    progress: { color: '#0d6efd' },
})
```

### 2. Update minisite.less

Add ORP UI CSS import:

```less
@import 'orp-ui/orp-ui.less';

// ... existing minisite styles
```

### 3. Update minisite.blade.php

```php
@vite([
    'resources/less/minisite.less',
    'resources/js/minisite-orp.js'
])
```

### 4. Update vite.config.js

Add the new entry:

```js
input: [
    // ... existing entries
    'resources/js/minisite-orp.js',
]
```

---

## Files to Modify

| File | Change |
|------|--------|
| `resources/js/minisite-orp.js` | CREATE - Clean entry without Bootstrap |
| `resources/less/minisite.less` | ADD - Import ORP UI CSS |
| `resources/views/minisite.blade.php` | UPDATE - Use minisite-orp.js |
| `vite.config.js` | UPDATE - Add minisite-orp.js entry |

---

## After Fix - Expected Assets

### Public Minisite `/b/{slug}`
| Asset | Status |
|-------|--------|
| Bootstrap CSS | ABSENT |
| Bootstrap JS | ABSENT |
| admin.css | ABSENT |
| minisite.less (with ORP) | PRESENT |
| minisite-orp.js | PRESENT |
| ORP UI CSS | PRESENT |
| Bootstrap Icons | PRESENT (if needed) |

### Admin `/member/*`
| Asset | Status |
|-------|--------|
| Bootstrap CSS | PRESENT |
| admin.less | PRESENT |
| app.js | PRESENT |

---

## Verification

1. Build: `npm run build`
2. Check HTML of `/b/{slug}` for:
   - `bootstrap` absent in CSS links
   - `minisite-orp` present
   - `orp-ui` present
3. Check HTML of `/member/*` still has Bootstrap

---

## Risk Assessment

- **LOW** - We are NOT removing Bootstrap from admin, only isolating it from minisite
- **LOW** - Creates new entry, doesn't modify existing working code paths
- **MEDIUM** - Need to verify minisite functionality works without Bootstrap JS

---

## Notes

- Bootstrap Icons can remain as ORP uses them as integration
- Leaflet CSS may be conditionally loaded only when map is present
- GLightbox CSS may be conditionally loaded only when gallery is present
