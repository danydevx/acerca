<template>
  <div class="stat-card" :class="variant">
    <div class="stat-icon-wrapper">
      <div class="stat-icon">
        <i :class="icon"></i>
      </div>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ value }}</div>
      <div class="stat-label">{{ label }}</div>
    </div>
    <div v-if="trend" class="stat-trend" :class="trendClass">
      <i :class="trendIcon"></i>
      {{ trend }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  icon: {
    type: String,
    required: true,
  },
  value: {
    type: [String, Number],
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  variant: {
    type: String,
    default: 'primary',
  },
  trend: {
    type: String,
    default: null,
  },
  trendDirection: {
    type: String,
    default: 'up',
  },
  iconSize: {
    type: String,
    default: '2rem',
  },
})

const trendClass = computed(() => {
  if (!props.trend) return ''
  return props.trendDirection === 'up' ? 'trend-up' : 'trend-down'
})

const trendIcon = computed(() => {
  return props.trendDirection === 'up' ? 'bi bi-arrow-up' : 'bi bi-arrow-down'
})
</script>

<style scoped>
.stat-card {
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: 1rem;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  transition: all 0.2s ease;
  position: relative;
  overflow: hidden;
  height: 100%;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--stat-color-start), var(--stat-color-end));
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.stat-icon-wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.stat-icon {
  width: 3.5rem;
  height: 3.5rem;
  border-radius: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: v-bind(iconSize);
}

.stat-card.primary {
  --stat-color-start: #2020F8;
  --stat-color-end: #8F62F7;
}

.stat-card.primary .stat-icon {
  background: linear-gradient(135deg, rgba(32, 32, 248, 0.15), rgba(143, 98, 247, 0.15));
  color: #2020F8;
}

.stat-card.success {
  --stat-color-start: #10B981;
  --stat-color-end: #34D399;
}

.stat-card.success .stat-icon {
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
  color: #10B981;
}

.stat-card.warning {
  --stat-color-start: #F59E0B;
  --stat-color-end: #FBBF24;
}

.stat-card.warning .stat-icon {
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.15));
  color: #F59E0B;
}

.stat-card.danger {
  --stat-color-start: #EF4444;
  --stat-color-end: #F87171;
}

.stat-card.danger .stat-icon {
  background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.15));
  color: #EF4444;
}

.stat-card.info {
  --stat-color-start: #8F62F7;
  --stat-color-end: #A78BFA;
}

.stat-card.info .stat-icon {
  background: linear-gradient(135deg, rgba(143, 98, 247, 0.15), rgba(167, 139, 250, 0.15));
  color: #8F62F7;
}

.stat-card.secondary {
  --stat-color-start: #6B7280;
  --stat-color-end: #9CA3AF;
}

.stat-card.secondary .stat-icon {
  background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(156, 163, 175, 0.15));
  color: #6B7280;
}

.stat-content {
  flex: 1;
}

.stat-value {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--bs-body-color);
  line-height: 1.1;
}

.stat-label {
  font-size: 0.875rem;
  color: var(--bs-secondary-color);
  margin-top: 0.25rem;
}

.stat-trend {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  border-radius: 0.5rem;
}

.stat-trend.trend-up {
  background: rgba(16, 185, 129, 0.1);
  color: #10B981;
}

.stat-trend.trend-down {
  background: rgba(239, 68, 68, 0.1);
  color: #EF4444;
}
</style>
