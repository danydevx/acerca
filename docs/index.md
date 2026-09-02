---
layout: home
title: ORP UI - Mobile-first UI Framework
---

<script setup>
import { ref } from 'vue'
</script>

<div class="orp-home">
  <header class="orp-home__header">
    <h1>ORP UI</h1>
    <p class="orp-home__tagline">Mobile-first UI framework for Vue 3 applications</p>
    <div class="orp-home__actions">
      <a href="/guide/introduction" class="orp-btn orp-btn--primary orp-btn--lg">Get Started</a>
      <a href="/components/" class="orp-btn orp-btn--secondary orp-btn--lg">Components</a>
    </div>
  </header>

  <section class="orp-home__features">
    <div class="orp-home__feature">
      <i class="bi bi-phone"></i>
      <h3>Mobile First</h3>
      <p>Designed for touch interfaces with responsive layouts that adapt seamlessly</p>
    </div>
    <div class="orp-home__feature">
      <i class="bi bi-grid-3x3"></i>
      <h3>CSS First</h3>
      <p>Use as pure CSS primitives or enhanced with Vue components when behavior is needed</p>
    </div>
    <div class="orp-home__feature">
      <i class="bi bi-palette"></i>
      <h3>Themeable</h3>
      <p>CSS variables for runtime theming with light, dark, and custom themes</p>
    </div>
    <div class="orp-home__feature">
      <i class="bi bi-check-circle"></i>
      <h3>Accessible</h3>
      <p>WCAG 2.2 AA compliant with keyboard navigation and ARIA support</p>
    </div>
  </section>

  <section class="orp-home__preview">
    <h2>Components</h2>
    <p>75+ production-ready components for every UI need</p>
    <div class="orp-home__component-grid">
      <span class="orp-chip">Button</span>
      <span class="orp-chip">Card</span>
      <span class="orp-chip">Modal</span>
      <span class="orp-chip">Sheet</span>
      <span class="orp-chip">Drawer</span>
      <span class="orp-chip">Tabs</span>
      <span class="orp-chip">Form Controls</span>
      <span class="orp-chip">Table</span>
      <span class="orp-chip">Notification</span>
      <span class="orp-chip">Toast</span>
      <span class="orp-chip">Video Player</span>
      <span class="orp-chip">...and more</span>
    </div>
  </section>
</div>

<style scoped>
.orp-home {
  max-width: 960px;
  margin: 0 auto;
  padding: var(--orp-space-8);
}

.orp-home__header {
  text-align: center;
  padding: var(--orp-space-8) 0;
}

.orp-home__header h1 {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: var(--orp-space-4);
}

.orp-home__tagline {
  font-size: var(--orp-font-size-xl);
  color: var(--orp-muted-foreground);
  margin-bottom: var(--orp-space-6);
}

.orp-home__actions {
  display: flex;
  gap: var(--orp-space-4);
  justify-content: center;
}

.orp-home__features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: var(--orp-space-6);
  padding: var(--orp-space-8) 0;
}

.orp-home__feature {
  text-align: center;
  padding: var(--orp-space-4);
}

.orp-home__feature i {
  font-size: 2.5rem;
  color: var(--orp-primary);
  margin-bottom: var(--orp-space-3);
}

.orp-home__feature h3 {
  font-size: var(--orp-font-size-lg);
  margin-bottom: var(--orp-space-2);
}

.orp-home__feature p {
  font-size: var(--orp-font-size-sm);
  color: var(--orp-muted-foreground);
}

.orp-home__preview {
  text-align: center;
  padding: var(--orp-space-8);
  background: var(--orp-surface-muted);
  border-radius: var(--orp-radius-lg);
  margin-top: var(--orp-space-6);
}

.orp-home__preview h2 {
  font-size: var(--orp-font-size-2xl);
  margin-bottom: var(--orp-space-2);
}

.orp-home__preview p {
  color: var(--orp-muted-foreground);
  margin-bottom: var(--orp-space-6);
}

.orp-home__component-grid {
  display: flex;
  flex-wrap: wrap;
  gap: var(--orp-space-2);
  justify-content: center;
}
</style>
