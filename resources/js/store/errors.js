import { createStore } from 'vuex'
import { arrayWrap } from '@/libs/array'
import { objHasKey } from '@/libs/object'

export const errors = createStore({
    // state
    state: {
        errors: {},
    },

    // getters
    getters: {
        all: (state) => state.errors,
        any: (state) => Object.keys(state.errors).length > 0,
        get: (state) => (field) => state.errors[field] || [],
        first: (state) => (field) => state.errors[field] ? state.errors[field][0] : undefined,
        has: (state) => (field) => objHasKey(state.errors, field) ? false : null,
        check: (state) => (field) => objHasKey(state.errors, field),
    },

    // mutations
    mutations: {
        SET_ERRORS(state, { errors }) {
            state.errors = errors
        },
    },

    // actions
    actions: {
        set({ commit, state }, field, messages) {
            if (typeof field === 'object') {
                commit('SET_ERRORS', { errors: field })
            } else {
                commit({...state.errors, [field]: arrayWrap(messages) })
            }
        },

        clear({ commit, state }, field) {
            const errors = {}

            if (field) {
                Object.keys(state.errors).forEach((key) => {
                    if (key !== field) {
                        errors[key] = state.errors[key]
                    }
                })
            }
            commit('SET_ERRORS', { errors })
        },
    },
})
