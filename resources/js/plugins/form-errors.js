import { errors } from '../store/errors'

class ErrorBag {
  all() {
    return errors.getters.all
  }

  any() {
    return errors.getters.any
  }

  get(field) {
    return errors.getters.get(field)
  }

  first(field) {
    return errors.getters.first(field)
  }

  has(field) {
    return errors.getters.has(field)
  }

  check(field) {
    return errors.getters.check(field)
  }

  set(field, messages = undefined) {
    errors.dispatch('set', field, messages)
  }

  clear(field) {
    errors.dispatch('clear', field)
  }
}

export default {
  /**
   * Installed flag
   */
  installed: false,

  /**
   * Install Plugin
   *
   * @param {Vue} Vue
   */
  install(Vue) {
    if (this.installed) {
      return
    }
    this.installed = true

    Vue.config.globalProperties.$errors = new ErrorBag()
  },
}
