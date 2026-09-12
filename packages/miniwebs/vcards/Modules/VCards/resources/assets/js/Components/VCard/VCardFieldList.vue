<template>
  <section v-if="activeFields && activeFields.length > 0" class="vcard-section vcard-fields">
    <h2 class="vcard-section__title">Redes sociales</h2>
    <div class="vcard__fields">
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
        </a>
        <div
          v-else
          class="vcard__field vcard__field--static"
          :class="{ 'rounded': shape === 'rounded' }"
        >
          <i :class="getFieldIcon(field.field_type_key)"></i>
        </div>
      </template>
    </div>
  </section>
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
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.75rem;
  margin-top: 1rem;
}

.vcard__field {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  background: var(--vcard-primary);
  border-radius: 50%;
  text-decoration: none;
  color: var(--vcard-surface);
  transition: all 0.2s;
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1);
}

.vcard__field i {
  font-size: 1.8rem;
  color: var(--vcard-surface);
}

.vcard__field:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(15, 23, 42, 0.15);
}

.vcard__field--static {
  cursor: default;
}

.vcard__field--static:hover {
  transform: none;
}
</style>
