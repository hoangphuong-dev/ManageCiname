require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import ElementPlus from "element-plus";
import "@element-plus/icons";
import "element-plus/dist/index.css";
import VueAxios from "vue-axios";
import axios from "@/plugins/axios";
import FormErrors from "@/plugins/form-errors";
import AppLayout from "@/Layouts/AppLayout.vue";
import useGlobalMixin from "@/Mixins/root-global";
import store from './store/store';
const appName = window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    async setup({ el, app, props, plugin }) {
        const rootApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ElementPlus)
            .use(VueAxios, axios)
            .use(FormErrors)
            .use(store)
            .mixin({ methods: { route } })
            .component('AppLayout', AppLayout);

            useGlobalMixin(rootApp);
        rootApp.mount(el);

        return rootApp;
    },
});

InertiaProgress.init({ color: "#4B5563" });
