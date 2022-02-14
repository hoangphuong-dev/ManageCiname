/**
 * Convert Date object to ISO string
 *
 * @param {Date} dt
 * @returns {string} YYYY-MM-DDTHH:II:SSZ
 */
export function datetimeToISO(dt) {
  return dt.toJSON().replace(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.*)Z$/, '$1-$2-$3T$4:$5:$6Z')
}

/**
 * Convert Date object to ISO string with date only
 *
 * @param {Date} d
 * @returns {string} YYYY-MM-DD
 */
export function dateToISO(d) {
  return d.toJSON().replace(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.*)Z$/, '$1-$2-$3')
}

/**
 * Convert date string to locale string with locale timezone
 *
 * @param {string} time
 * @param {string|undefined} locale
 */
export function formatDate(date, locale = undefined) {
  return new Date(date).toLocaleDateString(locale)
}

/**
 * Convert datetime string to locale string with locale timezone
 *
 * @param {string} datetime
 * @param {string|undefined} locale
 */
export function formatDateTime(dt, locale = undefined) {
  let options = {
    hour12: false,
    formatMatcher: 'basic',
    year: 'numeric',
    month: 'numeric',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
  }

  return new Date(dt).toLocaleString(locale, options)
}

/**
 * Convert Date object to Locale string
 *
 * @param {Date} dt
 * @returns {string} YYYY-MM-DDTHH:II:SSZ
 */
export function datetimeToLocale(dt) {
  var newDT = new Date(dt.getTime() - dt.getTimezoneOffset() * 60 * 1000)
  return newDT.toJSON().replace(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.*)Z$/, '$1-$2-$3T$4:$5')
}

/**
 * Convert Date object to Date Locale string
 *
 * @param {Date} dt
 * @returns {string} YYYY-MM-DDTHH:II:SSZ
 */
export function datetimeToDateLocale(dt) {
  var newDT = new Date(dt.getTime() - dt.getTimezoneOffset() * 60 * 1000)
  return newDT.toJSON().replace(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.*)Z$/, '$1-$2-$3')
}

/**
 * Convert Date object to Time Locale string
 *
 * @param {Date} dt
 * @returns {string} YYYY-MM-DDTHH:II:SSZ
 */
export function datetimeToTimeLocale(dt) {
  var newDT = new Date(dt.getTime() - dt.getTimezoneOffset() * 60 * 1000)
  return newDT.toJSON().replace(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.*)Z$/, '$4:$5:$6')
}

export function isSameOrBefore($dt, $before = 'now') {
  if ($before === 'now') {
    return Date.now() <= Date.parse($dt)
  }

  return Date.parse($before) <= Date.parse($dt)
}

export function getTimezone() {
  return Intl.DateTimeFormat().resolvedOptions().timeZone
}
