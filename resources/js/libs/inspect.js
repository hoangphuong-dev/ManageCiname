import { isArray } from './array'
import { isObject, isPlainObject } from './object'

/**
 * Detect variable is undefined
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isUndefined(value) {
  return typeof value === 'undefined'
}

/**
 * Detect variable is defined
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isDefined(value) {
  return typeof value !== 'undefined'
}

/**
 * Detect variable is string
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isString(value) {
  return typeof value === 'string'
}

/**
 * Detect variable is number
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isNumber(value) {
  return typeof value === 'number'
}

/**
 * Detect variable is boolean
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isBoolean(value) {
  return typeof value === 'boolean'
}

/**
 * Detect variable is function
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isFunction(value) {
  return typeof value === 'function'
}

/**
 * Detect variable is Date instance
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isDate(value) {
  return value instanceof Date
}

/**
 * Detect variable is Event instance
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isEvent(value) {
  return value instanceof Event
}

/**
 * Detect variable is Blob instance
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isBlob(value) {
  return value instanceof Blob
}

/**
 * Detect variable is File instance
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isFile(value) {
  return value instanceof File
}

/**
 * Detect variable is null
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isNull(value) {
  return value === null
}

/**
 * Detect variable is empty string
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isEmptyString(value) {
  return value === ''
}

/**
 * Detect variable is empty
 *
 * @param {mixed} value
 * @return {boolean}
 */
export function isEmpty(value) {
  return value === undefined || value === null || value === 0 || value === '' || (isArray(value) && value.length === 0)
}

/**
 * Detect browser is mobile browser
 *
 * @return {boolean}
 */
export function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(window.navigator.userAgent)
}

/**
 * Get type of variable
 *
 * @param {any} value
 * @returns {string}
 */
export function toType(value) {
  return typeof value
}

/**
 * Get raw type of object
 *
 * @param {any} value
 * @returns {string}
 */
export function toRawType(value) {
  return Object.prototype.toString.call(value).slice(8, -1)
}

export { isArray, isObject, isPlainObject }
