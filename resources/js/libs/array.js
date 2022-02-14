// ====================================================================================
// Array utilities
// ====================================================================================

/**
 * Detect variable is array
 *
 * @param {mixed} value
 * @returns {boolean}
 */
export function isArray(value) {
  return Array.isArray(value)
  // return Object.prototype.toString.call(value) === '[object Array]'
}

/**
 * Check array includes value
 *
 * @param {Array} array
 * @param {any} value
 * @returns {boolean}
 */
export function arrayIncludes(array, value) {
  return array.indexOf(value) !== -1
}

// /**
//  * Concat list
//  *
//  * @param  {...string} args
//  * @returns {string}
//  */
// export function concat(...args) {
//   return Array.prototype.concat.apply([], args)
// }

/**
 * Get unique elements of the array
 *
 * @param {Array} array
 * @returns {Array}
 */
export function unique(array) {
  return array.filter((el, index, arr) => index === arr.indexOf(el))
}

/**
 * Wrapper value to array
 *
 * @param {Array|any} value
 * @returns {Array}
 */
export function arrayWrap(value) {
  return isArray(value) ? value : [value]
}
