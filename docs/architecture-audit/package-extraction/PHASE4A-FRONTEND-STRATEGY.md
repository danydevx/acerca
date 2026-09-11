# PHASE 4A — FRONTEND STRATEGY

## Current State: NOT Module-Aware

### Key Findings from Analysis

1. **vite-module-loader.js exists but is DEAD CODE**
   - Located at `/desarrollo/server/laravel/laravel-acerca/vite-module-loader.js`
   - Only `VCards` module uses it
   - Main vite.config.js does NOT use it

2. **Hardcoded entry points in vite.config.js**
   ```javascript
   input: [
       'resources/scss/admin/admin.scss',
       'resources/less/minisite.less',
       'resources/js/app.js',
       // ...
   ]
   ```

3. **Module assets manually imported in app.js**
   - Only `VCards` and `Analytics` are imported
   - Other modules with assets are NOT imported

4. **No monorepo/workspace config**
   - Each module has package.json but they're standalone
   - No dependency sharing between modules

5. **Fuzzy page resolution**
   - `import.meta.glob` scans all modules at compile time
   - Priority not configurable

---

## Multi-Product Frontend Strategy

### Option A: Single Bundle (Current, not module-aware)

**Pros**: Simple, proven
**Cons**: Ships all module code regardless of installation

**Verdict**: NOT SUITABLE for multi-product

---

### Option B: Per-Product Builds + Lazy Loading (Recommended)

Each product defines which modules it needs at build time.

```javascript
// miniwebs-saas/vite.config.js
import { defineConfig } from 'vite'
import laravel from 'vite-plugin-laravel'
import { viteDefaults } from './vite-module-loader.js'

export default defineConfig({
    plugins: [
        laravel(),
        viteDefaults()
    ],
    build: {
        rollupOptions: {
            input: {
                app: './resources/js/app.js',
                minisite: './resources/js/minisite.js',
            }
        }
    }
})
```

Product-specific bundles include only installed module assets.

---

### Option C: NPM Workspace Monorepo

```
miniwebs-monorepo/
├── packages/
│   ├── core/
│   ├── minisite/
│   ├── catalog/
│   └── ...
├── products/
│   ├── miniwebs-saas/
│   ├── invitations-saas/
│   └── realestate-saas/
├── package.json (workspace root)
└── pnpm-workspace.yaml
```

**Pros**: Shared node_modules, unified build
**Cons**: Complex setup, all products must build together

**Verdict**: OVERKILL for this use case

---

## Recommended: Option B with Package Assets

### How it works:

1. **Package delivers frontend assets via Composer**
   ```
   vendor/miniwebs/catalog/
   ├── composer.json
   ├── src/
   └── resources/
       └── assets/
           ├── js/
           └── scss/
   ```

2. **Product's vite.config.js discovers and includes**
   ```javascript
   import { discoverModuleAssets } from './vite-module-loader.js'

   const moduleAssets = discoverModuleAssets([
       'miniwebs/core',
       'miniwebs/catalog',
       'miniwebs/appointments'
   ])

   export default defineConfig({
       build: {
           input: {
               app: './resources/js/app.js',
               ...moduleAssets.inputs
           }
       }
   })
   ```

3. **Module assets auto-published on composer install**
   ```bash
   # In miniwebs/catalog package post-install script
   "scripts": {
       "post-install-cmd": [
           "php artisan module:publish-assets ListingProducts",
           "php artisan module:publish-assets ListingServices"
       ]
   }
   ```

---

## Vite Module Loader Enhancement

The existing `vite-module-loader.js` needs to be:

1. **Integrated into main vite.config.js** (currently dead code)
2. **Extended to support Composer package discovery**
3. **Made to auto-discover module inputs from vendor/

```javascript
// vite-module-loader.js - enhanced version
import { glob } from 'glob'
import { readFileSync } from 'fs'
import { resolve } from 'path'

export function discoverModuleAssets(enabledPackages) {
    const inputs = {}

    for (const pkg of enabledPackages) {
        const pkgPath = resolveVendorPath(pkg)

        // Discover JS entry points
        const jsFiles = glob.sync(`${pkgPath}/resources/assets/js/**/*.js`)
        for (const file of jsFiles) {
            const name = getEntryName(file, pkg)
            inputs[name] = file
        }

        // Discover SCSS/LESS
        const styleFiles = glob.sync(`${pkgPath}/resources/assets/{scss,less}/**/*.{scss,less}`)
        for (const file of styleFiles) {
            const name = getEntryName(file, pkg)
            inputs[name] = file
        }
    }

    return { inputs, aliases: generateAliases(enabledPackages) }
}

function resolveVendorPath(pkg) {
    // Resolve to vendor/miniwebs/catalog
    return require.resolve(pkg).replace(/\\/g, '/').replace(/\/composer\/.*$/, '')
}
```

---

## Vue Component Strategy

### Module-owned Vue components

Modules deliver components via:
1. **Inertia page discovery** (existing, works)
2. **Manual component import** (needed for shared components)

```javascript
// In product's app.js
import { ModuleComponents } from '@miniwebs/core'

// Auto-discover all module Vue components
const moduleComponents = import.meta.glob('vendor/miniwebs/*/resources/assets/js/Components/**/*.vue')
for (const [path, component] of Object.entries(moduleComponents)) {
    const name = path.split('/').pop().replace('.vue', '')
    app.component(name, component.default)
}
```

---

## Migration Path

### Phase 1: Enable vite-module-loader (non-breaking)

```javascript
// vite.config.js - current
export default defineConfig({
    plugins: [laravel()],
    build: {
        input: [/* hardcoded */]
    }
})

// vite.config.js - after
import { viteDefaults } from './vite-module-loader.js'

export default defineConfig({
    plugins: [
        laravel(),
        viteDefaults() // Adds module discovery
    ],
    build: {
        input: [/* still hardcoded for now */]
    }
})
```

### Phase 2: Convert module assets to discovered inputs

Gradually migrate from hardcoded to discovered.

### Phase 3: Add Composer package discovery

Enhance vite-module-loader to scan vendor/ directory.

---

## CSS/Asset Strategy

### Current: Global LESS/SCSS files

```less
// resources/less/minisite.less
@import "modules/listingabout.less";
@import "modules/listingcontactform.less";
// Manually added per module
```

### Recommended: Module-delivered assets

```less
// In miniwebs/minisite/resources/assets/less/listingabout.less
.listing-about {
    // Module-specific styles
}
```

Product's main.less imports what it needs:
```less
@import "vendor/miniwebs/minisite/resources/assets/less/listingabout.less";
@import "vendor/miniwebs/minisite/resources/assets/less/listingfaqs.less";
```

---

## Summary

| Aspect | Current | Recommended |
|--------|---------|-------------|
| Module asset discovery | Manual import (2 modules) | Auto-discover via vite-module-loader |
| Bundle strategy | Single bundle (all) | Per-product bundles |
| Package assets | Not supported | Composer delivers assets |
| Vue components | Fuzzy glob | Explicit registration |
| Monorepo | None | Not needed |

**Key action**: Integrate `vite-module-loader.js` into main vite.config.js and enhance it to support Composer package discovery.
