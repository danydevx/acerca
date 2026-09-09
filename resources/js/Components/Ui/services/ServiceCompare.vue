<template>
  <div class="service-compare" :class="[`service-compare--${variant}`]">
    <div class="service-compare__header" v-if="title">
      <h3 class="service-compare__title">{{ title }}</h3>
      <p v-if="description" class="service-compare__description">{{ description }}</p>
    </div>

    <div class="service-compare__table">
      <div class="service-compare__head">
        <div class="service-compare__feature-col"></div>
        <div
          v-for="item in items"
          :key="item.id"
          class="service-compare__item-col"
          :class="{ 'is-featured': item.featured }"
        >
          <div v-if="item.badge" class="service-compare__badge">{{ item.badge }}</div>
          <h4 class="service-compare__item-name">{{ item.name }}</h4>
          <div class="service-compare__item-price">
            <span class="service-compare__price-value">{{ formatPrice(item.price) }}</span>
            <span v-if="item.period" class="service-compare__price-period">/{{ item.period }}</span>
          </div>
          <button
            class="service-compare__item-action"
            :class="item.featured ? 'is-primary' : ''"
            type="button"
            @click="$emit('select', item)"
          >
            {{ item.action_label || 'Elegir' }}
          </button>
        </div>
      </div>

      <div class="service-compare__body">
        <div
          v-for="feature in features"
          :key="feature.id"
          class="service-compare__row"
        >
          <div class="service-compare__feature-col">
            <span class="service-compare__feature-name">{{ feature.name }}</span>
            <span v-if="feature.description" class="service-compare__feature-desc">{{ feature.description }}</span>
          </div>

          <div
            v-for="item in items"
            :key="item.id"
            class="service-compare__value-col"
          >
            <template v-if="feature.values && feature.values[item.id] !== undefined">
              <span v-if="typeof feature.values[item.id] === 'boolean'">
                <i :class="feature.values[item.id] ? 'bi bi-check-lg' : 'bi bi-x-lg'" class="has-text-success"></i>
              </span>
              <span v-else-if="feature.values[item.id].icon" class="service-compare__icon-value">
                <i :class="feature.values[item.id].icon"></i>
                {{ feature.values[item.id].label }}
              </span>
              <span v-else>{{ feature.values[item.id] }}</span>
            </template>
            <span v-else class="service-compare__dash">—</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  title: String,
  description: String,
  items: {
    type: Array,
    default: () => [],
  },
  features: {
    type: Array,
    default: () => [],
  },
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'minimal', 'cards'].includes(v),
  },
})

defineEmits(['select'])

const formatPrice = (value) => {
  return new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
  }).format(value)
}
</script>

<style lang="scss" scoped>
.service-compare {
  &__header {
    margin-bottom: 1.5rem;
    text-align: center;
  }

  &__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0 0 0.25rem;
  }

  &__description {
    font-size: 0.9375rem;
    color: var(--bulma-text-weak);
    margin: 0;
  }

  &__table {
    background: var(--bulma-scheme-main);
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius-large);
    overflow: hidden;
  }

  &__head {
    display: grid;
    grid-template-columns: 1fr repeat(var(--items-count, 3), 1fr);
    background: var(--bulma-scheme-main-bis);
    border-bottom: 1px solid var(--bulma-border);
  }

  &__feature-col {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__item-col {
    padding: 1.25rem 1rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    border-left: 1px solid var(--bulma-border);
    position: relative;

    &.is-featured {
      background: color-mix(in oklch, var(--bulma-link) 5%, var(--bulma-scheme-main));
    }
  }

  &__badge {
    position: absolute;
    top: -1px;
    left: 50%;
    transform: translateX(-50%);
    padding: 0.25rem 0.75rem;
    background: var(--bulma-link);
    color: var(--bulma-link-invert);
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 0 0 var(--bulma-radius-small) var(--bulma-radius-small);
  }

  &__item-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--bulma-text);
    margin: 0.5rem 0 0;
  }

  &__item-price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.125rem;
  }

  &__price-value {
    font-size: 1.375rem;
    font-weight: 800;
    color: var(--bulma-success);
  }

  &__price-period {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__item-action {
    margin-top: 0.25rem;
    padding: 0.5rem 1.25rem;
    border: 1px solid var(--bulma-border);
    border-radius: var(--bulma-radius);
    background: transparent;
    color: var(--bulma-text);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;

    &:hover {
      border-color: var(--bulma-link);
      color: var(--bulma-link);
    }

    &.is-primary {
      background: var(--bulma-link);
      border-color: var(--bulma-link);
      color: var(--bulma-link-invert);

      &:hover {
        background: var(--bulma-link-hover);
      }
    }
  }

  &__body {
    //
  }

  &__row {
    display: grid;
    grid-template-columns: 1fr repeat(var(--items-count, 3), 1fr);
    border-bottom: 1px solid var(--bulma-border);

    &:last-child {
      border-bottom: none;
    }

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }
  }

  &__feature-col {
    padding: 0.875rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
  }

  &__feature-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bulma-text);
  }

  &__feature-desc {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
  }

  &__value-col {
    padding: 0.875rem 1rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    border-left: 1px solid var(--bulma-border);
    font-size: 0.875rem;
    color: var(--bulma-text);
  }

  &__icon-value {
    display: flex;
    align-items: center;
    gap: 0.25rem;

    i {
      font-size: 1rem;
    }
  }

  &__dash {
    color: var(--bulma-border);
  }

  &--minimal {
    .service-compare__table {
      border: none;
      border-radius: 0;
      background: transparent;
    }

    .service-compare__head,
    .service-compare__row {
      background: var(--bulma-scheme-main);
      border: 1px solid var(--bulma-border);
      border-radius: var(--bulma-radius);
    }

    .service-compare__head {
      border-radius: var(--bulma-radius) var(--bulma-radius) 0 0;
    }

    .service-compare__row {
      border-top: none;
      border-radius: 0;
    }

    .service-compare__row:last-child {
      border-radius: 0 0 var(--bulma-radius) var(--bulma-radius);
    }
  }

  &--cards {
    .service-compare__table {
      display: none;
    }

    .service-compare__head {
      display: none;
    }
  }
}
</style>
