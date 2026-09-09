export function formatPrice(amount, currency = 'USD') {
  if (amount === null || amount === undefined) return ''
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency,
  }).format(amount)
}

export function formatDuration(minutes) {
  if (!minutes) return ''
  if (minutes < 60) return `${minutes}min`
  const hours = Math.floor(minutes / 60)
  const mins = minutes % 60
  return mins > 0 ? `${hours}h ${mins}min` : `${hours}h`
}

export function formatDate(date, locale = 'es-ES') {
  if (!date) return ''
  return new Intl.DateTimeFormat(locale, {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(new Date(date))
}

export function formatRelativeTime(date, locale = 'es-ES') {
  if (!date) return ''
  const now = new Date()
  const target = new Date(date)
  const diffMs = now - target
  const diffMins = Math.floor(diffMs / 60000)
  const diffHours = Math.floor(diffMs / 3600000)
  const diffDays = Math.floor(diffMs / 86400000)

  if (diffMins < 1) return 'ahora'
  if (diffMins < 60) return `hace ${diffMins}min`
  if (diffHours < 24) return `hace ${diffHours}h`
  if (diffDays < 7) return `hace ${diffDays}d`
  return formatDate(date, locale)
}