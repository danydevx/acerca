<template>
  <div v-if="activeFields && activeFields.length > 0" class="vcard__fields">
    <template v-for="field in activeFields" :key="field.id">
      <a
        v-if="getActionUrl(field)"
        :href="getActionUrl(field)"
        class="vcard__field"
        :class="{ 'rounded': shape === 'rounded' }"
        target="_blank"
        rel="noopener nofollow"
      >
        <i :class="getFieldIcon(field.field_type_key)"></i>
        <span>{{ field.label || getFieldDisplayValue(field) }}</span>
      </a>
      <div v-else class="vcard__field vcard__field--static" :class="{ 'rounded': shape === 'rounded' }">
        <i :class="getFieldIcon(field.field_type_key)"></i>
        <span>{{ field.label || getFieldDisplayValue(field) }}</span>
      </div>
    </template>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  fields: {
    type: Array,
    default: () => [],
  },
  shape: {
    type: String,
    default: 'rounded',
  },
})

const fieldIcons = {
  website: 'bi-globe',
  link: 'bi-link',
  email: 'bi-envelope',
  phone: 'bi-telephone',
  whatsapp: 'bi-whatsapp',
  instagram: 'bi-instagram',
  facebook: 'bi-facebook',
  linkedin: 'bi-linkedin',
  twitter: 'bi-twitter-x',
  youtube: 'bi-youtube',
  tiktok: 'bi-tiktok',
  spotify: 'bi-spotify',
  github: 'bi-github',
  telegram: 'bi-telegram',
  discord: 'bi-discord',
  paypal: 'bi-paypal',
  venmo: 'bi-credit-card',
  pdf: 'bi-file-pdf',
  address: 'bi-geo-alt',
  note: 'bi-stickies',
}

const activeFields = computed(() => {
  const excludeTypes = ['whatsapp', 'email', 'website', 'link']
  return (props.fields || []).filter(f => f.active !== false && !excludeTypes.includes(f.field_type_key))
})

function getFieldIcon(fieldTypeKey) {
  return fieldIcons[fieldTypeKey] || 'bi-link'
}

function getFieldDisplayValue(field) {
  const config = field.config || {}
  switch (field.field_type_key) {
    case 'website':
    case 'link':
      return config.url || ''
    case 'instagram':
    case 'twitter':
    case 'facebook':
    case 'linkedin':
    case 'tiktok':
    case 'github':
    case 'telegram':
      return config.username || ''
    case 'phone':
    case 'whatsapp':
      return config.phone || ''
    case 'email':
      return config.email || ''
    case 'youtube':
      return config.url || ''
    case 'spotify':
      return config.url || ''
    case 'paypal':
      return config.url || ''
    case 'venmo':
      return config.username || ''
    case 'pdf':
      return config.label || 'PDF'
    case 'address':
      return formatAddress(config)
    case 'note':
      return config.text || ''
    default:
      return ''
  }
}

function formatAddress(config) {
  const parts = [
    config.street,
    config.city,
    config.state,
    config.postal_code,
    config.country,
  ].filter(Boolean)
  return parts.join(', ')
}

function getActionUrl(field) {
  const config = field.config || {}
  switch (field.field_type_key) {
    case 'website':
    case 'link':
      return config.url || null
    case 'instagram':
      return config.username ? `https://instagram.com/${config.username}` : null
    case 'twitter':
      return config.username ? `https://x.com/${config.username}` : null
    case 'facebook':
      return config.username ? `https://facebook.com/${config.username}` : null
    case 'linkedin':
      return config.username ? `https://linkedin.com/in/${config.username}` : null
    case 'tiktok':
      return config.username ? `https://tiktok.com/@${config.username}` : null
    case 'youtube':
      return config.url || null
    case 'spotify':
      return config.url || null
    case 'github':
      return config.username ? `https://github.com/${config.username}` : null
    case 'telegram':
      return config.username ? `https://t.me/${config.username}` : null
    case 'discord':
      return config.invite_url || null
    case 'paypal':
      return config.url || null
    case 'phone':
      return config.phone ? `tel:${config.phone}` : null
    case 'whatsapp':
      return config.phone ? `https://wa.me/${config.phone.replace(/\D/g, '')}` : null
    case 'email':
      return config.email ? `mailto:${config.email}` : null
    case 'pdf':
      return config.file ? `/storage/${config.file}` : null
    default:
      return null
  }
}
</script>

<style scoped>
.vcard__fields {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin: 1.25rem 0 1.5rem;
}

.vcard__field {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.95rem 1rem;
  background: var(--vcard-surface);
  border-radius: 0;
  text-decoration: none;
  color: var(--vcard-text);
  font-size: 0.95rem;
  font-weight: 500;
  transition: all 0.2s;
  box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
  border: 1px solid rgba(15, 23, 42, 0.04);
  min-height: 74px;
  width: 100%;
}

.vcard__field.rounded {
  border-radius: 14px;
}

.vcard__field i {
  font-size: 1.2rem;
  width: 42px;
  height: 42px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: color-mix(in srgb, var(--vcard-primary) 14%, var(--vcard-surface));
  color: var(--vcard-primary);
  border-radius: 12px;
  flex: 0 0 auto;
}

.vcard__field:hover {
  background: var(--vcard-primary);
  color: var(--vcard-surface);
  transform: translateY(-1px);
}

.vcard__field:hover i {
  background: rgba(255, 255, 255, 0.18);
  color: var(--vcard-surface);
}

.vcard__field--static {
  cursor: default;
}

.vcard__field--static:hover {
  background: var(--vcard-surface);
  color: var(--vcard-text);
  transform: none;
}

.vcard__field--static:hover i {
  background: color-mix(in srgb, var(--vcard-primary) 14%, var(--vcard-surface));
  color: var(--vcard-primary);
}
</style>
