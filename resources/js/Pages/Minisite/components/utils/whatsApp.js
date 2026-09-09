export function buildWhatsAppUrl(phone, message = '') {
  if (!phone) return '#'

  const cleanPhone = phone.toString().replace(/\D/g, '')

  const encodedMessage = message ? encodeURIComponent(message) : ''

  const baseUrl = cleanPhone.startsWith('521') || cleanPhone.startsWith('52')
    ? `https://wa.me/${cleanPhone}`
    : `https://wa.me/${cleanPhone}`

  return encodedMessage ? `${baseUrl}?text=${encodedMessage}` : baseUrl
}
