// ====================================================================================
// Object utilities
// ====================================================================================

/**
 * Detect variable is object
 *
 * @param {mixed} value
 * @returns {boolean}
 */
export function isObject(value) {
  return value !== null && typeof value === 'object'
}

/**
 * Detect variable is plain object
 *
 * @param {mixed} value
 * @returns {boolean}
 */
export function isPlainObject(value) {
  return Object.prototype.toString.call(value) === '[object Object]'
}

/**
 * Check object has key
 *
 * @param {object} obj
 * @param {string} key
 * @returns {boolean}
 */
export function objHasKey(obj, key) {
  return Object.prototype.hasOwnProperty.call(obj, key)
}
