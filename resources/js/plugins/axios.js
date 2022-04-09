import axios from "axios";
import { errors } from "@/store/errors";

/**
 * Axios default config
 */
export const defaultConfig = {
    // `baseURL` will be prepended to `url` unless `url` is absolute.
    // It can be convenient to set `baseURL` for an instance of axios to pass relative URLs
    // to methods of that instance.
    baseURL: "/api/",

    // `timeout` specifies the number of milliseconds before the request times out.
    // If the request takes longer than `timeout`, the request will be aborted.
    // default is `0` (no timeout)
    timeout: 60000,

    // `headers` are custom headers to be sent
    headers: { "X-Requested-With": "XMLHttpRequest" },

    // `withCredentials` indicates whether or not cross-site Access-Control requests
    // should be made using credentials
    withCredentials: true,

    // `responseType` indicates the type of data that the server will respond with
    // options are: 'arraybuffer', 'document', 'json', 'text', 'stream'
    //   browser only: 'blob'
    responseType: "json",

    // `xsrfCookieName` is the name of the cookie to use as a value for xsrf token
    xsrfCookieName: "XSRF-TOKEN", // default

    // `xsrfHeaderName` is the name of the http header that carries the xsrf token value
    xsrfHeaderName: "X-XSRF-TOKEN", // default
};

/**
 * @param {Object} options
 * @returns {axios.AxiosInstance}
 */
export function provideAxios(options = {}) {
    const instance = axios.create(Object.assign({}, defaultConfig, options));

    // Setting up axios
    instance.interceptors.request.use(
        function (requestConfig) {
            // TODO: multiple language
            // Setting up for i18n
            // const locale = store.getters["lang/locale"];
            // if (locale) {
            //     requestConfig.headers.common["Accept-Language"] = locale;
            // }

            return requestConfig;
        },
        function (error) {
            Promise.reject(error);
        }
    );

    instance.interceptors.response.use(
        function (response) {
            // Any status code that lie within the range of 2xx cause this function to trigger
            return response;
        },
        function (error) {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            const { status, data } = error.response;

            // TODO: Redirect to login if response 401
            if (status === 401) {
                this.$inertia.get(this.route("login"));
            }

            // Update error_bag if rsponse 422
            if (status === 422 || status === 302) {
                errors.dispatch("set", data.errors);
            }

            if ([400, 403, 404, 429, 500].includes(status)) {
                this.$inertia.get({
                    name: "error",
                    params: { status: status },
                });
            }

            return Promise.reject(error);
        }
    );

    return instance;
}

/**
 * Vue Axios Plugin
 */
export const VueAxios = {
    /**
     * @type {boolean}
     */
    installed: false,

    /**
     * Install Plugin
     *
     * @param {Vue} Vue
     * @param {axios.AxiosInstance} instance
     */
    install(Vue, instance = null) {
        if (this.installed) {
            // Skip install
            return;
        }
        this.installed = true;

        Vue.http = instance;

        Object.defineProperty(Vue.prototype, "$http", {
            get() {
                return Vue.$http;
            },
        });
    },
};

const instance = provideAxios();

export default instance;
