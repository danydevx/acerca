<script setup>
import { ref } from 'vue'

const showMobileMenu = ref(false)
</script>

<template>
  <div class="orp-docs-layout">
    <header class="orp-docs-header">
      <div class="orp-docs-header__inner">
        <a href="/" class="orp-docs-logo">
          <img src="/orp-ui-logo.svg" alt="ORP UI" width="32" height="32" />
          <span class="orp-docs-logo__text">ORP UI</span>
        </a>
        
        <nav class="orp-docs-nav">
          <a href="/guide/introduction">Guide</a>
          <a href="/foundations/colors">Foundations</a>
          <a href="/components/">Components</a>
          <a href="/utilities/">Utilities</a>
          <a href="/integrations/">Integrations</a>
        </nav>

        <button 
          class="orp-docs-mobile-toggle" 
          @click="showMobileMenu = !showMobileMenu"
          aria-label="Toggle menu"
        >
          <i class="bi bi-list" v-if="!showMobileMenu"></i>
          <i class="bi bi-x-lg" v-else></i>
        </button>
      </div>
    </header>

    <div class="orp-docs-mobile-menu" v-if="showMobileMenu">
      <a href="/guide/introduction" @click="showMobileMenu = false">Guide</a>
      <a href="/foundations/colors" @click="showMobileMenu = false">Foundations</a>
      <a href="/components/" @click="showMobileMenu = false">Components</a>
      <a href="/utilities/" @click="showMobileMenu = false">Utilities</a>
      <a href="/integrations/" @click="showMobileMenu = false">Integrations</a>
    </div>

    <div class="orp-docs-content">
      <Content />
    </div>

    <footer class="orp-docs-footer">
      <p>ORP UI - Mobile-first UI Framework</p>
      <p class="orp-docs-footer__copyright">MIT License</p>
    </footer>
  </div>
</template>

<style scoped>
.orp-docs-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.orp-docs-header {
  position: sticky;
  top: 0;
  z-index: 100;
  background: var(--orp-surface);
  border-bottom: 1px solid var(--orp-border);
  padding: var(--orp-space-3) var(--orp-space-4);
}

.orp-docs-header__inner {
  display: flex;
  align-items: center;
  gap: var(--orp-space-4);
  max-width: 1440px;
  margin: 0 auto;
}

.orp-docs-logo {
  display: flex;
  align-items: center;
  gap: var(--orp-space-2);
  text-decoration: none;
  color: var(--orp-surface-foreground);
  font-weight: 600;
  font-size: var(--orp-font-size-lg);
}

.orp-docs-nav {
  display: flex;
  gap: var(--orp-space-4);
  margin-left: auto;
}

.orp-docs-nav a {
  color: var(--orp-muted-foreground);
  text-decoration: none;
  font-size: var(--orp-font-size-sm);
  transition: color var(--orp-duration-fast);
}

.orp-docs-nav a:hover {
  color: var(--orp-surface-foreground);
}

.orp-docs-mobile-toggle {
  display: none;
  background: none;
  border: none;
  font-size: var(--orp-font-size-xl);
  color: var(--orp-surface-foreground);
  cursor: pointer;
}

.orp-docs-mobile-menu {
  display: none;
  flex-direction: column;
  gap: var(--orp-space-2);
  padding: var(--orp-space-4);
  background: var(--orp-surface);
  border-bottom: 1px solid var(--orp-border);
}

.orp-docs-content {
  flex: 1;
  max-width: 1440px;
  margin: 0 auto;
  padding: var(--orp-space-6) var(--orp-space-4);
  width: 100%;
}

.orp-docs-footer {
  padding: var(--orp-space-6) var(--orp-space-4);
  text-align: center;
  border-top: 1px solid var(--orp-border);
  color: var(--orp-muted-foreground);
  font-size: var(--orp-font-size-sm);
}

.orp-docs-footer__copyright {
  margin-top: var(--orp-space-2);
  opacity: 0.7;
}

@media (max-width: 768px) {
  .orp-docs-nav {
    display: none;
  }

  .orp-docs-mobile-toggle {
    display: block;
    margin-left: auto;
  }

  .orp-docs-mobile-menu {
    display: flex;
  }
}
</style>
