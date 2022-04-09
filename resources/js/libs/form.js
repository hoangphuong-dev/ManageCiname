// ====================================================================================
// Form utilities
// ====================================================================================

import { isArray, isBlob, isDate, isEmptyString, isFile, isNull, isObject, isUndefined } from './inspect'

/**
 * Check post data has a File field
 *
 * @param {object} data
 * @return {boolean}
 */
export function hasFiles(data) {
  for (const field in data) {
    if (data[field] instanceof File || data[field] instanceof FileList) {
      return true
    }

    if (isObject(data[field]) && hasFiles(data[field])) {
      return true
    }
  }

  return false
}

/**
 * Convert object to FormData for submit form
 * @param {mixed} obj
 * @param {string} prefix
 * @param {boolean} indices
 * @param {FormData|null} formData
 */
export function toFormData(obj, prefix = '', { indices = false }, formData = null) {
  formData = formData || new FormData()

  switch (true) {
    case isUndefined(obj):
      return formData
    case isNull(obj) || isEmptyString(obj):
      if (!prefix) {
        formData.append(prefix, '')
      }
      break
    case isDate(obj):
      formData.append(prefix, obj.toISOString())
      break
    case isArray(obj):
      if (!obj.length) {
        const key = prefix + '[]'

        formData.append(key, '')
      } else {
        obj.forEach((value, index) => {
          const key = prefix + '[' + (indices ? index : '') + ']'

          toFormData(value, key, { indices }, formData)
        })
      }
      break
    case isObject(obj) && !isFile(obj) && !isBlob(obj):
      Object.keys(obj).forEach((prop) => {
        const value = obj[prop]

        if (isArray(value)) {
          while (prop.length > 2 && prop.lastIndexOf('[]') === prop.length - 2) {
            prop = prop.substring(0, prop.length - 2)
          }
        }

        const key = prefix ? prefix + '[' + prop + ']' : prop

        toFormData(value, key, { indices }, formData)
      })
      break
    default:
      formData.append(prefix, obj)
      break
  }

  return formData
}
